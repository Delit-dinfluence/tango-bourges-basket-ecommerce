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

use Up2pay\ObjectModel\Up2paySubscriber;

/**
 * Class PayboxStoredCardsModuleFrontController
 */
class PayboxStoredCardsModuleFrontController extends ModuleFrontController
{
    /** @var Paybox $module */
    public $module;

    /** @var bool $redirectStoredCards */
    protected $redirectStoredCards = false;

    /**
     * @throws PrestaShopException
     */
    public function initContent()
    {
        \Up2pay\Utils\Tools::initLogger($this->module, 'Up2payStoredCards');
        if ($this->redirectStoredCards) {
            $this->redirectWithNotifications($this->context->link->getModuleLink('paybox', 'storedcards', []));
        }
        parent::initContent();
        $storedCards = \Up2pay\Utils\Tools::getCustomerTokens($this->context->customer->id, $this->context->shop->id);
        $this->context->smarty->assign([
            'stored_cards' => $storedCards,
            'img_path' => $this->module->getPathUri().'views/img/',
        ]);

        $this->setTemplate('module:paybox/views/templates/front/storedcards.tpl');
    }

    /**
     * @return bool|void
     */
    public function setMedia()
    {
        parent::setMedia();

        return $this->registerStylesheet(
            'up2pay-front',
            'modules/'.$this->module->name.'/views/css/front.css'
        );
    }

    /**
     *
     */
    public function postProcess()
    {
        if (Tools::getValue('delete')) {
            $this->deleteCard();
        }

        parent::postProcess();
    }

    /**
     * @return bool
     */
    public function deleteCard()
    {
        $idStoreCard = (int) Tools::getValue('id_stored_card');
        $tokenSent = Tools::getValue('token');
        $token = Tools::getToken(true, $this->context);
        if (!$idStoreCard || !$tokenSent || $tokenSent != $token) {
            $this->errors[] = $this->module->l('Could not delete stored card.', 'storedcards');

            return false;
        }
        try {
            $subscriber = new Up2paySubscriber((int) $idStoreCard);
            if (!Validate::isLoadedObject($subscriber) || $subscriber->id_customer != $this->context->customer->id) {
                $this->errors[] = $this->module->l('Could not delete stored card.', 'storedcards');

                return false;
            }
            $delete = $subscriber->delete();
        } catch (Exception $e) {
            $this->module->logger->error($e->getMessage());
            $this->errors[] = $this->module->l('Could not delete stored card.', 'storedcards');

            return false;
        }
        if ($delete) {
            $this->success[] = $this->module->l('Card deleted successfully.', 'storedcards');
            $this->redirectStoredCards = true;

            return true;
        } else {
            $this->errors[] = $this->module->l('Could not delete stored card.', 'storedcards');

            return false;
        }
    }
}
