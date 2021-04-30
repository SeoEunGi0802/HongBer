/*-------------상단바 스크롤 시-------------*/
$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 10) {
            $('.header').fadeOut();
        }
        else {
            $('.header').fadeIn();
        }
    });
});
var currentPosition = parseInt($("#sidebox").css("top")); $(window).scroll(function () { var position = $(window).scrollTop(); $("#sidebox").stop().animate({ "top": position + currentPosition + "px" }, 100); });