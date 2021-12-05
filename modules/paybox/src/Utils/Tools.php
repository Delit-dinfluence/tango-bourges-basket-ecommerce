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

namespace Up2pay\Utils;

use Address;
use Cart;
use Country;
use Db;
use DbQuery;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Symfony\Component\Filesystem\Filesystem;
use Up2pay\ObjectModel\Up2paySubscriber;
use Up2pay\ObjectModel\Up2payTransaction;

/**
 * Class Tools
 * @package Up2pay\Utils
 */
class Tools
{
    const GATEWAY_TEST = 'https://preprod-tpeweb.e-transactions.fr/';
    const GATEWAY_PROD = 'https://tpeweb.e-transactions.fr/';
    const DIRECT_GATEWAY_TEST = 'https://preprod-ppps.e-transactions.fr/';
    const DIRECT_GATEWAY_PROD = 'https://ppps.e-transactions.fr/';
    const SECONDARY_GATEWAY_TEST = 'https://preprod-tpeweb.e-transactions.fr/';
    const SECONDARY_GATEWAY_PROD = 'https://tpeweb1.e-transactions.fr/';
    const SECONDARY_DIRECT_GATEWAY_TEST = 'https://preprod-ppps.e-transactions.fr/';
    const SECONDARY_DIRECT_GATEWAY_PROD = 'https://ppps1.e-transactions.fr/';
    const CHECK_ENDPOINT = 'load.html';

    /**
     * @param \Paybox $module
     * @param string  $name
     * @param bool    $logsEnabled
     */
    public static function initLogger($module, $name = 'module', $logsEnabled = true)
    {
        $module->logger = new Logger($name);
        $level = $logsEnabled ? Logger::DEBUG : Logger::INFO;
        $fileHandler = new RotatingFileHandler(
            $module->getLocalPath().sprintf('logs/%s.log', self::hash(_PS_MODULE_DIR_)),
            3,
            $level
        );
        $fileHandler->setFilenameFormat('{date}_{filename}', 'Ym');
        $module->logger->pushHandler($fileHandler);
    }

    /**
     * @param array $array
     * @return string
     */
    public static function stringify(array $array)
    {
        $result = array();

        foreach ($array as $key => $value) {
            $result[] = sprintf('%s=%s', $key, $value);
        }

        return implode('&', $result);
    }

    /**
     * @param string $value
     * @return string
     */
    public static function hash($value)
    {
        return md5(_COOKIE_IV_.$value);
    }

    /**
     * @param string $source
     * @param string $destination
     */
    public static function copy($source, $destination)
    {
        $filesystem = new Filesystem();
        $filesystem->copy($source, $destination, true);
    }

    /**
     * @param Cart $cart
     * @return array
     */
    public static function get3DSv2Details(Cart $cart)
    {
        $products = $cart->getProducts();
        $quantity = 0;
        foreach ($products as $product) {
            $quantity += $product['cart_quantity'];
        }
        $billingAddr = new Address((int) $cart->id_address_invoice);
        $xmlShoppingCart = sprintf(
            '<?xml version="1.0" encoding="utf-8"?><shoppingcart><total><totalQuantity>%d</totalQuantity></total></shoppingcart>',
            $quantity
        );
        $billingDetails = [
            \Tools::substr($billingAddr->firstname, 0, 30),
            \Tools::substr($billingAddr->lastname, 0, 30),
            \Tools::substr($billingAddr->address1, 0, 40),
            \Tools::substr($billingAddr->postcode, 0, 16),
            \Tools::substr($billingAddr->city, 0, 40),
            Localization::$countryCodes[Country::getIsoById($billingAddr->id_country)]['num'],
        ];
        $xmlBilling = vsprintf(
            '<?xml version="1.0" encoding="utf-8"?><Billing><Address><FirstName>%s</FirstName><LastName>%s</LastName><Address1>%s</Address1><ZipCode>%s</ZipCode><City>%s</City><CountryCode>%d</CountryCode></Address></Billing>',
            $billingDetails
        );

        return [
            'PBX_SHOPPINGCART' => $xmlShoppingCart,
            'PBX_BILLING' => $xmlBilling,
        ];
    }

    /**
     * @param string $value
     * @return array
     */
    public static function getCartIdFromReturn($value)
    {
        $return = array();
        $return['x3'] = false;
        $x = \Tools::substr($value, 1, 1);
        $s = \Tools::substr($value, 0, 2);

        if ($x == 'x') {
            $return['id_cart'] = \Tools::substr($value, 2);
            $return['n'] = (int) \Tools::substr($value, 0, 1);
            if ($return['n'] != 1) {
                $return['x3'] = true;
            }
        } elseif ($s == 's-') {
            $return['id_cart'] = (int) \Tools::substr($value, 2, (\Tools::strpos($value, 'PBX_2MONT')) - 2);
        } else {
            $return['id_cart'] = (int) $value;
        }

        return $return;
    }

    /**
     * @param int $idCustomer
     * @param int $idShop
     * @return array|Up2paySubscriber[]
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public static function getCustomerTokens($idCustomer, $idShop)
    {
        $dbQuery = new DbQuery();
        $dbQuery
            ->select('id_up2pay_subscriber, id_shop, token, refabonne, pan, dateval')
            ->from('up2pay_subscriber')
            ->where(sprintf('id_customer = %d AND id_shop = %d', (int) $idCustomer, (int) $idShop));

        $rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($dbQuery);
        $tokens = [];
        if ($rows) {
            foreach ($rows as $row) {
                $tokens[] = new Up2paySubscriber((int) $row['id_up2pay_subscriber'], null, (int) $row['id_shop']);
            }
        }

        return $tokens;
    }

    /**
     * @param int $idOrder
     * @return Up2payTransaction
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public static function getTransactionByOrderId($idOrder)
    {
        $dbQuery = new DbQuery();
        $dbQuery
            ->select('id_up2pay_transaction')
            ->from('up2pay_transaction')
            ->where(sprintf('id_order = %d', (int) $idOrder));
        $id = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($dbQuery);

        return new Up2payTransaction((int) $id);
    }
}
