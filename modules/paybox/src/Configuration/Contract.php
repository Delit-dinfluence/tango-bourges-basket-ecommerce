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
 * Class Contract
 * @package Up2pay\Configuration
 */
class Contract implements JsonSerializable
{
    const DISPLAY_IFRAME = 'iframe';
    const DISPLAY_REDIRECT = 'redirect';
    const RWD_CONTRACT = ['CB', 'AMEX'];
    const CARD_ALIASES = ['CB', 'ELECTRON', 'VISA', 'MAESTRO', 'MASTERCARD', 'VPAY'];
    const CB_IDENTIFIER = 'CB VISA MASTERCARD';
    const CB_ALIASES = ['CB'];
    const VISA_ALIASES = ['VISA', 'ELECTRON', 'VPAY'];
    const MC_ALIASES = ['MASTERCARD', 'MAESTRO'];

    /** @var string $identifier */
    public $identifier;

    /** @var bool $isSelectable */
    public $isSelectable;

    /** @var bool $enabled */
    public $enabled;

    /** @var bool $oneClickEnabled */
    public $oneClickEnabled;

    /** @var bool $oneClickAvailable */
    public $oneClickAvailable;

    /** @var bool $forceRedirect */
    public $forceRedirect;

    /** @var string $displayType */
    public $displayType;

    /** @var array $title */
    public $title;

    /** @var string $logoFilename */
    public $logoFilename;

    /** @var float $minAmount */
    public $minAmount;

    /** @var string $cardType */
    public $cardType;

    /** @var string $paymentType */
    public $paymentType;

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'identifier' => $this->identifier,
            'cardType' => $this->cardType,
            'paymentType' => $this->paymentType,
            'isSelectable' => $this->isSelectable,
            'enabled' => $this->enabled,
            'oneClickEnabled' => $this->oneClickEnabled,
            'oneClickAvailable' => $this->oneClickAvailable,
            'forceRedirect' => $this->forceRedirect,
            'displayType' => $this->displayType,
            'title' => $this->title,
            'logoFilename' => $this->logoFilename,
            'minAmount' => $this->minAmount,
        ];
    }

    /**
     *
     */
    public function postMapping()
    {
        if ($this->forceRedirect === true) {
            $this->displayType = 'redirect';
        }
        if ($this->oneClickAvailable !== true) {
            $this->oneClickEnabled = false;
        }
    }

    /**
     *
     */
    public function disableOneClick()
    {
        $this->oneClickEnabled = false;
    }
}
