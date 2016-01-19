
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