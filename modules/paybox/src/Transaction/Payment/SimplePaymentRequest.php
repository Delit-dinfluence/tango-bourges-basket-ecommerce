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

use PrestaShop\PrestaShop\Core\Payment\PaymentOption;
use Up2pay\Configuration\PaymentConfiguration;

/**
 * Class SimplePaymentRequest
 * @package Up2pay\Transaction\Payment
 */
class SimplePaymentRequest extends AbstractPaymentRequest
{
    /**
     * @return array
     */
    public function getParameters()
    {
        $this->parameters = $this->resolver->resolve($this->parameters);
        $this->generateHmac();
        $this->setParameter('PBX_HMAC', $this->pbxHmac);
        $this->logger->debug('Simple Payment - Request params', $this->parameters);

        return $this->parameters;
    }

    /**
     *
     */
    public function setAdditionalParameters()
    {
        if ($this->settings->paymentConfiguration->debitType == PaymentConfiguration::DEBIT_DEFERRED) {
            if ($this->settings->paymentConfiguration->captureEvent == PaymentConfiguration::CAPTURE_DAYS) {
                $this->setParameter('PBX_DIFF', $this->settings->paymentConfiguration->deferredDays);
            } else {
                $this->setParameter('PBX_AUTOSEULE', 'O');
            }
        }
        $this->setParameters([
            'PBX_RETOUR' => self::PBX_RETOUR,
            'PBX_SOURCE' => 'RWD',
        ]);
    }

    /**
     * @return PaymentOption
     * @throws \SmartyException
     */
    public function getPaymentOption()
    {
        $this->setAdditionalParameters();
        $inputs = $this->getInputs();

        $paymentOption = new PaymentOption();
        $paymentOption
            ->setAction($this->getFormAction())
            ->setCallToActionText($this->settings->paymentConfiguration->displayTitle[$this->context->language->iso_code])
            ->setAdditionalInformation($this->context->smarty->fetch('module:paybox/views/templates/front/additionalInformation.tpl'))
            ->setInputs($inputs);
        if ($logoFilename = $this->settings->paymentConfiguration->genericLogoFilename) {
            $paymentOption->setLogo($this->settings->path['logos'].$logoFilename);
        }
        $this->context->smarty->clearAssign('contract');


        return $paymentOption;
    }
}
