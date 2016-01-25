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

        // First connexion notice
        $('#wic_update_fcn').click(function(e) {
            e.preventDefault();
            var $notice = $(this).parents('div.notice');
            $.post(ajaxurl, {
                action: 'wic_update_option',
                wic_hide_fcn: 1
            }, function(res) {
                if (res.success) {
                    $notice.slideUp();
                } else {
                    $notice.removeClass('notice-info').addClass('notice-error').html(res.message);
                }
            });
        });
    });

})(jQuery);
