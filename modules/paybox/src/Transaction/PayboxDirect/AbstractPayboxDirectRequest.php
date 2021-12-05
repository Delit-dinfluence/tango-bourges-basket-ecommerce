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

use Up2pay\Configuration\Settings;
use Up2pay\Transaction\AbstractRequest;
use Up2pay\Utils\Tools;

/**
 * Class AbstractPayboxDirectRequest
 * @package Up2pay\Transaction\PayboxDirect
 */
abstract class AbstractPayboxDirectRequest extends AbstractRequest
{
    const TYPE_REFUND = '00014';
    const TYPE_CAPTURE = '00002';
    const VERSION = '00104';

    /**
     * @return string
     */
    public function getEndpoint()
    {
        if ($this->settings->environment === Settings::ENV_TEST) {
            $gateway = $this->settings->useSecondaryGateway ? Tools::SECONDARY_DIRECT_GATEWAY_TEST : Tools::DIRECT_GATEWAY_TEST;
        } else {
            $gateway = $this->settings->useSecondaryGateway ? Tools::SECONDARY_DIRECT_GATEWAY_PROD : Tools::DIRECT_GATEWAY_PROD;
        }

        return $gateway.self::TRANSACTION_ENDPOINT;
    }
}
