<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:43:"./template/mobile/new2/goods\goodsList.html";i:1516343066;s:41:"./template/mobile/new2/public\header.html";i:1516181748;s:42:"./template/mobile/new2/public\top_nav.html";i:1508133937;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>商品列表--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
    <link rel="stylesheet" href="__STATIC__/css/mui.min.css">
    <link rel="stylesheet" href="__STATIC__/css/style.css">
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/iconfont.css"/>
    <script src="__STATIC__/js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/mui.min.js"  type="text/javascript" ></script>
    <!--<script src="__STATIC__/js/zepto-1.2.0-min.js" type="text/javascript" charset="utf-8"></script>-->
    <script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/mobile-util.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <script src="__STATIC__/js/layer.js"  type="text/javascript" ></script>
    <script src="__STATIC__/js/swipeSlide.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="__STATIC__/fonts/mui.ttf"/>
</head>
<body class="[body]">

<style>
    html,body{height:100%;}
</style>
    <!--搜索栏-s-->
    <div class="classreturn whiback">
        <div class="content">
            <div class="ds-in-bl return">
                <a href="javascript:history.back(-1);"><img src="__STATIC__/images/return.png" alt="返回"></a>
            </div>
            <div class="ds-in-bl search">
                <form action="" method="post">
                    <div class="sear-input">
                        <a href="<?php echo U('Goods/ajaxSearch'); ?>">
                            <input type="text" value="<?php echo I('q')?>">
                        </a>
                    </div>
                </form>
            </div>
            <div class="ds-in-bl menu">
                <a href="javascript:void(0);"><img src="__STATIC__/images/class1.png" alt="菜单"></a>
            </div>
        </div>
    </div>
    <!--搜索栏-e-->

    <!--顶部隐藏菜单-s-->
    <div class="flool tpnavf [top-header]">
    <div class="footer">
        <ul>
            <li>
                <a class="yello" href="<?php echo U('Index/index'); ?>">
                    <div class="icon">
                        <i class="icon-shouye iconfont"></i>
                        <p>首页</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('Goods/categoryList'); ?>">
                    <div class="icon">
                        <i class="icon-fenlei iconfont"></i>
                        <p>分类</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('Cart/index'); ?>">
                    <div class="icon">
                        <i class="icon-gouwuche iconfont"></i>
                        <p>购物车</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('User/index'); ?>">
                    <div class="icon">
                        <i class="icon-wode iconfont"></i>
                        <p>我的</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
    <!--顶部隐藏菜单-e-->

    <!--排序按钮-s-->
    <nav class="storenav p search_list_dump" id="head_search_box product_sort">
        <ul>
            <li>
               <span class="lb <?php if((I('sort') == 'is_new' or  I('sort') == 'comment_count')): ?>red<?php endif; ?>">综合</span>
                <i></i>
            </li>
            <li class="<?php if(I('sort') == 'sales_sum'): ?>red<?php endif; ?>">
                <a href="<?php echo urldecode(U('Mobile/Goods/goodsList',array_merge($filter_param,array('sort'=>'sales_sum')),''));?>" >
                    <span class="dq" >销量</span>
                </a>
            </li>
            <li class="<?php if(I('sort') == 'shop_price'): ?>red<?php endif; ?>">
                <a href="<?php echo urldecode(U('Mobile/Goods/goodsList',array_merge($filter_param,array('sort'=>'shop_price','sort_asc'=>$sort_asc)),''));?>">
                    <span class="jg dq">价格</span>
                </a>
                <i  class="pr <?php if(I('sort_asc') == 'asc'): ?>bpr2<?php endif; if(I('sort_asc') == 'desc'): ?> bpr1 <?php endif; ?>"></i>
            </li>
            <li>
                <span class="sx">筛选</span>
                <i class="fitter"></i>
            </li>
            <li>
                <i class="listorimg"></i>
            </li>
        </ul>
    </nav>
    <!--排序按钮-e-->

    <!--商品详情s-->
    <div id="goods_list" style="overflow-y: scroll;height: 100%;padding-bottom: 80px;">
        <?php if(empty($goods_list) || (($goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator ) && $goods_list->isEmpty())): ?>
            <p class="goods_title" id="goods_title" style="line-height: 100px;text-align: center;margin-top: 30px;">抱歉暂时没有相关结果,换个筛选条件试试吧！</p>
        <?php else: if(is_array($goods_list) || $goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator): if( count($goods_list)==0 ) : echo "" ;else: foreach($goods_list as $k=>$vo): ?>
            <div class="orderlistshpop p">
                <div class="maleri30">
                    <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$vo[goods_id])); ?>" class="item">
                        <div class="sc_list se_sclist">
                            <div class="shopimg fl">
                                <img src="<?php echo goods_thum_images($vo['goods_id'],400,400); ?>">
                            </div>
                            <div class="deleshow fr">
                                <div class="deletes">
                                    <span class="similar-product-text fl"><?php echo getSubstr($vo['goods_name'],0,20); ?></span>
                                </div>
                                <div class="prices">
                                    <p class="sc_pri fl"><span>￥</span><span><?php echo $vo[shop_price]; ?>元</span></p>
                                </div>
                                <p class="weight"><span><?php echo $vo[comment_count]; ?></span><span>条评价</span></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; endif; ?>
    </div>
    <!--商品详情e-->

    <!--加载更多S-->
    <?php if(!(empty($goods_list) || (($goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator ) && $goods_list->isEmpty()))): ?>
         <div class="loadbefore">
            <img class="ajaxloading" src="__STATIC__/images/loading.gif" alt="loading...">
        </div>
    <?php endif; ?>
    <!--加载更多E-->

    <!--综合排序-s-->
    <div class="fil_all_comm">
        <div class="maleri30">
            <ul>
                <li class="<?php if(I('sort') == ''): ?>red<?php endif; ?>">
                    <a href="<?php echo urldecode(U('Mobile/Goods/goodsList',array_merge($filter_param,array('sort'=>'')),''));?>" >综合</a>
                </li>
                <li class="<?php if(I('sort') == 'is_new'): ?>red<?php endif; ?>">
                    <a href="<?php echo urldecode(U('Mobile/Goods/goodsList',array_merge($filter_param,array('sort'=>'is_new')),''));?>" >新品</a>
                </li>
                <li class="<?php if(I('sort') == 'comment_count'): ?>red<?php endif; ?>">
                    <a href="<?php echo urldecode(U('Mobile/Goods/goodsList',array_merge($filter_param,array('sort'=>'comment_count')),''));?>">评价</a>
                </li>
            </ul>
        </div>
    </div>
    <!--综合排序-e-->

    <!--筛选-s-->
    <div class="screen_wi">
        <div class="classreturn loginsignup">
            <div class="content">
                <div class="ds-in-bl return seac_retu">
                    <a href="javascript:void(0);" ><img src="__STATIC__/images/return.png" alt="返回"></a>
                </div>
                <div class="ds-in-bl search center">
                    <span class="sx_jsxz">筛选</span>
                </div>
                <div class="ds-in-bl suce_ok">
                    <a href="javascript:void(0);">确定</a>
                </div>
            </div>
        </div>

        <!--顶部筛选-s-->
        <div class="popcover">
                <ul>
                    <li>
                        <span <?php if(\think\Request::instance()->param('sel') == 'all'): ?>class="ch_dg"<?php endif; ?>>
                        显示全部<input type="hidden"  class="sel" value="all" ></span>
                    </li>
                    <li>
                        <span <?php if(\think\Request::instance()->param('sel') == 'free_post'): ?>class="ch_dg"<?php endif; ?>>
                        仅看包邮<input type="hidden"  value="free_post" ></span>
                    </li>
                    <li>
                        <span <?php if(\think\Request::instance()->param('sel') == 'store_count'): ?>class="ch_dg"<?php endif; ?>>
                        仅看有货<input type="hidden"  value='store_count'></span>
                    </li>
                    <li>
                        <span <?php if(\think\Request::instance()->param('sel') == 'prom_type'): ?>class="ch_dg"<?php endif; ?>>促销商品
                        <input type="hidden"  value="prom_type" ></span>
                    </li>
                </ul>
            </div>
        <!--筛选顶部-e-->

        <!--一级筛选条件-s-->
        <div class="list-se-all ma-to-20 one-related" >
            <!--全部分类-s-->
            <div class="myorder p" onclick="cateArr()">
                <div class="content30">
                    <a href="javascript:void(0);">
                        <div class="order">
                            <div class="fl">
                                <span>全部分类</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!--全部分类-e-->

            <!--规格-s-->
            <?php if(is_array($filter_spec) || $filter_spec instanceof \think\Collection || $filter_spec instanceof \think\Paginator): if( count($filter_spec)==0 ) : echo "" ;else: foreach($filter_spec as $key=>$spec): if(!empty($spec[name])): ?>
                    <div class="myorder p " onclick="filtercriteria('spec',<?php echo $spec['spec_id']; ?>)" id="spec[<?php echo $spec['spec_id']; ?>]">
                        <div class="content30" >
                            <a href="javascript:void(0)">
                                <div class="order" >
                                    <div class="fl">
                                        <span><?php echo $spec[name]; ?></span>
                                    </div>
                                    <div class="fr">
                                        <i class="Mright"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            <!--规格-e-->

            <!--属性-s-->
            <?php if(is_array($filter_attr) || $filter_attr instanceof \think\Collection || $filter_attr instanceof \think\Paginator): if( count($filter_attr)==0 ) : echo "" ;else: foreach($filter_attr as $key=>$attr): if(!empty($attr[attr_name])): ?>
                    <div class="myorder p " onclick="filtercriteria('attr',<?php echo $attr['attr_id']; ?>)" id="attr[<?php echo $attr['attr_id']; ?>]">
                        <div class="content30" >
                            <a href="javascript:void(0)">
                                <div class="order" >
                                    <div class="fl">
                                        <span><?php echo $attr[attr_name]; ?></span>
                                    </div>
                                    <div class="fr">
                                        <i class="Mright"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            <!--属性-e-->

            <!--价格-s-->
            <div class="myorder p" onclick="filterprice()" >
                <div class="content30">
                    <a href="javascript:void(0)">
                        <div class="order" >
                            <div class="fl">
                                <span>价格</span>
                            </div>
                            <div class="fr">
                                <i class="Mright"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!--价格-e-->
            <input type="hidden" id="key" value="" />
        </div>
        <!--一级筛选条件-e-->

        <!--二级刷选条件-->
        <div class="list-se-all ma-to-20 two-related">
            <!--分类筛选-s-->
            <?php if(is_array($cateArr) || $cateArr instanceof \think\Collection || $cateArr instanceof \think\Paginator): if( count($cateArr)==0 ) : echo "" ;else: foreach($cateArr as $catek=>$cate): ?>
                    <div class="myorder p catearr">
                        <div class="content30">
                            <a href="<?php echo U('Mobile/Goods/goodsList',array('id'=>$cate['id'])); ?>">
                                <div class="order">
                                    <div class="fl">
                                        <span><?php echo $cate[name]; ?></span>
                                    </div>
                                    <div class="fr">
                                        <i class=""></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php if(is_array($cate[sub_menu]) || $cate[sub_menu] instanceof \think\Collection || $cate[sub_menu] instanceof \think\Paginator): if( count($cate[sub_menu])==0 ) : echo "" ;else: foreach($cate[sub_menu] as $catek2=>$cate2): ?>
                    <div class="myorder p catearr">
                        <div class="content30">
                            <a href="<?php echo U('Mobile/Goods/goodsList',array('id'=>$cate2['id'])); ?>">
                                <div class="order">
                                    <div class="fl">
                                        <span><?php echo str_repeat("&nbsp;",$cate2[level]); ?><?php echo $cate2[name]; ?></span>
                                    </div>
                                    <div class="fr">
                                        <i class=""></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
            <!--分类筛选-e-->

            <!--规格值筛选-s-->
            <?php if(is_array($filter_spec) || $filter_spec instanceof \think\Collection || $filter_spec instanceof \think\Paginator): if( count($filter_spec)==0 ) : echo "" ;else: foreach($filter_spec as $speck=>$spec1): if(is_array($spec1[item]) || $spec1[item] instanceof \think\Collection || $spec1[item] instanceof \think\Paginator): if( count($spec1[item])==0 ) : echo "" ;else: foreach($spec1[item] as $speck2=>$val): ?>
                    <div class="myorder p filter filterspec" data-id="<?php echo $spec1[spec_id]; ?>" >
                        <div class="content30" >
                            <a href="javascript:void(0)">
                                <div class="order">
                                    <div class="fl">
                                        <span><?php echo $val[item]; ?></span>
                                    </div>
                                    <div class="fr">
                                        <i class=""><input type="checkbox" style="display: none;"  value="<?php echo $val[val]; ?>"/></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
            <!--规格值筛选-e-->

            <!--属性值-s-->
            <?php if(is_array($filter_attr) || $filter_attr instanceof \think\Collection || $filter_attr instanceof \think\Paginator): if( count($filter_attr)==0 ) : echo "" ;else: foreach($filter_attr as $attrk=>$attr1): if(is_array($attr1[attr_value]) || $attr1[attr_value] instanceof \think\Collection || $attr1[attr_value] instanceof \think\Paginator): if( count($attr1[attr_value])==0 ) : echo "" ;else: foreach($attr1[attr_value] as $attrk2=>$attrval): ?>
                    <div class="myorder p filter filterattr" data-id="<?php echo $attr1[attr_id]; ?>" >
                        <div class="content30" >
                            <a href="javascript:void(0)">
                                <div class="order">
                                    <div class="fl">
                                        <span><?php echo $attrval[val]; ?></span>
                                    </div>
                                    <div class="fr">
                                        <i class=""><input type="checkbox" style="display: none;"  value="<?php echo $attrval[val]; ?>"/></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
            <!--属性-e-->

            <!--价格筛选-s-->
            <?php if($filter_price != null): if(is_array($filter_price) || $filter_price instanceof \think\Collection || $filter_price instanceof \think\Paginator): if( count($filter_price)==0 ) : echo "" ;else: foreach($filter_price as $pricek=>$price): ?>
                    <div class="myorder p tow-price">
                        <div class="content30">
                            <a href="<?php echo $price[href]; ?>">
                                <div class="order">
                                    <div class="fl">
                                        <span><?php echo $price[value]; ?></span>
                                    </div>
                                    <div class="fr">
                                        <i class=""></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; endif; else: echo "" ;endif; else: ?>
                <div class="myorder p tow-price">
                    <div class="content30">
                        <a href=" ">
                            <div class="order">
                                试试其他筛选吧！
                            </div>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <!--价格筛选-e-->
        </div>
        <!--二级刷选条件-e-->

    </div>
    <!--筛选-e-->

<div class="mask-filter-div" style="display: none;"></div>
<script type="text/javascript" src="__STATIC__/js/sourch_submit.js"></script>
<script type="text/javascript">
        //############   点击多选确定按钮      ############
        // t 为类型  是品牌 还是 规格 还是 属性
        // btn 是点击的确定按钮用于找位置
        get_parment ='<?php echo json_encode($_GET); ?>';// <?php echo json_encode($_GET); ?>;
        function submitMoreFilter(t)
        {
            var key = '';   // 请求的 参数名称
            var val = new Array();  // 请求的参数值
            $(".filter").each(function(i,o){
                var che=$(o).find('.fr input');
                if(che.attr('checked')){    //选中的值
                    key = $('#key').val();
                    val.push(che.val());
                }
            });
            // 没有被勾选的时候
            if(val == ''){
                return false;
            }
            // 品牌
            if(t == 'brand')
            {
                get_parment.brand_id = val.join('_');
            }

            // 规格
            if(t == 'spec')
            {
                if(get_parment.hasOwnProperty('spec'))
                {
                    get_parment.spec += '@'+key+'_'+val.join('_');
                }else{
                    get_parment.spec = key+'_'+val.join('_');
                }
            }
            // 属性
            if(t == 'attr')
            {
                if(get_parment.hasOwnProperty('attr'))
                {
                    get_parment.attr += '@'+key+'_'+val.join('_');
                }
                else
                {
                    get_parment.attr = key+'_'+val.join('_');
                }
            }

            // 组装请求的url
            var url = '';
            for ( var k in get_parment )
            {
                url += "&"+k+'='+get_parment[k];
            }
            location.href ="/index.php?m=Mobile&c=Goods&a=goodsList"+url;
        }

        //确定按钮
        $('.suce_ok').click(function(){
            //判断当前二级筛选状态
            if($('.suce_ok').is('.two')) {
                var t=$('#key').attr('class');
                submitMoreFilter(t);
            }else{
                var sel = $('.sel').val();
                // 组装请求的url
                var url = '';
                for ( var k in get_parment )
                {
                    if(sel != ''&& k=='sel'){
                        continue;
                    }
                    url += "&"+k+'='+get_parment[k];
                }
                location.href= "/index.php?m=Mobile&c=Goods&a=goodsList"+url+"&sel="+sel;
            }
        })

        //返回按钮
        $('.seac_retu').click(function(){
            //判断当前二级筛选状态
            if($('.suce_ok').is('.two')){
                $(".filter").each(function(i,o){
                    //去掉全部选择
                    $(o).find('.fr input').attr('checked',false);
                });
                $('#key').removeAttr('class');
                //显示一级筛选
                $('.screen_wi,.popcover,.one-related').show();
                $('.two-related').hide();
                $('.sx_jsxz').html('筛选');
                $('.suce_ok').removeClass('two');
            }else{
                $('.screen_wi').animate({width: '0', opacity: 'hide'}, 'normal',function(){
                    undercover();
                    $('.screen_wi').hide();
                });
            }
        })


    //筛选弹窗的全部分类筛选
    function cateArr(){
        $('.catearr').show();
        $('.tow-price').hide();
        $('.filter').hide();
        $('.filterspec').hide();
    }
    //显示规格对应值筛选
    function filtercriteria(criteria,id){
        $('#key').addClass(criteria).val(id);
        $('.filter').each(function(i,o){
            if($(o).attr('data-id') == id){
                $(o).show();
            }else{
                $(o).hide();
            }
        });
        $('.tow-price').hide();
        $('.catearr').hide();
    }
    //显示筛选弹窗的价格筛选
    function filterprice(){
        $('.tow-price').show();
        $('.filterspec').hide();
        $('.catearr').hide();
    }

//    var  page = 1;
    /**
     * ajax加载更多商品
     */
    var before_request = 1; // 上一次请求是否已经有返回来, 有才可以进行下一次请求
        var page = 2;
    function ajax_sourch_submit()
    {
//        page += 1;
//        $.ajax({
//            type : "POST",
//            url:"<?php echo U('Mobile/Goods/goodsList'); ?>",//+tab,
////			data : $('#filter_form').serialize(),// 你的formid 搜索表单 序列化提交
//            data:{id:'<?php echo \think\Request::instance()->param('id'); ?>',sort:'<?php echo \think\Request::instance()->param('sort'); ?>',sort_asc:'<?php echo \think\Request::instance()->param('sort_asc'); ?>',sel:'<?php echo \think\Request::instance()->param('sel'); ?>',is_ajax:1,p:page},
//            success: function(data)
//            {
//                if($.trim(data) == ''){
//                    $('.loadbefore').hide();
//                    $('#getmore').hide();
//                }else
//                    $("#goods_list").append(data);
//                    if( $("#goods_list").hasClass('addimgchan')){
//                        $('.orderlistshpop').addClass('addimgchan')
//                    }else{
//                        $('.orderlistshpop').removeClass('addimgchan')
//                    }
//            }
//        });

            if(before_request == 0)// 上一次请求没回来 不进行下一次请求
                return false;
            before_request = 0;
            page++;

            $.ajax({
                type : "POST",
                url:"<?php echo U('Mobile/Goods/goodsList'); ?>",//+tab,
                data:{id:'<?php echo \think\Request::instance()->param('id'); ?>',sort:'<?php echo \think\Request::instance()->param('sort'); ?>',sort_asc:'<?php echo \think\Request::instance()->param('sort_asc'); ?>',sel:'<?php echo \think\Request::instance()->param('sel'); ?>',is_ajax:1,p:page},
                success: function(data)
                {
                    if($.trim(data) == ''){
                        $('.loadbefore').hide();
                        $('#getmore').hide();
                    }else
                        $("#goods_list").append(data);
                         before_request = 1;
                    if( $("#goods_list").hasClass('addimgchan')){
                        $('.orderlistshpop').addClass('addimgchan')
                    }else{
                        $('.orderlistshpop').removeClass('addimgchan')
                    }
                }
            });

    }

        //显示隐藏筛选弹窗
        var lb = $('.search_list_dump .lb')
        var fil = $('.fil_all_comm');
        var cs = $('.classreturn,.search_list_dump');
        var son = $('.search_list_dump .jg').siblings();
        $('.storenav ul li span').click(function(){
            $(this).parent().addClass('red').siblings('li').removeClass('red')
            if(!$(this).hasClass('lb')){
                fil.hide();
                undercover();
                cs.removeClass('pore');
            }
            if(!$(this).hasClass('jg')){
                son.removeClass('bpr1');
                son.removeClass('bpr2');
            }
        });


$(function(){
    //显示综合筛选弹窗
    lb.click(function(){
        fil.show();
        cover();
        cs.addClass('pore');
    });

    lb.html($('.on').html());
        //筛选
        $('.search_list_dump .sx').click(function(){
            $('body').css('position','relative');
            $('.screen_wi').animate({width: '14.4rem', opacity: 'show'}, 'normal',function(){
                $('.screen_wi').show();
                cover();
            });
        })

        //  顶部筛选 筛选1-popcover
        $('.popcover ul li span').click(function(){
//            $(this).toggleClass('ch_dg');
            //给span添加样式，并给其子代input添加class
            $(this).addClass('ch_dg').find('input').addClass('sel');
            $(this).parent('li').siblings('li').find('span').removeClass('ch_dg')
                    .find('input').removeClass('sel');
        })


        // 一级筛选条件筛选2-one-related
        $('.one-related .myorder .order').click(function(){
            $('.two-related').show();
            $('.suce_ok').addClass('two');
            $('.tow-price,.one-related,.popcover').hide();
            $('.sx_jsxz').html($(this).find('.fl span').text());
        })

        //筛选3-two-related
        $('.two-related .myorder .order').click(function(){
            var mright = $(this).find('.fr i');
            var input = mright.find("input");
            mright.toggleClass('Mright');
            //改变复选框状态
            mright.hasClass('Mright') ? input.attr('checked',true) : input.attr('checked',false);
        })

        //切换商品排列样式
        $('.listorimg').click(function(){
            $(this).toggleClass('orimg');
            $('#goods_list').toggleClass('addimgchan');
            $('.orderlistshpop').toggleClass('addimgchan');
        })
    })

</script>
	</body>
</html>
