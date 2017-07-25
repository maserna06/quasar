/**
 * Ajax request
 * @param {string} url
 * @param {string} data to send
 * @param {function} callback
 * @returns {jqAjaxObject}
 */
function ajaxSend(url, data, callback) {
  data = data || false;
  return $.ajax({
    url: url,
    data: data,
    method: 'post',
    dataType: 'json',
    success: callback
  });
}
jQuery(function ($) {

  $('#WharehousesUser_apply_datafono').change(function (e) {
    e.preventDefault();
    if ($(this).is(':checked')) {
      requiredDataCash(true);
      $(".modal-dialog").width("70%");
      $('.main_').switchClass("col-xs-12", "col-xs-4", 1000, "easeInOutQuad");
      $('.cash').switchClass("hide", "@", 1050, "easeInOutQuad");
    } else {
      requiredDataCash();
      $('.cash').switchClass("@", "hide", 100, "easeInOutQuad");
      $('.main_').switchClass("col-xs-4", "col-xs-12", 10, "easeInOutQuad");
      $(".modal-dialog").width("30%");
      $("#WharehousesUser_cash_ip").val('');
      $("#WharehousesUser_cash_port").val('');
      $("#WharehousesUser_dataphone_ip").val('');
      $("#WharehousesUser_dataphone_port").val('');
      $("#WharehousesUser_dataphone_name").val('');
    }

  });

  $('input').keypress(function (e) {
    if (e.which == 13) {
      return false;
    }
  });

  function requiredDataCash(isRequired) {
    isRequired = isRequired || false;
    var cashInputs = $('.cash').find('input[type="text"]');
    cashInputs.each(function () {
      $(this).attr('required', isRequired);
    });
  }
});
