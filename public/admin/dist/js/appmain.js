
function _init() {

    'use strict';
    var neg = $('.main-header').outerHeight() + $('.main-footer').outerHeight();
    var nav_height = $('.nav.nav-tabs').outerHeight();
    var window_height = $(window).height();
    var postSetWidth;

    postSetWidth = window_height - neg;
    $(".content-wrapper").css('min-height', postSetWidth);
//    console.log(window_height);
//    console.log(neg);
//    console.log(postSetWidth);
//    console.log(nav_height);

    $(".tab-contentiframe").css('min-height', postSetWidth - nav_height - 5);
    /**
     * Comment
     * @param {type} parameter
     */
    TabVND(postSetWidth, nav_height);

}
_init();
