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

use Up2pay\ObjectModel\Up2payTransaction;

/**
 * Class AdminPayboxAjaxTransactionController
 */
class AdminPayboxAjaxTransactionController extends ModuleAdminController
{
    /** @var Paybox $module */
    public $module;

    /**
     * @throws JsonMapper_Exception
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function displayAjaxSendCapture()
    {
        $form = Tools::getValue('transaction');
        if (!$this->access('edit')) {
            //@formatter:off
            $this->context->smarty->assign([
                'payboxAjaxTransactionError' => $this->module->l('You do not have permission to capture funds.', 'AdminPayboxAjaxTransaction'),
            ]);
            //@formatter:on
            $this->ajaxDie(json_encode([
                'result_html' => $this->module->hookAdminOrderCommon((int) $form['idOrder']),
            ]));
            exit;
        }
        $up2payTransaction = new Up2payTransaction((int) $form['id']);
        if (!Validate::isLoadedObject($up2payTransaction)) {
            //@formatter:off
            $this->context->smarty->assign([
                'payboxAjaxTransactionError' => $this->module->l('Cannot retrieve transaction', 'AdminPayboxAjaxTransaction'),
            ]);
            //@formatter:on
            $this->ajaxDie(json_encode([
                'result_html' => $this->module->hookAdminOrderCommon((int) $form['idOrder']),
            ]));
            exit;
        }
        try {
            $response = $this->module->captureFunds($up2payTransaction, $form['amountToCapture']);
        } catch (Exception $e) {
            $this->module->logger->error($e->getMessage());
            //@formatter:off
            $this->context->smarty->assign([
                'payboxAjaxTransactionError' => $this->module->l('Could not capture funds.', 'AdminPayboxAjaxTransaction'),
            ]);
            //@formatter:on
            $this->ajaxDie(json_encode([
                'result_html' => $this->module->hookAdminOrderCommon((int) $form['idOrder']),
            ]));
            exit;
        }
        $output = [];
        $content = (string) utf8_encode($response->getBody()->__toString());
        parse_str($content, $output);
        $this->module->logger->debug('Capture - Response', ['query' => $content]);
        if ($output['CODEREPONSE'] != '00000') {
            //@formatter:off
            $this->context->smarty->assign([
                'payboxAjaxTransactionError' => $output['COMMENTAIRE'],
            ]);
            //@formatter:on
            $this->ajaxDie(json_encode([
                'result_html' => $this->module->hookAdminOrderCommon((int) $form['idOrder']),
            ]));
            exit;
        } else {
            $up2payTransaction->setAsCaptured($output, $form['amountToCapture']);
            $this->ajaxDie(json_encode([
                'redirect_after' => $this->context->link->getAdminLink(
                    'AdminOrders',
                    true,
                    [],
                    ['id_order' => $form['idOrder'], 'vieworder' => 1, 'paybox_capture' => 1]
                ),
            ]));
            exit;
        }
    }

    /**
     * @throws JsonMapper_Exception
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function displayAjaxSendRefund()
    {
        $form = Tools::getValue('transaction');
        if (!$this->access('edit')) {
            //@formatter:off
            $this->context->smarty->assign([
                'payboxAjaxTransactionError' => $this->module->l('You do not have permission to make refunds.', 'AdminPayboxAjaxTransaction'),
            ]);
            //@formatter:on
            $this->ajaxDie(json_encode([
                'result_html' => $this->module->hookAdminOrderCommon((int) $form['idOrder']),
            ]));
            exit;
        }
        $up2payTransaction = new Up2payTransaction((int) $form['id']);
        if (!Validate::isLoadedObject($up2payTransaction)) {
            //@formatter:off
            $this->context->smarty->assign([
                'payboxAjaxTransactionError' => $this->module->l('Cannot retrieve transaction', 'AdminPayboxAjaxTransaction'),
            ]);
            //@formatter:on
            $this->ajaxDie(json_encode([
                'result_html' => $this->module->hookAdminOrderCommon((int) $form['idOrder']),
            ]));
            exit;
        }
        $refundableAmount = $up2payTransaction->getRefundableAmount();
        if (!$refundableAmount || $form['amountToRefund'] > $refundableAmount) {
            //@formatter:off
            $this->context->smarty->assign([
                'payboxAjaxTransactionError' => $this->module->l('The amount you want to refund is greater than original purchase amount.', 'AdminPayboxAjaxTransaction'),
            ]);
            //@formatter:on
            $this->ajaxDie(json_encode([
                'result_html' => $this->module->hookAdminOrderCommon((int) $form['idOrder']),
            ]));
            exit;
        }
        try {
            $response = $this->module->makeRefund($up2payTransaction, $form['amountToRefund']);
        } catch (Exception $e) {
            $this->module->logger->error($e->getMessage());
            //@formatter:off
            $this->context->smarty->assign([
                'payboxAjaxTransactionError' => $this->module->l('Could not make refund.', 'AdminPayboxAjaxTransaction'),
            ]);
            //@formatter:on
            $this->ajaxDie(json_encode([
                'result_html' => $this->module->hookAdminOrderCommon((int) $form['idOrder']),
            ]));
            exit;
        }
        $output = [];
        $content = (string) utf8_encode($response->getBody()->__toString());
        parse_str($content, $output);
        $this->module->logger->debug('Refund - Response', ['query' => $content]);
        if ($output['CODEREPONSE'] != '00000') {
            //@formatter:off
            $this->context->smarty->assign([
                'payboxAjaxTransactionError' => $output['COMMENTAIRE'],
            ]);
            //@formatter:on
            $this->ajaxDie(json_encode([
                'result_html' => $this->module->hookAdminOrderCommon((int) $form['idOrder']),
            ]));
            exit;
        } else {
            $up2payTransaction->addRefund($output, $form['amountToRefund']);
            $order = new Order((int) $up2payTransaction->id_order);
            $language = new Language((int) $order->id_lang);
            $customer = new Customer((int) $order->id_customer);
            $subjects = [
                'en' => 'Partial refund',
                'fr' => 'Remboursement partiel',
            ];

            if ($up2payTransaction->getRefundableAmount() > 0) {
                Mail::send(
                    $order->id_lang,
                    'up2pay_refund',
                    isset($subjects[$language->iso_code]) ? $subjects[$language->iso_code] : $subjects['en'],
                    [
                        '{refund_amount}' => Tools::displayPrice($form['amountToRefund']),
                        '{order_name}' => $order->reference,
                        '{firstname}' => $customer->firstname,
                        '{lastname}' => $customer->lastname,
                    ],
                    $customer->email,
                    null,
                    null,
                    null,
                    null,
                    null,
                    _PS_MODULE_DIR_.$this->module->name.'/mails/'
                );
            }

            $this->ajaxDie(json_encode([
                'redirect_after' => $this->context->link->getAdminLink(
                    'AdminOrders',
                    true,
                    [],
                    ['id_order' => $form['idOrder'], 'vieworder' => 1, 'paybox_refund' => 1]
                ),
            ]));
            exit;
        }
    }
}
