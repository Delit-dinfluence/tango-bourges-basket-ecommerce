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

use Context;
use Paybox;
use PrestaShop\PrestaShop\Core\Payment\PaymentOption;
use Up2pay\Configuration\Instalment;
use Up2pay\Transaction\AbstractParameterResolver;

/**
 * Class InstalmentRequest
 * @package Up2pay\Transaction\Payment
 */
class InstalmentRequest extends AbstractPaymentRequest
{
    /** @var Instalment $instalment */
    private $instalment;

    /**
     * InstalmentRequest constructor.
     * @param Instalment                $instalment
     * @param Paybox                    $module
     * @param Context                   $context
     * @param AbstractParameterResolver $resolver
     */
    public function __construct(
        Instalment $instalment,
        Paybox $module,
        Context $context,
        AbstractParameterResolver $resolver
    ) {
        $this->instalment = $instalment;
        parent::__construct($module, $context, $resolver);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        $this->parameters = $this->resolver->resolve($this->parameters);
        $this->generateHmac();
        $this->setParameter('PBX_HMAC', $this->pbxHmac);
        $this->logger->debug('Instalment - Request params', $this->parameters);

        return $this->parameters;
    }

    /**
     *
     */
    public function setAdditionalParameters()
    {
        $orderTotal = $this->context->cart->getOrderTotal();
        $countInstalment = $this->instalment->partialPayments;
        $totalInstalment = 0;
        for ($i = 0; $i < ($countInstalment - 1); $i++) {
            $amount = round($orderTotal * ($this->instalment->percents[$i] / 100), 2);
            $totalInstalment += $amount;
            if ($i === 0) {
                $this->setParameter('PBX_TOTAL', $amount * 100);
            } else {
                $this->setParameters([
                    'PBX_2MONT'.$i => $amount * 100,
                    'PBX_DATE'.$i => strftime('%d/%m/%Y', strtotime('+'.($this->instalment->daysBetweenPayments * $i).' day')),
                ]);
            }
        }
        $remainingAmount = ($orderTotal - $totalInstalment) * 100;
        $this->setParameters([
            'PBX_CMD' => ['nb' => $countInstalment, 'cart' => $this->context->cart->id],
            'PBX_2MONT'.($countInstalment - 1) => $remainingAmount,
            'PBX_DATE'.($countInstalment - 1) => strftime('%d/%m/%Y', strtotime('+'.($this->instalment->daysBetweenPayments * ($countInstalment - 1)).' day')),
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
        $paymentOption = new PaymentOption();
        $paymentOption
            ->setAction($this->getFormAction())
            ->setCallToActionText($this->instalment->title[$this->context->language->iso_code])
            ->setAdditionalInformation($this->context->smarty->fetch('module:paybox/views/templates/front/additionalInformation.tpl'))
            ->setInputs($this->getInputs());
        if ($logoFilename = $this->instalment->logoFilename) {
            $paymentOption->setLogo($this->settings->path['logos'].$logoFilename);
        }

        return $paymentOption;
    }
}
