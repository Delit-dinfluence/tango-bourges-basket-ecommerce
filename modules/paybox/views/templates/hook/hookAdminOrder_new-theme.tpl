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

<div id="up2pay-admin-order" class="card">
  <h3 class="card-header">
    <img style="height: 22px;" src="{$up2pay_uri|escape:'htmlall':'UTF-8'}logo.png"/>
    {l s='Up2pay e-Transactions Crédit Agricole' mod='paybox'}
  </h3>
  <div class="card-body">
    {if isset($payboxAjaxTransactionError)}
      <div class="alert alert-danger">
        <p class="text-danger">{$payboxAjaxTransactionError|escape:'htmlall':'UTF-8'}</p>
      </div>
    {/if}
    {if isset($capture_confirmation) && $capture_confirmation}
      <div class="alert alert-success">
        <p class="text-success">{l s='Funds have been captured successfully' mod='paybox'}</p>
      </div>
    {/if}
    {if isset($refund_confirmation) && $refund_confirmation}
      <div class="alert alert-success">
        <p class="text-success">{l s='Refund done successfully' mod='paybox'}</p>
      </div>
    {/if}
    <div class="row">
      <div class="col-md-12">
        <div class="info-block">
          <div class="row">
            <div class="col-sm text-center">
              <p class="text-muted mb-0"><strong>{l s='Transaction number' mod='paybox'}</strong></p>
              <strong id="">{$transaction.transactionNumber|escape:'htmlall':'UTF-8'}</strong>
            </div>
            <div id="" class="col-sm text-center">
              <p class="text-muted mb-0"><strong>{l s='Total' mod='paybox'}</strong></p>
              <strong id="">{displayPrice price=$transaction.amount|floatval currency=$id_currency_euro|intval}</strong>
            </div>
            <div id="" class="col-sm text-center">
              <p class="text-muted mb-0"><strong>{l s='Card Type' mod='paybox'}</strong></p>
              <strong id="">{$transaction.cardType|escape:'htmlall':'UTF-8'}</strong>
            </div>
            <div id="" class="col-sm text-center">
              <p class="text-muted mb-0"><strong>{l s='3D Secure' mod='paybox'}</strong></p>
              <strong id="">
                {if $transaction.guarantee3DS == 1}{l s='Yes' mod='paybox'}{else}{l s='No' mod='paybox'}{/if}
              </strong>
            </div>
          </div>
        </div>
      </div>
    </div>
    <p></p>
    {if !$is_contract_access}
      <div class="row">
        <div class="col-xl-6">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h4>{l s='Capture' mod='paybox'}</h4>
                  <div class="row mb-1">
                    <div class="col-6 text-right">{l s='Amount captured' mod='paybox'}</div>
                    <div class="col-6">{displayPrice price=$transaction.amountCaptured|floatval currency=$id_currency_euro|intval}</div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-6 text-right">{l s='Amount that can be captured' mod='paybox'}</div>
                    <div class="col-6">{displayPrice price=$transaction.capturableAmount|floatval currency=$id_currency_euro|intval}</div>
                  </div>
                  {if $transaction.capturableAmount}
                    <hr>
                    <form class="form-horizontal"
                          action="{$link->getAdminLink('AdminPayboxAjaxTransaction')|escape:'htmlall':'UTF-8'}"
                          name="paybox_capture"
                          id="paybox-capture-form"
                          method="post"
                          enctype="multipart/form-data">
                      <div class="form-group row">
                        <div class="col-sm">
                          <div class="input-group money-type">
                            <input type="text"
                                   id=""
                                   name="transaction[amountToCapture]"
                                   class="form-control"
                                   onchange="this.value = parseFloat(this.value.replace(/,/g, '.')) || 0"
                                   value="{$transaction.capturableAmount|floatval|string_format:'%.2f'}">
                            <div class="input-group-append">
                              <span class="input-group-text"> €</span>
                            </div>
                            <button class="btn btn-primary btn-sm ml-2">
                              {l s='Submit' mod='paybox'}
                            </button>
                          </div>
                          <input type="hidden" name="transaction[id]" value="{$transaction.id|intval}"/>
                          <input type="hidden" name="transaction[idOrder]" value="{$transaction.idOrder|intval}"/>
                        </div>
                      </div>
                    </form>
                    {if $order_total != $transaction.amount}
                      <div class="alert alert-warning">
                        <p class="text-warning">
                          {capture name="txt_amount_capture"}
                            {displayPrice price=$transaction.capturableAmount|floatval currency=$id_currency_euro|intval}
                          {/capture}
                          {capture name="txt_amount_total"}
                            {displayPrice price=$order_total|floatval currency=$id_currency_euro|intval}
                          {/capture}
                          {l s='Be careful, you\'re about to capture [1]%s[/1] while the total of order is [1]%s[/1]' sprintf=[$smarty.capture.txt_amount_capture, $smarty.capture.txt_amount_total] tags=['<b>'] mod='paybox'}
                        </p>
                      </div>
                    {/if}
                  {/if}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h4>{l s='Refund' mod='paybox'}</h4>
                  <div class="row mb-1">
                    <div class="col-6 text-right">{l s='Amount refunded' mod='paybox'}</div>
                    <div class="col-6">{displayPrice price=$transaction.amountRefunded|floatval currency=$id_currency_euro|intval}</div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-6 text-right">{l s='Amount that can be refunded' mod='paybox'}</div>
                    <div class="col-6">{displayPrice price=$transaction.refundableAmount|floatval currency=$id_currency_euro|intval}</div>
                  </div>
                  {if $transaction.refundableAmount}
                    <hr>
                    <form class="form-horizontal"
                          action="{$link->getAdminLink('AdminPayboxAjaxTransaction')|escape:'htmlall':'UTF-8'}"
                          name="paybox_refund"
                          id="paybox-refund-form"
                          method="post"
                          enctype="multipart/form-data">
                      <div class="form-group row">
                        <div class="col-sm">
                          <div class="input-group money-type">
                            <input type="text"
                                   id=""
                                   name="transaction[amountToRefund]"
                                   class="form-control"
                                   onchange="this.value = parseFloat(this.value.replace(/,/g, '.')) || 0"
                                   value="{$transaction.refundableAmount|floatval|string_format:'%.2f'}">
                            <div class="input-group-append">
                              <span class="input-group-text"> €</span>
                            </div>
                            <button class="btn btn-primary btn-sm ml-2">
                              {l s='Make refund' mod='paybox'}
                            </button>
                          </div>
                          <input type="hidden" name="transaction[id]" value="{$transaction.id|intval}"/>
                          <input type="hidden" name="transaction[idOrder]" value="{$transaction.idOrder|intval}"/>
                        </div>
                      </div>
                    </form>
                  {/if}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    {/if}
  </div>
</div>
