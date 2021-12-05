/*
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
*/

function toggleOneClickIframe(cb, contract) {
  var form = $('.js-up2pay-form-' + contract);

  if (cb.checked) {
    form.find('input[name="PBX_RANG"]').after('<input type="hidden" name="PBX_REFABONNE" value="'+oneClickValues[contract]['withAbo']['PBX_REFABONNE']+'" />');
    form.find('input[name="PBX_HMAC"]').val(oneClickValues[contract]['withAbo']['PBX_HMAC']);
    form.find('input[name="PBX_CMD"]').val(oneClickValues[contract]['withAbo']['PBX_CMD']);
    form.find('input[name="PBX_RETOUR"]').val(oneClickValues[contract]['withAbo']['PBX_RETOUR']);
    form.get(0).submit();
  } else {
    form.find('input[name="PBX_REFABONNE"]').remove();
    form.find('input[name="PBX_HMAC"]').val(oneClickValues[contract]['withoutAbo']['PBX_HMAC']);
    form.find('input[name="PBX_CMD"]').val(oneClickValues[contract]['withoutAbo']['PBX_CMD']);
    form.find('input[name="PBX_RETOUR"]').val(oneClickValues[contract]['withoutAbo']['PBX_RETOUR']);
    form.get(0).submit();
  }
}

function toggleOneClickRedirect(cb, contract) {
  let form = $(cb).parents('.js-additional-information').next('.js-payment-option-form');

  if (cb.checked) {
    form.find('input[name="PBX_RANG"]').after('<input type="hidden" name="PBX_REFABONNE" value="'+oneClickValues[contract]['withAbo']['PBX_REFABONNE']+'" />');
    form.find('input[name="PBX_HMAC"]').val(oneClickValues[contract]['withAbo']['PBX_HMAC']);
    form.find('input[name="PBX_CMD"]').val(oneClickValues[contract]['withAbo']['PBX_CMD']);
    form.find('input[name="PBX_RETOUR"]').val(oneClickValues[contract]['withAbo']['PBX_RETOUR']);
  } else {
    form.find('input[name="PBX_REFABONNE"]').remove();
    form.find('input[name="PBX_HMAC"]').val(oneClickValues[contract]['withoutAbo']['PBX_HMAC']);
    form.find('input[name="PBX_CMD"]').val(oneClickValues[contract]['withoutAbo']['PBX_CMD']);
    form.find('input[name="PBX_RETOUR"]').val(oneClickValues[contract]['withoutAbo']['PBX_RETOUR']);
  }
}
