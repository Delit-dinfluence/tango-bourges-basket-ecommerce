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

namespace Up2pay\Transaction\PayboxDirect;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Up2pay\Transaction\AbstractParameterResolver;

/**
 * Class DirectParameterResolver
 * @package Up2pay\Transaction\PayboxDirect
 */
class DirectParameterResolver extends AbstractParameterResolver
{
    /** @var array $fields */
    private $fields = [
        'VERSION',
        'TYPE',
        'SITE',
        'RANG',
        'NUMQUESTION',
        'MONTANT',
        'DEVISE',
        'NUMTRANS',
        'NUMAPPEL',
        'REFERENCE',
        'DATEQ',
        'HASH',
    ];

    /**
     * @param OptionsResolver $resolver
     * @return mixed|void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired($this->fields)
            ->setDefined($this->fields)
            ->setAllowedValues('HASH', 'SHA512')
            ->setNormalizer(
                'MONTANT',
                function (Options $options, $value) {
                    return (int) round($value, 0);
                }
            );
    }

    /**
     * @param array $array
     * @return array|mixed
     */
    public function resolve($array)
    {
        return $this->resolver->resolve($array);
    }
}
