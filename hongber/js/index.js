/*-------------로그인 및 회원가입영역 hide&show-------------*/
$(function () {
    $('.btn_show').click(function () {
        $('.content').slideToggle(1000);
    });
});
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