{*
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
*}

{include file="module:paybox/views/templates/front/additionalInformationModeAlert.tpl"}

{if isset($contract) && isset($oneClickValues[$contract])}
  <div>
    <input onclick="toggleOneClickRedirect(this, '{$contract|escape:'htmlall':'UTF-8'}');"
           class=""
           name="etransaction_store_card"
           type="checkbox"/>
    <span>{l s='Store my credit card details for future payments' mod='paybox'}</span>
    <p></p>
  </div>
{/if}

<p>{l s='To proceed with the payment, please agree to the terms of service' mod='paybox'}</p>
