<?php
/**
 * 2021 Crédit Agricole
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0).
 * It is also available through the world-wide-web at this URL: https://opensource.org/licenses/AFL-3.0
 *
 * @author    PrestaShop / PrestaShop partner
 * @copyright 2020-2021 Crédit Agricole
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *
 */

use Up2pay\Configuration\PaymentConfiguration;
use Up2pay\Configuration\Settings;
use Up2pay\ObjectModel\Up2paySubscriber;
use Up2pay\ObjectModel\Up2paySubscription;
use Up2pay\ObjectModel\Up2payTransaction;
use Up2pay\Utils\Signature;

/**
 * Class PayboxIpnModuleFrontController
 */
class PayboxIpnModuleFrontController extends ModuleFrontController
{
    /** @var Paybox $module */
    public $module;

    /** @var array $requiredParams */
    private $requiredParams = ['m', 'r', 't', 'e', 'p', 'c', 's'];

    /**
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function initContent()
    {
        $this->ajax = true;
        \Up2pay\Utils\Tools::initLogger($this->module, 'Up2payIPN');
        $this->module->logger->debug('IPN called');

        $values = Tools::strtolower($_SERVER['REQUEST_METHOD']) == 'post' ? $_POST : $_GET;
        $missingParams = array_diff($this->requiredParams, array_keys($values));
        if (!empty($missingParams)) {
            $this->module->logger->error('IPN - Missing params', $missingParams);
            $this->module->logger->debug('IPN - Received params', $values);
            $this->ajaxDie();
            exit;
        }
        $this->module->logger->debug('IPN - Received params', $values);

        $context = Context::getContext();
        $cartString = \Up2pay\Utils\Tools::getCartIdFromReturn(str_replace('U_', '', $values['r']));

        $cart = new Cart((int) $cartString['id_cart']);
        if (!$cart->id) {
            $cartString = \Up2pay\Utils\Tools::getCartIdFromReturn(str_replace('A_', '', $values['r']));
            $cart = new Cart((int) $cartString['id_cart']);

            if (!$cart->id) {
                $this->module->logger->error('IPN - Cart is not valid');
                $this->ajaxDie();
                exit;
            }
        }
        $context->cart = $cart;

        try {
            Signature::verifySignature($_SERVER['QUERY_STRING'], true);
        } catch (Exception $e) {
            $this->module->logger->error(sprintf('IPN - %s', $e->getMessage()));
            $this->ajaxDie();
            exit;
        }

        if ((!isset($values['a']) || empty($values['a']))) {
            $this->module->logger->warning('IPN - No authorisation number');
        }

        if (isset($values['a']) && $values['a'] == 'XXXXXX' && $this->module->settings->environment == Settings::ENV_PROD) {
            $this->module->logger->warning('IPN - Wrong authorisation number');
        }

        $customer = new Customer((int) $cart->id_customer);
        $currency = new Currency($cart->id_currency);
        $context->customer = $customer;
        $context->cart = $cart;
        $context->currency = $currency;

        $cartTotal = (float) $cart->getOrderTotal(true, Cart::BOTH);
        $isSubscription = Tools::substr($values['r'], 0, 2) == 's-' ? 1 : 0;

        $paymentName = 'e-Transactions';
        if ($cartString['x3']) {
            $paymentName = $paymentName.' '.$this->module->l('in', 'ipn').' '.$cartString['n'].'x';
            $instalment = $this->module->settings->instalmentConfiguration->instalments[(int) $cartString['n'] - 2];
            $amount = round($cartTotal * ($instalment->percents[0] / 100), 2);
            $amountSent = $values['m'] / 100;
            if ($amount != $amountSent) {
                $this->module->logger->error(
                    sprintf('IPN - %dx amount does not match', $cartString['n']),
                    ['calculated' => $amount, 'received' => $amountSent]
                );
                $this->ajaxDie();
                exit;
            }
            $totalPaid = $cartTotal;
        } elseif ($isSubscription && isset($values['b'])) {
            $paymentName .= ' '.$this->module->l('with subscription', 'ipn');
            $totalPaid = $values['m'] / 100;
        } else {
            $totalPaid = $values['m'] / 100;
        }

        $pbxError = trim($values['e']);
        $message = '';
        if ($this->module->settings->environment == Settings::ENV_TEST) {
            if ($pbxError == '00000') {
                $message = '***TEST*** : Validated Payment  <br>'."\n";
                $orderStateId = _PS_OS_PAYMENT_;
            } else {
                $this->module->logger->debug('IPN - Paybox error code '.$pbxError);
                $this->ajaxDie();
                exit;
            }
        } else {
            if ($pbxError == '00000') {
                $orderStateId = _PS_OS_PAYMENT_;
            } else {
                $this->module->logger->debug('IPN - Paybox error code '.$pbxError);
                $this->ajaxDie();
                exit;
            }
        }

        if ($orderStateId == Configuration::get('PS_OS_PAYMENT') &&
            $this->module->settings->paymentConfiguration->debitType == PaymentConfiguration::DEBIT_DEFERRED &&
            $this->module->settings->paymentConfiguration->captureEvent == PaymentConfiguration::CAPTURE_STATUS &&
            !$isSubscription
        ) {
            $orderStateId = Configuration::get('PBX_AWAITING_CAPTURE_STATUS');
        }

        $message .= "\n".' Total paid : '.$totalPaid."\n"
                    .' Cart total : '.$cartTotal."\n"
                    .' Statut : '.$orderStateId."\n"
                    .$this->generateMessage($values);

        $idOrder = (int) Order::getOrderByCartId($cart->id);
        if ($idOrder) {
            $order = new Order((int) $idOrder);
            $order->setCurrentState($orderStateId);
        } else {
            $this->module->logger->debug('IPN - Validating order');
            $paymentName .= sprintf(' [%s]', $values['c']);
            $this->module->validateOrder(
                $cart->id,
                $orderStateId,
                $totalPaid,
                $paymentName,
                '',
                array('transaction_id' => $values['s']),
                null,
                false,
                $customer->secure_key
            );
            $idOrder = (int) Order::getOrderByCartId($cart->id);
            $order = new Order((int) $idOrder);
        }
        if ($this->module->settings->contract) {
            $guarantee3DS = 0;
            if (isset($values['g']) && $values['g'] == 'O') {
                $guarantee3DS = 1;
            }
            if (Validate::isLoadedObject($order) && $orderStateId == Configuration::get('PBX_AWAITING_CAPTURE_STATUS')) {
                $transaction = new Up2payTransaction();
                $transaction->id_order = (int) $order->id;
                $transaction->amount_captured = 0;
                $transaction->amount = (float) $totalPaid;
                $transaction->auth_numtrans = pSQL($values['s']);
                $transaction->numtrans = null;
                $transaction->numappel = pSQL($values['t']);
                $transaction->guarantee_3ds = (int) $guarantee3DS;
                $transaction->card_type = pSQL($values['c']);
                $transaction->captured = 0;
                try {
                    $transaction->save();
                } catch (Exception $e) {
                    $this->module->logger->error($e->getMessage());
                }
            } elseif (Validate::isLoadedObject($order) && $orderStateId == Configuration::get('PS_OS_PAYMENT')) {
                $transaction = new Up2payTransaction();
                $transaction->id_order = (int) $order->id;
                $transaction->amount_captured = (float) $totalPaid;
                $transaction->amount = (float) $totalPaid;
                $transaction->auth_numtrans = null;
                $transaction->numtrans = pSQL($values['s']);
                $transaction->numappel = pSQL($values['t']);
                $transaction->guarantee_3ds = (int) $guarantee3DS;
                $transaction->card_type = pSQL($values['c']);
                $transaction->captured = 1;
                try {
                    $transaction->save();
                } catch (Exception $e) {
                    $this->module->logger->error($e->getMessage());
                }
            }
        }
        if (Validate::isLoadedObject($order) && $values['e'] == '00000' && isset($values['abo'])) {
            $refabonne = str_replace(' ', '', $context->shop->name);
            $refabonne .= $context->customer->id.str_replace('@', '', $context->customer->email).'';
            $token = Tools::substr($values['abo'], 0, Tools::strlen($values['abo']) - 11);
            $idUp2paySubscriber = Up2paySubscriber::exists($refabonne, $customer->id, $cart->id_shop, $token);
            $countSubscriptions = Up2paySubscriber::count($customer->id, $this->context->cart->id_shop, $refabonne);

            if ($countSubscriptions > 0) {
                $refabonne .= 'c' . $countSubscriptions;
                $idUp2paySubscriber = null;
            }

            $subscriber = new Up2paySubscriber((int) $idUp2paySubscriber);
            $subscriber->id_customer = (int) $customer->id;
            $subscriber->id_shop = (int) $cart->id_shop;
            $subscriber->token = pSQL($token);
            $subscriber->refabonne = pSQL($refabonne);
            $subscriber->dateval = pSQL($values['d']);
            $subscriber->pan = pSQL($values['j']);
            $subscriber->bin6 = pSQL($values['n']);
            $subscriber->card_type = pSQL(Tools::strtoupper($values['c']));
            try {
                $subscriber->save();
            } catch (Exception $e) {
                $this->module->logger->error('IPN - Saving subscriber: '.$e->getMessage());
            }
        }
        if (Validate::isLoadedObject($order) && isset($values['b']) && $isSubscription) {
            $subscription = new Up2paySubscription();
            $subscription->id_customer = (int) $customer->id;
            $subscription->id_order = (int) $order->id;
            $subscription->unsubscribed = 0;
            $subscription->abonnement = pSQL($values['b']);
            try {
                $subscription->save();
            } catch (Exception $e) {
                $this->module->logger->error('IPN - Saving subscription: '.$e->getMessage());
            }
        }
        $this->ajaxDie();
        exit;
    }

    /**
     * @param array $values
     * @return string
     */
    public function generateMessage($values)
    {
        $authNumber = isset($values['a']) ? $values['a'] : '';
        $message = "\n".'Payment Type : '.$values['p']."\n"
                   .'Card Type : '.$values['c']."\n"
                   .'Expiry Date of Card (YY/MM) : '.$values['d']."\n"
                   .'Country code of IP Address of the cardholder : '.$values['i']."\n\n"
                   .'Paybox Transaction ID : '.$values['s']."\n"
                   .'Reference of the Order : '.$values['r']."\n"
                   .'Paybox Call Number : '.$values['t']."\n"
                   .'Authorisation Number : '.$authNumber."\n"
                   .'Subscriber Number : '.$values['b']."\n"
                   .'Transaction processing date on the Paybox platform : '.$values['w']."\n\n"
                   .'Amount of Transaction : '.$values['m']."\n\n"
                   .'Signature of the Fields : '.$values['k']."\n";

        return $message;
    }
}
