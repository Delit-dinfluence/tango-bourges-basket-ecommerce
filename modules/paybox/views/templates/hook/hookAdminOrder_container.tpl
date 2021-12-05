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

<div id="up2pay-admin-order-container">
  {$html}
</div>
{literal}
  <script type="text/javascript">
    let adminOrderContainer = $('#up2pay-admin-order-container');

    adminOrderContainer.on('submit', '#paybox-capture-form', function (e) {
      e.preventDefault();

      if (!window.confirm(confirmCaptureTxt)) {
        return false;
      }

      let adminOrder = $('#up2pay-admin-order');
      let data = {
        action: 'sendCapture',
      };

      adminOrder.find('button').prop('disabled', 'disabled');
      adminOrder.css({'opacity': 0.6});
      let ajax = $.ajax({
        type: 'POST',
        dataType: 'json',
        url: payboxAjaxTransactionUrl + '&' + $.param(data),
        data: $('#paybox-capture-form').serialize(),
      });

      ajax.done(function (data) {
        if (data.redirect_after) {
          window.location.href = data.redirect_after;
        }
        $('#up2pay-admin-order-container').html(data.result_html);
      });

      ajax.fail(function (jqXHR, textStatus, errorThrown) {
        console.debug(jqXHR);
        console.debug(textStatus);
        console.debug(errorThrown);
        showErrorMessage(payboxGenericErrorMessage);
        adminOrder.find('button').prop('disabled', false);
        adminOrder.css({'opacity': 1});
      });

    });

    adminOrderContainer.on('submit', '#paybox-refund-form', function (e) {
      e.preventDefault();

      if (!window.confirm(makeRefundTxt)) {
        return false;
      }

      let adminOrder = $('#up2pay-admin-order');
      let data = {
        action: 'sendRefund',
      };

      adminOrder.find('button').prop('disabled', 'disabled');
      adminOrder.css({'opacity': 0.6});
      let ajax = $.ajax({
        type: 'POST',
        dataType: 'json',
        url: payboxAjaxTransactionUrl + '&' + $.param(data),
        data: $('#paybox-refund-form').serialize(),
      });

      ajax.done(function (data) {
        if (data.redirect_after) {
          window.location.href = data.redirect_after;
        }
        $('#up2pay-admin-order-container').html(data.result_html);
      });

      ajax.fail(function () {
        showErrorMessage(payboxGenericErrorMessage);
        adminOrder.find('button').prop('disabled', false);
        adminOrder.css({'opacity': 1});
      });
    });
  </script>
{/literal}
