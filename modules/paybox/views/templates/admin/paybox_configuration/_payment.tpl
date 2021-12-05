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

<div class="panel js-up2pay-payment-form">
  <form class="form-horizontal"
        action="#"
        name="paybox_payment_form"
        id="paybox-payment-form"
        method="post"
        enctype="multipart/form-data">
    <div class="panel-heading"><i class="icon-credit-card"></i> {l s='Payment configuration' mod='paybox'}</div>
    <div class="row">
      <div class="up2pay-payment col-xs-12">
        <!-- Affichage moyens de paiement -->
        <div class="form-group js-up2pay-payment-display-block">
          <label class="control-label col-lg-3 ">
            <span>
              {l s='Display of payment methods' mod='paybox'}
            </span>
          </label>
          <div class="col-lg-9 js-up2pay-payment-display-switch">
            <span class="switch prestashop-switch fixed-width-xxl">
              <input type="radio"
                     value="{$data.const.displaySimple|escape:'html':'UTF-8'}"
                     name="up2payPayment[display]"
                     id="up2payPayment_display_simple"
                     {if $data.payment.display == $data.const.displaySimple}checked="checked"{/if}>
              <label for="up2payPayment_display_simple">{l s='Grouped' mod='paybox'}</label>
              <input type="radio"
                     value="{$data.const.displayDetailed|escape:'html':'UTF-8'}"
                     name="up2payPayment[display]"
                     id="up2payPayment_display_detailed"
                     {if $data.payment.display != $data.const.displaySimple}checked="checked"{/if}>
              <label for="up2payPayment_display_detailed">{l s='Advanced' mod='paybox'}</label>
              <a class="slide-button btn"></a>
            </span>
          </div>
          <div class="col-lg-9 col-lg-offset-3">
            <div class="help-block">
              {l s='[1]Grouped: [/1]display only one payment button for all means of payment' mod='paybox' tags=['<strong>']}<br />
              {l s='[1]Advanced: [/1]display one button for each means of payment activated' mod='paybox' tags=['<strong>']}
              <span></span>
            </div>
          </div>
        </div>
        <!-- /Affichage moyens de paiement -->
        <!-- Texte generique -->
        <div class="form-group js-up2pay-display-text-block">
          <label class="control-label col-lg-3 ">
            <span>
              {l s='Title displayed on your payment page' mod='paybox'}
            </span>
          </label>
          <div class="col-lg-9">
            {foreach from=$languages item=language}
              <div class="translatable-field flex lang-{$language.id_lang|intval}" {if $language.iso_code != $lang_iso} style="display:none;"{/if}>
                <div class="col-lg-5">
                  <input type="text"
                         id="up2pay-display-text-{$language.id_lang|intval}"
                         name="up2payPayment[displayTitle][{$language.iso_code|escape:'html':'UTF-8'}]"
                         class=""
                         value="{$data['payment']['displayTitle'][$language.iso_code|escape:'html':'UTF-8']}">
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
              {l s='Title of generic payment option displayed on your page with means of payment choices' mod='paybox'}
              <span></span>
            </div>
          </div>
        </div>
        <!-- /Texte generique -->
        <!-- Logo -->
        <div class="form-group js-up2pay-logo-block">
          <label class="control-label col-lg-3 ">
            <span>
              {l s='Logo displayed on your payment page' mod='paybox'}
            </span>
          </label>
          <div class="col-lg-9">
            {if $data.payment.genericLogoFilename}
              <img class="preview-logo"
                   src="{$data.path.img|escape:'html':'UTF-8'}logos/{$data.payment.genericLogoFilename|escape:'html':'UTF-8'}"/>
            {/if}
            <input type="hidden"
                   name="up2payPayment[genericLogoFilename]"
                   value="{$data.payment.genericLogoFilename|escape:'html':'UTF-8'}"/>
            <input type="file"
                   name="up2payPayment[genericLogo]"
                   id="up2payPayment[genericLogo]"
                   class="up2pay-upload js-up2pay-upload"/>
            <label for="up2payPayment[genericLogo]">
              <i class="icon icon-upload"></i>
              <span>
                  {l s='Upload' mod='paybox'}
                </span>
            </label>
          </div>
          <div class="col-lg-9 col-lg-offset-3">
            <div class="help-block">
              {l s='You can upload here a new logo (file types accepted for logos are: .png .gif .jpg only)' mod='paybox'}<br/>
              {l s='We recommend that you use images with 30px height & 120px length maximum' mod='paybox'}
              <span></span>
            </div>
          </div>
        </div>
        <!-- /Logo -->
        <!-- Type de débit -->
        <div class="form-group js-up2pay-debit-type-block">
          <label class="control-label col-lg-3 ">
            <span>
              {l s='Debit type' mod='paybox'}
            </span>
          </label>
          <div class="col-lg-9 js-up2pay-debit-type-switch">
            <span class="switch prestashop-switch fixed-width-xxl">
              <input type="radio"
                     value="{$data.const.debitImmediate|escape:'html':'UTF-8'}"
                     name="up2payPayment[debitType]"
                     id="up2payPayment_debit_immediat"
                     {if $data.payment.debitType != $data.const.debitDeferred}checked="checked"{/if}>
              <label for="up2payPayment_debit_immediat">{l s='Immediate' mod='paybox'}</label>
              <input type="radio"
                     value="{$data.const.debitDeferred|escape:'html':'UTF-8'}"
                     name="up2payPayment[debitType]"
                     id="up2payPayment_debit_deferred"
                     {if $data.payment.debitType == $data.const.debitDeferred}checked="checked"{/if}>
              <label for="up2payPayment_debit_deferred">{l s='Deferred' mod='paybox'}</label>
              <a class="slide-button btn"></a>
            </span>
          </div>
          <div class="col-lg-9 col-lg-offset-3">
            <div class="help-block">
              {l s='[1]Immediate: [/1]debit is done the day of the order' mod='paybox' tags=['<strong>']}<br />
              {l s='[1]Deferred: [/1]you can set number of days to wait before remittance to bank' mod='paybox' tags=['<strong>']}
              <span></span>
            </div>
          </div>
        </div>
        <!-- /Type de débit -->
        {if $data.configuration.contract == $data.const.contractPremium}
          <!-- Capture Event -->
          <div class="form-group js-up2pay-capture-event-block">
            <label class="control-label col-lg-3 ">
            <span>
              {l s='Event that will trigger remittance to bank' mod='paybox'}
            </span>
            </label>
            <div class="col-lg-9 js-up2pay-capture-event-switch">
            <span class="switch prestashop-switch fixed-width-xxl">
              <input type="radio"
                     value="{$data.const.captureDays|escape:'html':'UTF-8'}"
                     name="up2payPayment[captureEvent]"
                     id="up2payPayment_event_days"
                     {if $data.payment.captureEvent == $data.const.captureDays}checked="checked"{/if}>
              <label for="up2payPayment_event_days">{l s='Delay' mod='paybox'}</label>
              <input type="radio"
                     value="{$data.const.captureStatus|escape:'html':'UTF-8'}"
                     name="up2payPayment[captureEvent]"
                     id="up2payPayment_event_status"
                     {if $data.payment.captureEvent != $data.const.captureDays}checked="checked"{/if}>
              <label for="up2payPayment_event_status">{l s='Order status' mod='paybox'}</label>
              <a class="slide-button btn"></a>
            </span>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='[1]Delay: [/1]automatically triggered after a delay' mod='paybox' tags=['<strong>']}<br />
                {l s='[1]Order Status: [/1]automatically triggered on order status changed' mod='paybox' tags=['<strong>']}<br />
                {l s='Please note that order status option, allow to trigger remittance also manually by using action button in order detail' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /Capture Event -->
        {else}
          <input type="radio" checked="checked" id="up2payPayment_event_days" style="display: none;"/>
        {/if}
        <!-- Jours différés -->
        <div class="form-group js-up2pay-deferred-days-block">
          <label class="control-label col-lg-3 ">
            <span>
              {l s='Delay (days) before remittance to bank' mod='paybox'}
            </span>
          </label>
          <div class="col-lg-9">
            <select name="up2payPayment[deferredDays]" class="fixed-width-lg">
              {for $day=1 to 7}
                <option value="{$day|intval}" {if $data.payment.deferredDays == $day}selected{/if}>
                  {$day|intval}
                </option>
              {/for}
            </select>
          </div>
          <div class="col-lg-9 col-lg-offset-3">
            <div class="help-block">
              {l s='Number of days before integration of your transaction in remittance to bank treatment' mod='paybox'}
              <span></span>
            </div>
          </div>
        </div>
        <!-- /Jours différés -->
        {if $data.configuration.contract == $data.const.contractPremium}
          <!-- Statut -->
          <div class="form-group js-up2pay-deferred-status-block">
            <label class="control-label col-lg-3 ">
            <span>
              {l s='Order statuses that trigger capture' mod='paybox'}
            </span>
            </label>
            <div class="col-lg-9">
              <select name="up2payPayment[captureStatuses][]" class="chosen fixed-width-xl" id="" multiple="multiple">
                {foreach $order_statuses as $order_status}
                  <option value="{$order_status.id_order_state|intval}"
                          {if in_array($order_status.id_order_state, $data.payment.captureStatuses)}selected{/if}>
                    {$order_status.name|escape:'html':'UTF-8'}
                  </option>
                {/foreach}
              </select>
            </div>
            <div class="col-lg-9 col-lg-offset-3">
              <div class="help-block">
                {l s='Define order statuses that trigger automatically the capture  for the remittance to bank of the transaction' mod='paybox'}
                <span></span>
              </div>
            </div>
          </div>
          <!-- /Statut -->
        {/if}
        <!-- Moyens de paiement détaillés -->
        {include file="./_contracts.tpl"}
        <!-- /Moyens de paiement détaillés -->
        <input type="hidden" name="action" value="savePaymentForm"/>
      </div>
    </div>
    <div class="panel-footer">
      <button type="submit" class="btn btn-default pull-right" name="submitPayboxPaymentForm">
        <i class="process-icon-save"></i> {l s='Save' mod='paybox'}
      </button>
    </div>
  </form>
</div>
