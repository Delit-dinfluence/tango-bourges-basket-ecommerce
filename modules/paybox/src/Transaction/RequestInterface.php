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

/**
 * Interface RequestInterface
 */
interface RequestInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function getParameter($name);

    /**
     * @return array
     */
    public function getParameters();

    /**
     * @param string $name
     * @param string $value
     * @return mixed
     */
    public function setParameter($name, $value);

    /**
     * @param array $parameters
     * @return mixed
     */
    public function setParameters($parameters);
}
