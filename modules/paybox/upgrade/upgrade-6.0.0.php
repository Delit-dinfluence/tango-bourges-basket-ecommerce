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

use Up2pay\Configuration\Contract;
use Up2pay\Configuration\PaymentConfiguration;
use Up2pay\Configuration\Settings;
use Up2pay\ObjectModel\Up2paySubscriber;
use Up2pay\ObjectModel\Up2paySubscription;
use Up2pay\ObjectModel\Up2payTransaction;
use Up2pay\Utils\Installer;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Upgrade to 6.0.0
 *
 * @param $module Paybox
 * @return bool
 */
function upgrade_module_6_0_0($module)
{
    Shop::setContext(Shop::CONTEXT_ALL);
    $installer = new Installer($module);
    try {
        $installer->run();
    } catch (Exception $e) {
        $module->logger->error(sprintf('%s - %s - %s', $e->getMessage(), $e->getFile(), $e->getTraceAsString()));

        return false;
    }
    \Up2pay\Utils\Tools::initLogger($module, 'Up2payUpgradeV6', true);

    $contractsQuery = new DbQuery();

    $contractsQuery
        ->select('*')
        ->from('paybox_contracts');

    $oldContracts = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($contractsQuery);

    $shops = Shop::getShops();
    foreach ($shops as $shop) {
        $data = [];
        $idShop = (int) $shop['id_shop'];
        Shop::setContext(Shop::CONTEXT_SHOP, $idShop);

        // Main settings & Account
        $demoMod = !Configuration::get('PBX_DEMO_MODE', null, null, $idShop);
        $testDetails = Configuration::get('PBX_USER_TEST_DETAILS', null, null, $idShop);
        $data['settings']['demoMode'] = $demoMod && !$testDetails;
        $data['settings']['showWhatsNew'] = true;

        $settings = new Settings($idShop);

        if ($data['settings']['demoMode']) {
            $data['settings']['environment'] = Settings::ENV_TEST;
        } else {
            $data['account']['siteNumber'] = Configuration::get('PBX_SITE', null, null, $idShop);
            $data['account']['rank'] = Configuration::get('PBX_RANG', null, null, $idShop);
            $data['account']['id'] = Configuration::get('PBX_ID', null, null, $idShop);
            if ($demoMod) {
                $data['settings']['environment'] = Settings::ENV_TEST;
                $data['account']['hmacTest'] = Configuration::get('PBX_HMAC', null, null, $idShop);
            } else {
                $data['settings']['environment'] = Settings::ENV_PROD;
                $data['account']['hmacProd'] = Configuration::get('PBX_HMAC', null, null, $idShop);
            }
        }
        if (!Configuration::get('PBX_SOLUTION', null, null, $idShop)) {
            $data['settings']['contract'] = Settings::CONTRACT_ACCESS;
        } else {
            $data['settings']['contract'] = Settings::CONTRACT_PREMIUM;
        }

        // Payment configuration
        if (Configuration::get('PBX_FULL_INTEGRATION', null, null, $idShop)) {
            $data['paymentConfiguration']['display'] = PaymentConfiguration::DISPLAY_DETAILED;
            // liste contrat
            foreach ($settings->paymentMethods as $paymentMethod) {
                if ($paymentMethod->identifier == Contract::CB_IDENTIFIER) {
                    $paymentMethod->enabled = true;
                    $paymentMethod->displayType = Contract::DISPLAY_IFRAME;
                    if (Configuration::get('PBX_WALLET', null, null, $idShop)) {
                        $paymentMethod->oneClickEnabled = true;
                    }
                } elseif ($paymentMethod->identifier == 'OTHER') {
                    $paymentMethod->enabled = false;
                    $paymentMethod->isSelectable = false;
                } else {
                    $paymentMethod->enabled = false;
                    $paymentMethod->isSelectable = true;
                }
            }
        } else {
            if (Configuration::get('PBX_SIMPLE_ADVANCED', null, null, $idShop)) {
                $data['paymentConfiguration']['display'] = PaymentConfiguration::DISPLAY_SIMPLE;
                $data['paymentConfiguration']['oneClickEnabled'] = false;
            } else {
                $data['paymentConfiguration']['display'] = PaymentConfiguration::DISPLAY_DETAILED;
                // liste contrat

                foreach ($settings->paymentMethods as $paymentMethod) {
                    $paymentMethod->oneClickEnabled = false;
                    $paymentMethod->displayType = Contract::DISPLAY_REDIRECT;

                    if (!empty($oldContracts)) {
                        foreach ($oldContracts as $oldContract) {
                            if ($paymentMethod->cardType == $oldContract['card_type']) {
                                $paymentMethod->enabled = (bool) $oldContract['active'];
                                $paymentMethod->isSelectable = !$oldContract['active'];
                                break;
                            }
                        }
                    }
                }
            }
        }
        switch (Configuration::get('PBX_CAPTURE_PAY_TYPE', null, null, $idShop)) {
            case 'capture_manual':
                if ($data['settings']['contract'] == Settings::CONTRACT_PREMIUM) {
                    $data['paymentConfiguration']['debitType'] = PaymentConfiguration::DEBIT_DEFERRED;
                    $data['paymentConfiguration']['captureEvent'] = PaymentConfiguration::CAPTURE_STATUS;
                    $data['paymentConfiguration']['captureStatuses'] = [Configuration::get('PS_OS_SHIPPING')];
                } else {
                    $data['paymentConfiguration']['debitType'] = PaymentConfiguration::DEBIT_IMMEDIATE;
                }
                break;
            case 'capture_delayed':
                $data['paymentConfiguration']['debitType'] = PaymentConfiguration::DEBIT_DEFERRED;
                $data['paymentConfiguration']['captureEvent'] = PaymentConfiguration::CAPTURE_DAYS;
                $data['paymentConfiguration']['deferredDays'] = Configuration::get(
                    'PBX_CAPTURE_DELAY_DAYS',
                    null,
                    null,
                    $idShop
                );
                break;
            case 'capture_immediate':
            default:
                $data['paymentConfiguration']['debitType'] = PaymentConfiguration::DEBIT_IMMEDIATE;
                break;
        }

        if ($data['settings']['contract'] == Settings::CONTRACT_PREMIUM) {
            // Instalments
            if (Configuration::get('PBX_MULTIPLE_2X_PAYMENTS', null, null, $idShop)) {
                $settings->instalmentConfiguration->enabled = true;
                $settings->instalmentConfiguration->instalments[0]->enabled = true;
            }
            $settings->instalmentConfiguration->instalments[0]->daysBetweenPayments = (int) Configuration::get(
                'PBX_DELAY',
                null,
                null,
                $idShop
            );
            $settings->instalmentConfiguration->instalments[0]->minAmount = (float) Configuration::get(
                'PBX_2X_MINIMUM',
                null,
                null,
                $idShop
            );
            if (Configuration::get('PBX_MULTIPLE_3X_PAYMENTS', null, null, $idShop)) {
                $settings->instalmentConfiguration->enabled = true;
                $settings->instalmentConfiguration->instalments[1]->enabled = true;
            }
            $settings->instalmentConfiguration->instalments[1]->daysBetweenPayments = (int) Configuration::get(
                'PBX_DELAY',
                null,
                null,
                $idShop
            );
            $settings->instalmentConfiguration->instalments[1]->minAmount = (float) Configuration::get(
                'PBX_3X_MINIMUM',
                null,
                null,
                $idShop
            );
            if (Configuration::get('PBX_MULTIPLE_4X_PAYMENTS', null, null, $idShop)) {
                $settings->instalmentConfiguration->enabled = true;
                $settings->instalmentConfiguration->instalments[2]->enabled = true;
            }
            $settings->instalmentConfiguration->instalments[2]->daysBetweenPayments = (int) Configuration::get(
                'PBX_DELAY',
                null,
                null,
                $idShop
            );
            $settings->instalmentConfiguration->instalments[2]->minAmount = (float) Configuration::get(
                'PBX_4X_MINIMUM',
                null,
                null,
                $idShop
            );

            // Subscriptions
            if (Configuration::get('PBX_ENABLE_SUBSCRIPTIONS', null, null, $idShop)) {
                $settings->subscriptionConfiguration->enabled = true;
            }
            $settings->subscriptionConfiguration->frequency = (int) Configuration::get('PBX_FREQ', null, null, $idShop);
            $settings->subscriptionConfiguration->dayOfPayment = (int) Configuration::get(
                'PBX_QUAND',
                null,
                null,
                $idShop
            );
            $settings->subscriptionConfiguration->delay = (int) Configuration::get(
                'PBX_SUBSCRIPTION_DELAY',
                null,
                null,
                $idShop
            );
        }

        $module->logger->debug('Apply settings');

        try {
            $settings->updateSettings($data['settings']);
            $module->logger->debug('Applied settings', ['data' => $data['settings']]);
            if (!empty($data['account'])) {
                $settings->updateAccount($data['account']);
                $module->logger->debug('Applied account', ['data' => $data['account']]);
            }
            $settings->updatePaymentConfiguration($data['paymentConfiguration']);
            $module->logger->debug('Applied payment config.', ['data' => $data['paymentConfiguration']]);
            $settings->updateInstalmentConfiguration(
                json_decode(json_encode($settings->instalmentConfiguration), true)
            );
            $module->logger->debug(
                'Applied instalment config.',
                ['data' => json_encode($settings->instalmentConfiguration)]
            );
            $settings->updateSubscriptionConfiguration(
                json_decode(json_encode($settings->subscriptionConfiguration), true)
            );
            $module->logger->debug(
                'Applied subscription config.',
                ['data' => json_encode($settings->subscriptionConfiguration)]
            );
            $settings->updatePaymentMethods(json_decode(json_encode($settings->paymentMethods), true));
            $module->logger->debug('Applied PM', ['data' => json_encode($settings->paymentMethods)]);
        } catch (Exception $e) {
            $module->logger->error(sprintf('%s - %s - %s', $e->getMessage(), $e->getFile(), $e->getTraceAsString()));

            return false;
        }
    }
    // Db data
    $dbQueryTransaction = new DbQuery();
    $dbQueryTransaction
        ->select('*')
        ->from('paybox_authorised_await_capture');

    $oldTransactions = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($dbQueryTransaction);
    if ($oldTransactions) {
        foreach ($oldTransactions as $oldTransaction) {
            $order = new Order((int) $oldTransaction['id_order']);
            if (!Validate::isLoadedObject($order)) {
                $module->logger->error('Cannot migrate transaction', ['data' => $oldTransaction]);
                continue;
            }
            $transaction = new Up2payTransaction();
            $transaction->id_order = (int) $oldTransaction['id_order'];
            $transaction->auth_numtrans = $oldTransaction['captured'] ? '' : pSQL($oldTransaction['numtrans']);
            $transaction->numtrans = $oldTransaction['captured'] ? pSQL($oldTransaction['numtrans']) : '';
            $transaction->numappel = pSQL($oldTransaction['numappel']);
            $transaction->amount = (float) $order->total_paid;
            if ($oldTransaction['captured'] && $oldTransaction['amount_paid']) {
                $amountCaptured = (float) $oldTransaction['amount_paid'] / 100;
            } elseif ($oldTransaction['captured'] && !$oldTransaction['amount_paid']) {
                $amountCaptured = (float) $order->total_paid;
            } else {
                $amountCaptured = 0;
            }
            $transaction->amount_captured = (float) $amountCaptured;
            $transaction->card_type = '';
            $transaction->captured = (int) $oldTransaction['captured'];
            try {
                $transaction->save();
            } catch (Exception $e) {
                $module->logger->error(sprintf(
                    '%s - %s - %s',
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getTraceAsString()
                ));
                continue;
            }

            if ($oldTransaction['amount_refunded']) {
                try {
                    Db::getInstance()->insert(
                        'up2pay_refund',
                        [
                            'id_up2pay_transaction' => (int) $transaction->id,
                            'amount' => (float) ($oldTransaction['amount_refunded'] / 100),
                            'numtrans' => '00000000',
                            'numappel' => '00000000',
                            'date_add' => '0000-00-00 00:00:00',
                        ]
                    );
                } catch (Exception $e) {
                    $module->logger->error(sprintf(
                        '%s - %s - %s',
                        $e->getMessage(),
                        $e->getFile(),
                        $e->getTraceAsString()
                    ));
                    continue;
                }
            }
        }
    }

    $dbQueryWallet = new DbQuery();
    $dbQueryWallet
        ->select('*')
        ->from('paybox_wallet');

    $oldWallets = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($dbQueryWallet);
    if ($oldWallets) {
        foreach ($oldWallets as $oldWallet) {
            $customer = new Customer((int) $oldWallet['id_customer']);
            if (!Validate::isLoadedObject($customer)) {
                $module->logger->error('Cannot migrate subscriber', ['data' => $oldWallet]);
                continue;
            }
            if (Up2paySubscriber::exists(
                $oldWallet['refabonne'],
                $customer->id,
                $customer->id_shop,
                $oldWallet['porteur']
            )) {
                continue;
            }
            $subscriber = new Up2paySubscriber();
            $subscriber->id_customer = (int) $customer->id;
            $subscriber->id_shop = (int) $customer->id_shop;
            $subscriber->token = pSQL($oldWallet['porteur']);
            $subscriber->refabonne = pSQL($oldWallet['refabonne']);
            $subscriber->pan = pSQL($oldWallet['pan']);
            $subscriber->bin6 = '####';
            $subscriber->dateval = pSQL($oldWallet['dateval']);
            $subscriber->card_type = '';
            try {
                $subscriber->save();
            } catch (Exception $e) {
                $module->logger->error(sprintf(
                    '%s - %s - %s',
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getTraceAsString()
                ));
                continue;
            }
        }
    }

    $dbQuerySubscriptions = new DbQuery();
    $dbQuerySubscriptions
        ->select('*')
        ->from('paybox_subscriptions');

    $oldSubscriptions = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($dbQuerySubscriptions);
    if ($oldSubscriptions) {
        foreach ($oldSubscriptions as $oldSubscription) {
            $subscription = new Up2paySubscription();
            $subscription->id_customer = (int) $oldSubscription['id_customer'];
            $subscription->id_order = (int) $oldSubscription['id_order'];
            $subscription->unsubscribed = (int) $oldSubscription['unsubscribed'];
            $subscription->abonnement = (int) $oldSubscription['abonnement'];
            try {
                $subscription->save();
            } catch (Exception $e) {
                $module->logger->error(sprintf(
                    '%s - %s - %s',
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getTraceAsString()
                ));
                continue;
            }
        }
    }

    return true;
}
