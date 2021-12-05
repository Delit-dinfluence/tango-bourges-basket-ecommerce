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

use Up2pay\Configuration\Settings;
use Up2pay\Transaction\AbstractRequest;
use Up2pay\Utils\Tools;

/**
 * Class AbstractPaymentRequest
 * @package Up2pay\Transaction\Payment
 */
abstract class AbstractPaymentRequest extends AbstractRequest
{
    const PBX_RETOUR = 'm:M;r:R;t:T;a:A;b:B;p:P;c:C;s:S;y:Y;e:E;f:F;g:G;n:N;j:J;i:I;w:W;d:D;k:K;';
    const PBX_RETOUR_ABO = 'abo:U;m:M;r:R;t:T;a:A;b:B;p:P;c:C;s:S;y:Y;e:E;f:F;g:G;n:N;j:J;i:I;w:W;d:D;k:K;';

    /**
     * @return mixed
     */
    abstract protected function setAdditionalParameters();

    /**
     * @return array
     */
    protected function getInputs()
    {
        $inputs = [];
        $parameters = $this->getParameters();
        foreach ($parameters as $key => $value) {
            $inputs += [
                $key => ['name' => $key, 'type' => 'hidden', 'value' => $value],
            ];
        }

        return $inputs;
    }

    /**
     * @return string
     */
    private function getGateway()
    {
        if ($this->settings->environment === Settings::ENV_TEST) {
            return ($this->settings->useSecondaryGateway ? Tools::SECONDARY_GATEWAY_TEST : Tools::GATEWAY_TEST);
        } else {
            return ($this->settings->useSecondaryGateway ? Tools::SECONDARY_GATEWAY_PROD : Tools::GATEWAY_PROD);
        }
    }

    /**
     * @return string
     */
    protected function getFormAction()
    {
        $endpoint = self::REDIRECT_ENDPOINT;

        return $this->getGateway().$endpoint;
    }

    /**
     * @return string
     */
    protected function getIframeFormAction()
    {
        $endpoint = self::IFRAME_ENDPOINT;

        return $this->getGateway().$endpoint;
    }
}
