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

namespace Up2pay\ObjectModel;

use ObjectModel;

/**
 * Class Up2paySubscription
 * @package Up2pay\ObjectModel
 */
class Up2paySubscription extends ObjectModel
{
    /** @var int $id_customer */
    public $id_customer;

    /** @var int $id_order */
    public $id_order;

    /** @var bool $unsubscribed */
    public $unsubscribed;

    /** @var string $abonnement */
    public $abonnement;

    /**
     * @var array $definition
     */
    public static $definition = [
        'table' => 'up2pay_subscription',
        'primary' => 'id_up2pay_subscription',
        'fields' => [
            'id_customer' => ['type' => self::TYPE_INT],
            'id_order' => ['type' => self::TYPE_INT],
            'unsubscribed' => ['type' => self::TYPE_BOOL, 'required' => true, 'size' => 50],
            'abonnement' => ['type' => self::TYPE_STRING, 'required' => false, 'size' => 50],
        ],
    ];
}
