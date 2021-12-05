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
use Tools;

/**
 * Class Up2paySubscriber
 * @package Up2pay\ObjectModel
 */
class Up2paySubscriber extends ObjectModel
{
    /** @var int $id_customer */
    public $id_customer;

    /** @var int $id_shop */
    public $id_shop;

    /** @var string $token */
    public $token;

    /** @var string $refabonne */
    public $refabonne;

    /** @var string $pan */
    public $pan;

    /** @var string $bin6 */
    public $bin6;

    /** @var string $dateval */
    public $dateval;

    /** @var string $card_type */
    public $card_type;

    /** @var string $datevalTxt */
    public $datevalTxt;

    /**
     * @var array $definition
     */
    public static $definition = [
        'table' => 'up2pay_subscriber',
        'primary' => 'id_up2pay_subscriber',
        'fields' => [
            'id_customer' => ['type' => self::TYPE_INT],
            'id_shop' => ['type' => self::TYPE_INT],
            'token' => ['type' => self::TYPE_STRING, 'required' => true, 'size' => 50],
            'refabonne' => ['type' => self::TYPE_STRING, 'required' => true, 'size' => 256],
            'pan' => ['type' => self::TYPE_STRING, 'required' => true, 'size' => 50],
            'bin6' => ['type' => self::TYPE_STRING, 'required' => false, 'size' => 50],
            'dateval' => ['type' => self::TYPE_STRING, 'required' => true, 'size' => 50],
            'card_type' => ['type' => self::TYPE_STRING, 'required' => false, 'size' => 50],
        ],
    ];

    /**
     * Up2paySubscriber constructor.
     * @param null $id
     * @param null $id_lang
     * @param null $id_shop
     * @param null $translator
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function __construct($id = null, $id_lang = null, $id_shop = null, $translator = null)
    {
        parent::__construct($id, $id_lang, $id_shop, $translator);
        if ($this->dateval) {
            $this->datevalTxt = sprintf(
                '%s/%s',
                Tools::substr($this->dateval, 2, 2),
                Tools::substr($this->dateval, 0, 2)
            );
        }
    }

    /**
     * @param string $refabonne
     * @param int    $idCustomer
     * @param int    $idShop
     * @param string $token
     * @return int
     */
    public static function exists($refabonne, $idCustomer, $idShop, $token)
    {
        $dbQuery = new \DbQuery();
        $dbQuery
            ->select('id_up2pay_subscriber')
            ->from('up2pay_subscriber')
            ->where(sprintf(
                'id_customer = %d AND id_shop = %d AND refabonne = "%s" AND token = "%s"',
                (int) $idCustomer,
                (int) $idShop,
                pSQL($refabonne),
                pSQL($token)
            ));

        return (int) \Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($dbQuery);
    }

    public static function count($idCustomer, $idShop, $refabonne)
    {
        $dbQuery = new \DbQuery();
        $dbQuery
            ->select('COUNT(id_up2pay_subscriber)')
            ->from('up2pay_subscriber')
            ->where(sprintf(
                'id_customer = %d AND id_shop = %d AND refabonne LIKE "%s"',
                (int) $idCustomer,
                (int) $idShop,
                pSQL('%'.$refabonne.'%')
            ));

        return (int) \Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($dbQuery);
    }
}
