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
use Up2pay\Configuration\Contract;
use Up2pay\Configuration\PaymentConfiguration;
use Up2pay\ObjectModel\Up2paySubscriber;
use Up2pay\Transaction\AbstractParameterResolver;
use Up2pay\Utils\Tools;

/**
 * Class TokenPaymentRequest
 * @package Up2pay\Transaction\Payment
 */
class TokenPaymentRequest extends AbstractPaymentRequest
{
    /** @var Up2paySubscriber $subscriber */
    private $subscriber;

    /** @var Contract $contract */
    private $contract;

    /** @var Paybox $module */
    private $module;

    /**
     * TokenPaymentRequest constructor.
     * @param Up2paySubscriber          $subscriber
     * @param Contract                  $contract
     * @param Paybox                    $module
     * @param Context                   $context
     * @param AbstractParameterResolver $resolver
     */
    public function __construct($subscriber, $contract, Paybox $module, Context $context, AbstractParameterResolver $resolver)
    {
        $this->subscriber = $subscriber;
        $this->contract = $contract;
        $this->module = $module;
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
        $this->logger->debug('Token Payment - Request params', $this->parameters);

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

        if ($this->contract->displayType == Contract::DISPLAY_IFRAME) {
            $this->setParameters([
                'PBX_ANNULE' => $this->getParameter('PBX_ANNULE').'&iframe=1',
                'PBX_EFFECTUE' => $this->getParameter('PBX_EFFECTUE').'&iframe=1',
                'PBX_REFUSE' => $this->getParameter('PBX_REFUSE').'&iframe=1',
            ]);
        }

        $this->setParameters([
            'PBX_DATEVAL' => $this->subscriber->dateval,
            'PBX_REFABONNE' => $this->subscriber->refabonne,
            'PBX_RETOUR' => self::PBX_RETOUR,
            'PBX_SOURCE' => 'RWD',
            'PBX_TOKEN' => $this->subscriber->token,
        ]);
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        if (in_array($this->subscriber->card_type, Contract::CB_ALIASES)) {
            return 'CB.svg';
        }
        if (in_array($this->subscriber->card_type, Contract::VISA_ALIASES)) {
            return 'VISA.svg';
        }
        if (in_array($this->subscriber->card_type, Contract::MC_ALIASES)) {
            return 'MC.svg';
        }

        return $this->contract->logoFilename;
    }

    /**
     * @return PaymentOption
     * @throws \SmartyException
     */
    public function getPaymentOption()
    {
        $contract = $this->contract;
        $this->setAdditionalParameters();
        $inputs = $this->getInputs();
        $paymentOption = new PaymentOption();
        $dateValTxt = sprintf(
            '%s/%s',
            \Tools::substr($this->subscriber->dateval, 2, 2),
            \Tools::substr($this->subscriber->dateval, 0, 2)
        );
        $paymentOption->setCallToActionText(sprintf(
            $this->module->l('Pay with my previously stored card - %s****%s - %s', 'TokenPaymentRequest'),
            \Tools::substr($this->subscriber->bin6, 0, 4),
            $this->subscriber->pan,
            $dateValTxt
        ));
        if ($logoFilename = $this->getLogo()) {
            $paymentOption->setLogo($this->settings->path['logos'].$logoFilename);
        }
        if ($contract->displayType == Contract::DISPLAY_REDIRECT) {
            $paymentOption
                ->setInputs($inputs)
                ->setAdditionalInformation($this->context->smarty->fetch('module:paybox/views/templates/front/additionalInformationOneClick.tpl'))
                ->setAction($this->getFormAction());
        } else {
            $paymentOption
                ->setBinary(true)
                ->setAdditionalInformation($this->context->smarty->fetch('module:paybox/views/templates/front/additionalInformationOneClickIframe.tpl'))
                ->setModuleName('up2pay-contract-'.$contract->cardType.'-'.$this->subscriber->id);
            $iframes = $this->context->smarty->getTemplateVars('up2payIframes');
            $iframes[$contract->cardType.'-'.$this->subscriber->id] = $inputs;
            $this->context->smarty->assign(['up2payIframes' => $iframes]);
        }
        $this->context->smarty->assign('iframeFormAction', $this->getIframeFormAction());

        return $paymentOption;
    }
}
