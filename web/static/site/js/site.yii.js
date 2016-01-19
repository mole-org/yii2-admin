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