jQuery(function ($) {
    $(".btn_box").hover(function () {
        $(".drop_btn").stop().slideToggle("500");
        $(".drop_btn1").stop().slideToggle("500");
    });

    $(".hot_card").hover(function () {
        $(this).children(".hot_img").toggle(500);
    });

    $(".honor_card").hover(function () {
        $(this).children(".hm_img").toggle(500);
    });
});