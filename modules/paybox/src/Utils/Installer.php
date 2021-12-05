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

namespace Up2pay\Utils;

use Configuration;
use Language;
use OrderState;
use PrestaShopBundle\Install\SqlLoader;
use Tab;
use Validate;

/**
 * Class Installer
 * @package Up2pay\Utils
 */
class Installer
{
    /** @var \Paybox $module */
    private $module;

    /**
     * Installer constructor.
     * @param $module
     */
    public function __construct($module)
    {
        $this->module = $module;
    }

    /**
     * @throws \JsonMapper_Exception
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     * @throws \Exception
     */
    public function run()
    {
        $this->checkTechnicalRequirements();
        $this->addMenu(['en' => 'Logs Up2pay', 'fr' => 'Up2pay Logs'], 'AdminPayboxLogs', '', false);
        $this->addMenu(['en' => 'Ajax Up2pay', 'fr' => 'Up2pay Ajax'], 'AdminPayboxAjax', '', false);
        $this->addMenu(['en' => 'Transaction Up2pay', 'fr' => 'Up2pay Transaction'], 'AdminPayboxAjaxTransaction', '', false);
        $this->addMenu(['en' => 'Configuration Up2pay', 'fr' => 'Up2pay Configuration'], 'AdminPayboxConfiguration', '', false);
        $this->registerHooks($this->module->hooks);
        $this->installDb();
        $this->createOrderStatuses([
            [
                'configuration' => 'PBX_AWAITING_CAPTURE_STATUS',
                'color' => '#3498D8',
                'logo' => 'os_capture.gif',
                'template' => 'payment',
                'send_email' => false,
                'invoice' => true,
                'logable' => true,
                'deleted' => 0,
                'names' => ['en' => 'Awaiting Payment Capture by Merchant', 'fr' => 'Débit en attente de confirmation'],
            ],
            [
                'configuration' => 'PBX_PARTIALLY_REFUNDED_STATUS',
                'color' => '#01B887',
                'logo' => 'os_refund.gif',
                'template' => 'refund',
                'send_email' => true,
                'invoice' => true,
                'logable' => true,
                'deleted' => 0,
                'names' => ['en' => 'Partially refunded', 'fr' => 'Partiellement remboursé'],
            ],
        ]);
        $this->initConfiguration();
    }

    /**
     * @param array $tabNames
     * @param string $className
     * @param string $parentClassName
     * @param string $icon
     * @param bool $visible
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     * @throws \Exception
     */
    public function addMenu($tabNames, $className, $parentClassName, $icon = '', $visible = true)
    {
        if (Tab::getIdFromClassName($className)) {
            return;
        }
        $tab = new Tab();
        $tab->class_name = $className;
        $tab->module = $this->module->name;
        $tab->icon = $icon;
        $tab->id_parent = (int) Tab::getIdFromClassName($parentClassName);
        $tab->active = $visible;
        $tab->name = [];
        foreach (Language::getLanguages() as $lang) {
            $isoCode = $lang['iso_code'];
            $tabName = $tabNames[$isoCode] = isset($tabNames[$isoCode]) ? $tabNames[$isoCode] : $tabNames['en'];
            $tab->name[$lang['id_lang']] = $tabName;
        }

        if (!$tab->add()) {
            throw new \Exception('Cannot add menu.');
        }
    }

    /**
     * @param array $hooks
     */
    public function registerHooks($hooks)
    {
        foreach ($hooks as $hook) {
            $this->module->logger->info(sprintf('Register module on %s', $hook));
            $this->module->registerHook($hook);
        }
    }

    /**
     * @throws \JsonMapper_Exception
     */
    public function initConfiguration()
    {
        $this->module->settings->resetConfig();
        $this->module->settings->updatePaymentConfiguration([
            'display' => 'simple',
            'debitType' => 'immediat',
            'displayTitle' => [
                'fr' => 'Paiement sécurisé via Crédit Agricole',
                'en' => 'Secure payment with Crédit Agricole',
            ],
            'genericLogoFilename' => 'CB_VISA_MC.svg',
            'deferredDays' => 2,
        ]);
        $this->module->settings->updateSubscriptionConfiguration([
            'enabled' => false,
            'title' => [
                'fr' => 'Payer par abonnement',
                'en' => 'Pay with subscription',
            ],
            'logoFilename' => 'subscription.svg',
        ]);
        $jsonContracts = \Tools::file_get_contents($this->module->getLocalPath().'install/default_payment_contracts.json');
        if (\Validate::isJson($jsonContracts)) {
            Configuration::updateGlobalValue('UP2P_PAYMENT_METHODS', $jsonContracts);
        }
        $jsonInstalments = \Tools::file_get_contents($this->module->getLocalPath().'install/default_instalments.json');
        if (\Validate::isJson($jsonInstalments)) {
            $this->module->settings->updateInstalmentConfiguration(json_decode($jsonInstalments, true));
        }
        $this->module->logger->info('Default configuration loaded');
    }

    /**
     * @throws \Exception
     */
    public function checkTechnicalRequirements()
    {
        //@formatter:off
        if (extension_loaded('curl') == false) {
            throw new \Exception(
                $this->module->l('You need to enable the cURL extension to use this module.', 'Installer')
            );
        }
        //@formatter:on
        $this->module->logger->info('Configuration meets technical requirements');
    }

    /**
     *
     */
    public function installDb()
    {
        $sqlLoader = new SqlLoader();
        $sqlLoader->setMetaData([
            'PREFIX_' => _DB_PREFIX_,
        ]);
        $sqlLoader->parse_file($this->module->getLocalPath().'install/install.sql');
        $this->module->logger->info('Database updated');
    }

    /**
     * @param array $orderStatuses
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function createOrderStatuses($orderStatuses)
    {
        foreach ($orderStatuses as $orderStatus) {
            $orderState = new OrderState(Configuration::getGlobalValue($orderStatus['configuration']));
            if (!Validate::isLoadedObject($orderState) || $orderState->deleted) {
                $this->module->logger->info(sprintf('Creating order status %s', $orderStatus['configuration']));
                $orderState->hydrate($orderStatus);
                $orderState->name = [];
                $orderState->module_name = pSQL($this->module->name);
                $languages = Language::getLanguages(false);
                foreach ($languages as $language) {
                    $name = isset($orderStatus['names'][$language['iso_code']]) ?
                        $orderStatus['names'][$language['iso_code']] :
                        $orderStatus['names']['en'];
                    $orderState->name[(int) $language['id_lang']] = pSQL($name);
                }
                if ($orderState->save()) {
                    $source = realpath(_PS_MODULE_DIR_.$this->module->name.'/views/img/icons/'.$orderStatus['logo']);
                    $destination = _PS_ROOT_DIR_.'/img/os/'.(int) $orderState->id.'.gif';
                    Tools::copy($source, $destination);
                    Configuration::updateGlobalValue($orderStatus['configuration'], (int) $orderState->id);
                    $this->module->logger->info(sprintf('Order status %s created.', $orderStatus['configuration']));
                }
            } else {
                $this->module->logger->info(sprintf('Order status %s already exists.', $orderStatus['configuration']));
                $orderState->send_email = false;
                $orderState->template = '';
                $orderState->save();
                $this->module->logger->info(
                    sprintf('Order status %s send_email set to false.', $orderStatus['configuration'])
                );
            }
        }
    }
}
