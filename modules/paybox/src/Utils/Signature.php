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

use Exception;

/**
 * Class Signature
 * @package Up2pay\Utils
 */
class Signature
{
    const PUBKEY = 'pubkey.pem';

    /**
     * @param bool   $pub
     * @param string $pass
     * @return bool|resource
     */
    public static function loadKey($pub = true, $pass = '')
    {
        $keyFile = _PS_MODULE_DIR_.'/paybox/'.self::PUBKEY;
        $fileSize = filesize($keyFile);
        if (!$fileSize) {
            return false;
        }
        $fpk = fopen($keyFile, 'r');
        if (!$fpk) {
            return false;
        }
        $fileData = fread($fpk, $fileSize);
        fclose($fpk);
        if (!$fileData) {
            return false;
        }
        if ($pub) {
            $key = openssl_pkey_get_public($fileData);
        } else {
            $key = openssl_pkey_get_private(array($fileData, $pass));
        }

        return $key;
    }

    /**
     * @param $stringArray
     * @return mixed
     */
    public static function uncompressObject($stringArray)
    {
        $baseDecode = 'base64_decode';

        return $baseDecode($stringArray);
    }

    /**
     * @param $queryString
     * @param $data
     * @param $sig
     * @param $url
     */
    public static function getSignedData($queryString, &$data, &$sig, $url)
    {
        $pos = strrpos($queryString, '&');
        $data = \Tools::substr($queryString, 0, $pos);
        $pos = strpos($queryString, '=', $pos) + 1;
        $sig = \Tools::substr($queryString, $pos);
        if ($url) {
            $sig = urldecode($sig);
        }
        $sig = self::uncompressObject($sig);
    }

    /**
     * @param string $queryString
     * @param bool   $url
     * @return int
     * @throws Exception
     */
    public static function verifySignature($queryString, $url)
    {
        $key = self::loadKey();
        $data = '';
        $sig = '';
        if (!$key) {
            throw new Exception('Cannot load .pem key file');
        }

        self::getSignedData($queryString, $data, $sig, $url);

        $queryString = openssl_verify($data, $sig, $key);
        if ($queryString == 0) {
            throw new Exception('Signature has been falsified');
        } elseif ($queryString == -1) {
            throw new Exception('Error during the signature verification');
        }

        return $queryString;
    }
}
