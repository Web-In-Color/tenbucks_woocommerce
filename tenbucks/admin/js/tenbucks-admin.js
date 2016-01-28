(function($) {
    'use strict';

    $(document).ready(function() {
        var contentHeight = $('#adminmenuback').height(),
            $iframe = $('#tenbucks-iframe'),
            iframeOffset = $iframe.offset(),
            calculedHeight = contentHeight - iframeOffset.top - $('#wpfooter').height() - 20;
        $iframe.animate({
            height: calculedHeight
        });

        // Key generation
        $('.tenbucks-action-btn').click(function(e) {
            e.preventDefault();
            var generateKeys = this.name === 'tb-generate' ? 1 : 0,
                $notice = $('#tenbucks-kgn');

            $.post(ajaxurl, {
                action: 'tenbucks_create_key',
                generate: generateKeys
            }, function(res) {
                console.log(res);
                if (res.success) {
                    window.setTimeout(function() {
                        $notice.slideUp();
                    }, 2000);
                } else {
                    $notice.removeClass('notice-info').addClass('notice-error').html(res.message);
                }
                $notice.find('h4').text(res.data.message);
            });
        });
    });

})(jQuery);
