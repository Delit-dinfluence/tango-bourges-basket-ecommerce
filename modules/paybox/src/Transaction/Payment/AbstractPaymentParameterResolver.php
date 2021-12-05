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

namespace Up2pay\Transaction\Payment;

use Up2pay\Transaction\AbstractParameterResolver;

/**
 * Class AbstractPaymentParameterResolver
 * @package Up2pay\Transaction\Payment
 */
abstract class AbstractPaymentParameterResolver extends AbstractParameterResolver
{
    /** @var array $whiteListFields */
    protected $whiteListFields = [
        'PBX_2MONT1',
        'PBX_2MONT2',
        'PBX_2MONT3',
        'PBX_ANNULE',
        'PBX_AUTOSEULE',
        'PBX_CMD',
        'PBX_DATEVAL',
        'PBX_DATE2',
        'PBX_DATE3',
        'PBX_DEVISE',
        'PBX_DIFF',
        'PBX_EFFECTUE',
        'PBX_HASH',
        'PBX_HMAC',
        'PBX_IDENTIFIANT',
        'PBX_LANGUE',
        'PBX_PAYPAL_DATA',
        'PBX_PORTEUR',
        'PBX_RANG',
        'PBX_REFABONNE',
        'PBX_REFUSE',
        'PBX_REPONDRE_A',
        'PBX_RETOUR',
        'PBX_SITE',
        'PBX_SOURCE',
        'PBX_TIME',
        'PBX_TOKEN',
        'PBX_TOTAL',
        'PBX_TYPECARTE',
        'PBX_TYPEPAIEMENT',
        'PBX_VERSION',
    ];

    /**
     * @param array $array
     * @return array|mixed
     */
    public function resolve($array)
    {
        return $this->resolver->resolve($array);
    }
}
