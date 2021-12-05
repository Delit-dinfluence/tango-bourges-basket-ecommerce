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

namespace Up2pay\Configuration;

use Context;
use Configuration;
use JsonMapper;
use JsonSerializable;

/**
 * Class Settings
 * @package Up2pay\Configuration
 */
class Settings implements JsonSerializable
{
    const ENV_TEST = 'test';
    const ENV_PROD = 'production';
    const CONTRACT_ACCESS = 'access';
    const CONTRACT_PREMIUM = 'premium';

    /** @var int|null $idShop */
    private $idShop;

    /** @var int|null $idShopGroup */
    private $idShopGroup;

    /** @var JsonMapper $mapper */
    private $mapper;

    /** @var bool $showMarketing */
    public $showMarketing;

    /** @var bool $showWhatsNew */
    public $showWhatsNew;

    /** @var bool $demoMode */
    public $demoMode;

    /** @var string $environment */
    public $environment;

    /** @var bool $logsEnabled */
    public $logsEnabled;

    /** @var bool $useSecondaryGateway */
    public $useSecondaryGateway;

    /** @var string $contract */
    public $contract;

    /** @var Account $account */
    public $account;

    /** @var Account $userAccount */
    public $userAccount;

    /** @var Account $demoAccount */
    public $demoAccount;

    /** @var PaymentConfiguration $paymentConfiguration */
    public $paymentConfiguration;

    /** @var InstalmentConfiguration $instalmentConfiguration */
    public $instalmentConfiguration;

    /** @var SubscriptionConfiguration $subscriptionConfiguration */
    public $subscriptionConfiguration;

    /** @var Contract[] $paymentMethods */
    public $paymentMethods;

    /** @var array $path */
    public $path;

    /**
     * Settings constructor.
     * @param null|int $idShop
     * @param null|int $idShopGroup
     * @throws \JsonMapper_Exception
     */
    public function __construct($idShop = null, $idShopGroup = null)
    {
        $this->idShop = $idShop;
        $this->idShopGroup = $idShopGroup;
        $this->mapper = new JsonMapper();
        $this->mapper->bEnforceMapType = false;
        $this->mapper->bStrictNullTypes = false;
        $this->mapper->postMappingMethod = 'postMapping';
        $this->loadConfig();
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'configuration' => [
                'showMarketing' => $this->showMarketing,
                'showWhatsNew' => $this->showWhatsNew,
                'environment' => $this->environment,
                'demoMode' => $this->demoMode,
                'logsEnabled' => $this->logsEnabled,
                'useSecondaryGateway' => $this->useSecondaryGateway,
                'contract' => $this->contract,
            ],
            'userAccount' => $this->userAccount,
            'demoAccount' => $this->demoAccount,
            'payment' => $this->paymentConfiguration,
            'subscription' => $this->subscriptionConfiguration,
            'instalment' => $this->instalmentConfiguration,
            'paymentMethods' => $this->paymentMethods,
            'path' => [
                'module' => __PS_BASE_URI__.'modules/paybox/',
                'img' => __PS_BASE_URI__.'modules/paybox/views/img/',
                'doc' => $this->getUserGuideUri(),
            ],
            'const' => [
                'envTest' => self::ENV_TEST,
                'envProd' => self::ENV_PROD,
                'contractAccess' => self::CONTRACT_ACCESS,
                'contractPremium' => self::CONTRACT_PREMIUM,
                'displaySimple' => PaymentConfiguration::DISPLAY_SIMPLE,
                'displayDetailed' => PaymentConfiguration::DISPLAY_DETAILED,
                'debitImmediate' => PaymentConfiguration::DEBIT_IMMEDIATE,
                'debitDeferred' => PaymentConfiguration::DEBIT_DEFERRED,
                'captureDays' => PaymentConfiguration::CAPTURE_DAYS,
                'captureStatus' => PaymentConfiguration::CAPTURE_STATUS,
                'displayRedirect' => Contract::DISPLAY_REDIRECT,
                'displayIframe' => Contract::DISPLAY_IFRAME,
            ],
        ];
    }

    /**
     * @throws \JsonMapper_Exception
     */
    public function loadConfig()
    {
        $this->mapper->map(json_decode($this->get('UP2P_SETTINGS') ? : '[]', true), $this);
        $this->userAccount = $this->mapper->map(json_decode($this->get('UP2P_ACCOUNT') ? : '[]', true), new Account());
        $this->demoAccount = new DemoAccount();
        $this->paymentConfiguration = $this->mapper->map(
            json_decode($this->get('UP2P_PAYMENT_CONFIGURATION') ? : '[]', true),
            new PaymentConfiguration()
        );
        $this->subscriptionConfiguration = $this->mapper->map(
            json_decode($this->get('UP2P_SUBSCRIPTION_CONFIGURATION') ? : '[]', true),
            new SubscriptionConfiguration()
        );
        $this->instalmentConfiguration = $this->mapper->map(
            json_decode($this->get('UP2P_INSTALMENT_CONFIGURATION') ? : '[]', true),
            new InstalmentConfiguration()
        );
        $this->paymentMethods = $this->mapper->mapArray(
            json_decode($this->get('UP2P_PAYMENT_METHODS') ? : '[]', true),
            [],
            'Up2pay\Configuration\Contract'
        );
        $this->postLoading();
    }

    /**
     * @throws \JsonMapper_Exception
     */
    public function resetConfig()
    {
        Configuration::updateGlobalValue('UP2P_SETTINGS', '[]');
        Configuration::updateGlobalValue('UP2P_ACCOUNT', '[]');
        Configuration::updateGlobalValue('UP2P_PAYMENT_CONFIGURATION', '[]');
        Configuration::updateGlobalValue('UP2P_INSTALMENT_CONFIGURATION', '[]');
        Configuration::updateGlobalValue('UP2P_SUBSCRIPTION_CONFIGURATION', '[]');
        Configuration::updateGlobalValue('UP2P_PAYMENT_METHODS', '[]');
    }

    /**
     *
     */
    public function postLoading()
    {
        if ($this->contract == self::CONTRACT_ACCESS) {
            $this->paymentConfiguration->captureEvent = PaymentConfiguration::CAPTURE_DAYS;
            $this->instalmentConfiguration->enabled = false;
            $this->subscriptionConfiguration->enabled = false;
            array_map(
                function ($contract) {
                    return $contract->disableOneClick();
                },
                $this->paymentMethods
            );
        }
        if ($this->demoMode) {
            $this->environment = self::ENV_TEST;
        }
        $this->account = $this->demoMode === true ? $this->demoAccount : $this->userAccount;
        $this->account->hmac = $this->environment == self::ENV_TEST ? $this->account->hmacTest : $this->account->hmacProd;
        if (ctype_xdigit($this->account->hmac)) {
            $this->account->binKey = pack('H*', $this->account->hmac);
        }
        $this->demoAccount->binKey = pack('H*', $this->demoAccount->hmac);
        $this->path = [
            'uri' => __PS_BASE_URI__.'modules/paybox/',
            'img' => __PS_BASE_URI__.'modules/paybox/views/img/',
            'logos' => __PS_BASE_URI__.'modules/paybox/views/img/logos/',
        ];
    }

    /**
     * @param array $account
     * @throws \JsonMapper_Exception
     */
    public function updateAccount($account)
    {
        if (!$account) {
            return;
        }
        $this->mapper->map(array_map('trim', $account), $this->userAccount);
        $accountArray = json_decode(json_encode($this->userAccount), true);
        Configuration::updateValue('UP2P_ACCOUNT', json_encode($accountArray));
    }

    /**
     * @param $paymentConfiguration
     * @throws \JsonMapper_Exception
     */
    public function updatePaymentConfiguration($paymentConfiguration)
    {
        $this->mapper->map($paymentConfiguration, $this->paymentConfiguration);
        $paymentConfigurationArray = json_decode(json_encode($this->paymentConfiguration), true);
        Configuration::updateValue('UP2P_PAYMENT_CONFIGURATION', json_encode($paymentConfigurationArray));
    }

    /**
     * @param $paymentMethods
     * @throws \JsonMapper_Exception
     */
    public function updatePaymentMethods($paymentMethods)
    {
        foreach ($paymentMethods as $key => $paymentMethod) {
            if (!isset($this->paymentMethods[$key])) {
                $this->paymentMethods[$key] = new Contract();
            }
            $this->paymentMethods[$key] = $this->mapper->map($paymentMethod, $this->paymentMethods[$key]);
        }
        $paymentConfigurationArray = json_decode(json_encode($this->paymentMethods), true);
        Configuration::updateValue('UP2P_PAYMENT_METHODS', json_encode($paymentConfigurationArray));
    }

    /**
     * @param $instalmentConfiguration
     * @throws \JsonMapper_Exception
     */
    public function updateInstalmentConfiguration($instalmentConfiguration)
    {
        $this->mapper->map($instalmentConfiguration, $this->instalmentConfiguration);
        $instalmentConfigurationArray = json_decode(json_encode($this->instalmentConfiguration), true);
        Configuration::updateValue('UP2P_INSTALMENT_CONFIGURATION', json_encode($instalmentConfigurationArray));
    }

    /**
     * @param $subscriptionConfiguration
     * @throws \JsonMapper_Exception
     */
    public function updateSubscriptionConfiguration($subscriptionConfiguration)
    {
        $this->mapper->map($subscriptionConfiguration, $this->subscriptionConfiguration);
        $subscriptionConfigurationArray = json_decode(json_encode($this->subscriptionConfiguration), true);
        Configuration::updateValue('UP2P_SUBSCRIPTION_CONFIGURATION', json_encode($subscriptionConfigurationArray));
    }

    /**
     * @param array $settings
     * @throws \JsonMapper_Exception
     */
    public function updateSettings($settings)
    {
        $this->mapper->map($settings, $this);
        $settingsArray = json_decode(json_encode($this), true);
        Configuration::updateValue('UP2P_SETTINGS', json_encode($settingsArray['configuration']));
    }

    /**
     * @param string $cardType
     * @return Contract|null
     */
    public function getContractByIdentifier($cardType)
    {
        if (in_array($cardType, Contract::CARD_ALIASES)) {
            $cardType = Contract::CB_IDENTIFIER;
        }

        foreach ($this->paymentMethods as $paymentMethod) {
            if ($paymentMethod->identifier === $cardType) {
                return $paymentMethod;
            }
        }

        return null;
    }

    /**
     * Return user guide url
     * @return string
     */
    private function getUserGuideUri()
    {
        $isoCode = Context::getContext()->language->iso_code;

        $basePath = _PS_MODULE_DIR_ .  'paybox/views/docs/';
        $fileName = 'user_guide.pdf';

        $filePath = $basePath . $isoCode . '/' . $fileName;

        if (file_exists($filePath)) {
            return str_replace(_PS_MODULE_DIR_, __PS_BASE_URI__ . 'modules/', $filePath);
        }

        $filePath = $basePath . 'en/' . $fileName;

        if (file_exists($filePath)) {
            return str_replace(_PS_MODULE_DIR_, __PS_BASE_URI__ . 'modules/', $filePath);
        }

        return '#';
    }

    /**
     * @param string $key
     * @return string
     */
    private function get($key)
    {
        return Configuration::get($key, null, $this->idShopGroup, $this->idShop);
    }
}
