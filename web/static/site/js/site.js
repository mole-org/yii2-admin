(function($) {
  'use strict';

  var App = window.App
  var pub = {
    isActive: true,
    init: function() {
      initAjax()
      initPjax()
      initAjaxFileUpload()
      initFixed()
    }
  }

  function initAjax() {
    $.ajaxPrefilter(function(options, originalOptions, jqXHR) {
      jqXHR.$$handled = false
      jqXHR.fail(function(jqXHR, textStatus, errorThrown) {
        if (textStatus === 'error' && errorThrown === '') {
          App.error('Can\'t connect the server, please check you networks.')
        } else if (textStatus === 'timeout') {
          App.error('Request timeout')
        } else if (textStatus === 'parsererror') {
          console.error(errorThrown.stack)
        } else if (jqXHR.status >= 301 && jqXHR.status <= 303) {
          // Using pjax for redirect.
          var url = jqXHR.getResponseHeader('X-Pjax-Url') || jqXHR.getResponseHeader('X-Redirect')
          $.pjax({url: url})
        } else if (jqXHR.status === 401) {
          var $dialog = $($('#login-modal').html())
          $dialog.modal()
          $dialog.on('hidden.bs.modal', function() { $dialog.remove() })
          $dialog.on('submit', 'form', function(event) {
            var $this = $(this)
            $.ajax({
              type: this.method.toUpperCase(),
              url: this.action,
              data: $this.serializeArray(),
              target: this
            }).done(function() {
              $dialog.modal('hide')
            })

            event.stopImmediatePropagation()
            return false
          })
        } else if (jqXHR.status === 417) {
          var message = jqXHR.responseText
          try {
            message = $.trim(message.substr(message.indexOf(':') + 1))
            message = $.parseJSON(message)
            App.error(message)
          } catch(ex) { console.error(ex) }
        } else {
          App.error(jqXHR.responseText) 
        }

        jqXHR.$$handled = true
      })

      if (options.target) {
        var $target = $(options.target)
        var count = $target.data('@JQ_AJAX_COUNT@') || 0
        if (count > 0) {
          jqXHR.abort()
        } else {
          $target.data('@JQ_AJAX_COUNT@', ++count)
          jqXHR.always(function() {
            $target.data('@JQ_AJAX_COUNT@', --count)
          })
        }
      }
    })

    var ajaxLoading = '#ajax-loading'
    var $ajaxLoading = $(ajaxLoading)
    $(document).ajaxStart(function() {
      $ajaxLoading.addClass('fullwidth')
    })
    $(document).ajaxStop(function() {
      $ajaxLoading.removeClass('fullwidth')
    })
  }

  var pjaxContainer = '#page-wrapper'
  function initPjax() {
    // Fixed for IE
    if (!$.support.pjax) return

    // Pjax default setting
    $.pjax.defaults.timeout = 30 * 1000
    $.pjax.defaults.isPjax = true
    $.pjax.defaults.container = pjaxContainer


    // Change the default behavior of PJAX for redirect handle.
    $.ajaxPrefilter(function(options, originalOptions, jqXHR) {

      if (options.isPjax) {
        var error = options.error
        options.error = function(xhr, textStatus, errorThrown) {
          // TODO handle the error
          //if ($.isFunction(error)) error.call(this, xhr, textStatus, errorThrown)
        }

        options.context.on('pjax:start', function() { App.cleanMessages() })
      }
    })

    $(document).pjax('a', pjaxContainer)
    $(document).on('submit', 'form', function(event) {
      if ($(this).data('pjax')) {
        $.pjax.submit(event, pjaxContainer)
      }
    })
  }

  function initAjaxFileUpload() {
    $(document).on('change', '.btn-file :file', function() {
      var $this = $(this)
      var label = $this.val().replace(/\\/g, '/').replace(/.*\//, '')
      
      $this.trigger('fileselect', [label])
    })

    $(document).on('fileselect', '.btn-file :file', function(event, label) {
      var $this = $(this)
      var $label = $this.data('label')

      if (!$label) {
        $label = $('<span />').insertAfter($this.parent())
        $this.data('label', $label)
      }
      $label.text(label)
    })

    // Ajax file upload handler
    // $.ajax({
    //   url: this.action,
    //   method: this.method || 'GET',
    //   data: new FormData(this),
    //   contentType: false,
    //   processData: false,
    //   cache: false
    // })
  }

  function initFixed() {
    $.fn.ready = function(fn) {
    // Add the callback
      var _fn = function() {
        try {
          fn.apply(this, arguments)
        } catch (e) {
          console.error(e)
        }
      }
      $.ready.promise().done(_fn)

      return this
    };
  }

  $(document).ready(function () {
    window.yii.initModule(pub)
  })
  
})(jQuery);