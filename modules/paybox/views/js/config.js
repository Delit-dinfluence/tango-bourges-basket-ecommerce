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

$(document).ready(function () {
  (function () {
    var Up2pay = {
      el: {
        body: $('body'),

        max: 99,

        marketingBlock: $('.up2pay-marketing'),
        accountBlock: $('.up2pay-account'),
        paymentBlock: $('.up2pay-payment'),
        instalmentBlock: $('.up2pay-instalment'),
        subscriptionBlock: $('.up2pay-subscription'),

        hideWhatsNewBtn: $('.js-up2pay-hide-whatsnew'),

        marketingForm: $('.js-up2pay-marketing-form'),
        showMarketingBtn: $('.js-up2pay-marketing-display'),

        switchEnv: $('.js-up2pay-env-switch span'),
        switchDemoMode: $('.js-up2pay-demo-mode-switch span'),
        switchPaymentDisplay: $('.js-up2pay-payment-display-switch span'),
        switchDebitType: $('.js-up2pay-debit-type-switch span'),
        switchCaptureEvent: $('.js-up2pay-capture-event-switch span'),
        switchEnableSubscription: $('.js-up2pay-subscription-enabled-switch span'),
        switchEnableInstalment: $('.js-up2pay-instalment-enabled-switch span'),

        credentialsBlock: $('.js-up2pay-credentials-block'),
        demoCredentialsBlock: $('.js-up2pay-demo-credentials-block'),
        credentialsInputs: $('.js-up2pay-credentials-block :input[type="text"]'),
        hmacTestBlock: $('.js-up2pay-hmac-test-block'),
        hmacProdBlock: $('.js-up2pay-hmac-prod-block'),

        demoModeBlock: $('.js-up2pay-demo-mode-block'),
        envBlock: $('.js-up2pay-env-block'),
        displayPaymentBlock: $('.js-up2pay-payment-display-block'),
        contractsBlock: $('.js-up2pay-contracts-block'),
        debitTypeBlock: $('.js-up2pay-debit-type-block'),
        captureEventBlock: $('.js-up2pay-capture-event-block'),
        deferredDaysBlock: $('.js-up2pay-deferred-days-block'),
        deferredStatusBlock: $('.js-up2pay-deferred-status-block'),
        displayTextBlock: $('.js-up2pay-display-text-block'),
        logoBlock: $('.js-up2pay-logo-block'),
        oneClickBlock: $('.js-up2pay-one-click-block'),

        contractSelect: $('#up2pay-add-contract'),

        enableSubscriptionBlock: $('.js-up2pay-subscription-enabled-block'),
        subscriptionInputsBlock: $('.js-up2pay-subscription-inputs-block'),
        enableInstalmentBlock: $('.js-up2pay-instalment-enabled-block'),
        instalmentInputsBlock: $('.js-up2pay-instalment-inputs-block'),

        whatsNewModal: $('#up2pay-modal-whatsnew'),
        checkConfigModal: $('#up2pay-modal-check-config'),
        contactModal: $('#up2pay-modal-contact'),

        inputs2: $('#instalment-2 input.subpart'),
        inputs3: $('#instalment-3 input.subpart'),
        inputs4: $('#instalment-4 input.subpart'),
      },
      init: function () {
        var el = this.el;

        el.showMarketingBtn.on('click', this.hideMarketing);
        el.whatsNewModal.on('click', '.js-up2pay-hide-whatsnew', this.hideWhatsNew);
        el.demoModeBlock.on('click', el.switchDemoMode, this.toggleDemoMode);
        el.envBlock.on('click', el.switchEnv, this.toggleLiveEnv);
        el.displayPaymentBlock.on('click', el.switchPaymentDisplay, this.togglePaymentDisplay);
        el.debitTypeBlock.on('click', el.switchDebitType, this.toggleDebitType);
        el.captureEventBlock.on('click', el.switchCaptureEvent, this.toggleCaptureEvent);
        el.subscriptionBlock.on('click', el.switchEnableSubscription, this.toggleSubscription);
        el.instalmentBlock.on('click', el.switchEnableInstalment, this.toggleInstalment);
        el.whatsNewModal.on('shown.bs.modal', this.loadWhatsNew);
        el.whatsNewModal.on('hide.bs.modal', this.resetModal);
        el.checkConfigModal.on('shown.bs.modal', this.loadCheckConfig);
        el.checkConfigModal.on('hide.bs.modal', this.resetModal);
        el.contactModal.on('shown.bs.modal', this.loadContact);
        el.contactModal.on('hide.bs.modal', this.resetModal);
        el.contractSelect.on('change', this.updateContract);
        $('.remove-contract').on('click', this.hideContract);
        el.inputs2.on('input', function (e) {
          var $this = $(this);
          var sum = Up2pay.sumInputs(Up2pay.el.inputs2.not(function (i, el) {
            return el === e.target;
          }));
          var value = parseInt($this.val(), 10) || 0;
          var subpartAuto = $('#instalment-2 .subpartAuto');

          if (sum + value > 99) {
            $this.val(99 - sum);
            subpartAuto.val(1);
            return;
          }
          subpartAuto.val(99 - sum - value + 1);
        });
        el.inputs3.on('input', function (e) {
          var $this = $(this);
          var sum = Up2pay.sumInputs(Up2pay.el.inputs3.not(function (i, el) {
            return el === e.target;
          }));
          var value = parseInt($this.val(), 10) || 0;
          var subpartAuto = $('#instalment-3 .subpartAuto');

          if (sum + value > 99) {
            $this.val(99 - sum);
            subpartAuto.val(1);
            return;
          }
          subpartAuto.val(99 - sum - value + 1);
        });
        el.inputs4.on('input', function (e) {
          var $this = $(this);
          var sum = Up2pay.sumInputs(Up2pay.el.inputs4.not(function (i, el) {
            return el === e.target;
          }));
          var value = parseInt($this.val(), 10) || 0;
          var subpartAuto = $('#instalment-4 .subpartAuto');

          if (sum + value > 99) {
            $this.val(99 - sum);
            subpartAuto.val(1);
            return;
          }
          subpartAuto.val(99 - sum - value + 1);
        });
        this.toggleLiveEnv();
        this.toggleDemoMode();
        this.togglePaymentDisplay();
        this.toggleCaptureEvent();
        this.toggleDebitType();
        this.toggleSubscription();
        this.toggleInstalment();
        this.displayWhatsNewModal();

      },
      sumInputs: function ($inputs) {
        var sum = 0;

        $inputs.each(function () {
          sum += parseInt($(this).val(), 0);
        });

        return sum;
      },
      hideMarketing: function (e) {
        e.preventDefault();

        var btn = $(this);
        var icon = $(this).find('i');

        btn.toggleClass('disabled');
        icon.toggleClass('icon-eye-slash icon-spinner icon-spin');
        var data = {
          controller: 'AdminPayboxAjax',
          ajax: 1,
          token: up2payAjaxToken,
          action: 'hideMarketingBlock'
        };
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: baseAdminDir + 'index.php?' + $.param(data)
        }).fail(function (jqXHR, textStatus) {
          showErrorMessage(genericErrorMessage);
        }).done(function (data) {
          if (!data.errors) {
            Up2pay.el.marketingForm.remove();
          } else {
            showErrorMessage(data.message);
          }
        }).always(function (data) {
          btn.toggleClass('disabled');
          icon.toggleClass('icon-eye-slash icon-spinner icon-spin');
        });
      },
      toggleDemoMode: function () {
        if ($('#up2paySettings_demoMode_on').prop('checked')) {
          Up2pay.el.envBlock.hide();
          Up2pay.el.credentialsInputs.prop('disabled', true);
          Up2pay.el.credentialsBlock.hide();
          Up2pay.el.demoCredentialsBlock.show(400);
          Up2pay.el.hmacTestBlock.css({'opacity': 1});
          Up2pay.el.hmacTestBlock.attr('required', true);
          Up2pay.el.hmacProdBlock.css({'opacity': 1});
          Up2pay.el.hmacProdBlock.attr('required', true);
        } else {
          Up2pay.el.credentialsInputs.prop('disabled', false);
          Up2pay.el.credentialsBlock.show(400);
          Up2pay.el.demoCredentialsBlock.hide();
          Up2pay.el.envBlock.show(400);
          Up2pay.toggleLiveEnv();
        }
      },
      toggleLiveEnv: function () {
        if ($('#up2paySettings_environment_prod').prop('checked')) {
          Up2pay.el.hmacTestBlock.css({'opacity': 0.3});
          Up2pay.el.hmacTestBlock.find('input[type="text"]').removeAttr('required');
          Up2pay.el.hmacTestBlock.find('label').removeClass('required');
          Up2pay.el.hmacProdBlock.css({'opacity': 1});
          Up2pay.el.hmacProdBlock.find('input[type="text"]').attr('required', true);
          Up2pay.el.hmacProdBlock.find('label').addClass('required');
        } else {
          Up2pay.el.hmacTestBlock.css({'opacity': 1});
          Up2pay.el.hmacTestBlock.find('input[type="text"]').attr('required', true);
          Up2pay.el.hmacTestBlock.find('label').addClass('required');
          Up2pay.el.hmacProdBlock.css({'opacity': 0.3});
          Up2pay.el.hmacProdBlock.find('input[type="text"]').removeAttr('required');
          Up2pay.el.hmacProdBlock.find('label').removeClass('required');
        }
      },
      toggleDebitType: function () {
        if ($('#up2payPayment_debit_immediat').prop('checked')) {
          Up2pay.el.deferredDaysBlock.hide();
          Up2pay.el.deferredStatusBlock.hide();
          Up2pay.el.captureEventBlock.hide();
        } else {
          Up2pay.el.captureEventBlock.show(400);
          Up2pay.toggleCaptureEvent();
        }
      },
      togglePaymentDisplay: function () {
        if ($('#up2payPayment_display_detailed').prop('checked')) {
          Up2pay.el.contractsBlock.show(400);
          Up2pay.el.displayTextBlock.hide();
          Up2pay.el.logoBlock.hide();
          Up2pay.el.oneClickBlock.hide();
        } else {
          Up2pay.el.contractsBlock.hide();
          Up2pay.el.displayTextBlock.show(400);
          Up2pay.el.logoBlock.show(400);
          Up2pay.el.oneClickBlock.show(400);
        }
      },
      toggleCaptureEvent: function () {
        if ($('#up2payPayment_event_days').prop('checked')) {
          Up2pay.el.deferredDaysBlock.show(400);
          Up2pay.el.deferredStatusBlock.hide();
        } else {
          Up2pay.el.deferredDaysBlock.hide();
          Up2pay.el.deferredStatusBlock.show(400);
        }
      },
      toggleInstalment: function () {
        if ($('#up2payInstalment_enabled').prop('checked')) {
          Up2pay.el.instalmentInputsBlock.show(400);
        } else {
          Up2pay.el.instalmentInputsBlock.hide();
        }
      },
      displayWhatsNewModal: function () {
        if (showWhatsNew === true) {
          Up2pay.el.whatsNewModal.modal('show');
        }
      },
      toggleSubscription: function () {
        if ($('#up2paySubscription_enabled').prop('checked')) {
          Up2pay.el.subscriptionInputsBlock.show(400);
        } else {
          Up2pay.el.subscriptionInputsBlock.hide();
        }
      },
      updateContract: function (e) {
        var select = $(e.target);
        var dataId = select.find('option:selected').val();
        var row = Up2pay.el.contractsBlock.find('[data-id=' + dataId + ']');

        row.toggleClass('selectable');
        select.val(-1);
        select.find('option[value=' + dataId + ']').hide();
        $('input[name="up2payPaymentMethods[' + dataId + '][isSelectable]"').val('');
      },
      hideContract: function (e) {
        e.preventDefault();

        var link = $(e.target);
        var dataId = link.attr('data-id');
        var row = Up2pay.el.contractsBlock.find('[data-id=' + dataId + ']');

        console.debug(link);
        console.debug(dataId);

        row.find('input[name="up2payPaymentMethods[' + dataId + '][enabled]"]').prop('checked', false);
        row.find('input[name="up2payPaymentMethods[' + dataId + '][enabled]"]').trigger('click');
        row.toggleClass('selectable');
        Up2pay.el.contractSelect.find('option[value=' + dataId + ']').show();
        $('input[name="up2payPaymentMethods[' + dataId + '][isSelectable]"').val('true');
      },
      loadWhatsNew: function (e) {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: 'index.php',
          data: {
            controller: 'AdminPayboxAjax',
            ajax: 1,
            token: up2payAjaxToken,
            action: 'whatsNew'
          }
        }).fail(function (jqXHR, textStatus) {
        }).done(function (data) {
          $(e.target).find('.modal-body').html(data.result_html);
        }).always(function (data) {
        });
      },
      hideWhatsNew: function (e) {
        e.preventDefault();

        var btn = $(this);
        var icon = $(this).find('i');

        btn.toggleClass('disabled');
        icon.toggleClass('icon-eye-slash icon-spinner icon-spin');

        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: 'index.php',
          data: {
            controller: 'AdminPayboxAjax',
            ajax: 1,
            token: up2payAjaxToken,
            action: 'hideWhatsNew'
          }
        }).fail(function (jqXHR, textStatus) {
        }).done(function (data) {
          Up2pay.el.whatsNewModal.modal('hide');
        }).always(function (data) {
          btn.toggleClass('disabled');
          icon.toggleClass('icon-eye-slash icon-spinner icon-spin');
        });
      },
      loadCheckConfig: function (e) {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: 'index.php',
          data: {
            controller: 'AdminPayboxAjax',
            ajax: 1,
            token: up2payAjaxToken,
            action: 'checkConfig'
          }
        }).fail(function (jqXHR, textStatus) {
        }).done(function (data) {
          $(e.target).find('.modal-body').html(data.result_html);
        }).always(function (data) {
        });
      },
      loadContact: function (e) {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: 'index.php',
          data: {
            controller: 'AdminPayboxAjax',
            ajax: 1,
            token: up2payAjaxToken,
            action: 'contact'
          }
        }).fail(function (jqXHR, textStatus) {
        }).done(function (data) {
          $(e.target).find('.modal-body').html(data.result_html);
        }).always(function (data) {
        });
      },
      resetModal: function (e) {
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: 'index.php',
          data: {
            controller: 'AdminPayboxAjax',
            ajax: 1,
            token: up2payAjaxToken,
            action: 'resetModal'
          }
        }).fail(function (jqXHR, textStatus) {
        }).done(function (data) {
          $(e.target).find('.modal-body').remove();
          $(e.target).find('.modal-footer').remove();
          $(e.target).find('.modal-content').append(data.result_html);
        }).always(function (data) {
        });
      }
    };

    Up2pay.init();
  })();
});

function validateInstalmentsAmount() {
  let amount21 = parseFloat(document.getElementsByName('up2payInstalment[instalments][0][minAmount]')[0].value);
  let amount22 = parseFloat(document.getElementsByName('up2payInstalment[instalments][0][maxAmount]')[0].value);
  let amount31 = parseFloat(document.getElementsByName('up2payInstalment[instalments][1][minAmount]')[0].value);
  let amount32 = parseFloat(document.getElementsByName('up2payInstalment[instalments][1][maxAmount]')[0].value);
  let amount41 = parseFloat(document.getElementsByName('up2payInstalment[instalments][2][minAmount]')[0].value);
  let amount42 = parseFloat(document.getElementsByName('up2payInstalment[instalments][2][maxAmount]')[0].value);

  if (amount21 >= amount22 && amount21 > 0) {
    showErrorMessage(instalmentAmountsErrorMessage);

    return false;
  }
  if (amount31 >= amount32 && amount31 > 0) {
    showErrorMessage(instalmentAmountsErrorMessage);

    return false;
  }
  if (amount41 >= amount42 && amount41 > 0) {
    showErrorMessage(instalmentAmountsErrorMessage);

    return false;
  }

  return true;
}
