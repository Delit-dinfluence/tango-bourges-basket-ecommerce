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

{if isset($up2payIframes) && !empty($up2payIframes)}
  {foreach $up2payIframes as $key => $inputs}
    <div class="js-payment-up2pay-contract-{$key|escape:'htmlall':'UTF-8'} up2pay-iframe js-payment-binary">
      <iframe name="up2pay-contract-{$key|escape:'htmlall':'UTF-8'}"
              style="border: none; width: 100%; height: 590px;">
      </iframe>
    </div>
    <form class="form-up2pay-iframe js-up2pay-form-{$key|escape:'htmlall':'UTF-8'}"
          action="{$iframeFormAction|escape:'htmlall':'UTF-8'}"
          target="up2pay-contract-{$key|escape:'htmlall':'UTF-8'}"
          method="post">
      {foreach $inputs as $input}
        <input type="hidden"
               name="{$input.name|escape:'htmlall':'UTF-8'}"
               value="{$input.value|escape:'htmlall':'UTF-8'}"/>
      {/foreach}
    </form>
  {/foreach}
  <script type="text/javascript">
    let forms = document.getElementsByClassName('form-up2pay-iframe');

    Array.prototype.forEach.call(forms, function (el) {
      el.submit();
    });

  </script>
{/if}
{if isset($oneClickValues)}
  <script type="text/javascript">
    {literal}
    var oneClickValues = {/literal}{$oneClickValues|json_encode nofilter}{literal};
    {/literal}
  </script>
{/if}
