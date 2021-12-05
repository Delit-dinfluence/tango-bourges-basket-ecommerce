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

{if isset($up2payModeAlertTest)}
  <div class="alert alert-warning">
    <span>{l s='You are using Up2Pay test environment' mod='paybox'}</span>
  </div>
{elseif isset($up2payModeAlertDemo)}
  <div class="alert alert-warning">
    <span>{l s='You are using Up2Pay demo environment' mod='paybox'}</span>
  </div>
{/if}
