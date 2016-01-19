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