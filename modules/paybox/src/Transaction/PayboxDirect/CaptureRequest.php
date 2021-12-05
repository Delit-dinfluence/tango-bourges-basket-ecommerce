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

namespace Up2pay\Transaction\PayboxDirect;

use Context;
use Paybox;
use Up2pay\Transaction\AbstractParameterResolver;

/**
 * Class CaptureRequest
 * @package Up2pay\Transaction\Payment
 */
class CaptureRequest extends AbstractPayboxDirectRequest
{
    /**
     * CaptureRequest constructor.
     * @param Paybox                    $module
     * @param Context                   $context
     * @param AbstractParameterResolver $resolver
     */
    public function __construct(Paybox $module, Context $context, AbstractParameterResolver $resolver)
    {
        parent::__construct($module, $context, $resolver);
        $this->setDefaultFields();
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        $this->parameters = $this->resolver->resolve($this->parameters);
        $this->generateHmac();
        $this->setParameter('HMAC', $this->pbxHmac);
        $this->logger->debug('Capture - Request params', $this->parameters);

        return $this->parameters;
    }

    /**
     *
     */
    public function setDefaultFields()
    {
        $this->setParameters([
            'VERSION' => self::VERSION,
            'TYPE' => self::TYPE_CAPTURE,
            'SITE' => $this->settings->account->siteNumber,
            'RANG' => $this->settings->account->rank,
            'NUMQUESTION' => time(),
            'HASH' => 'SHA512',
        ]);
    }
}
