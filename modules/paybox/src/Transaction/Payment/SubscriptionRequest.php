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

/**
 * Class SubscriptionRequest
 * @package Up2pay\Transaction\Payment
 */
class SubscriptionRequest extends AbstractPaymentRequest
{
    /**
     * @return array
     */
    public function getParameters()
    {
        $this->parameters = $this->resolver->resolve($this->parameters);
        $this->generateHmac();
        $this->setParameter('PBX_HMAC', $this->pbxHmac);
        $this->logger->debug('Subscription - Request params', $this->parameters);

        return $this->parameters;
    }

    /**
     *
     */
    public function setAdditionalParameters()
    {
        $this->setParameters([
            'PBX_RETOUR' => self::PBX_RETOUR,
            'PBX_SOURCE' => 'RWD',
            'PBX_CMD' => sprintf(
                '%dPBX_2MONT%sPBX_NBPAIE00PBX_FREQ%sPBX_QUAND%sPBX_DELAIS%s',
                $this->context->cart->id,
                str_pad((int) $this->getParameter('PBX_TOTAL'), 10, '0', STR_PAD_LEFT),
                str_pad((int) $this->settings->subscriptionConfiguration->frequency, 2, '0', STR_PAD_LEFT),
                str_pad((int) $this->settings->subscriptionConfiguration->dayOfPayment, 2, '0', STR_PAD_LEFT),
                str_pad((int) $this->settings->subscriptionConfiguration->delay, 3, '0', STR_PAD_LEFT)
            )
        ]);
    }

    /**
     * @return PaymentOption
     * @throws \SmartyException
     */
    public function getPaymentOption()
    {
        $this->setAdditionalParameters();
        $paymentOption = new PaymentOption();
        $paymentOption
            ->setAction($this->getFormAction())
            ->setCallToActionText($this->settings->subscriptionConfiguration->title[$this->context->language->iso_code])
            ->setAdditionalInformation($this->context->smarty->fetch('module:paybox/views/templates/front/additionalInformation.tpl'))
            ->setInputs($this->getInputs());
        if ($logoFilename = $this->settings->subscriptionConfiguration->logoFilename) {
            $paymentOption->setLogo($this->settings->path['logos'].$logoFilename);
        }

        return $paymentOption;
    }
}
