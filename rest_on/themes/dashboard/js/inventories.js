jQuery(function ($) {
  var $actionBtn = $('.btn-search-product'),
          $autocompleteInput = $('#product-autocomplete'),
          currentSelected = {id: false};

  if ($autocompleteInput.length) {
    $autocompleteInput.autocomplete({
      source: function (request, response) {
        $.ajax({
          url: $autocompleteInput.data('source'),
          dataType: "json",
          data: {
            term: request.term
          },
          success: function (data) {
            response(data);
          }
        });
      },
      minLength: 1,
      select: function (event, ui) {
        $autocompleteInput.val(ui.item.value);
        currentSelected = ui.item;
        return false;
      }

    });

    $actionBtn.on('click', function (e) {
      e.preventDefault();
      var product;
      if (!currentSelected)
        product = false;
      else
        product = currentSelected.id;
      loadData($autocompleteInput.data('url'), product);
    });

  }

  $('#paginator').on('click', 'ul li a', function (e) {
    e.preventDefault();
    url = $(this).attr('href');
    loadData(url, currentSelected.id ? currentSelected.id : 0);
  });

  /**
   * Load prodcut list
   * @param {string} url
   * @param {numeric} product id del producto     */
  function loadData(url, product) {
    var p = !product ? 0 : product;
    if($autocompleteInput.val()===''){
      p = false;
      currentSelected = {id: false};
    }
    var company = null;
    if($('#companies-select').length){
      company = $('#companies-select').val();
    }
    $.getJSON(url, {
      query: $autocompleteInput.val(),
      view: $('.view-options input[type="radio"]:checked').val(),
      product: p,
      company: company
    }).done(function (set) {
      if (set.data) {
        $('#Inventories_wrapper').html(set.data);
      }
      if (set.paginator) {
        $('#paginator').html(set.paginator);
      } else {
        $('#paginator').html('');
      }
    });
  }

  var $inputViewType = $('.view-options input[type="radio"]');
  $.each($inputViewType, function (index, item) {
    checkOption(item);
    $(item).change(function () {
      $('.view-options label').removeClass('active');
      product = currentSelected.id;
      loadData($('.product-autocomplete').data('url'), product);
      checkOption(item);
    });
  });

  /**
   * add class to parent radio
   * @param {object} e element active
   * @returns void
   */
  function checkOption(e) {
    if ($(e).is(':checked')) {
      $(e).parent('label').addClass('active');
    }
  }

//    scroll to product titles and category description

  $('#Inventories_wrapper').find('.caption').children('h3').slimScroll({
    height: '40px'
  });
  $('#Inventories_wrapper').find('.caption').children('.category').slimScroll({
    height: '40px'
  });
  
  $(document).on('click', '.open-detail', function(e){
    e.preventDefault();
    $('#modal-product').find('.modal-body').html('<i class="fa fa-refresh fa-spin"></i>')
    $.ajax({
      url: urlDetailProduct,
      dataType: "json",
      data: {
        product: $(this).data('id')
      }
    }).done(function (set) {
      if(!set.error){
        $('#modal-product').find('.modal-body').html(set.data);
        $('#modal-product').modal('show');
      }
    });
  });
  
});