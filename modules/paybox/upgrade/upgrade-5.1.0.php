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

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Upgrade to 5.1.0
 *
 * @param $module Paybox
 * @return bool
 */
function upgrade_module_5_1_0($module)
{
    $shops = Shop::getShops();
    foreach ($shops as $shop) {
        Configuration::updateValue('PBX_GATEWAY', 'ca', false, null, $shop['id_shop']);
        Configuration::updateValue('PBX_DISABLE_3D', 0, false, null, $shop['id_shop']);
        Configuration::updateValue('PBX_3D_MINIMUM', 0, false, null, $shop['id_shop']);
    }
    Configuration::updateGlobalValue('PBX_GATEWAY', 'ca');
    Configuration::updateGlobalValue('PBX_DISABLE_3D', 0);
    Configuration::updateGlobalValue('PBX_3D_MINIMUM', 0);
    if (Configuration::get('PBX_SOLUTION') == 1) {
        Configuration::updateValue('PBX_SOLUTION', 2);
    }

    if (Tools::version_compare(_PS_VERSION_, '1.7', '>=')) {
        $module->registerHook('displayPaymentByBinaries');
    }
    $module->registerHook('actionOrderStatusPostUpdate');
    $dbQueryaPaylib = new DbQuery();
    $dbQueryaPaylib->select('id_paybox_contract')
        ->from('paybox_contracts')
        ->where('name = "PAYLIB"');
    $paylib = (int) Db::getInstance()->getValue($dbQueryaPaylib);
    if (!$paylib) {
        Db::getInstance()->execute(
            'INSERT INTO `'._DB_PREFIX_.'paybox_contracts` (name, image, payment_type, card_type, active, paid_shipping, deferred, refund, immediate, deletable) VALUES ("PAYLIB", "img/PAYLIB.png", "WALLET", "PAYLIB", 0, 1, 1, 1, 1, 0)'
        );
    }
    $contractsToDelete = array('VISA', 'MASTERCARD', 'E-CARD BLEUE', 'MAESTRO', 'BUYSTER');
    Db::getInstance()->delete('paybox_contracts', sprintf('name IN("%s")', implode('", "', $contractsToDelete)));

    return true;
}
