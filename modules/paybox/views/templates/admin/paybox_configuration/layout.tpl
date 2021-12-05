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

<div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <div id="up2pay-configuration">
      <div class="up2pay-information">
        <i class="icon icon-info-circle"></i>
        {l s='Module version' mod='paybox'} v{$module_version|escape:'html':'UTF-8'} -
        <a data-toggle="modal" data-target="#up2pay-modal-whatsnew" href="#">{l s='What\'s new?' mod='paybox'}</a>
      </div>
      {include file="./_header.tpl"}

      {if $data.configuration.showMarketing !== false}
        {include file="./_marketing.tpl"}
      {/if}

      {if $data.configuration.demoMode !== null}
        {include file="./_demoMode.tpl"}
      {/if}

      {if $data.configuration.environment !== null}
        {include file="./_account.tpl"}
      {/if}

      {if $data.configuration.contract !== null}
        {include file="./_payment.tpl"}
      {/if}

      {if $data.configuration.contract === $data.const.contractPremium}
        {include file="./_instalment.tpl"}
      {/if}

      {if $data.configuration.contract === $data.const.contractPremium}
        {include file="./_subscription.tpl"}
      {/if}
    </div>
  </div>
</div>
<script type="text/javascript">
  var languages = new Array();

  // Multilang field setup must happen before document is ready so that calls to displayFlags() to avoid
  // precedence conflicts with other document.ready() blocks
  {foreach $languages as $k => $language}
  languages[{$k}] = {
    id_lang: {$language.id_lang|escape:'javascript':'UTF-8'},
    iso_code: '{$language.iso_code|escape:'javascript':'UTF-8'}',
    name: '{$language.name|escape:'javascript':'UTF-8'}',
    is_default: '{$language.is_default|escape:'javascript':'UTF-8'}'
  };
  {/foreach}
</script>
