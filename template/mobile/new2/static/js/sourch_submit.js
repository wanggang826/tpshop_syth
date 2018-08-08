// //滚动加载更多
$('#pullrefresh').scroll(
    function() {
        var scrollTop = $(this).scrollTop();
        if(scrollTop > 150){
            $('.banner').hide()
            $('.yincang').show();
        }else{
            $('.banner').show();
            $('.yincang').hide();
        }
        var scrollHeight = $(document).height();
        var windowHeight = $(window).height();
        if (scrollTop + windowHeight > scrollHeight - 200) {
            ajax_sourch_submit();//调用加载更多
        }
    }
);
// 商品列表滚动加载更多
    $('#goods_list').on('scroll',function () {
        var scrollTop = $(this).scrollTop();
        var scrollHeight = $(document).height();
        var windowHeight = $(window).height();
        if (scrollTop + windowHeight > scrollHeight - 200) {
            ajax_sourch_submit();//调用加载更多
        }
        }
    );
