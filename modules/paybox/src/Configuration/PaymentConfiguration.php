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
 * Class PaymentConfiguration
 * @package Up2pay\Configuration
 */
class PaymentConfiguration implements JsonSerializable
{
    const DISPLAY_SIMPLE = 'simple';
    const DISPLAY_DETAILED = 'detailed';
    const DEBIT_IMMEDIATE = 'immediate';
    const DEBIT_DEFERRED = 'deferred';
    const CAPTURE_DAYS = 'days';
    const CAPTURE_STATUS = 'status';

    /** @var string $display (simple|detailed) Display a simple payment option or detailed payment methods */
    public $display;

    /** @var string $debitType (immediate|deferred) */
    public $debitType;

    /** @var string $captureEvent (days|status) */
    public $captureEvent;

    /** @var int $deferredDays */
    public $deferredDays;

    /** @var array $captureStatuses */
    public $captureStatuses;

    /** @var array $displayTitle */
    public $displayTitle;

    /** @var string $genericLogoFilename */
    public $genericLogoFilename;

    /** @var bool $oneClickEnabled */
    public $oneClickEnabled;

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'display' => $this->display,
            'debitType' => $this->debitType,
            'captureEvent' => $this->captureEvent,
            'deferredDays' => $this->deferredDays,
            'captureStatuses' => $this->captureStatuses,
            'displayTitle' => $this->displayTitle,
            'genericLogoFilename' => $this->genericLogoFilename,
        ];
    }

    /**
     *
     */
    public function postMapping()
    {
        if ($this->captureStatuses === null) {
            $this->captureStatuses = [];
        }
    }
}
