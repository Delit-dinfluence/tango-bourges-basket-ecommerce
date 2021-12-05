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

use JsonSerializable;

/**
 * Class Account
 * @package Up2pay\Configuration
 */
class Account implements JsonSerializable
{
    /** @var string $siteNumber */
    public $siteNumber;

    /** @var string $rank */
    public $rank;

    /** @var string $id */
    public $id;

    /** @var string $hmacTest */
    public $hmacTest;

    /** @var string $hmacProd */
    public $hmacProd;

    /** @var string $hmac */
    public $hmac;

    /** @var string $binKey */
    public $binKey;

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'siteNumber' => $this->siteNumber,
            'rank' => $this->rank,
            'id' => $this->id,
            'hmacTest' => $this->hmacTest,
            'hmacProd' => $this->hmacProd,
        ];
    }

    /**
     *
     */
    public function postMapping()
    {
        $this->siteNumber = preg_replace('/\D/', '', $this->siteNumber);
        $this->rank = preg_replace('/\D/', '', $this->rank);
        $this->id = preg_replace('/\D/', '', $this->id);
    }

    /**
     * @return bool
     */
    public function isConfigured()
    {
        return ($this->siteNumber && $this->rank && $this->id && $this->hmac && $this->binKey);
    }
}
