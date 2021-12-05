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

namespace Up2pay\Transaction;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractParameterResolver
 */
abstract class AbstractParameterResolver implements ParameterResolverInterface
{
    /**
     * @var OptionsResolver $resolver
     */
    protected $resolver;

    /**
     * AbstractParameterResolver constructor.
     */
    public function __construct()
    {
        $this->resolver = new OptionsResolver();
        $this->configureOptions($this->resolver);
    }

    /**
     * @param OptionsResolver $resolver
     * @return mixed
     */
    abstract public function configureOptions(OptionsResolver $resolver);
}
