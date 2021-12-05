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
 * Class InstalmentConfiguration
 * @package Up2pay\Configuration
 */
class InstalmentConfiguration implements JsonSerializable
{
    /** @var bool $enabled */
    public $enabled;

    /** @var Instalment[] $instalments */
    public $instalments;

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $firstEnabled = array_filter(
            $this->instalments,
            function ($i) {
                return $i->enabled == true;
            }
        );
        $activeTab = count($firstEnabled) ? array_shift($firstEnabled)->partialPayments : 2;

        return [
            'activeTab' => $activeTab,
            'enabled' => $this->enabled,
            'instalments' => $this->instalments,
        ];
    }

    /**
     *
     */
    public function postMapping()
    {
        if (!$this->enabled && $this->instalments) {
            foreach ($this->instalments as $instalment) {
                $instalment->enabled = false;
            }
        }
    }
}
