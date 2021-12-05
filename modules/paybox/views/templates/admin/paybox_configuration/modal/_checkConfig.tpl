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

<h4>{l s='Module Requirements' mod='paybox'}</h4>
{foreach $data.requirements as $text => $requirement}
  <p class="requirement">
    <i class="icon {if $requirement.pass}icon-check{else}icon-times{/if}"></i>
    {$requirement.text|escape:'html':'UTF-8'}
  </p>
{/foreach}
<hr>
<h4>{l s='Account configuration' mod='paybox'}</h4>
{if $data.endpointHttpCode === 200}
  <div class="alert alert-success">
    <p>{l s='Your module is correctly configured' mod='paybox'}</p>
  </div>
{else}
<div class="alert alert-warning">
  <p>{l s='The account configuration check failed.' mod='paybox'}</p>
  <p>{l s='Please make sure your account credentials and the environment ("Test" or "Production") are correct and try again.' mod='paybox'}</p>
  <p>{l s='If you have trouble, please contact the e-Transactions support team.' mod='paybox'}</p>
</div>
{/if}
<form class="form-horizontal"
      action="#"
      name="paybox_gateway_form"
      id="paybox-gateway-form"
      method="post"
      enctype="multipart/form-data">
  <div class="form-group">
    <label class="control-label col-lg-3 ">
      <span>{l s='Use secondary gateway' mod='paybox'}</span>
    </label>
    <div class="col-lg-9">
    <span class="switch prestashop-switch fixed-width-md">
        <input type="radio"
               value="1"
               name="up2paySettings[useSecondaryGateway]"
               id="up2paySettings[useSecondaryGateway]_on"
               {if $data.configuration.useSecondaryGateway === true}checked="checked"{/if}>
        <label for="up2paySettings[useSecondaryGateway]_on">{l s='Yes' mod='paybox'}</label>
        <input type="radio"
               value="0"
               name="up2paySettings[useSecondaryGateway]"
               id="up2paySettings[useSecondaryGateway]_off"
               {if $data.configuration.useSecondaryGateway !== true}checked="checked"{/if}>
        <label for="up2paySettings[useSecondaryGateway]_off">{l s='No' mod='paybox'}</label>
        <a class="slide-button btn"></a>
      </span>
    </div>
    <div class="col-lg-9 col-lg-offset-3">
      <div class="help-block">
        {l s='Texte d\'aide' mod='paybox'}
        <span></span>
      </div>
    </div>
  </div>
  <!-- Logs enabled -->
  <h4>{l s='Logs' mod='paybox'}</h4>
  <div class="alert alert-info">
    <p>
      {l s='Click' mod='paybox'}
      <a href="{$link->getAdminLink('AdminPayboxLogs', true, [], ['action' => 'downloadLogFile'])|escape:'html':'UTF-8'}">
        {l s='here' mod='paybox'}
      </a>
      {l s='to download the last log file.' mod='paybox'}
    </p>
    <p>
      {l s='Older files can be accessed on your server, in the "logs" directory of this module.' mod='paybox'}
    </p>
  </div>
  <div class="form-group">
    <label class="control-label col-lg-3 ">
      <span>{l s='Enable verbose logs' mod='paybox'}</span>
    </label>
    <div class="col-lg-9">
      <span class="switch prestashop-switch fixed-width-md">
        <input type="radio"
               value="1"
               name="up2paySettings[logsEnabled]"
               id="up2paySettings[logsEnabled]_on"
               {if $data.configuration.logsEnabled === true}checked="checked"{/if}>
        <label for="up2paySettings[logsEnabled]_on">{l s='Yes' mod='paybox'}</label>
        <input type="radio"
               value="0"
               name="up2paySettings[logsEnabled]"
               id="up2paySettings[logsEnabled]_off"
               {if $data.configuration.logsEnabled !== true}checked="checked"{/if}>
        <label for="up2paySettings[logsEnabled]_off">{l s='No' mod='paybox'}</label>
        <a class="slide-button btn"></a>
      </span>
    </div>
    <div class="col-lg-9 col-lg-offset-3">
      <div class="help-block">
        {l s='The minimum log level will be set to Debug.' mod='paybox'}<br/>
        {l s='Enable this option only if the Support Team asks you to do it.' mod='paybox'}
        <span></span>
      </div>
    </div>
  </div>
  <!-- /Logs enabled -->
  <input type="hidden" name="action" value="saveCheckConfigForm">
  <button type="submit" class="btn btn-primary col-lg-offset-3" value="submitCheckConfig">
    <i class="icon icon-save"></i>
    {l s='Save' mod='paybox'}
  </button>
</form>
