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

<div class="panel js-up2pay-marketing-form">
  <div class="row">
    <div class="up2pay-marketing marketing-header col-xs-12">
      <div class="col-xs-10 col-lg-8 marketing-bloc-1">
        <p class="marketing-title">
            {l s='[1]The ideal solution[/1] [2]to accept online payments![/2]' mod='paybox' tags=['<span class="accentued">', '<span>']}
        </p>
      </div>
      <div class="col-xs-2 col-lg-4 ">
        {if $data.configuration.demoMode !== null}
          <a href="#"
             class="js-up2pay-marketing-display marketing-display">
            {l s='Don\'t show this again' mod='paybox'}
            <i class="icon icon-eye-slash"></i>
          </a>
        {/if}
      </div>
    </div>
  </div>
  <div class="row marketing-blocs-container">
    <div class="up2pay-marketing bloc-left col-xs-8">
      <div class="marketing-top-bloc">
        <ul class="marketing-list">
          <li>{l s="Choose a solution already used by thousands of merchants." mod='paybox'}</li>
          <li>{l s="Offer your customer a shop integrated payment form or a hosted payment page." mod='paybox'}</li>
          <li>{l s="Secure your transactions with 3D-Secure v2 (PSD2 compliant)." mod='paybox'}</li>
          <li>{l s="Easily manage your order from you Prestashop Back-Office." mod='paybox'}</li>
          <li>{l s="Your bank account credited at D+1." mod='paybox'}</li>
          <li>{l s="Take advantage of support provided by e-Commerce experts." mod='paybox'}</li>
        </ul>
      </div>
      <div class="row marketing-block-text-container">
        <div class="col-xs-6 marketing-bloc-text marketing-bloc-access">
          <span class="col-xs-6 marketing-bloc-title">{l s="Access Offer" mod='paybox'}</span>
          <p>{l s="A simple offer with the basics to accept online payments" mod='paybox'}</p>
          <ul class="marketing-bloc-list">
            <li>
              {l s="[1]Accept CB, VISA, Mastercard cards and also Paylib and Paypal.[/1]" mod='paybox' tags=['<strong>']}
            </li>
            <li>
              {l s="[1]Available features:[/1] immediate or deferred payments." mod='paybox' tags=['<strong>']}
            </li>
          </ul>
        </div>
        <div class="marketing-bloc-text marketing-bloc-premium">
          <span class="marketing-bloc-title">{l s="Premium Offer" mod='paybox'}</span>
          <p>{l s="A complete offer to optimize your activity and improve customer experience" mod='paybox'}</p>
          <ul class="marketing-bloc-list">
            <li>
              {l s="[1]Accept more payment methods[/1] as Amex, Titres Restaurant, e-Chèques Vacances (ANCV)." mod='paybox' tags=['<strong>']}
            </li>
            <li>
              {l s="[1]Activate more features: [/1] One-click payment, subscription, instalment payment, capture on shipment and refund from PrestaShop Back-Office." mod='paybox' tags=['<strong>']}
            </li>
            <li>
              {l s="[1]Customize[/1] your payment page using your graphic charter." mod='paybox' tags=['<strong>']}
            </li>
          </ul>
        </div>
      </div>

    </div>
    <div class="up2pay-marketing col-xs-4 bloc-right">
      <img class="visuel-marketing" src="/modules/paybox/views/img/visuel.jpg" alt="up2pay">
      <form class="flex cta-buttons"
            action="#"
            name="paybox_marketing_form"
            id="paybox-marketing-form"
            method="post"
            enctype="multipart/form-data">
        {if $data.configuration.demoMode === null}
          <button type="submit"
                  name="action"
                  value="startLogin"
                  class="btn btn-primary">{l s='I already have an account' mod='paybox'}
          </button>
        {/if}
        {if $data.configuration.demoMode === null}
          <button type="submit"
                  name="action"
                  value="startDemo"
                  class="btn btn-primary">{l s='Test using demo account' mod='paybox'}
          </button>
        {/if}
        <a href="https://offres.ca-moncommerce.com/up2pay-e-transactions/up2pay-e-transactions-pour-prestashop/" target="_blank" class="btn btn-primary">{l s='Sign-up' mod='paybox'}</a>
      </form>
    </div>
  </div>
</div>
