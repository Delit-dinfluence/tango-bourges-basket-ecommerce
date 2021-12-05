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

namespace Up2pay\Configuration;

/**
 * Class DemoAccount
 * @package Up2pay\Configuration
 */
class DemoAccount extends Account
{
    const DEMO_RANK = 32;
    const DEMO_ID = 2;
    const DEMO_SITE_NUMBER = 1999888;
    const DEMO_HMAC = '0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF0123456789ABCDEF';

    /**
     * DemoAccount constructor.
     */
    public function __construct()
    {
        $this->siteNumber = self::DEMO_SITE_NUMBER;
        $this->rank = self::DEMO_RANK;
        $this->id = self::DEMO_ID;
        $this->hmacTest = self::DEMO_HMAC;
        $this->hmac = self::DEMO_HMAC;
    }
}
