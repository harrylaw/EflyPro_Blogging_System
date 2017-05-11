/**
 * Created by harry on 10/05/2017.
 */
$(document).ready(function () {

    // 滚动窗口来判断按钮显示或隐藏
    $(window).scroll(function () {
        if ($(this).scrollTop() > 150) {
            $('.scroll-to-top').fadeIn(100);
        } else {
            $('.scroll-to-top').fadeOut(100);
        }
        if ($(this).scrollTop() > $(document).height() - $(this).height() - 150) { //文件高度减窗口高度再减150px
            $('.scroll-to-bottom').fadeOut(100);
        } else {
            $('.scroll-to-bottom').fadeIn(100);
        }
        //alert();
    });

    // jQuery实现动画滚动
    $('.scroll-to-top').click(function(event) {
        event.preventDefault();
        $('html, body').animate({scrollTop: 0}, 400);
    });
    $('.scroll-to-bottom').click(function(event) {
        event.preventDefault();
        $('html, body').animate({scrollTop: $(document).height() - $(window).height()}, 400);
    });
});