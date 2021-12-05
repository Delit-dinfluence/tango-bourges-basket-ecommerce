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

/**
 * Class PayboxReturnModuleFrontController
 */
class PayboxReturnModuleFrontController extends ModuleFrontController
{
    /** @var Paybox $module */
    public $module;

    /**
     * @throws PrestaShopException
     */
    public function initContent()
    {
        \Up2pay\Utils\Tools::initLogger($this->module, 'Up2payReturn');
        $action = Tools::getValue('action');
        $iframe = Tools::getValue('iframe');
        switch ($action) {
            case 'cancel':
                $this->actionCancel($iframe);
                break;
            case 'denied':
                $this->actionDenied($iframe);
                break;
            case 'done':
            default:
                $this->actionDone($iframe);
                break;
        }
    }

    /**
     * @param bool $iframe
     * @throws PrestaShopException
     */
    public function actionCancel($iframe)
    {
        if ($iframe) {
            $vars = ['redirect_url' => $this->context->link->getPageLink('order', null, null, ['step' => 3])];
            $this->context->smarty->assign($vars + ['img_path' => $this->module->settings->path['img']]);
            $this->setTemplate('module:paybox/views/templates/front/redirectiframe.tpl');
        } else {
            Tools::redirectAdmin($this->context->link->getPageLink('order', null, null, ['step' => 3]));
        }
    }

    /**
     * @param bool $iframe
     * @throws PrestaShopException
     */
    public function actionDenied($iframe)
    {
        $this->actionCancel($iframe);
    }

    /**
     * @param bool $iframe
     * @throws PrestaShopException
     */
    public function actionDone($iframe)
    {
        $idCart = (int) Tools::getValue('cart');
        $cart = new Cart($idCart);
        if (!Validate::isLoadedObject($cart)) {
            $this->module->logger->error(sprintf('Cart ID %d not valid', $cart->id));
            $this->ajaxDie('Cart not valid');
            exit;
        }
        /**
         * A vérifier : Lors d'un paiement en iframe on a pas de contexte donc comparaison toujours false
         * jbrito 18/05/2021
         */
        if (!$iframe && $this->context->customer->id != $cart->id_customer) {
            $this->module->logger->error(sprintf(
                'Cart customer (%d) does not match context customer (%d)',
                $cart->id,
                $this->context->customer->id
            ));
            $this->ajaxDie('There was a problem with this order. Please contact our support team.');
            exit;
        }
        $idOrder = 0;
        $count = 0;
        while ($idOrder == 0) {
            sleep(2);
            $idOrder = (int) Order::getOrderByCartId($idCart);
            ++$count;
            if ($count == 15) {
                $this->module->logger->error('Timeout while returning to shop');
                $this->ajaxDie('Timeout! There was a problem with this order. Please contact our support team.');
                exit;
            }
        }
        $customer = new Customer((int) $cart->id_customer);
        if (!Validate::isLoadedObject($customer)) {
            $this->module->logger->error('Customer is not valid');
            $this->ajaxDie('Customer not valid');
            exit;
        }

        if ($iframe) {
            $vars = [
                'redirect_url' => $this->context->link->getPageLink(
                    'order-confirmation',
                    null,
                    null,
                    [
                        'id_cart' => $cart->id,
                        'id_module' => $this->module->id,
                        'key' => $customer->secure_key,
                    ]
                ),
            ];
            $this->context->smarty->assign($vars + ['img_path' => $this->module->settings->path['img']]);
            $this->setTemplate('module:paybox/views/templates/front/redirectiframe.tpl');
        } else {
            Tools::redirect(
                $this->context->link->getPageLink(
                    'order-confirmation',
                    null,
                    null,
                    [
                        'id_cart' => $cart->id,
                        'id_module' => $this->module->id,
                        'key' => $customer->secure_key,
                    ]
                )
            );
        }
    }
}
