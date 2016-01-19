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