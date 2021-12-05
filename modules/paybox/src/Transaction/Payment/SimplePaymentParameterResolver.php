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

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SimplePaymentParameterResolver
 * @package Up2pay\Transaction\Payment
 */
class SimplePaymentParameterResolver extends AbstractPaymentParameterResolver
{
    /** @var array $requiredFields */
    private $requiredFields = [
        'PBX_BILLING',
        'PBX_CMD',
        'PBX_DEVISE',
        'PBX_HASH',
        'PBX_IDENTIFIANT',
        'PBX_LANGUE',
        'PBX_PORTEUR',
        'PBX_RANG',
        'PBX_RETOUR',
        'PBX_SHOPPINGCART',
        'PBX_SITE',
        'PBX_TOTAL',
        'PBX_TIME',
    ];

    /**
     * @param OptionsResolver $resolver
     * @return mixed|void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired($this->requiredFields)
            ->setDefined(array_diff($this->whiteListFields, $this->requiredFields))
            ->setAllowedValues('PBX_HASH', 'SHA512')
            ->setNormalizer(
                'PBX_TOTAL',
                function (Options $options, $value) {
                    return (int) round($value, 0);
                }
            )
            ->setNormalizer(
                'PBX_CMD',
                function (Options $options, $value) {
                    if (isset($options['PBX_REFABONNE'])) {
                        return 'U_1x'.$value;
                    } else {
                        return '1x'.$value;
                    }
                }
            );
    }
}
