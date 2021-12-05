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

use GuzzleHttp\Client;
use Up2pay\Transaction\Payment\SimplePaymentParameterResolver;
use Up2pay\Transaction\Payment\TestPaymentRequest;

/**
 * Class AdminPayboxAjaxController
 */
class AdminPayboxAjaxController extends ModuleAdminController
{
    /** @var Paybox $module */
    public $module;

    /**
     * @throws JsonMapper_Exception
     * @throws PrestaShopException
     */
    public function ajaxProcessHideMarketingBlock()
    {
        $this->module->settings->updateSettings(['showMarketing' => false]);
        $this->ajaxDie(json_encode([
            'errors' => false,
        ]));
    }

    /**
     * @throws JsonMapper_Exception
     * @throws PrestaShopException
     */
    public function ajaxProcessHideWhatsNew()
    {
        $this->module->settings->updateSettings(['showWhatsNew' => false]);
        $this->ajaxDie(json_encode([
            'errors' => false,
        ]));
    }

    /**
     * @throws PrestaShopException
     * @throws SmartyException
     */
    public function displayAjaxWhatsNew()
    {
        $html = $this->context->smarty->fetch(
            $this->module->getLocalPath().'views/templates/admin/paybox_configuration/modal/_whatsnew.tpl'
        );

        $this->ajaxDie(json_encode([
            'result_html' => $html,
            'errors' => [],
        ]));
    }

    /**
     * @throws PrestaShopException
     * @throws SmartyException
     */
    public function displayAjaxCheckConfig()
    {
        $parameters = [
            'PBX_BILLING' => '<?xml version="1.0" encoding="utf-8"?><Billing><Address><FirstName>John</FirstName><LastName>Doe</LastName><Address1>1 AVENUE DE L\'OPERA</Address1><ZipCode>75001</ZipCode><City>PARIS</City><CountryCode>250</CountryCode></Address></Billing>',
            'PBX_CMD' => 123,
            'PBX_DEVISE' => 978,
            'PBX_HASH' => 'SHA512',
            'PBX_IDENTIFIANT' => $this->module->settings->account->id,
            'PBX_LANGUE' => 'FRA',
            'PBX_PORTEUR' => 'test@test.com',
            'PBX_RANG' => $this->module->settings->account->rank,
            'PBX_RETOUR' => TestPaymentRequest::PBX_RETOUR,
            'PBX_SHOPPINGCART' => '<?xml version="1.0" encoding="utf-8"?><shoppingcart><total><totalQuantity>1</totalQuantity></total></shoppingcart>',
            'PBX_SITE' => $this->module->settings->account->siteNumber,
            'PBX_TIME' => date('c'),
            'PBX_TOTAL' => 1000,
        ];
        $testRequest = new TestPaymentRequest($this->module, new SimplePaymentParameterResolver());
        $testRequest->setParameters($parameters);
        $query = $testRequest->getParameters();
        $client = new Client();
        try {
            $response = $client->post($testRequest->getFormAction(),
                [
                    'body' => $query,
                ]);
            $httpCode = $response->getStatusCode();
        } catch (Exception $e) {
            $this->module->logger->error($e->getMessage());
            $httpCode = 500;
        }

        $settingsArray = json_decode(json_encode($this->module->settings), true);
        $requirements = [
            [
                'text' => $this->module->l('PHP version', 'AdminPayboxAjaxController'),
                'pass' => Tools::version_compare(phpversion(), Paybox::PHP_MIN_VERSION, '>=') >= 0,
            ],
            [
                'text' => $this->module->l('EURO currency installed', 'AdminPayboxAjaxController'),
                'pass' => (int) Currency::getIdByIsoCode('EUR'),
            ],
            [
                'text' => $this->module->l('Up2pay account configured', 'AdminPayboxAjaxController'),
                'pass' => (bool) $this->module->settings->account->isConfigured(),
            ],
        ];
        $data = ['endpointHttpCode' => $httpCode, 'requirements' => $requirements] + $settingsArray;
        $this->context->smarty->assign(['data' => $data]);

        $html = $this->context->smarty->fetch(
            $this->module->getLocalPath().'views/templates/admin/paybox_configuration/modal/_checkConfig.tpl'
        );

        $this->ajaxDie(json_encode([
            'result_html' => $html,
            'errors' => [],
        ]));
    }

    /**
     * @throws PrestaShopException
     * @throws SmartyException
     */
    public function displayAjaxContact()
    {
        $curlVersion = curl_version();
        $this->module->settings->userAccount->hmacTest = '***';
        $this->module->settings->userAccount->hmacProd = '***';
        $account = json_encode($this->module->settings->userAccount);
        $data = [
            'ps_version' => _PS_VERSION_,
            'php_version' => phpversion(),
            'module_version' => $this->module->version,
            'curl_version' => isset($curlVersion['version']) ? $curlVersion['version'] : 'unknown',
            'openssl_version' => OPENSSL_VERSION_TEXT,
            'multishop_enabled' => Shop::isFeatureActive() ? 'yes' : 'no',
            'mode_debug' => _PS_MODE_DEV_ ? 'yes' : 'no',
            'tmp_dir' => sys_get_temp_dir(),
            'main_settings' => Configuration::get('UP2P_SETTINGS'),
            'userAccount_settings' => $account,
            'payment_settings' => Configuration::get('UP2P_PAYMENT_CONFIGURATION'),
            'instalment_settings' => Configuration::get('UP2P_INSTALMENT_CONFIGURATION'),
            'subscription_settings' => Configuration::get('UP2P_SUBSCRIPTION_CONFIGURATION'),
            'module_addons_id' => $this->module->addonsId,
            'modules_list' => $this->getModulesListDebug(),
        ];
        $this->context->smarty->assign(['data' => $data]);

        $html = $this->context->smarty->fetch(
            $this->module->getLocalPath().'views/templates/admin/paybox_configuration/modal/_contact.tpl'
        );

        $this->ajaxDie(json_encode([
            'result_html' => $html,
            'errors' => [],
        ]));
    }

    /**
     * @throws PrestaShopException
     * @throws SmartyException
     */
    public function ajaxProcessResetModal()
    {
        $this->context->smarty->assign([
            'loader' => $this->module->getPathUri().'/views/img/loader.gif',
        ]);
        $html = $this->context->smarty->fetch(
            $this->module->getLocalPath().'views/templates/admin/paybox_configuration/modal/_loading.tpl'
        );

        $this->ajaxDie(json_encode([
            'result_html' => $html,
            'errors' => [],
        ]));
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getModulesListDebug()
    {
        $moduleRepository = \PrestaShopBundle\Kernel\ModuleRepositoryFactory::getInstance()->getRepository();
        $modules = $moduleRepository->getActiveModules();
        $modulesList = array();
        foreach ($modules as $moduleName) {
            $modulesList[$moduleName] = Module::getInstanceByName($moduleName)->version;
        }

        return $modulesList;
    }
}
