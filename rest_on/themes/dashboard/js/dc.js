;
var globalClickEvent = 'click',
        touchDevice = false;

function isTouchDevice() {
  return "ontouchstart" in window || "onmsgesturechange" in window;
}

function showMessage(options) {
  if (Modal) {
    Modal.show(options);
  } else {
    alert(options);
  }
}

jQuery(function ($) {
  var $settings = $('#edit-roles-list'),
          $body = $('body'),
          $document = $(document);

  if ($settings.length) {
    /**
     * Ajax request to change role
     * @param {string} url
     * @param {function} callback
     * @returns {jqAjaxObject}
     */
    function changeRole(url, callback) {
      return $.ajax({
        url: url,
        method: 'post',
        dataType: 'json',
        success: callback
      });
    }

    $settings.find('li a.btn').on('click', function (e) {
      e.preventDefault();
      var $this = $(this),
              successClass = 'btn-success',
              dangerClass = 'btn-danger'
              ;
      if ($this.attr('disabled') == 'disabled')
        return false;
      $this.attr('disabled', 'disabled');
      changeRole(this.href, function (response) {
        $this.removeAttr('disabled');
        if (!response.error) {
          if (response.show) {
            $(response.show).show('fast');
          } else if (response.hide) {
            $(response.hide).hide('fast');
            try {
              $('#bodegas a.btn').removeClass('btn-success').addClass('btn-danger').text('Off');
            } catch (e) {
            }
          }
          if ($this.hasClass(successClass)) {
            $this.removeClass(successClass).addClass(dangerClass).text('Off');
          } else if ($this.hasClass(dangerClass)) {
            $this.removeClass(dangerClass).addClass(successClass).text('On');
          }
        } else {
          showMessage(response.error);
        }
      });
    });
  }
  /*Sidebar toggle*/
  var ajaxSidebar = null,
          collapseState = 'sidebar-collapse';
  $('a.sidebar-toggle').on('click', function () {
    var state = $('body').hasClass(collapseState) ? '' : collapseState;
    if (ajaxSidebar) {
      ajaxSidebar.abort();
    }
    ajaxSideBar = $.ajax({
      url: './site/saveMenuState',
      method: 'post',
      dataType: 'json',
      data: {
        'sidebar-state': state
      }
    });
  });
  /**
   * Fix Touch menu events on tablets
   */
  touchDevice = isTouchDevice();
  if (touchDevice) {
    globalClickEvent = 'touchstart';
    $body.addClass('touch-device');
    function documentClick(e) {
      if (!$(e.target).parents().hasClass('sidebar-menu')) {
        $('ul.sidebar-menu').removeAttr('style');
        $document.off(globalClickEvent, documentClick);
      }
    }
    $('ul.sidebar-menu li.treeview a').each(function () {
      var $this = $(this),
              $li = $this.parent(),
              $ul = $li.parent();
      $this.on(globalClickEvent, function () {
        $ul.attr('style', 'overflow:visible !important');
        $document.off(globalClickEvent, documentClick);
        $document.on(globalClickEvent, documentClick);
      });
    });
  }

  /*
   * Print buttons action
   */
  $('.printing').on('click', function (e) {
    e.preventDefault();
    var section = $(this).data('section');
    if (section) {
      return printSection(section);
    }
  });
});

/**
 * Print section
 * @param {string} section Section Id
 * @returns {void}
 */
function printSection(section) {
  if (section) {
    section = jQuery('#' + section);
    if (section.length) {
      section.removeClass('section-to-print').addClass('section-to-print');
      try {
        window.print();
        section.revemoClas('section-to-print');
      } catch (e) {
      }
    }
  } else {
    try {
      window.print();
    } catch (e) {
    }
  }
}


