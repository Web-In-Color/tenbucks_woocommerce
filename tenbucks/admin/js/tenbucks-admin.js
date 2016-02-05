(function() {
  var bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  jQuery(document).ready(function($) {
    var $iframe, Notice, calculedHeight, contentHeight, iframeOffset;
    contentHeight = $('#adminmenuback').height();
    $iframe = $('#tenbucks-iframe');
    if ($iframe.length) {
      iframeOffset = $iframe.offset();
      calculedHeight = contentHeight - iframeOffset.top - $('#wpfooter').height() - 20;
      $iframe.animate({
        height: calculedHeight
      });
    }
    $('#tenbucks_register_form').submit(function(e) {
      var data, notice;
      e.preventDefault();
      data = $(this).serializeArray();
      data.push({
        name: 'action',
        value: 'tenbucks_create_key'
      });
      notice = new Notice;
      $('#submit').attr('disabled', true);
      return $.post(ajaxurl, data, function(res) {
        if (res.success) {
          notice.setType('success');
        } else {
          notice.setType('error');
          $('#submit').attr('disabled', false);
        }
        if (res.data.message) {
          return notice.setMessage(res.data.message);
        }
      });
    });
    return Notice = (function() {
      function Notice(type, message, parentSelector, ANIMATION_TIME, scrollTo) {
        var $notice;
        if (type == null) {
          type = 'info';
        }
        this.parentSelector = parentSelector != null ? parentSelector : '#notices';
        this.ANIMATION_TIME = ANIMATION_TIME != null ? ANIMATION_TIME : 400;
        if (scrollTo == null) {
          scrollTo = false;
        }
        this.setMessageHtml = bind(this.setMessageHtml, this);
        this.setMessage = bind(this.setMessage, this);
        this.setType = bind(this.setType, this);
        this.getAlert = bind(this.getAlert, this);
        this.active = true;
        this.identifer = 'notice' + Date.now();
        if (typeof message === 'undefined') {
          message = $(this.parentSelector).data('wait');
        }
        $notice = $('<div />', {
          'class': "notice notice-" + (type.replace(/^notice-/, '')),
          id: this.identifer
        }).append($('<p />', {
          text: message
        }));
        $(this.parentSelector).prepend($notice);
        if (scrollTo) {
          $('html, body').animate({
            scrollTop: $notice.offset().top - 40
          }, this.ANIMATION_TIME);
        }
        return this;
      }

      Notice.prototype.getAlert = function() {
        return $(this.parentSelector).find('#' + this.identifer);
      };

      Notice.prototype.setType = function(type) {
        var newClass;
        newClass = "notice notice-" + (type.replace(/^notice-/, ''));
        this.getAlert().removeClass().addClass(newClass);
        return this;
      };

      Notice.prototype.setMessage = function(message) {
        this.getAlert().find('p').text(message);
        return this;
      };

      Notice.prototype.setMessageHtml = function(message) {
        this.getAlert().find('p').html(message);
        return this;
      };

      Notice.prototype.hide = function(callback) {
        return this.getAlert().slideUp(this.ANIMATION_TIME, callback);
      };

      Notice.prototype.show = function(callback) {
        return this.getAlert().slideDown(this.ANIMATION_TIME, callback);
      };

      return Notice;

    })();
  });

}).call(this);

//# sourceMappingURL=tenbucks-admin.js.map
