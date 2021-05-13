/*-------------상단바 스크롤 시-------------*/
$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 10) {
            $('.nav').fadeOut();
        }
        else {
            $('.nav').fadeIn();
        }
    });
});