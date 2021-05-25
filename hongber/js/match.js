jQuery(function ($) {
    $(".btn_box").hover(function () {
        $(".drop_btn").stop().slideToggle("500");
        $(".drop_btn1").stop().slideToggle("500");
    });
});