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

<div class="panel js-up2pay-subscription-form">
  <form class="form-horizontal"
        action="#"
        name="paybox_subscription_form"
        id="paybox-subscription-form"
        method="post"
        enctype="multipart/form-data">
    <div class="panel-heading"><i class="icon-credit-card"></i> {l s='SUBSCRIPTION PAYMENT CONFIGURATION' mod='paybox'}</div>
    <div class="row">
      <div class="up2pay-subscription col-xs-12">
        <!-- Abonnement activé -->
        <div class="form-group js-up2pay-subscription-enabled-block">
          <label class="control-label col-lg-3 ">
            <span>
              {l s='Enable subscription' mod='paybox'}
            </span>
          </label>
          <div class="col-lg-9 js-up2pay-subscription-enabled-switch">
            <span class="switch prestashop-switch fixed-width-xxl">
              <input type="radio"
                     value="1"
                     name="up2paySubscription[enabled]"
                     id="up2paySubscription_enabled"
                     {if $data.subscription.enabled === true}checked="checked"{/if}>
              <label for="up2paySubscription_enabled">{l s='Yes' mod='paybox'}</label>
              <input type="radio"
                     value="0"
                     name="up2paySubscription[enabled]"
                     id="up2paySubscription_disabled"
                     {if $data.subscription.enabled !== true}checked="checked"{/if}>
              <label for="up2paySubscription_disabled">{l s='No' mod='paybox'}</label>
              <a class="slide-button btn"></a>
            </span>
          </div>
          <div class="col-lg-9 col-lg-offset-3">
            <div class="help-block">
              {l s='Propose subscription payment option to your customers' mod='paybox'}
              <span></span>
            </div>
          </div>
        </div>
        <!-- /Abonnement activé -->
        <div class="js-up2pay-subscription-inputs-block">
          <!-- Libellé abonnement -->
          <div class="form-group">
            <label class="control-label col-lg-3 ">
            <span>
              {l s='Title displayed on your payment page' mod='paybox'}
            </span>
            </label>
            <div class="col-lg-9">
              {foreach from=$languages item=language}
                <div class="translatable-field flex lang-{$language.id_lang|intval}" {if $language.iso_code != $lang_iso}style="display:none;"{/if}>
                  <div class="col-lg-5">
                    <input type="text"
                           id="up2pay-subscription-text-{$language.id_lang|intval}"
                           name="up2paySubscription[title][{$language.iso_code|escape:'html':'UTF-8'}]"
                           class=""
                           value="{$data['subscription']['title'][$language.iso_code|escape:'html':'UTF-8']}">
                  </div>
                  <div class="col-lg-2">
                    <button type="button"
                            class="btn btn-default dropdown-toggle"
                            tabindex="-1"
                            data-toggle="dropdown">
                      {$language.iso_code|escape:'html':'UTF-8'}
                      <i class="icon-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu">
                      {foreach from=$languages item=language}
                        <li>
                          <a href="javascript:hideOtherLanguage({$language.id_lang|intval});" tabindex="-1">
                            {$language.name|escape:'html':'UTF-8'}
                          </a>
                        </li>
                      {/foreach}
                    </ul>
                  </div>
                </div>
              {/foreach}
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='Title of subscription payment option displayed on your page with means of payment choices' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /Libellé abonnement -->
          <!-- Logo -->
          <div class="form-group">
            <label class="control-label col-lg-3 ">
            <span>
              {l s='Logo displayed on your payment page' mod='paybox'}
            </span>
            </label>
            <div class="col-lg-9">
              {if $data.subscription.logoFilename}
                <img class="preview-logo"
                     src="{$data.path.img|escape:'html':'UTF-8'}logos/{$data.subscription.logoFilename|escape:'html':'UTF-8'}"/>
              {/if}
              <input type="hidden"
                     name="up2paySubscription[logoFilename]"
                     value="{$data.subscription.logoFilename|escape:'html':'UTF-8'}"/>
              <input type="file"
                     name="up2paySubscription[logo]"
                     id="up2paySubscription[logo]"
                     class="up2pay-upload js-up2pay-upload"/>
              <label for="up2paySubscription[logo]">
                <i class="icon icon-upload"></i>
                <span>
                      {l s='Upload' mod='paybox'}
                    </span>
              </label>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='You can upload here a new logo (file types accepted for logos are: .png .gif .jpg only)' mod='paybox'}<br />
                {l s='We recommend that you use images with 30px height & 120px length maximum' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /Logo -->
          <!-- Jour de l'échéance -->
          <div class="form-group">
            <label class="control-label col-lg-3 ">
            <span>
              {l s='Day of payment' mod='paybox'}
            </span>
            </label>
            <div class="col-lg-9">
              <select name="up2paySubscription[dayOfPayment]" class="fixed-width-sm">
                {for $day=0 to 28}
                  <option value="{$day|intval}" {if $data.subscription.dayOfPayment == $day}selected{/if}>
                    {$day|intval}
                  </option>
                {/for}
              </select>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='Choose 0 in order to have each payment the same day in month than the one of the first order. If month doesn\'t contain the day indicated, le last day of the month will be used.' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /Jour de l'échéance -->
          <!-- Fréquence -->
          <div class="form-group">
            <label class="control-label col-lg-3 ">
            <span>
              {l s='Frequency of payment' mod='paybox'}
            </span>
            </label>
            <div class="col-lg-9">
              <select name="up2paySubscription[frequency]" class="fixed-width-sm">
                {for $month=1 to 6}
                  <option value="{$month|intval}" {if $data.subscription.frequency == $month}selected{/if}>
                    {$month|intval}
                  </option>
                {/for}
              </select>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='In months - 1 = every month, 2 = every 2 months, …' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /Fréquence -->
          <!-- Jour différé -->
          <div class="form-group">
            <label class="control-label col-lg-3 ">
            <span>
              {l s='Delay to start subscription' mod='paybox'}
            </span>
            </label>
            <div class="col-lg-9">
              <input name="up2paySubscription[delay]"
                     class="fixed-width-sm"
                     type="number"
                     max="999"
                     min="0"
                     value="{$data.subscription.delay|intval}"/>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='Delay in days to wait before to start subscription (also with frequency and day of payment configuration)' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /Jour différé -->
          <!-- Minimum amount of order -->
          <div class="form-group">
            <label class="control-label col-lg-3 ">
            <span>
              {l s='Minimum amoount of order to display payment option' mod='paybox'}
            </span>
            </label>
            <div class="col-lg-9">
              <div class="input-group fixed-width-md">
                <input value="{$data.subscription.minAmount|floatval}"
                       type="text"
                       onchange="this.value = parseFloat(this.value.replace(/,/g, '.')) || 0"
                       name="up2paySubscription[minAmount]">
                <span class="input-group-addon">
                  {$default_currency_iso|escape:'html':'UTF-8'}
                </span>
              </div>
            </div>
          </div>
          <!-- /Minimum amount of order -->
        </div>
        <input type="hidden" name="action" value="saveSubscriptionForm"/>
      </div>
    </div>
    <div class="panel-footer">
      <button type="submit" class="btn btn-default pull-right" name="submitPayboxSubscriptionForm">
        <i class="process-icon-save"></i> {l s='Save' mod='paybox'}
      </button>
    </div>
  </form>
</div>
