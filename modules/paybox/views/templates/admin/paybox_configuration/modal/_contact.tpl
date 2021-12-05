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

<div class="alert alert-info">
  {l s='If you contact the support, please copy both sections below and past them in the message body to receive a quicker response.' mod='paybox'}
</div>
<span class="help-block">{l s='(click anywhere in the area to copy to clipboard)' mod='paybox'}</span>
<pre id="up2pay-global-configuration" style="cursor: pointer; max-height: 400px; line-height: 1.2">
=================================================<br/>
  {l s='PrestaShop & server configuration' mod='paybox'}<br/>
=================================================<br/>
{l s='PrestaShop version: ' mod='paybox'}<span>{$data.ps_version|escape:'html':'UTF-8'}</span><br/>
{l s='PHP version: ' mod='paybox'}<span>{$data.php_version|escape:'html':'UTF-8'}</span><br/>
{l s='Module version: ' mod='paybox'}<span>{$data.module_version|escape:'html':'UTF-8'}</span><br/>
{l s='cURL version: ' mod='paybox'}<span>{$data.curl_version|escape:'html':'UTF-8'}</span><br/>
{l s='OpenSSL version: ' mod='paybox'}<span>{$data.openssl_version|escape:'html':'UTF-8'}</span><br/>
{l s='Multishop enabled: ' mod='paybox'}<span>{$data.multishop_enabled|escape:'html':'UTF-8'}</span><br/>
{l s='PrestaShop mode debug: ' mod='paybox'}<span>{$data.mode_debug|escape:'html':'UTF-8'}</span><br/>
{l s='Temporary directory: ' mod='paybox'}<span>{$data.tmp_dir|escape:'html':'UTF-8'}</span>
<p></p>
=================================================<br/>
  {l s='Module configuration' mod='paybox'}<br/>
=================================================<br/>
{l s='Main settings' mod='paybox'}<br/>
<span class="up2pay-json-main-settings"></span><br/>
{l s='Account settings' mod='paybox'}<br/>
<span class="up2pay-json-account-settings"></span><br/>
{l s='Payment settings' mod='paybox'}<br/>
<span class="up2pay-json-payment-settings"></span><br/>
{l s='Instalment settings' mod='paybox'}<br/>
<span class="up2pay-json-instalment-settings"></span><br/>
{l s='Subscription settings' mod='paybox'}<br/>
<span class="up2pay-json-subscription-settings"></span><br/>
=================================================<br/>
{l s='Installed Modules List' mod='paybox'}<br/>
=================================================
  <dl>
    {foreach from=$data.modules_list key=$module_name item=$version}
      <dt>{$module_name|escape:'html':'UTF-8'} - v{$version|escape:'html':'UTF-8'}</dt>
    {/foreach}
  </dl>
</pre>
<p class="contact-us">
  <a href="https://addons.prestashop.com/en/contact-us?id_product={$data.module_addons_id|intval}"
     target="_blank"
     class="btn-primary btn">
    {l s='Contact the support' mod='paybox'}
  </a>
</p>

{literal}
<script type="text/javascript">
  var mainSettings = JSON.parse('{/literal}{$data.main_settings}{literal}');
  var accountSettings = JSON.parse('{/literal}{$data.userAccount_settings}{literal}');
  var paymentSettings = JSON.parse('{/literal}{$data.payment_settings}{literal}');
  var instalmentSettings = JSON.parse('{/literal}{$data.instalment_settings}{literal}');
  var subscriptionSettings = JSON.parse('{/literal}{$data.subscription_settings}{literal}');

  $(document).ready(function () {
    $('.up2pay-json-main-settings').text(JSON.stringify(mainSettings, undefined, 2));
    $('.up2pay-json-account-settings').text(JSON.stringify(accountSettings, undefined, 2));
    $('.up2pay-json-payment-settings').text(JSON.stringify(paymentSettings, undefined, 2));
    $('.up2pay-json-instalment-settings').text(JSON.stringify(instalmentSettings, undefined, 2));
    $('.up2pay-json-subscription-settings').text(JSON.stringify(subscriptionSettings, undefined, 2));
  });

  function copyInput($input) {
    var range = document.createRange();
    var sel = window.getSelection();

    range.setStartBefore($input.firstChild);
    range.setEndAfter($input.lastChild);
    sel.removeAllRanges();
    sel.addRange(range);

    try {
      document.execCommand('copy');
      showSuccessMessage(copyMessage);
    } catch (err) {
      console.error('Unable to copy');
    }
  }

  $('#up2pay-global-configuration').on('click', function (e) {
    copyInput(this);
  });
</script>
{/literal}
