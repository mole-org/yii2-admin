

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