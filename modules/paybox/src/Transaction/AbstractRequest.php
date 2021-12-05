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

namespace Up2pay\Transaction;

use Context;
use Paybox;
use Up2pay\Configuration\Settings;
use Up2pay\Utils\Tools;

/**
 * Class AbstractRequest
 * @package Up2pay\Transaction
 */
abstract class AbstractRequest implements RequestInterface
{
    const REDIRECT_ENDPOINT = 'php/';
    const IFRAME_ENDPOINT = 'cgi/MYframepagepaiement_ip.cgi';
    const TRANSACTION_ENDPOINT = 'PPPS.php';

    /** @var Settings $settings */
    protected $settings;

    /** @var Context $context */
    protected $context;

    /** @var AbstractParameterResolver $resolver */
    protected $resolver;

    /** @var \Monolog\Logger $logger */
    protected $logger;

    /** @var array $parameters */
    protected $parameters;

    /** @var string $pbxHmac */
    public $pbxHmac;

    /**
     * AbstractRequest constructor.
     * @param Paybox                    $module
     * @param Context                   $context
     * @param AbstractParameterResolver $resolver
     */
    public function __construct(Paybox $module, Context $context, AbstractParameterResolver $resolver)
    {
        $this->settings = $module->settings;
        $this->context = $context;
        $this->resolver = $resolver;
        $this->logger = $module->logger;
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * @param array $parameters
     */
    public function setParameters($parameters)
    {
        foreach ($parameters as $name => $value) {
            $this->setParameter($name, $value);
        }
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getParameter($name)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
    }

    /**
     *
     */
    protected function generateHmac()
    {
        $this->pbxHmac = \Tools::strtoupper(hash_hmac('sha512', $this->parametersToString(), $this->settings->account->binKey));
        $this->logger->debug('HMAC generated', ['PBX_HMAC' => $this->pbxHmac, 'params' => $this->parametersToString()]);
    }

    /**
     * @return string
     */
    protected function parametersToString()
    {
        if (isset($this->parameters['PBX_HMAC'])) {
            unset($this->parameters['PBX_HMAC']);
        }

        ksort($this->parameters);

        return Tools::stringify($this->parameters);
    }

    /**
     * @param Settings $settings
     */
    public function overrideSettings($settings)
    {
        $this->settings = $settings;
    }
}
