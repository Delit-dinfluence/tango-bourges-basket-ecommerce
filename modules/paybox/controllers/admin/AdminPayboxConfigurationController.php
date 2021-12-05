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

use Up2pay\Configuration\Settings;

/**
 * Class AdminPayboxConfigurationController
 */
class AdminPayboxConfigurationController extends ModuleAdminController
{
    /** @var Paybox $module */
    public $module;

    /** @var array $authorizedLogoExtensions */
    private $authorizedLogoExtensions = ['png' => IMAGETYPE_PNG, 'gif' => IMAGETYPE_GIF, 'jpg' => IMAGETYPE_JPEG];

    /**
     * AdminPayboxConfigurationController constructor.
     * @throws PrestaShopException
     */
    public function __construct()
    {
        $this->bootstrap = true;
        parent::__construct();
        $this->context->smarty->assign([
            'loader' => $this->module->getPathUri().'/views/img/loader.gif',
        ]);
    }

    /**
     * @param bool $isNewTheme
     */
    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);
        $this->context->controller->addCSS([$this->module->getLocalPath().'/views/css/config.css']);
        //@formatter:off
        Media::addJsDef([
            'up2payAjaxToken' => Tools::getAdminTokenLite('AdminPayboxAjax'),
            'genericErrorMessage' => $this->module->l('An error occurred during the process, please try again', 'AdminPayboxConfigurationController'),
            'instalmentAmountsErrorMessage' => $this->module->l('Instalments maximum amounts must be greater than minimum amounts', 'AdminPayboxConfigurationController'),
            'copyMessage' => $this->module->l('Copied!', 'AdminPayboxConfigurationController'),
        ]);
        Media::addJsDef([
            'showWhatsNew' => $this->module->settings->showWhatsNew === true,
        ]);
        //@formatter:on
    }

    /**
     * @throws SmartyException
     */
    public function setModals()
    {
        $this->modals[] = [
            'modal_id' => 'up2pay-modal-whatsnew',
            'modal_class' => 'modal-lg',
            'modal_title' => $this->module->l('Latest version - What\'s new?', 'AdminPayboxConfigurationController'),
            'modal_content' => $this->createTemplate('modal/_loading.tpl')->fetch(),
        ];
        $this->modals[] = [
            'modal_id' => 'up2pay-modal-check-config',
            'modal_class' => 'modal-lg',
            'modal_title' => $this->module->l('Check the module configuration', 'AdminPayboxConfigurationController'),
            'modal_content' => $this->createTemplate('modal/_loading.tpl')->fetch(),
        ];
        $this->modals[] = [
            'modal_id' => 'up2pay-modal-contact',
            'modal_class' => 'modal-lg',
            'modal_title' => $this->module->l('Contact us', 'AdminPayboxConfigurationController'),
            'modal_content' => $this->createTemplate('modal/_loading.tpl')->fetch(),
        ];
    }

    /**
     * @throws SmartyException
     */
    public function initContent()
    {
        $this->setModals();
        if (Tools::getValue('action') === 'startLogin') {
            $this->module->settings->demoAccount = false;
            $this->module->settings->environment = Settings::ENV_TEST;
        }
        $currency = new Currency((int) Configuration::get('PS_CURRENCY_DEFAULT'));
        $this->context->smarty->assign([
            'data' => json_decode(json_encode($this->module->settings), true),
            'order_statuses' => OrderState::getOrderStates($this->context->language->id),
            'languages' => $this->getLanguages(),
            'default_currency_iso' => $currency->iso_code,
            'module_version' => $this->module->version,
        ]);

        $this->content = $this->createTemplate('layout.tpl')->fetch();
        parent::initContent();
    }

    /**
     * @return bool|ObjectModel
     * @throws JsonMapper_Exception
     */
    public function postProcess()
    {
        $postProcess = parent::postProcess();
        $this->module->settings = new Settings();

        return $postProcess;
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function processStartDemo()
    {
        $this->module->settings->updateSettings([
            'demoMode' => true,
            'environment' => Settings::ENV_TEST,
            'contract' => Settings::CONTRACT_ACCESS,
        ]);
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function processSaveAccountForm()
    {
        $this->module->settings->updateAccount(Tools::getValue('up2payAccount'));
        $this->module->settings->updateSettings(Tools::getValue('up2paySettings'));
        //@formatter:off
        $this->confirmations[] = $this->module->l('Account settings saved successfully', 'AdminPayboxConfigurationController');
        //@formatter:on
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function processSaveCheckConfigForm()
    {
        $this->module->settings->updateSettings(Tools::getValue('up2paySettings'));
        //@formatter:off
        $this->confirmations[] = $this->module->l('Additional settings saved successfully', 'AdminPayboxConfigurationController');
        //@formatter:on
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function processSavePaymentForm()
    {
        $up2payPaymentForm = Tools::getValue('up2payPayment');
        $this->module->settings->updatePaymentConfiguration($up2payPaymentForm);
        if (!isset($up2payPaymentForm['captureStatuses'])) {
            $this->module->settings->updatePaymentConfiguration(['captureStatuses' => []]);
        }
        $this->module->settings->updatePaymentMethods(Tools::getValue('up2payPaymentMethods'));
        //@formatter:off
        $this->confirmations[] = $this->module->l('Payment settings saved successfully', 'AdminPayboxConfigurationController');
        //@formatter:on
        $this->processContractsLogoUpload();
        $this->processGenericLogoUpload();
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function processSaveSubscriptionForm()
    {
        $this->module->settings->updateSubscriptionConfiguration(Tools::getValue('up2paySubscription'));
        //@formatter:off
        $this->confirmations[] = $this->module->l('Subscription settings saved successfully', 'AdminPayboxConfigurationController');
        //@formatter:on
        $this->processSubscriptionLogoUpload();
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function processSaveInstalmentForm()
    {
        $this->module->settings->updateInstalmentConfiguration(Tools::getValue('up2payInstalment'));
        //@formatter:off
        $this->confirmations[] = $this->module->l('Instalment settings saved successfully', 'AdminPayboxConfigurationController');
        //@formatter:on
        $this->processInstalmentLogoUpload();
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function processContractsLogoUpload()
    {
        /** @var \Up2pay\Configuration\Contract[] $contracts */
        $contracts = $this->module->settings->paymentMethods;
        foreach ($contracts as $key => $contract) {
            if (!isset($_FILES['up2payPaymentMethods']['error'][$key]['logo']) ||
                is_array($_FILES['up2payPaymentMethods']['error'][$key]['logo'])
            ) {
                $this->errors[] = sprintf(
                    $this->module->l('%s: Error while uploading logo', 'AdminPayboxConfigurationController'),
                    $contract->identifier
                );
                continue;
            }
            switch ($_FILES['up2payPaymentMethods']['error'][$key]['logo']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    continue 2;
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $this->errors[] = sprintf(
                        $this->module->l('%s: Exceeded filesize limit.', 'AdminPayboxConfigurationController'),
                        $contract->identifier
                    );
                    continue 2;
                default:
                    $this->errors[] = sprintf(
                        $this->module->l('%s: Unknown error.', 'AdminPayboxConfigurationController'),
                        $contract->identifier
                    );
                    continue 2;
            }
            $source = $_FILES['up2payPaymentMethods']['tmp_name'][$key]['logo'];
            list($width, $height, $fileType) = getimagesize($source);
            if (!in_array($fileType, $this->authorizedLogoExtensions)) {
                //@formatter:off
                $this->errors[] = sprintf(
                    $this->module->l('%s: You must submit .png, .gif, or .jpg files only.', 'AdminPayboxConfigurationController'),
                    $contract->identifier
                );
                //@formatter:on
                continue;
            }
            $filename = sprintf(
                '%s.%s',
                md5(time().$contract->identifier),
                array_search($fileType, $this->authorizedLogoExtensions)
            );
            $file = _PS_MODULE_DIR_.$this->module->name.'/views/img/logos/'.$filename;
            if (!move_uploaded_file($source, $file)) {
                $this->errors[] = sprintf(
                    $this->module->l('%s: Cannot upload logo.', 'AdminPayboxConfigurationController'),
                    $contract->identifier
                );
                continue;
            }

            $contract->logoFilename = $filename;
        }
        $this->module->settings->updatePaymentMethods(json_decode(json_encode($contracts), true));
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function processGenericLogoUpload()
    {
        if (!isset($_FILES['up2payPayment']['error']['genericLogo']) ||
            is_array($_FILES['up2payPayment']['error']['genericLogo'])
        ) {
            //@formatter:off
            $this->errors[] = $this->module->l('Error while uploading generic logo', 'AdminPayboxConfigurationController');
            //@formatter:on

            return;
        }
        switch ($_FILES['up2payPayment']['error']['genericLogo']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                //@formatter:off
                $this->errors[] = $this->module->l('Exceeded filesize limit for generic logo.', 'AdminPayboxConfigurationController');
                //@formatter:on

                return;
            default:
                //@formatter:off
                $this->errors[] = $this->module->l('Generic logo: Unknown error.', 'AdminPayboxConfigurationController');
                //@formatter:on

                return;
        }
        $source = $_FILES['up2payPayment']['tmp_name']['genericLogo'];
        list($width, $height, $fileType) = getimagesize($source);
        if (!in_array($fileType, $this->authorizedLogoExtensions)) {
            //@formatter:off
            $this->errors[] = $this->module->l('Generic logo: You must submit .png, .gif, or .jpg files only.', 'AdminPayboxConfigurationController');
            //@formatter:on

            return;
        }
        $filename = sprintf('%s.%s', md5(time()), array_search($fileType, $this->authorizedLogoExtensions));
        $file = _PS_MODULE_DIR_.$this->module->name.'/views/img/logos/'.$filename;
        if (!move_uploaded_file($source, $file)) {
            $this->errors[] = $this->module->l('Cannot upload generic logo.', 'AdminPayboxConfigurationController');

            return;
        }

        $this->module->settings->updatePaymentConfiguration(['genericLogoFilename' => $filename]);
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function processSubscriptionLogoUpload()
    {
        if (!isset($_FILES['up2paySubscription']['error']['logo']) ||
            is_array($_FILES['up2paySubscription']['error']['logo'])
        ) {
            //@formatter:off
            $this->errors[] = $this->module->l('Error while uploading subscription logo', 'AdminPayboxConfigurationController');
            //@formatter:on

            return;
        }
        switch ($_FILES['up2paySubscription']['error']['logo']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                //@formatter:off
                $this->errors[] = $this->module->l('Exceeded filesize limit for subscription logo.', 'AdminPayboxConfigurationController');
                //@formatter:on

                return;
            default:
                //@formatter:off
                $this->errors[] = $this->module->l('Subscription logo: Unknown error.', 'AdminPayboxConfigurationController');
                //@formatter:on

                return;
        }
        $source = $_FILES['up2paySubscription']['tmp_name']['logo'];
        list($width, $height, $fileType) = getimagesize($source);
        if (!in_array($fileType, $this->authorizedLogoExtensions)) {
            //@formatter:off
            $this->errors[] = $this->module->l('Subscription logo: You must submit .png, .gif, or .jpg files only.', 'AdminPayboxConfigurationController');
            //@formatter:on

            return;
        }
        $filename = sprintf('%s.%s', md5(time()), array_search($fileType, $this->authorizedLogoExtensions));
        $file = _PS_MODULE_DIR_.$this->module->name.'/views/img/logos/'.$filename;
        if (!move_uploaded_file($source, $file)) {
            //@formatter:off
            $this->errors[] = $this->module->l('Cannot upload subscription logo.', 'AdminPayboxConfigurationController');
            //@formatter:on

            return;
        }

        $this->module->settings->updateSubscriptionConfiguration(['logoFilename' => $filename]);
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function processInstalmentLogoUpload()
    {
        /** @var \Up2pay\Configuration\Instalment[] $instalments */
        $instalments = $this->module->settings->instalmentConfiguration->instalments;
        foreach ($instalments as $key => $instalment) {
            if (!isset($_FILES['up2payInstalment']['error']['instalments'][$key]['logo']) ||
                is_array($_FILES['up2payInstalment']['error']['instalments'][$key]['logo'])
            ) {
                //@formatter:off
                $this->errors[] = sprintf(
                    $this->module->l('%dx instalment: Error while uploading logo', 'AdminPayboxConfigurationController'),
                    $instalment->partialPayments
                );
                //@formatter:on
                continue;
            }
            switch ($_FILES['up2payInstalment']['error']['instalments'][$key]['logo']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    continue 2;
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    //@formatter:off
                    $this->errors[] = sprintf(
                        $this->module->l('%dx instalment: Exceeded filesize limit.', 'AdminPayboxConfigurationController'),
                        $instalment->partialPayments
                    );
                    //@formatter:on
                    continue 2;
                default:
                    $this->errors[] = sprintf(
                        $this->module->l('%dx instalment: Unknown error.', 'AdminPayboxConfigurationController'),
                        $instalment->partialPayments
                    );
                    continue 2;
            }
            $source = $_FILES['up2payInstalment']['tmp_name']['instalments'][$key]['logo'];
            list($width, $height, $fileType) = getimagesize($source);
            if (!in_array($fileType, $this->authorizedLogoExtensions)) {
                //@formatter:off
                $this->errors[] = sprintf(
                    $this->module->l('%dx instalment: You must submit .png, .gif, or .jpg files only.', 'AdminPayboxConfigurationController'),
                    $instalment->partialPayments
                );
                //@formatter:on
                continue;
            }
            $filename = sprintf(
                '%s.%s',
                md5(time().$instalment->partialPayments),
                array_search($fileType, $this->authorizedLogoExtensions)
            );
            $file = _PS_MODULE_DIR_.$this->module->name.'/views/img/logos/'.$filename;
            if (!move_uploaded_file($source, $file)) {
                $this->errors[] = sprintf(
                    $this->module->l('%dx instalment: Cannot upload logo.', 'AdminPayboxConfigurationController'),
                    $instalment->partialPayments
                );
                continue;
            }

            $instalment->logoFilename = $filename;
        }
        $this->module->settings->updateInstalmentConfiguration([
            'instalments' => json_decode(json_encode($instalments), true),
        ]);
    }
}
