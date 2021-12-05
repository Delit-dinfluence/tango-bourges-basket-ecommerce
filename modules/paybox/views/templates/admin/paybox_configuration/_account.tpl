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

<div class="panel js-up2pay-account-form">
  <form class="form-horizontal"
        action="#"
        name="paybox_account_form"
        id="paybox-account-form"
        method="post"
        enctype="multipart/form-data">
    <div class="panel-heading"><i class="icon-user"></i> {l s='My Account' mod='paybox'}</div>
    <div class="row">
      <div class="up2pay-account col-xs-12">
        <!-- Demo mode -->
        <div class="form-group js-up2pay-demo-mode-block">
          <label class="control-label col-lg-3 ">
            <span>
              {l s='Use demo mode' mod='paybox'}
            </span>
          </label>
          <div class="col-lg-9 js-up2pay-demo-mode-switch">
            <span class="switch prestashop-switch fixed-width-xxl">
              <input type="radio"
                     value="1"
                     name="up2paySettings[demoMode]"
                     id="up2paySettings_demoMode_on"
                     {if $data.configuration.demoMode}checked="checked"{/if}> 
              <label for="up2paySettings_demoMode_on">{l s='Yes' mod='paybox'}</label>
              <input type="radio"
                     value="0"
                     name="up2paySettings[demoMode]"
                     id="up2paySettings_demoMode_off"
                     {if !$data.configuration.demoMode}checked="checked"{/if}>
              <label for="up2paySettings_demoMode_off">{l s='No' mod='paybox'}</label>
              <a class="slide-button btn"></a>
            </span>
          </div>
          <div class="col-lg-9 col-lg-offset-3">
            <div class="help-block">
              {l s='With demo mode you can check this module and fonctionalities of Up2pay e-Transactions solution.' mod='paybox'}
              <span></span>
            </div>
          </div>
        </div>
        <!-- /Demo mode -->
        <!-- Environment -->
        <div class="form-group js-up2pay-env-block">
          <label class="control-label col-lg-3 ">
            <span>
              {l s='Environment' mod='paybox'}
            </span>
          </label>
          <div class="col-lg-9">
            <span class="switch prestashop-switch fixed-width-xxl">
              <input type="radio"
                     value="{$data.const.envTest|escape:'htmlall':'UTF-8'}"
                     name="up2paySettings[environment]"
                     id="up2paySettings_environment_test"
                     {if $data.configuration.environment != $data.const.envProd}checked="checked"{/if}>
              <label for="up2paySettings_environment_test">{l s='Test' mod='paybox'}</label>
              <input type="radio"
                     value="{$data.const.envProd|escape:'htmlall':'UTF-8'}"
                     name="up2paySettings[environment]"
                     id="up2paySettings_environment_prod"
                     {if $data.configuration.environment == $data.const.envProd}checked="checked"{/if}>
              <label for="up2paySettings_environment_prod">{l s='Production' mod='paybox'}</label>
              <a class="slide-button btn"></a>
            </span>
          </div>
          <div class="col-lg-9 col-lg-offset-3">
            <div class="help-block">
              {l s='On TEST environment, simulated payments are not real transactions.' mod='paybox'}
              <span></span>
            </div>
          </div>
        </div>
        <!-- /Environment -->
        <div class="js-up2pay-credentials-block">
          <!-- Site Number -->
          <div class="form-group">
            <label class="control-label col-lg-3 required">
              <span>{l s='Site Number' mod='paybox'}</span>
            </label>
            <div class="col-lg-9">
              <div class="fixed-width-xxl">
                <input value="{$data.userAccount.siteNumber|escape:'htmlall':'UTF-8'}"
                       type="text"
                       name="up2payAccount[siteNumber]"
                       maxlength="7"
                       class="input fixed-width-xxl"
                       required="required">
              </div>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='7-digit number - Informations founded in you welcome email.' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /Site Number -->
          <!-- Rank -->
          <div class="form-group">
            <label class="control-label col-lg-3 required">
              <span>{l s='Rank' mod='paybox'}</span>
            </label>
            <div class="col-lg-9">
              <div class="fixed-width-xxl">
                <input value="{$data.userAccount.rank|escape:'htmlall':'UTF-8'}"
                       type="text"
                       name="up2payAccount[rank]"
                       maxlength="3"
                       class="input fixed-width-xxl"
                       required="required">
              </div>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='2 or 3-digit number' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /Rank -->
          <!-- UP2Pay ID -->
          <div class="form-group">
            <label class="control-label col-lg-3 required">
              <span>{l s='ID' mod='paybox'}</span>
            </label>
            <div class="col-lg-9">
              <div class="fixed-width-xxl">
                <input value="{$data.userAccount.id|escape:'htmlall':'UTF-8'}"
                       type="text"
                       name="up2payAccount[id]"
                       maxlength="9"
                       class="input fixed-width-xxl"
                       required="required">
              </div>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='1-digit to 9-digit number' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /UP2Pay ID -->
          <!-- HMAC test -->
          <div class="form-group js-up2pay-hmac-test-block">
            <label class="control-label col-lg-3 required">
              <span>{l s='TEST HMAC key' mod='paybox'}</span>
            </label>
            <div class="col-lg-9">
              <div class="fixed-width-xxl">
                <input value="{$data.userAccount.hmacTest|escape:'htmlall':'UTF-8'}"
                       type="text"
                       pattern="[A-Fa-f0-9]{literal}{128}{/literal}"
                       name="up2payAccount[hmacTest]"
                       class="input fixed-width-xxl"
                       required="required">
              </div>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='Generate your HMAC secret key in you Vision Back-Office in Test environment' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /HMAC test -->
          <!-- HMAC prod -->
          <div class="form-group js-up2pay-hmac-prod-block">
            <label class="control-label col-lg-3 required">
              <span>{l s='PRODUCTION HMAC key' mod='paybox'}</span>
            </label>
            <div class="col-lg-9">
              <div class="fixed-width-xxl">
                <input value="{$data.userAccount.hmacProd|escape:'htmlall':'UTF-8'}"
                       type="text"
                       pattern="[A-Fa-f0-9]{literal}{128}{/literal}"
                       name="up2payAccount[hmacProd]"
                       class="input fixed-width-xxl"
                       required="required">
              </div>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='Generate your HMAC secret key in you Vision Back-Office in Production environment' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /HMAC prod -->
        </div>
        <div class="js-up2pay-demo-credentials-block">
          <!-- Site Number -->
          <div class="form-group">
            <label class="control-label col-lg-3 required">
              <span>{l s='Site Number' mod='paybox'}</span>
            </label>
            <div class="col-lg-9">
              <div class="fixed-width-xxl">
                <input value="{$data.demoAccount.siteNumber|escape:'htmlall':'UTF-8'}"
                       type="text"
                       name="up2payDemoAccount[siteNumber]"
                       maxlength="7"
                       class="input fixed-width-xxl"
                       disabled="disabled">
              </div>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='7-digit number - Informations founded in you welcome email.' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /Site Number -->
          <!-- Rank -->
          <div class="form-group">
            <label class="control-label col-lg-3 required">
              <span>{l s='Rank' mod='paybox'}</span>
            </label>
            <div class="col-lg-9">
              <div class="fixed-width-xxl">
                <input value="{$data.demoAccount.rank|escape:'htmlall':'UTF-8'}"
                       type="text"
                       name="up2payDemoAccount[rank]"
                       maxlength="2"
                       class="input fixed-width-xxl"
                       disabled="disabled">
              </div>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='2 or 3-digit number' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /Rank -->
          <!-- UP2Pay ID -->
          <div class="form-group">
            <label class="control-label col-lg-3 required">
              <span>{l s='ID' mod='paybox'}</span>
            </label>
            <div class="col-lg-9">
              <div class="fixed-width-xxl">
                <input value="{$data.demoAccount.id|escape:'htmlall':'UTF-8'}"
                       type="text"
                       name="up2payDemoAccount[id]"
                       maxlength="9"
                       class="input fixed-width-xxl"
                       disabled="disabled">
              </div>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='1-digit to 9-digit number' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /UP2Pay ID -->
          <!-- HMAC -->
          <div class="form-group">
            <label class="control-label col-lg-3 required">
              <span>{l s='HMAC key' mod='paybox'}</span>
            </label>
            <div class="col-lg-9">
              <div class="fixed-width-xxl">
                <input value="{$data.demoAccount.hmacTest|escape:'htmlall':'UTF-8'}"
                       type="text"
                       name="up2payDemoAccount[hmac]"
                       class="input fixed-width-xxl"
                       disabled="disabled">
              </div>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='Texte d\'aide' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /HMAC -->
        </div>
        <div class="clearfix"></div>
        <!-- Contract -->
        <div class="form-group">
          <label class="control-label col-lg-3 ">
            <span>
              {l s='Up2pay e-Transactions offer subscribed' mod='paybox'}
            </span>
          </label>
          <div class="col-lg-9">
            <span class="switch prestashop-switch fixed-width-xxl">
              <input type="radio"
                     value="{$data.const.contractAccess|escape:'html':'UTF-8'}"
                     name="up2paySettings[contract]"
                     id="up2paySettings[contract]_on"
                     {if $data.configuration.contract != $data.const.contractPremium}checked="checked"{/if}>
              <label for="up2paySettings[contract]_on">{l s='Access' mod='paybox'}</label>
              <input type="radio"
                     value="{$data.const.contractPremium|escape:'html':'UTF-8'}"
                     name="up2paySettings[contract]"
                     id="up2paySettings[contract]_off"
                     {if $data.configuration.contract == $data.const.contractPremium}checked="checked"{/if}>
              <label for="up2paySettings[contract]_off">{l s='Premium' mod='paybox'}</label>
              <a class="slide-button btn"></a>
            </span>
          </div>
          <div class="col-lg-9 col-lg-offset-3">
            <div class="help-block">
              {l s='Up2pay e-Transactions offer subscribed with your Credit Agricole Regional Bank' mod='paybox'}
              <span></span>
            </div>
          </div>
        </div>
        <!-- /Contract -->
        <input type="hidden" name="action" value="saveAccountForm"/>
      </div>
    </div>
    <div class="panel-footer">
      <button type="submit" class="btn btn-default pull-right" name="submitPayboxAccountForm">
        <i class="process-icon-save"></i> {l s='Save' mod='paybox'}
      </button>
    </div>
  </form>
</div>
