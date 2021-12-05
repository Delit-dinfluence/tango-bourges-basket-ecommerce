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

<div class="up2pay-demo-mode {$data.configuration.environment|escape:'htmlall':'UTF-8'}">
  <span>
    <i class="icon icon-warning"></i>
    {if $data.configuration.demoMode}
      {assign var='mode' value='demo'}
    {else}
      {assign var='mode' value=$data.configuration.environment|escape:'htmlall':'UTF-8'}
    {/if}
    {l s='Your are using the %s mode' sprintf=$mode|upper mod='paybox'}
  </span>
</div>
