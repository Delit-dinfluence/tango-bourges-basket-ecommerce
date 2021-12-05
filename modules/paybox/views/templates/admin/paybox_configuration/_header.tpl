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

<div class="panel">
  <div class="row">
    <div class="up2pay-header flex col-xs-12">
      <div class="up2pay-logo">
        <img src="{$data.path.img|escape:'html':'UTF-8'}up2pay-logo.svg"/>
      </div>
      <div class="up2pay-support flex">
        <div class="contact flex">
          <i class="icon icon-question-circle icon-big flex"></i>
          <div class="flex">
            <p><b>{l s='Do you have a question?' mod='paybox'}</b></p>
            <p>{l s='Contact us using' mod='paybox'}
              <a data-toggle="modal"
                 data-target="#up2pay-modal-contact"
                 href="#">
                {l s='this link' mod='paybox'}
              </a>
            </p>
          </div>
        </div>
        <div class="cta-buttons flex">
          <a class="btn btn-primary" href="{$data.path.doc|escape:'html':'UTF-8'}">{l s='User guide' mod='paybox'}</a>
          <a data-toggle="modal"
             data-target="#up2pay-modal-check-config"
             href="#"
             class="btn btn-primary">{l s='Check configuration' mod='paybox'}</a>
        </div>
      </div>
    </div>
  </div>
</div>
