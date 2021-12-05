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

use GuzzleHttp\Client;
use Up2pay\Configuration\Contract;
use Up2pay\Configuration\PaymentConfiguration;
use Up2pay\Configuration\Settings;
use Up2pay\Transaction\PayboxDirect\CaptureRequest;
use Up2pay\Transaction\PayboxDirect\DirectParameterResolver;
use Up2pay\Transaction\PayboxDirect\RefundRequest;
use Up2pay\Transaction\Payment\ContractParameterResolver;
use Up2pay\Transaction\Payment\ContractRequest;
use Up2pay\Transaction\Payment\InstalmentParameterResolver;
use Up2pay\Transaction\Payment\InstalmentRequest;
use Up2pay\Transaction\Payment\SimplePaymentParameterResolver;
use Up2pay\Transaction\Payment\SimplePaymentRequest;
use Up2pay\Transaction\Payment\SubscriptionParameterResolver;
use Up2pay\Transaction\Payment\SubscriptionRequest;
use Up2pay\Transaction\Payment\TokenPaymentParameterResolver;
use Up2pay\Transaction\Payment\TokenPaymentRequest;
use Up2pay\Utils\Installer;
use Up2pay\Utils\Localization;

/**
 * Class Paybox
 */
class Paybox extends PaymentModule
{
    const PHP_MIN_VERSION = '5.6';

    /** @var int $addonsId */
    public $addonsId = 17346;

    /** @var Settings $settings */
    public $settings;

    /** @var \Monolog\Logger $logger */
    public $logger;

    /** @var array $hooks */
    public $hooks = [
        'paymentOptions',
        'orderConfirmation',
        'displayAdminOrderLeft',
        'displayAdminOrderMainBottom',
        'displayHeader',
        'displayPaymentByBinaries',
        'actionOrderStatusPostUpdate',
        'displayBackOfficeFooter',
        'actionFrontControllerSetMedia',
        'actionAdminControllerSetMedia',
        'customerAccount',
    ];

    /** @var string $theme */
    public $theme;

    /**
     * Paybox constructor.
     */
    public function __construct()
    {
        require_once(dirname(__FILE__).'/vendor/autoload.php');

        $this->name = 'paybox';
        $this->author = 'Crédit Agricole';
        $this->version = '6.0.1';
        $this->tab = 'payments_gateways';
        $this->module_key = '538eb192ffd66b71bba651031ca4fbd8';
        $this->currencies = true;
        $this->currencies_mode = 'checkbox';
        parent::__construct();
        $this->bootstrap = true;
        $this->settings = new Settings();
        \Up2pay\Utils\Tools::initLogger($this, 'Up2pay', $this->settings->logsEnabled);
        $this->displayName = $this->l('Up2pay e-Transactions Crédit Agricole');
        $this->description = $this->l('This payment module for banks using Paybox allows your customers to pay by Credit Card');
        $this->theme = Tools::version_compare(_PS_VERSION_, '1.7.7', '>=') ? 'new-theme' : 'legacy';
    }

    /**
     * @return bool|string
     */
    public function install()
    {
        //@formatter:off
        try {
            \Up2pay\Utils\Tools::initLogger($this, 'Up2payInstall');
            $this->logger->info('Start install process');
            if (!parent::install()) {
                return false;
            }
            $this->settings->resetConfig();
            $this->settings = new Settings();
            $installer = new Installer($this);
            $installer->run();
        } catch (Exception $e) {
            $this->logger->error(sprintf('%s - %s - %s', $e->getMessage(), $e->getFile(), $e->getTraceAsString()));
            $this->_errors[] = $this->l('Up2pay module could not be installed. Please check the logs inside the module "logs" directory.');

            return false;
        }
        //@formatter:on
        $this->logger->info('Module installed successfully');

        return true;
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        Configuration::deleteByName('UP2P_SETTINGS');
        Configuration::deleteByName('UP2P_ACCOUNT');
        Configuration::deleteByName('UP2P_PAYMENT_CONFIGURATION');
        Configuration::deleteByName('UP2P_INSTALMENT_CONFIGURATION');
        Configuration::deleteByName('UP2P_SUBSCRIPTION_CONFIGURATION');
        Configuration::deleteByName('UP2P_PAYMENT_METHODS');

        return parent::uninstall();
    }

    /**
     * @throws PrestaShopException
     */
    public function getContent()
    {
        Tools::redirectAdmin(Context::getContext()->link->getAdminLink('AdminPayboxConfiguration'));
    }

    /**
     * @param array $params
     * @return string
     */
    public function hookDisplayBackOfficeFooter($params)
    {
        if (Tools::getValue('controller') == 'AdminPayboxConfiguration') {
            return '
                <script type="text/javascript" src="'.$this->getPathUri().'views/js/config.js"></script>
                <script type="text/javascript" src="'.$this->getPathUri().'views/js/jquery.custom-file-input.js"></script>
            ';
        }

        return '';
    }

    /**
     * @param array $sharedParameters
     * @return \PrestaShop\PrestaShop\Core\Payment\PaymentOption|null
     */
    public function buildSimplePaymentOption($sharedParameters)
    {
        if ($this->settings->paymentConfiguration->display === PaymentConfiguration::DISPLAY_DETAILED) {
            return null;
        }

        try {
            $paymentRequest = new SimplePaymentRequest($this, $this->context, new SimplePaymentParameterResolver());
            $paymentRequest->setParameters($sharedParameters);

            return $paymentRequest->getPaymentOption();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());

            return null;
        }
    }

    /**
     * @param array $sharedParameters
     * @param float $totalCart
     * @return array|\PrestaShop\PrestaShop\Core\Payment\PaymentOption[]
     * @throws Exception
     */
    public function buildContractsPaymentOption($sharedParameters, $totalCart)
    {
        if ($this->settings->paymentConfiguration->display === PaymentConfiguration::DISPLAY_SIMPLE) {
            return [];
        }

        $paymentOptions = [];
        foreach ($this->settings->paymentMethods as $contract) {
            try {
                if (!$contract->enabled) {
                    continue;
                }
                if ($totalCart < $contract->minAmount) {
                    continue;
                }
                $paymentRequest = new ContractRequest(
                    $contract,
                    $this,
                    $this->context,
                    new ContractParameterResolver()
                );
                $paymentRequest->setParameters($sharedParameters);
                $paymentOptions[] = $paymentRequest->getPaymentOption();
            } catch (Exception $e) {
                $this->logger->error($e->getMessage());

                continue;
            }
        }

        return $paymentOptions;
    }

    /**
     * @param array $sharedParameters
     * @param float $totalCart
     * @return array|\PrestaShop\PrestaShop\Core\Payment\PaymentOption[]
     * @throws Exception
     */
    public function buildTokenPaymentOption($sharedParameters, $totalCart)
    {
        $paymentOptions = [];
        $tokens = \Up2pay\Utils\Tools::getCustomerTokens($this->context->customer->id, $this->context->shop->id);
        foreach ($tokens as $token) {
            $date = date('ym');
            if (strcmp($date, $token->dateval) > 0) {
                continue;
            }
            $cardType = $token->card_type ?: Contract::CB_IDENTIFIER;
            $contract = $this->settings->getContractByIdentifier($cardType);
            if ($contract === null ||
                !$contract->enabled ||
                !$contract->oneClickEnabled ||
                $totalCart < $contract->minAmount
            ) {
                continue;
            }
            try {
                $paymentRequest = new TokenPaymentRequest(
                    $token,
                    $contract,
                    $this,
                    $this->context,
                    new TokenPaymentParameterResolver()
                );
                $paymentRequest->setParameters($sharedParameters);
                $paymentOptions[] = $paymentRequest->getPaymentOption();
            } catch (Exception $e) {
                $this->logger->error($e->getMessage());

                continue;
            }
        }

        return $paymentOptions;
    }

    /**
     * @param array $sharedParameters
     * @param float $totalCart
     * @return array
     */
    public function buildInstalmentPaymentOption($sharedParameters, $totalCart)
    {
        if (!$this->settings->instalmentConfiguration->enabled) {
            return [];
        }

        $paymentOptions = [];
        foreach ($this->settings->instalmentConfiguration->instalments as $key => $instalment) {
            try {
                if (!$instalment->enabled) {
                    continue;
                }
                if ($totalCart < $instalment->minAmount || ($instalment->maxAmount && $totalCart > $instalment->maxAmount)) {
                    continue;
                }
                $paymentRequest = new InstalmentRequest(
                    $instalment,
                    $this,
                    $this->context,
                    new InstalmentParameterResolver()
                );
                $paymentRequest->setParameters($sharedParameters);
                $paymentOptions[] = $paymentRequest->getPaymentOption();
            } catch (Exception $e) {
                $this->logger->error(sprintf('Instalment %dx - %s', $key + 2, $e->getMessage()));

                continue;
            }
        }

        return $paymentOptions;
    }

    /**
     * @param array $sharedParameters
     * @param float $totalCart
     * @return \PrestaShop\PrestaShop\Core\Payment\PaymentOption|null
     */
    public function buildSubscriptionPaymentOption($sharedParameters, $totalCart)
    {
        if (!$this->settings->subscriptionConfiguration->enabled) {
            return null;
        }
        if ($totalCart < $this->settings->subscriptionConfiguration->minAmount) {
            return null;
        }

        try {
            $subscriptionRequest = new SubscriptionRequest($this, $this->context, new SubscriptionParameterResolver());
            $subscriptionRequest->setParameters($sharedParameters);

            return $subscriptionRequest->getPaymentOption();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());

            return null;
        }
    }

    /**
     *
     */
    public function hookActionFrontControllerSetMedia()
    {
        $controller = Tools::getValue('controller');
        if (false === in_array($controller, ['cart', 'order'], true)) {
            return;
        }

        $this->context->controller->registerStylesheet(
            'up2pay-css-paymentOptions',
            $this->getPathUri().'views/css/front.css?version='.$this->version,
            ['server' => 'remote']
        );
        $this->context->controller->registerJavascript(
            'up2pay-js-paymentOptions',
            $this->getPathUri().'views/js/front.js?version='.$this->version,
            ['position' => 'bottom', 'priority' => 201, 'server' => 'remote']
        );
    }

    /**
     * @throws PrestaShopException
     */
    public function hookActionAdminControllerSetMedia()
    {
        if (Tools::getValue('controller') == 'AdminOrders') {
            Media::addJsDef([
                'tokenPayboxAjaxTransaction' => Tools::getAdminTokenLite('AdminPayboxAjaxTransaction'),
                'payboxAjaxTransactionUrl' => $this->context->link->getAdminLink(
                    'AdminPayboxAjaxTransaction',
                    true,
                    [],
                    ['ajax' => 1]
                ),
                'payboxGenericErrorMessage' => $this->l('An error occurred while processing your request. Please try again.'),
                'confirmCaptureTxt' => $this->l('Do you confirm the capture of the funds?'),
                'makeRefundTxt' => $this->l('Do you confirm the refund of the transaction?'),
            ]);
        }
    }

    /**
     * @param array $params
     * @return array|null
     * @throws Exception
     */
    public function hookPaymentOptions($params)
    {
        if ($this->settings->environment === null) {
            return null;
        }
        if (!$this->settings->account->isConfigured()) {
            return null;
        }

        $cart = new Cart($this->context->cart->id);
        $currency = new Currency($cart->id_currency);
        $customer = new Customer($cart->id_customer);
        $conversionRate = $currency->conversion_rate;
        $orderTotalDefaultCurrency = $cart->getOrderTotal() / $conversionRate;
        $pbxVersion = 'prestashop-' . _PS_VERSION_ . '-up2pay_etransactions-' . $this->version;

        $langIso6393 = Localization::getIso6393Code($this->context->language);
        $_3DSFields = \Up2pay\Utils\Tools::get3DSv2Details($cart);
        $sharedParameters = [
            'PBX_ANNULE' => $this->context->link->getModuleLink('paybox', 'return', ['action' => 'cancel']),
            'PBX_BILLING' => $_3DSFields['PBX_BILLING'],
            'PBX_CMD' => $cart->id,
            'PBX_DEVISE' => $currency->iso_code_num,
            'PBX_EFFECTUE' => $this->context->link->getModuleLink(
                'paybox',
                'return',
                ['action' => 'done', 'cart' => $cart->id]
            ),
            'PBX_HASH' => 'SHA512',
            'PBX_IDENTIFIANT' => $this->settings->account->id,
            'PBX_LANGUE' => $langIso6393,
            'PBX_PORTEUR' => $customer->email,
            'PBX_RANG' => $this->settings->account->rank,
            'PBX_REFUSE' => $this->context->link->getModuleLink(
                'paybox',
                'return',
                ['action' => 'denied', 'cart' => $cart->id]
            ),
            'PBX_REPONDRE_A' => $this->context->link->getModuleLink('paybox', 'ipn', []),
            'PBX_SHOPPINGCART' => $_3DSFields['PBX_SHOPPINGCART'],
            'PBX_SITE' => $this->settings->account->siteNumber,
            'PBX_TIME' => date('c'),
            'PBX_TOTAL' => $orderTotalDefaultCurrency * 100,
            'PBX_VERSION' => $pbxVersion,
        ];
        if ($this->settings->environment !== Settings::ENV_PROD) {
            if ($this->settings->demoMode) {
                $this->context->smarty->assign('up2payModeAlertDemo', true);
            } else {
                $this->context->smarty->assign('up2payModeAlertTest', true);
            }
        }

        $paymentOptions = $this->buildTokenPaymentOption($sharedParameters, $orderTotalDefaultCurrency);
        $paymentOptions[] = $this->buildSimplePaymentOption($sharedParameters);
        $paymentOptions = array_merge(
            $paymentOptions,
            $this->buildContractsPaymentOption($sharedParameters, $orderTotalDefaultCurrency)
        );
        $paymentOptions = array_merge(
            $paymentOptions,
            $this->buildInstalmentPaymentOption($sharedParameters, $orderTotalDefaultCurrency)
        );
        $paymentOptions[] = $this->buildSubscriptionPaymentOption($sharedParameters, $orderTotalDefaultCurrency);

        return array_filter($paymentOptions);
    }

    /**
     * @return string|void
     * @throws SmartyException
     */
    public function hookDisplayPaymentByBinaries()
    {
        return $this->context->smarty->fetch($this->getLocalPath().'/views/templates/front/hookPaymentByBinaries.tpl');
    }

    /**
     * @param array $params
     * @return bool
     * @throws JsonMapper_Exception
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function hookActionOrderStatusPostUpdate($params)
    {
        $order = new Order((int) $params['id_order']);
        if (!Validate::isLoadedObject($order)) {
            return false;
        }
        $settings = new Settings($order->id_shop);
        $paymentConfiguration = $settings->paymentConfiguration;
        if ($paymentConfiguration->debitType == PaymentConfiguration::DEBIT_IMMEDIATE ||
            $paymentConfiguration->captureEvent != PaymentConfiguration::CAPTURE_STATUS || empty($paymentConfiguration->captureStatuses)
        ) {
            return false;
        }
        $newOrderState = $params['newOrderStatus'];
        if (!in_array($newOrderState->id, $paymentConfiguration->captureStatuses)) {
            return false;
        }
        $transaction = \Up2pay\Utils\Tools::getTransactionByOrderId($order->id);
        if (!Validate::isLoadedObject($transaction) || $transaction->captured) {
            return false;
        }

        $response = $this->captureFunds($transaction, $transaction->amount);
        $output = [];
        parse_str($response->getBody()->getContents(), $output);
        if ($output['CODEREPONSE'] == '00000') {
            try {
                $transaction->setAsCaptured($output, $transaction->amount);
            } catch (Exception $e) {
                $this->logger->error($e->getMessage());

                return false;
            }
        }

        return true;
    }

    /**
     * @param int $idOrder
     * @return string
     * @throws JsonMapper_Exception
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function hookAdminOrderCommon($idOrder)
    {
        $transaction = \Up2pay\Utils\Tools::getTransactionByOrderId((int) $idOrder);
        if (!Validate::isLoadedObject($transaction)) {
            return '';
        }
        $order = new Order((int) $transaction->id_order);
        $settings = new Settings($order->id_shop);

        $this->context->smarty->assign([
            'up2pay_uri' => $settings->path['uri'],
            'transaction' => $transaction->toArray(),
            'order_total' => $order->total_paid_tax_incl,
            'id_currency_euro' => Currency::getIdByIsoCode('EUR'),
            'capture_confirmation' => Tools::getValue('paybox_capture'),
            'refund_confirmation' => Tools::getValue('paybox_refund'),
            'is_contract_access' => $settings->contract == Settings::CONTRACT_ACCESS
        ]);

        return $this->display(__FILE__, '/views/templates/hook/hookAdminOrder_'.$this->theme.'.tpl');
    }

    /**
     * @param array $params
     * @return string
     * @throws JsonMapper_Exception
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function hookDisplayAdminOrderMainBottom($params)
    {
        if (Tools::version_compare(_PS_VERSION_, '1.7.7', '<')) {
            return '';
        }

        $html = $this->hookAdminOrderCommon(Tools::getValue('id_order'));
        $this->context->smarty->assign([
            'html' => $html,
        ]);

        return $this->display(__FILE__, '/views/templates/hook/hookAdminOrder_container.tpl');
    }

    /**
     * @param array $params
     * @return string
     * @throws JsonMapper_Exception
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function hookDisplayAdminOrderLeft($params)
    {
        if (Tools::version_compare(_PS_VERSION_, '1.7.7', '>=')) {
            return '';
        }
        if (Tools::getValue('paybox_capture')) {
            $this->context->controller->confirmations[] = $this->l('Funds have been captured successfully');
        }
        if (Tools::getValue('paybox_refund')) {
            $this->context->controller->confirmations[] = $this->l('Refund done successfully');
        }

        $html = $this->hookAdminOrderCommon(Tools::getValue('id_order'));
        $this->context->smarty->assign([
            'html' => $html,
        ]);

        return $this->display(__FILE__, '/views/templates/hook/hookAdminOrder_container.tpl');
    }

    /**
     * @param array $params
     * @return string
     */
    public function hookCustomerAccount($params)
    {
        return $this->display(__FILE__, '/views/templates/hook/customerAccount.tpl');
    }

    /**
     * @param \Up2pay\ObjectModel\Up2payTransaction $up2payTransaction
     * @param float                                 $amountToCapture
     * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null
     * @throws JsonMapper_Exception
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function captureFunds($up2payTransaction, $amountToCapture)
    {
        $order = new Order((int) $up2payTransaction->id_order);
        $currency = new Currency((int) $order->id_currency);
        $request = new CaptureRequest($this, $this->context, new DirectParameterResolver());
        $request->overrideSettings(new Settings($order->id_shop, null));
        $request->setDefaultFields();
        $request->setParameters([
            'DATEQ' => date('dmYHis'),
            'DEVISE' => $currency->iso_code_num,
            'MONTANT' => $amountToCapture * 100,
            'NUMAPPEL' => $up2payTransaction->numappel,
            'NUMTRANS' => $up2payTransaction->auth_numtrans,
            'REFERENCE' => sprintf('dx%d-%d', $order->id_cart, $order->id_customer),
        ]);
        $query = $request->getParameters();
        $this->logger->debug('Capture - Params', ['fields' => $query]);
        $client = new Client();
        $response = $client->post($request->getEndpoint(), ['body' => $query]);

        return $response;
    }

    /**
     * @param \Up2pay\ObjectModel\Up2payTransaction $up2payTransaction
     * @param float                                 $amountToRefund
     * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null
     * @throws JsonMapper_Exception
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function makeRefund($up2payTransaction, $amountToRefund)
    {
        $order = new Order((int) $up2payTransaction->id_order);
        $currency = new Currency((int) $order->id_currency);
        $request = new RefundRequest($this, $this->context, new DirectParameterResolver());
        $request->overrideSettings(new Settings($order->id_shop, null));
        $request->setDefaultFields();
        $request->setParameters([
            'DATEQ' => date('dmYHis'),
            'DEVISE' => $currency->iso_code_num,
            'MONTANT' => $amountToRefund * 100,
            'NUMAPPEL' => $up2payTransaction->numappel,
            'NUMTRANS' => $up2payTransaction->numtrans,
            'REFERENCE' => sprintf('dx%d-%d', $order->id_cart, $order->id_customer),
        ]);
        $query = $request->getParameters();
        $this->logger->debug('Refund - Params', ['fields' => $query]);
        $client = new Client();
        $response = $client->post($request->getEndpoint(), ['body' => $query]);

        return $response;
    }
}
