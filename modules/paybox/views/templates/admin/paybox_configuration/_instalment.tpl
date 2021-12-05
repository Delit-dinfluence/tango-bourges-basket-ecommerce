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

<div class="panel js-up2pay-instalment-form">
  <form class="form-horizontal"
        action="#"
        name="paybox_instalment_form"
        id="paybox-instalment-form"
        onsubmit="return validateInstalmentsAmount();"
        method="post"
        enctype="multipart/form-data">
    <div class="panel-heading"><i class="icon-credit-card"></i> {l s='Instalment configuration' mod='paybox'}</div>
    <div class="row">
      <div class="up2pay-instalment col-xs-12">
        <!-- Paiement x fois activé -->
        <div class="form-group js-up2pay-instalment-enabled-block">
          <label class="control-label col-lg-3 ">
            <span>
              {l s='Enable instalment' mod='paybox'}
            </span>
          </label>
          <div class="col-lg-9 js-up2pay-instalment-enabled-switch">
            <span class="switch prestashop-switch fixed-width-xxl">
              <input type="radio"
                     value="1"
                     name="up2payInstalment[enabled]"
                     id="up2payInstalment_enabled"
                     {if $data.instalment.enabled === true}checked="checked"{/if}>
              <label for="up2payInstalment_enabled">{l s='Yes' mod='paybox'}</label>
              <input type="radio"
                     value="0"
                     name="up2payInstalment[enabled]"
                     id="up2payInstalment_disabled"
                     {if $data.instalment.enabled !== true}checked="checked"{/if}>
              <label for="up2payInstalment_disabled">{l s='No' mod='paybox'}</label>
              <a class="slide-button btn"></a>
            </span>
          </div>
          <div class="col-lg-9 col-lg-offset-3">
            <div class="help-block">
              {l s='Propose payment of order with multiple instalment in 2, 3 or 4 times (future instalment are not garanteed in case of payment refused)' mod='paybox'}
              <span></span>
            </div>
          </div>
        </div>
        <!-- /Paiement x fois activé -->
        <div class="form-wrapper js-up2pay-instalment-inputs-block">
          <ul class="nav nav-tabs up2pay-instalment-tabs">
            {foreach from=$data.instalment.instalments key=k item=instalment name=instalment}
              <li class="{if $instalment.partialPayments == $data.instalment.activeTab}active {/if}{if $instalment.enabled == true}green{else}darkgrey{/if}">
                <a href="#instalment-{$instalment.partialPayments|intval}"
                   data-toggle="tab">
                  <i class="icon icon-{if $instalment.enabled == true}check{else}times{/if}"></i>
                  {l s='%dx payment' sprintf=$instalment.partialPayments|intval mod='paybox'}
                </a>
              </li>
            {/foreach}
          </ul>
          <div class="tab-content panel">
            {foreach from=$data.instalment.instalments key=k item=instalment name=instalment}
              <div id="instalment-{$instalment.partialPayments|intval}"
                   class="tab-pane {if $instalment.partialPayments == $data.instalment.activeTab}active{/if}">
                <div class="row">
                  <div class="col-lg-12">
                    <input type="hidden"
                           name="up2payInstalment[instalments][{$k|intval}][partialPayments]"
                           value="{$instalment.partialPayments|intval}"/>
                    <!-- Paiement x fois activé -->
                    <div class="form-group">
                      <label class="control-label col-lg-3 ">
                        <span>
                          {l s='Enable %dx instalment payment' sprintf=$instalment.partialPayments|intval mod='paybox'}
                        </span>
                      </label>
                      <div class="col-lg-9">
                        <span class="switch prestashop-switch fixed-width-xxl">
                          <input type="radio"
                                 value="1"
                                 name="up2payInstalment[instalments][{$k|intval}][enabled]"
                                 id="up2payInstalment[instalments][{$k|intval}][enabled]_enabled"
                                 {if $instalment.enabled === true}checked="checked"{/if}>
                          <label for="up2payInstalment[instalments][{$k|intval}][enabled]_enabled">{l s='Yes' mod='paybox'}</label>
                          <input type="radio"
                                 value="0"
                                 name="up2payInstalment[instalments][{$k|intval}][enabled]"
                                 id="up2payInstalment[instalments][{$k|intval}][enabled]_disabled"
                                 {if $instalment.enabled !== true}checked="checked"{/if}>
                          <label for="up2payInstalment[instalments][{$k|intval}][enabled]_disabled">{l s='No' mod='paybox'}</label>
                          <a class="slide-button btn"></a>
                        </span>
                      </div>
                      <div class="col-lg-9 col-lg-offset-3">
                        <div class="help-block">
                          {l s='First instalment correspond to the day of the payment of order. You will be credited at every instalment.' mod='paybox'}
                          <span></span>
                        </div>
                      </div>
                    </div>
                    <!-- /Paiement x fois activé -->
                    <!-- Texte generique -->
                    <div class="form-group">
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
                                     id="up2pay-instalment-{$k|intval}-title-text-{$language.id_lang|intval}"
                                     name="up2payInstalment[instalments][{$k|intval}][title][{$language.iso_code|escape:'html':'UTF-8'}]"
                                     class=""
                                     value="{$instalment['title'][$language.iso_code|escape:'html':'UTF-8']}">
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
                          {l s='Title of instalment payment option displayed on your page with means of payment choices.' mod='paybox'}
                          <span></span>
                        </div>
                      </div>
                    </div>
                    <!-- /Texte generique -->
                    <!-- Logo -->
                    <div class="form-group">
                      <label class="control-label col-lg-3 ">
                        <span>
                          {l s='Logo displayed on your payment page' mod='paybox'}
                        </span>
                      </label>
                      <div class="col-lg-9">
                        {if $instalment.logoFilename}
                          <img class="preview-logo"
                               src="{$data.path.img|escape:'html':'UTF-8'}logos/{$instalment.logoFilename|escape:'html':'UTF-8'}"/>
                        {/if}
                        <input type="hidden"
                               name="up2payInstalment[instalments][{$k|intval}][logoFilename]"
                               value="{$instalment.logoFilename|escape:'html':'UTF-8'}"/>
                        <input type="file"
                               name="up2payInstalment[instalments][{$k|intval}][logo]"
                               id="up2payInstalment[instalments][{$k|intval}][logo]"
                               class="up2pay-upload js-up2pay-upload"/>
                        <label for="up2payInstalment[instalments][{$k|intval}][logo]">
                          <i class="icon icon-upload"></i>
                          <span>
                      {l s='Upload' mod='paybox'}
                    </span>
                        </label>
                      </div>
                      <div class="col-lg-9 col-lg-offset-3">
                        <div class="help-block">
                          {l s='You can upload here a new logo (file types accepted for logos are: .png .gif .jpg only' mod='paybox'}<br/>
                          {l s='we recommend that you use images with 30px height & 120px length maximum.' mod='paybox'}
                          <span></span>
                        </div>
                      </div>
                    </div>
                    <!-- /Logo -->
                    <!-- Interval entre 2 paiements -->
                    <div class="form-group">
                      <label class="control-label col-lg-3 ">
                        <span>
                          {l s='Days between each instalment' mod='paybox'}
                        </span>
                      </label>
                      <div class="col-lg-9">
                        <select name="up2payInstalment[instalments][{$k|intval}][daysBetweenPayments]"
                                class="fixed-width-sm">
                          {for $days=1 to 90 / ($instalment.partialPayments|intval - 1)}
                            <option value="{$days|intval}" {if $instalment.daysBetweenPayments == $days}selected{/if}>
                              {$days|intval}
                            </option>
                          {/for}
                        </select>
                      </div>
                      <div class="col-lg-9 col-lg-offset-3">
                        <div class="help-block">
                          {l s='Number of days between each instalment. Delay between the first payment on the last instalment can\'t exceed 90 days.' mod='paybox'}
                          <span></span>
                        </div>
                      </div>
                    </div>
                    <!-- /Interval entre 2 paiements -->
                    <!-- Répartition paiements -->
                    <div class="form-group">
                      <label class="control-label col-lg-3 ">
                        <span>
                          {l s='Payments division' mod='paybox'}
                        </span>
                      </label>
                      <div class="col-lg-9">
                        {for $part=1 to $instalment.partialPayments|intval}
                          <div class="input-group fixed-width-md">
                            <input {if $part == $instalment.partialPayments}readonly{/if}
                                   name="up2payInstalment[instalments][{$k|intval}][percents][]"
                                   class="{if $part != $instalment.partialPayments}subpart{else}subpartAuto{/if}"
                                   step="1"
                                   type="number"
                                   max="{math equation="100 - x + 1" x=$instalment.partialPayments|intval}"
                                   min="1"
                                   value="{$instalment['percents'][{$part|intval - 1}]|intval}"/>
                            <span> %</span>
                          </div>
                        {/for}
                      </div>
                    </div>
                    <!-- /Répartition paiements -->
                    <!-- Minimum amount of order -->
                    <div class="form-group">
                      <label class="control-label col-lg-3 ">
                        <span>
                          {l s='Minimum amount of order to display payment option' mod='paybox'}
                        </span>
                      </label>
                      <div class="col-lg-9">
                        <div class="input-group fixed-width-md">
                          <input value="{$instalment.minAmount|floatval}"
                                 type="text"
                                 onchange="this.value = parseFloat(this.value.replace(/,/g, '.')) || 0"
                                 name="up2payInstalment[instalments][{$k|intval}][minAmount]">
                          <span class="input-group-addon">
                            {$default_currency_iso|escape:'html':'UTF-8'}
                          </span>
                        </div>
                      </div>
                    </div>
                    <!-- /Minimum amount of order -->
                    <!-- Maximum amount of order -->
                    <div class="form-group">
                      <label class="control-label col-lg-3 ">
                        <span>
                          {l s='Maximum amount of order to display payment option' mod='paybox'}
                        </span>
                      </label>
                      <div class="col-lg-9">
                        <div class="input-group fixed-width-md">
                          <input value="{$instalment.maxAmount|floatval}"
                                 type="text"
                                 onchange="this.value = parseFloat(this.value.replace(/,/g, '.')) || 0"
                                 name="up2payInstalment[instalments][{$k|intval}][maxAmount]">
                          <span class="input-group-addon">
                            {$default_currency_iso|escape:'html':'UTF-8'}
                          </span>
                        </div>
                      </div>
                    </div>
                    <!-- /Maximum amount of order -->
                  </div>
                </div>
              </div>
            {/foreach}
          </div>
        </div>
        <input type="hidden" name="action" value="saveInstalmentForm"/>
      </div>
    </div>
    <div class="panel-footer">
      <button type="submit" class="btn btn-default pull-right" name="submitPayboxInstalmentForm">
        <i class="process-icon-save"></i> {l s='Save' mod='paybox'}
      </button>
    </div>
  </form>
</div>
