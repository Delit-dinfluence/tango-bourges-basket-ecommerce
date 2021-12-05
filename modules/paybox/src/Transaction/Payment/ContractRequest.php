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

use Address;
use Context;
use Country;
use Paybox;
use PrestaShop\PrestaShop\Core\Payment\PaymentOption;
use Up2pay\Configuration\Contract;
use Up2pay\Configuration\PaymentConfiguration;
use Up2pay\ObjectModel\Up2paySubscriber;
use Up2pay\Transaction\AbstractParameterResolver;

/**
 * Class ContractRequest
 * @package Up2pay\Transaction\Payment
 */
class ContractRequest extends AbstractPaymentRequest
{
    /** @var Contract $contract */
    private $contract;

    /**
     * ContractRequest constructor.
     * @param Contract $contract
     * @param Paybox $module
     * @param Context $context
     * @param AbstractParameterResolver $resolver
     */
    public function __construct(
        Contract $contract,
        Paybox $module,
        Context $context,
        AbstractParameterResolver $resolver
    ) {
        $this->contract = $contract;
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
        $this->logger->debug(sprintf('PM %s - Request params', $this->contract->cardType), $this->parameters);

        return $this->parameters;
    }

    /**
     * @return mixed|void
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
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
        if (in_array($this->contract->cardType, Contract::RWD_CONTRACT)) {
            $this->setParameter('PBX_SOURCE', 'RWD');
        }
        if ($this->contract->cardType == 'PAYPAL') {
            $context = $this->context;
            $invoiceAddress = new Address((int) $context->cart->id_address_invoice);
            $invoiceCountry = new Country((int) $invoiceAddress->id_country, (int) $context->cart->id_lang);
            $paypalData = sprintf(
                '%s %s#%s#%s#%s#%s#%s#%s#%s#%s',
                pSQL($invoiceAddress->firstname),
                pSQL($invoiceAddress->lastname),
                pSQL($invoiceAddress->address1),
                pSQL($invoiceAddress->address2),
                pSQL($invoiceAddress->city),
                pSQL($invoiceAddress->other),
                pSQL($invoiceAddress->postcode),
                pSQL($invoiceCountry->iso_code),
                pSQL($invoiceAddress->phone),
                pSQL($context->shop->name)
            );
            $this->setParameter('PBX_PAYPAL_DATA', $paypalData);
        }
        if ($this->contract->displayType == Contract::DISPLAY_IFRAME) {
            $this->setParameters([
                'PBX_ANNULE' => $this->getParameter('PBX_ANNULE').'&iframe=1',
                'PBX_EFFECTUE' => $this->getParameter('PBX_EFFECTUE').'&iframe=1',
                'PBX_REFUSE' => $this->getParameter('PBX_REFUSE').'&iframe=1',
            ]);
        }
        $this->setParameters([
            'PBX_RETOUR' => self::PBX_RETOUR,
            'PBX_TYPECARTE' => $this->contract->cardType,
            'PBX_TYPEPAIEMENT' => $this->contract->paymentType,
        ]);
    }

    /**
     *
     */
    public function setOneClickParameters()
    {
        if ($this->contract->oneClickEnabled) {
            $customer = $this->context->customer;
            $refAbonne = str_replace(' ', '', $this->context->shop->name).$customer->id.str_replace('@', '', $customer->email);
            $countSubscriptions = Up2paySubscriber::count($customer->id, $this->context->cart->id_shop, $refAbonne);

            if ($countSubscriptions > 0) {
                $refAbonne .= 'c' . $countSubscriptions;
            }
            $oneClickContracts = $this->context->smarty->getTemplateVars('oneClickValues');
            $oneClickContracts[$this->contract->cardType]['withoutAbo'] = [
                'PBX_CMD' => $this->getParameter('PBX_CMD'),
                'PBX_RETOUR' => $this->getParameter('PBX_RETOUR'),
                'PBX_HMAC' => $this->getParameter('PBX_HMAC'),
            ];
            $this->setParameters([
                'PBX_REFABONNE' => $refAbonne,
                'PBX_CMD' => $this->context->cart->id,
                'PBX_RETOUR' => self::PBX_RETOUR_ABO,
            ]);
            $this->parameters = $this->resolver->resolve($this->parameters);
            $this->generateHmac();
            $oneClickContracts[$this->contract->cardType]['withAbo'] = [
                'PBX_REFABONNE' => $this->getParameter('PBX_REFABONNE'),
                'PBX_CMD' => $this->getParameter('PBX_CMD'),
                'PBX_RETOUR' => $this->getParameter('PBX_RETOUR'),
                'PBX_HMAC' => $this->pbxHmac,
            ];
            $this->context->smarty->assign('contract', $this->contract->cardType);
            $this->context->smarty->assign('oneClickValues', $oneClickContracts);
        }
    }

    /**
     * @return PaymentOption
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     * @throws \SmartyException
     */
    public function getPaymentOption()
    {
        $contract = $this->contract;
        $this->setAdditionalParameters();
        $inputs = $this->getInputs();
        $this->setOneClickParameters();
        $paymentOption = new PaymentOption();
        $paymentOption->setCallToActionText($contract->title[$this->context->language->iso_code]);
        if ($logoFilename = $contract->logoFilename) {
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
                ->setModuleName('up2pay-contract-'.$contract->cardType);
            $iframes = $this->context->smarty->getTemplateVars('up2payIframes');
            $iframes[$contract->cardType] = $inputs;
            $this->context->smarty->assign(['up2payIframes' => $iframes]);
        }
        $this->context->smarty->clearAssign('contract');
        $this->context->smarty->assign('iframeFormAction', $this->getIframeFormAction());

        return $paymentOption;
    }
}
