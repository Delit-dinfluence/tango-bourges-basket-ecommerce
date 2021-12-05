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

use Paybox;
use Up2pay\Transaction\AbstractParameterResolver;

/**
 * Class TestPaymentRequest
 * @package Up2pay\Transaction\Payment
 */
class TestPaymentRequest extends AbstractPaymentRequest
{
    /**
     * TestPaymentRequest constructor.
     * @param Paybox                    $module
     * @param AbstractParameterResolver $resolver
     */
    public function __construct(Paybox $module, AbstractParameterResolver $resolver)
    {
        $this->settings = $module->settings;
        $this->logger = $module->logger;
        $this->resolver = $resolver;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        $this->parameters = $this->resolver->resolve($this->parameters);
        $this->generateHmac();
        $this->setParameter('PBX_HMAC', $this->pbxHmac);
        $this->logger->debug('Test - Request params', $this->parameters);

        return $this->parameters;
    }

    /**
     * @return mixed|void
     */
    public function setAdditionalParameters()
    {
        return;
    }

    /**
     * @return string
     */
    public function getFormAction()
    {
        return parent::getFormAction();
    }
}
