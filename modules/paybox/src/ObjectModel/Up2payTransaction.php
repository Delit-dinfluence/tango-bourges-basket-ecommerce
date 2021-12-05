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

use Configuration;
use DateTime;
use Db;
use ObjectModel;
use OrderHistory;

/**
 * Class Up2payTransaction
 * @package Up2pay\ObjectModel
 */
class Up2payTransaction extends ObjectModel
{
    /** @var int $id_order */
    public $id_order;

    /** @var float $amount */
    public $amount;

    /** @var float $amount_captured */
    public $amount_captured;

    /** @var string $auth_numtrans */
    public $auth_numtrans;

    /** @var string $numtrans */
    public $numtrans;

    /** @var string $numappel */
    public $numappel;

    /** @var int $guarantee_3ds */
    public $guarantee_3ds;

    /** @var string $card_type */
    public $card_type;

    /** @var bool $captured */
    public $captured;

    /** @var string $date_capture */
    public $date_capture;

    /** @var string $date_add */
    public $date_add;

    /**
     * @var array $definition
     */
    public static $definition = [
        'table' => 'up2pay_transaction',
        'primary' => 'id_up2pay_transaction',
        'fields' => [
            'id_order' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'],
            'amount' => ['type' => self::TYPE_FLOAT, 'required' => true],
            'amount_captured' => ['type' => self::TYPE_FLOAT, 'required' => false],
            'auth_numtrans' => ['type' => self::TYPE_STRING, 'required' => false, 'size' => 50],
            'numtrans' => ['type' => self::TYPE_STRING, 'required' => false, 'size' => 50],
            'numappel' => ['type' => self::TYPE_STRING, 'required' => false, 'size' => 50],
            'guarantee_3ds' => ['type' => self::TYPE_INT, 'required' => false, 'size' => 1],
            'card_type' => ['type' => self::TYPE_STRING, 'required' => false, 'size' => 50],
            'captured' => ['type' => self::TYPE_BOOL, 'required' => true, 'size' => 1, 'validate' => 'isBool'],
            'date_capture' => ['type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate'],
            'date_add' => ['type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate'],
        ],
    ];

    /**
     * @return array
     * @throws \Exception
     */
    public function toArray()
    {
        $transactionNumber = $this->captured ? $this->numtrans : $this->auth_numtrans;
        $refundedAmount = $this->getRefundedAmount();

        return [
            'id' => $this->id,
            'idOrder' => $this->id_order,
            'amount' => $this->amount,
            'amountCaptured' => (float) $this->amount_captured,
            'amountRefunded' => (float) $refundedAmount,
            'authNumTrans' => $this->auth_numtrans,
            'numTrans' => $this->numtrans,
            'numAppel' => $this->numappel,
            'guarantee3DS' => $this->guarantee_3ds,
            'cardType' => $this->card_type,
            'captured' => $this->captured,
            'transactionNumber' => $transactionNumber,
            'capturableAmount' => $this->getCapturableAmount(),
            'refundableAmount' => $this->getRefundableAmount(),
        ];
    }

    /**
     * @return float|int
     */
    public function getCapturableAmount()
    {
        return $this->captured ? 0 : $this->amount;
    }

    /**
     * @return float
     * @throws \Exception
     */
    public function getRefundableAmount()
    {
        $datePayment = new DateTime($this->date_add);
        $today = new DateTime('now');
        $interval = $datePayment->diff($today);
        $intervalDays = $interval->format('%a');
        if ($intervalDays > 75) {
            return 0.00;
        }
        $amountRefunded = $this->getRefundedAmount();

        return (float) $this->amount_captured - $amountRefunded;
    }

    /**
     * @return float
     */
    public function getRefundedAmount()
    {
        $dbQuery = new \DbQuery();
        $dbQuery
            ->select('SUM(amount)')
            ->from('up2pay_refund')
            ->where(sprintf('id_up2pay_transaction = %d', (int) $this->id));

        return (float) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($dbQuery);
    }

    /**
     * @param array $fields
     * @param float $amount
     * @return bool
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function setAsCaptured($fields, $amount)
    {
        $history = new OrderHistory();
        $history->id_order = (int) $this->id_order;
        $history->changeIdOrderState(Configuration::get('PS_OS_PAYMENT'), (int) $this->id_order);
        $history->addWithemail();
        $this->numtrans = pSQL($fields['NUMTRANS']);
        $this->captured = 1;
        $this->amount_captured = (float) $amount;
        $this->date_capture = date('Y-m-d H:i:s');

        return $this->update();
    }

    /**
     * @param array $fields
     * @param float $amount
     * @return bool
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function addRefund($fields, $amount)
    {
        Db::getInstance()->insert(
            'up2pay_refund',
            [
                'id_up2pay_transaction' => (int) $this->id,
                'amount' => (float) $amount,
                'numtrans' => pSQL($fields['NUMTRANS']),
                'numappel' => pSQL($fields['NUMAPPEL']),
                'date_add' => date('Y-m-d H:i:s'),
            ]
        );

        $history = new OrderHistory();
        $history->id_order = (int) $this->id_order;
        if ($this->getRefundableAmount() > 0) {
            $history->changeIdOrderState(Configuration::get('PBX_PARTIALLY_REFUNDED_STATUS'), $history->id_order);
        } else {
            $history->changeIdOrderState(Configuration::get('PS_OS_REFUND'), $history->id_order);
        }

        return $history->addWithemail();
    }
}
