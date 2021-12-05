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
 * Class Instalment
 * @package Up2pay\Configuration
 */
class Instalment implements JsonSerializable
{
    /** @var int $partialPayments */
    public $partialPayments;

    /** @var bool $enabled */
    public $enabled;

    /** @var int $daysBetweenPayments */
    public $daysBetweenPayments;

    /** @var int[] $percents */
    public $percents;

    /** @var array $title */
    public $title;

    /** @var string $logoFilename */
    public $logoFilename;

    /** @var float $minAmount */
    public $minAmount;

    /** @var float $maxAmount */
    public $maxAmount;

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'partialPayments' => $this->partialPayments,
            'enabled' => $this->enabled,
            'daysBetweenPayments' => $this->daysBetweenPayments,
            'percents' => $this->percents,
            'title' => $this->title,
            'logoFilename' => $this->logoFilename,
            'minAmount' => $this->minAmount,
            'maxAmount' => $this->maxAmount,
        ];
    }
}
