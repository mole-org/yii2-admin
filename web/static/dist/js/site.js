(function($) {
  // Overwrite the yii init
  'use strict';

  var yii = window.yii
  var pub = yii

  yii.init = function () {
      initCsrfHandler();
      initScriptFilter();
  }

  function initCsrfHandler() {
    // automatically send CSRF token for all AJAX requests
    $.ajaxPrefilter(function (options, originalOptions, xhr) {
      if (!options.crossDomain && pub.getCsrfParam()) {
        xhr.setRequestHeader('X-CSRF-Token', pub.getCsrfToken());
      }
    });
    pub.refreshCsrfToken();
  }

  function initDataMethods() {
    var handler = function (event) {
      var $this = $(this),
        method = $this.data('method'),
        message = $this.data('confirm');

      if (method === undefined && message === undefined) {
        return true;
      }

      if (message !== undefined) {
        pub.confirm(message, function () {
          pub.handleAction($this);
        });
      } else {
        pub.handleAction($this);
      }
      event.stopImmediatePropagation();
      return false;
    };

    // handle data-confirm and data-method for clickable and changeable elements
    $(document).on('click.yii', pub.clickableSelector, handler)
      .on('change.yii', pub.changeableSelector, handler);
  }

  function initScriptFilter() {
    var hostInfo = location.protocol + '//' + location.host;
    var loadedScripts = $('script[src]').map(function () {
      return this.src.charAt(0) === '/' ? hostInfo + this.src : this.src;
    }).toArray();
    $.ajaxPrefilter('script', function (options, originalOptions, xhr) {
      if (options.dataType == 'jsonp') {
        return;
      }
      var url = options.url.charAt(0) === '/' ? hostInfo + options.url : options.url;
      if ($.inArray(url, loadedScripts) === -1) {
        loadedScripts.push(url);
      } else {
        var found = $.inArray(url, $.map(pub.reloadableScripts, function (script) {
          return script.charAt(0) === '/' ? hostInfo + script : script;
        })) !== -1;
        if (!found) {
          xhr.abort();
        }
      }
    });
  }
})(jQuery);
(function($) {
  'use strict';

  var rcleanScript = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g
  var rscriptType = /^$|\/(?:java|ecma)script/i
  var rscriptTypeMasked = /^true\/(.*)/

  function InsertHtml(content) {
    this.$content = $(content)
    this.$scripts = null
  }

  InsertHtml.prototype = {

    disableScript: function() {
      this.$scripts = 
        this.$content.filter('script')
          .add(this.$content.find('script'))
          .each(function() {
            this.type = (this.getAttribute('type') !== null) + "/" + this.type.replace('/', '|')
          })

      return this
    },

    enableScript: function(noDestroy) {
      if (this.$scripts.length) {
        this.$scripts.each(function() {
            var match = rscriptTypeMasked.exec(this.type)

            if (match) {
              this.type = match[1].replace('|', '/')
            } else {
              this.removeAttribute('type')
            }

            if (rscriptType.test(this.type || '')) {
              if (this.src) {
                $._evalUrl(this.src)
              } else {
                $.globalEval(this.textContent.replace(rcleanScript, ''))
              }
            }
        })
      }

      if (!noDestroy) {
        this.destroy()
      }

      return this
    },

    getContent: function() {
      return this.$content
    },

    destroy: function() {
      this.$content = null
      this.$scripts = null
    }
  }

  window.InsertHtml = InsertHtml
})(jQuery);
(function($) {
  'use strict';

  // Extend $.fn
  $.support.animate = (function() {
    var prefix = ['Webkit', 'Moz', 'O', 'webkit', 'moz', 'o', 'ms']
    var myStyle = document.createElement('div').style
    var i
    for (i in prefix) {
      if (myStyle[prefix[i] + 'AnimationName'] !== undefined) return true
    }
    return false
  })()

  if ($.support.animate) {
    $.each('fadeInUp, fadeOutUp, fadeInDown, fadeOutDown'.split(/,\s*/), function(i, name) {
      $.fn[name] = function(done) {
        this.each(function() {
          var $this = $(this)
          $this.removeClass(name).addClass('animated ' + name)
            .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
              $this.removeClass('animated ' + name)
              $.isFunction(done) && done.apply(this)
            })
        })

        return this
      }
    })
  } else {
    $.fn.fadeInUp = $.fn.fadeInDown = function(done) { return $.fn.fadeIn.call(this, done) }
    $.fn.fadeOutUp = $.fn.fadeOutDown = function(done) { return $.fn.fadeOut.call(this, done) }
  }

  $.fn.findAll = function(selector) {
    return this.filter(selector).add(this.find(selector))
  }

})(jQuery);


(function($) {
  'use strict';

  // window.App
  var App = window.App || {}

  var flat = function(obj, res) {
    if (!res) {
      res = []
    }

    if (typeof(obj) === 'object') {
      var k
      for (k in obj) {
        if (obj.hasOwnProperty(k)) {
          flat(obj[k], res)
        }
      }
    } else {
      res.push(obj)
    }

    return res
  }

  var msgContainer = '#js-messages'
  var tplMessages = '#tpl-messages'
  App._message = function(msg, type, time) {
    if (!App._message.tpl) {
      App._message.tpl = $(tplMessages).html()
    }

    var timeid = null
    var $tpl = $(App.replace(App._message.tpl, {msg: flat(msg).join('<br/>'), type: type}))
    var setTime = function() {
      timeid = window.setTimeout(function() {
        $tpl.find('.message-close').trigger('click')
      }, (time || 5) * 1000)
    }
    var clearTime = function() {
      timeid && window.clearTimeout(timeid) && (timeid = null)
    }

    $tpl.prependTo(msgContainer)
      .fadeInDown()
      .on('mouseover', clearTime)
      .on('mouseout', setTime)
      .find('.message-close')
      .on('click', function() {
        clearTime()
        $tpl.fadeOutDown(function() { $tpl.remove() })
      })

    setTime()
  }
  App.info = function(msg, time) {
    App._message(msg || 'Info', 'info', time)
  }
  App.warning = function(msg, time) {
    App._message(msg || 'Warning', 'warning', time)
  }
  App.success = function(msg, time) {
    App._message(msg || 'Success', 'success', time)
  }
  App.error = function(msg, time) {
    App._message(msg || 'Error', 'error', time)
  }
  App.cleanMessages = function() {
    $(msgContainer).find('.message-close').trigger('click')
  }

  App.dialog = function(options, target) {
    if (!App.dialog.modal) {
      App.dialog.modal = $('#dialog-modal').html()
    }

    var $dialog = $(App.dialog.modal)
    var $dialogTitle = $dialog.find('.modal-title')
    var $dialogBody = $dialog.find('.modal-body')

    if (target) {
      $dialog.data('@EVENT_TRIGGER@', target)
    }

    $.ajax(options)
      .success(function(data, textStatus, jqXHR) {
        var insert = new window.InsertHtml('<div>' + data + '</div>')
        var $content = insert.getContent()
        var title = ''

        if ($content.first().data('title')) {
          title = $content.first().data('title')
        } else if ($content.find('title').length) {
          title = $content.find('title').last().remove().text()
        } 

        if (title) {
          $dialogTitle.text(title)
        }
        
        insert.disableScript()
        $content.find('.breadcrumb').remove()

        $dialog.off('shown.bs.modal').on('shown.bs.modal', function() { insert.enableScript() })
        $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function() { $dialog.remove() })
        $dialogBody.html($content.children())
        $dialog.modal()
      })

    return $dialog
  }

  App.confirm = function(message, ok) {
    if (!App.confirm.$modal) {
      App.confirm.$modal = $($('#confirm-modal').html())
      App.confirm.$body = App.confirm.$modal.find('.modal-body > p')
      App.confirm.$ok = App.confirm.$modal.find('.btn-primary')
    }

    var $dialog = App.confirm.$modal
    var $dialogBody = App.confirm.$body
    var $ok = App.confirm.$ok

    $dialogBody.html(message)
    $ok.off('click')
    if ($.isFunction(ok)) {
      $ok.on('click', ok)
    }
    $dialog.modal()

    return $dialog
  }

  App.alert = function(message) {
    if (!App.alert.$modal) {
      App.alert.$modal = $($('#alert-modal').html())
      App.alert.$body = App.alert.$modal.find('.modal-body > p')
    }

    var $dialog = App.alert.$modal
    var $dialogBody = App.alert.$body
    $dialogBody.html(message)
    $dialog.modal()

    return $dialog
  }

  App.replace = function(str, dict) {
    var r = /\$\{([^\}]+)\}/g
    
    return str.replace(r, function($0, $1) {
      return dict[$1] !== undefined ? dict[$1] : '' 
    })
  }

  window.App = App
})(jQuery);

jQuery(function($) {
  'use strict';

  // Actions handle
  var App = window.App
  var handlers = App.actionHandlers = {}

  $(document).on('click.App', '[data-action]', function(event) {
    var $this = $(this)
    var action = $this.data('action')

    if ($.isFunction(App.actionHandlers[action])) {
      return App.actionHandlers[action].apply(this, arguments)
    } else {
      event.stopImmediatePropagation()
      event.preventDefault()
      console.error(action + ' is not implement.')
    }
  })

  handlers['get.modal'] = function(event) {
    var $this = $(this)

    App.dialog({
      url: $this.attr('href'),
      target: this
    }, this)

    if ($this.closest('.dropdown-menu').length) {
      $(document).click()
    } 
    
    event.stopImmediatePropagation()
    return false
  }
  
  handlers['multi-delete.grid-view'] = function(event) {
    var $this = $(this)
    var $grid = $this.closest('.grid-view')
    var $inputs = $grid.find('.pk > input:enabled:checked')
    var pks = []

    $inputs.each(function() { pks.push($(this).val()) })
    if (!pks.length) {
      App.alert('请选择记录。')
    } else {
      App.confirm(App.replace('确定删除这<b>${num}</b>条记录？', {'num': pks.length}), function() {
        $.ajax({
          url: $this.attr('href'),
          type: 'POST',
          data: {ids: pks}
        }).done(function() {
          $.pjax.reload()
        })
      })
    }

    event.stopImmediatePropagation()
    return false
  }

  handlers['delete.grid-view'] = function(event) {
    var $this = $(this)

    App.confirm('确定删除这条记录？', function() {
      $.ajax({
        url: $this.attr('href'),
        type: 'POST'
      }).done(function() {
        $.pjax.reload()
      })
    })

    event.stopImmediatePropagation()
    return false
  }

  var submitHandeler = function(event) {
    var $this = $(this)
    var data = $this.data('yiiActiveForm')

    if (data.validated) {
      if (this.tagName.toUpperCase() !== 'FORM') {
        throw 'Submit requires a form element.'
      }

      var $modal = $this.closest('.modal')
      var options = event.data && event.data || {}
      var defaults = {
        type: this.method.toUpperCase(),
        url: this.action,
        data: $this.serializeArray(),
        target: this
      }
      $.ajax($.extend({}, defaults, options))
    }
    
    event.stopImmediatePropagation()
    return false
  }
  handlers['update.model-form'] = function(event) {
    var $this = $(this)

    if ($this.data('update.model-form')) {
      return
    } else {
      $this.data('update.model-form', true)
    }
    
    var $form = $this.closest('form')
    var $modal = $form.closest('.modal')
    var options = {}

    if ($modal.length) {
      var $eventTrigger = $($modal.data('@EVENT_TRIGGER@'))
      if ($eventTrigger.closest('.grid-view').length) {
        options['headers'] = {'Accept': 'text/grid'}
        options['success'] = function(data, textStatus, jqXHR) {
          var $tr = $eventTrigger.closest('tr')
          $tr.replaceWith($('<div>' + data + '</div>').find('.grid-view tbody > tr'))
          $modal.modal('hide')
        }
      } else {
        options['success'] = function(data, textStatus, jqXHR) {
          $modal.modal('hide')
        }
      }

      $form.on('submit', options, submitHandeler)
      event.stopImmediatePropagation()
    }
  }
  handlers['create.model-form'] = function(event) {
    var $this = $(this)

    if ($this.data('create.model-form')) {
      return
    } else {
      $this.data('create.model-form', true)
    }

    var $form = $this.closest('form')
    var $modal = $form.closest('.modal')
    var options = {}

    if ($modal.length) {
      var $eventTrigger = $($modal.data('@EVENT_TRIGGER@'))
      if ($eventTrigger.closest('.grid-view').length) {
        options['headers'] = {'Accept': 'text/grid'}
        options['success'] = function(data, textStatus, jqXHR) {
          var $tbody = $eventTrigger.closest('.grid-view').find('tbody:first')
          $tbody.prepend($('<div>' + data + '</div>').find('.grid-view tbody > tr'))
          $modal.modal('hide')
        }
      } else {
        options['success'] = function(data, textStatus, jqXHR) {
          $modal.modal('hide')
        }
      }

      $form.on('submit', options, submitHandeler)
      event.stopImmediatePropagation()
    }
  }
});
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
//# sourceMappingURL=maps/site.js.map