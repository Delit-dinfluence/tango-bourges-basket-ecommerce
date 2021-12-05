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

<div class="form-group up2pay-contracts js-up2pay-contracts-block">
  <div class="alert alert-info">
    <p>{l s='File types accepted for logos are: .png .gif .jpg only' mod='paybox'}</p>
    <p>{l s='We recommend that you use images with 40px height & 120px length maximum' mod='paybox'}</p>
  </div>
  {foreach from=$data.paymentMethods key=k item=contract name=contract}
    <div data-id="{$k|intval}" class="flex contract {if $contract.isSelectable !== false}selectable{/if}">
      <div class="flex column-identifier" {if $smarty.foreach.contract.first}style="justify-content: flex-start"{/if}>
        {if $smarty.foreach.contract.first}<p>&nbsp;</p>{/if}
        <span>
                  {if $contract.identifier === 'OTHER'}
                    {l s='Display a generic payment option for all payment methods subscribed' mod='paybox'}
                  {else}
                    {$contract.identifier|escape:'html':'UTF-8'}
                    <br/>
                    {if $k !== 0}
                    <a class="remove-contract" data-id="{$k|intval}" href="#">({l s='remove' mod='paybox'})</a>
                  {/if}
                  {/if}
                </span>
        <input type="hidden"
               name="up2payPaymentMethods[{$k|intval}][isSelectable]"
               value="{$contract.isSelectable|escape:'html':'UTF-8'}">
      </div>
      <div class="flex column-config" {if $smarty.foreach.contract.first}style="align-items: flex-start"{/if}>
        <!-- Active -->
        <div class="cell-active">
          {if $smarty.foreach.contract.first}<p>{l s='Active' mod='paybox'}</p>{/if}
          <span class="switch prestashop-switch fixed-width-sm">
                    <input type="radio"
                           value="1"
                           name="up2payPaymentMethods[{$k|intval}][enabled]"
                           id="up2payPayment_{$k|intval}_enabled"
                           {if $contract.enabled !== false}checked="checked"{/if}>
                    <label for="up2payPayment_{$k|intval}_enabled">{l s='Yes' mod='paybox'}</label>
                    <input type="radio"
                           value="0"
                           name="up2payPaymentMethods[{$k|intval}][enabled]"
                           id="up2payPayment_{$k|intval}_disabled"
                           {if $contract.enabled === false}checked="checked"{/if}>
                    <label for="up2payPayment_{$k|intval}_disabled">{l s='No' mod='paybox'}</label>
                    <a class="slide-button btn"></a>
                  </span>
        </div>
        <!-- /Active -->
        <!-- Payment Display -->
        <div class="cell-payment-display">
          {if $smarty.foreach.contract.first}<p>{l s='Payment display' mod='paybox'}</p>{/if}
          <select name="up2payPaymentMethods[{$k|intval}][displayType]"
                  class="fixed-width-md"
                  {if $contract.forceRedirect === true}disabled="disabled"{/if}>
            <option value="{$data.const.displayIframe|escape:'html':'UTF-8'}"
                    {if $contract.displayType == $data.const.displayIframe}selected="selected"{/if}>
              {l s='Integrated' mod='paybox'}
            </option>
            <option value="{$data.const.displayRedirect|escape:'html':'UTF-8'}"
                    {if $contract.displayType == $data.const.displayRedirect}selected="selected"{/if}>
              {l s='Redirected' mod='paybox'}
            </option>
          </select>
        </div>
        <!-- /Payment Display -->
        <!-- 1-Click -->
        {if $data.configuration.contract == $data.const.contractPremium}
          <div class="cell-one-click">
            {if $smarty.foreach.contract.first}<p>{l s='1-Click' mod='paybox'}</p>{/if}
            {if $contract.oneClickAvailable}
              <span class="switch prestashop-switch fixed-width-sm">
                <input type="radio"
                       value="1"
                       name="up2payPaymentMethods[{$k|intval}][oneClickEnabled]"
                       id="up2payPayment_{$k|intval}_one_click_enabled"
                       {if $contract.oneClickEnabled !== false}checked="checked"{/if}>
                <label for="up2payPayment_{$k|intval}_one_click_enabled">{l s='Yes' mod='paybox'}</label>
                <input type="radio"
                       value="0"
                       name="up2payPaymentMethods[{$k|intval}][oneClickEnabled]"
                       id="up2payPayment_{$k|intval}_one_click_disabled"
                       {if $contract.oneClickEnabled === false}checked="checked"{/if}>
                <label for="up2payPayment_{$k|intval}_one_click_disabled">{l s='No' mod='paybox'}</label>
                <a class="slide-button btn"></a>
              </span>
            {else}
              <p class="fixed-width-sm">---</p>
            {/if}
          </div>
        {/if}
        <!-- /1-Click -->
        <!-- Display Text -->
        <div class="cell-display-text">
          {if $smarty.foreach.contract.first}<p>{l s='Display text' mod='paybox'}</p>{/if}
          {foreach from=$languages item=language}
            <div class="translatable-field flex lang-{$language.id_lang|intval}" {if $language.iso_code != $lang_iso} style="display:none;"{/if}>
              <div class="fixed-width-lg">
                <input type="text"
                       id="up2pay-payment-title-{$language.id_lang|intval}"
                       name="up2payPaymentMethods[{$k|intval}][title][{$language.iso_code|escape:'html':'UTF-8'}]"
                       class=""
                       value="{$contract['title'][$language.iso_code|escape:'html':'UTF-8']}">
              </div>
              <div class="fixed-width-xs" style="position: relative;">
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
        <!-- /Display Text -->
        <!-- Logo -->
        <div class="cell-logo">
          {if $smarty.foreach.contract.first}<p>{l s='Logo' mod='paybox'}</p>{/if}
          {if $contract.logoFilename}
            <img src="{$data.path.img|escape:'html':'UTF-8'}logos/{$contract.logoFilename|escape:'html':'UTF-8'}" />
          {/if}
          <input type="file"
                 name="up2payPaymentMethods[{$k|intval}][logo]"
                 id="up2payPaymentMethods[{$k|intval}][logo]"
                 class="up2pay-upload js-up2pay-upload"/>
          <label for="up2payPaymentMethods[{$k|intval}][logo]">
            <i class="icon icon-upload"></i>
            <span>
                      {l s='Upload' mod='paybox'}
                    </span>
          </label>
        </div>
        <!-- /Logo -->
        <!-- From Amount -->
        <div class="cell-from-amount">
          {if $smarty.foreach.contract.first}<p>{l s='From' mod='paybox'}</p>{/if}
          <div class="input-group">
            <input value="{$contract.minAmount|floatval}"
                   type="text"
                   onchange="this.value = parseFloat(this.value.replace(/,/g, '.')) || 0"
                   name="up2payPaymentMethods[{$k|intval}][minAmount]"
                   class="input fixed-width-xs">
            <span class="input-group-addon">
              {$default_currency_iso|escape:'html':'UTF-8'}
            </span>
          </div>
        </div>
        <!-- /From Amount -->
      </div>
    </div>
  {/foreach}
  <hr>
  <p><b>{l s='Add a means of payment' mod='paybox'}</b></p>
  <select id="up2pay-add-contract" class="fixed-width-xxl">
    <option name="default" value="-1">-- {l s='Choose a means of payment' mod='paybox'} --</option>
    {foreach from=$data.paymentMethods key=k item=contract name=contract}
      <option {if $contract.isSelectable === false}style="display:none"{/if}
              value="{$k|intval}">{$contract.identifier|escape:'html':'UTF-8'}</option>
    {/foreach}
  </select>
  <p class="help-block">{l s='You can activate means of payment only included in your contract' mod='paybox'}</p>
</div>
