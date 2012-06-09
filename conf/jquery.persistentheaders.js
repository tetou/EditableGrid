/**
 * jquery.persistentheaders.js
 *
 * Release 0.0.1 (Mar 27, 2012)
 *
 * http://css-tricks.com/examples/PersistantHeaders/
 */

(function($){

    jQuery.fn.persistentHeaders = function(options) {

        var defaults = {
            areaName: 'persist-area',
            headerName: 'persist-header',
            slideUpSpeed: 0,
            slideDownSpeed: 0,
            isHidden: true
        };
        var setting = jQuery.extend(defaults, options);

        var clonedHeaderRow;
        jQuery(".persist-area").each(function() {
            clonedHeaderRow = jQuery(".persist-header", this);
            clonedHeaderRow
                .before(clonedHeaderRow.clone())
                .css("width", clonedHeaderRow.width())
                .addClass("floatingHeader");
        });
        jQuery(window)
            .scroll(function () {
                $(".persist-area").each(function() {
                    var el             = $(this),
                        offset         = el.offset(),
                        scrollTop      = $(window).scrollTop(),
                        floatingHeader = $(".floatingHeader", this)
                    if ((scrollTop > offset.top) && (scrollTop < offset.top + el.height())) {
                        floatingHeader.slideDown(setting.slideDownSpeed);
                        floatingHeader.css({
                            "visibility": "visible"
                        });
                    } else if ((scrollTop > offset.top)) {
                        if (setting.isHidden) {
                            floatingHeader.slideUp(setting.slideUpSpeed);
                        }
                    } else {
                        floatingHeader.css({
                            "visibility": "hidden"
                        });
                    };
                })
            }).trigger("scroll");
        return this;
    };
})(jQuery)
