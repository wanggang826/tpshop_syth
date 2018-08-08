<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:42:"./template/pc/rainbow/goods\goodsInfo.html";i:1511156194;s:40:"./template/pc/rainbow/public\header.html";i:1511170667;s:40:"./template/pc/rainbow/public\footer.html";i:1508900007;s:46:"./template/pc/rainbow/public\sidebar_cart.html";i:1508133946;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>商品详情</title>
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/tpshop.css" />
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/jquery.jqzoom.css">
    <script src="__STATIC__/js/jquery-1.11.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/layer/layer-min.js"></script>
    <script type="text/javascript" src="__STATIC__/js/jquery.jqzoom.js"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <script src="__PUBLIC__/js/pc_common.js"></script>
    <link rel="stylesheet" href="__STATIC__/css/location.css" type="text/css"><!-- 收货地址，物流运费 -->
</head>
<body>
<!--header-s-->
<link rel="stylesheet" type="text/css" href="__STATIC__/css/base.css"/>
<div class="tpshop-tm-hander">
	<div class="top-hander clearfix">
		<div class="w1224 pr clearfix">
			<div class="fl">
			    <?php if(strtolower(ACTION_NAME) != 'goodsinfo'): ?>
                      <link rel="stylesheet" href="__STATIC__/css/location.css" type="text/css"><!-- 收货地址，物流运费 -->
                      <div class="sendaddress pr fl">
                          <span>送货至：</span>
                          <!-- <span>深圳<i class="share-a_a1"></i></span>-->
                          <span>
                              <ul class="list1">
                                  <li class="summary-stock though-line">
                                      <div class="dd" style="border-right:0px;width:200px;">
                                          <div class="store-selector add_cj_p">
                                              <div class="text"><div></div><b></b></div>
                                              <div onclick="$(this).parent().removeClass('hover')" class="close"></div>
                                          </div>
                                      </div>
                                  </li>
                              </ul>
                          </span>
                      </div>
                      <script src="__STATIC__/js/location.js"></script>
                <?php endif; ?>
				<div class="fl nologin">
					<a class="red" href="<?php echo U('Home/user/login'); ?>">登录</a>
					<a href="<?php echo U('Home/user/reg'); ?>">注册</a>
				</div>
				<div class="fl islogin hide">
					<a class="red userinfo" href="<?php echo U('Home/user/index'); ?>"></a>
					<a  href="<?php echo U('Home/user/logout'); ?>"  title="退出" target="_self">安全退出</a>
				</div>
			</div>
			<ul class="top-ri-header fr clearfix">
				<li><a target="_blank" href="<?php echo U('Home/Order/order_list'); ?>">我的订单</a></li>
				<li class="spacer"></li>
				<li><a target="_blank" href="<?php echo U('Home/User/visit_log'); ?>">我的浏览</a></li>
				<li class="spacer"></li>
				<!--<li><a target="_blank" href="<?php echo U('Home/User/goods_collect'); ?>">我的收藏</a></li>-->
				<li class="spacer"></li>
				<li>客户服务</li>
				<li class="spacer"></li>
				<li class="hover-ba-navdh">
					<!--<div class="nav-dh">-->
						<!--<span>网站导航</span>-->
						<!--<i class="share-a_a1"></i>-->
					<!--</div>-->
					<ul class="conta-hv-nav clearfix">
						<!--<li>-->
							<!--<a href="#">优惠活动</a>-->
						<!--</li>-->
						<!--<li>-->
							<!--<a href="#">预售活动</a>-->
						<!--</li>-->
						<!--<li>-->
							<!--<a href="#">拍卖活动</a>-->
						<!--</li>-->
						<!--<li>
							<a href="#">兑换中心</a>
						</li>-->
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<div class="nav-middan-z w1224 clearfix">
		<a class="ecsc-logo" href="#"><img src="<?php echo $tpshop_config['shop_info_store_logo']; ?>"></a>
		<div class="ecsc-search">
			<form id="searchForm" name="" method="get" action="<?php echo U('Home/Goods/search'); ?>" class="ecsc-search-form">
				<input autocomplete="off"name="q" id="q" type="text" value="" class="ecsc-search-input" placeholder="请输入搜索关键字...">
				<button type="submit" class="ecsc-search-button">搜索</button>
    			<div class="candidate p">
                    <ul id="search_list"></ul>
                </div>
                <script type="text/javascript">
                    ;(function($){
                        $.fn.extend({
                            donetyping: function(callback,timeout){
                                timeout = timeout || 1e3;
                                var timeoutReference,
                                        doneTyping = function(el){
                                            if (!timeoutReference) return;
                                            timeoutReference = null;
                                            callback.call(el);
                                        };
                                return this.each(function(i,el){
                                    var $el = $(el);
                                    $el.is(':input') && $el.on('keyup keypress',function(e){
                                        if (e.type=='keyup' && e.keyCode!=8) return;
                                        if (timeoutReference) clearTimeout(timeoutReference);
                                        timeoutReference = setTimeout(function(){
                                            doneTyping(el);
                                        }, timeout);
                                    }).on('blur',function(){
                                        doneTyping(el);
                                    });
                                });
                            }
                        });
                    })(jQuery);

                    $('.ecsc-search-input').donetyping(function(){
                        search_key();
                    },500).focus(function(){
                        var search_key = $.trim($('#q').val());
                        if(search_key != ''){
                            $('.candidate').show();
                        }
                    });
                    $('.candidate').mouseleave(function(){
                        $(this).hide();
                    });

                    function searchWord(words){
                        $('#q').val(words);
                        $('#searchForm').submit();
                    }
                    function search_key(){
                        var search_key = $.trim($('#q').val());
                        if(search_key != ''){
                            $.ajax({
                                type:'post',
                                dataType:'json',
                                data: {key: search_key},
                                url:"<?php echo U('Home/Api/searchKey'); ?>",
                                success:function(data){
                                    if(data.status == 1){
                                        var html = '';
                                        $.each(data.result, function (n, value) {
                                            html += '<li onclick="searchWord(\''+value.keywords+'\');"><div class="search-item">'+value.keywords+'</div><div class="search-count">约'+value.goods_num+'个商品</div></li>';
                                        });
                                        html += '<li class="close"><div class="search-count">关闭</div></li>';
                                        $('#search_list').empty().append(html);
                                        $('.candidate').show();
                                    }else{
                                        $('#search_list').empty();
                                    }
                                }
                            });
                        }
                    }
                </script>
			</form>
			<div class="keyword clearfix">
				<?php if(is_array($tpshop_config['hot_keywords']) || $tpshop_config['hot_keywords'] instanceof \think\Collection || $tpshop_config['hot_keywords'] instanceof \think\Paginator): if( count($tpshop_config['hot_keywords'])==0 ) : echo "" ;else: foreach($tpshop_config['hot_keywords'] as $k=>$wd): ?>
				<!--<a class="key-item" href="<?php echo U('Home/Goods/search',array('q'=>$wd)); ?>" target="_blank"><?php echo $wd; ?></a>-->
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
		<div class="u-g-cart fr" id="hd-my-cart">
			<a href="<?php echo U('Home/Cart/index'); ?>">
			<div class="c-n fl">
				<i class="share-shopcar-index"></i>
				<span>我的购物车</span>
				<em class="shop-nums" id="cart_quantity"></em>
			</div>
			</a>
			<div class="u-fn-cart" id="show_minicart">
				<div class="minicartContent" id="minicart">
				</div>
			</div>
		</div>
	</div>
	<div class="nav w1224 clearfix">
		<div class="categorys home_categorys">
			<div class="dt" style="margin-left: -200px;">
				<a href="" target="_blank"><i class="share-a_a2"></i>全部商品分类</a>
			</div>
			<!--全部商品分类-s-->
			<div class="dd" style="margin-left: -200px;">
				<div class="cata-nav" id="cata-nav">
				<?php if(is_array($goods_category_tree) || $goods_category_tree instanceof \think\Collection || $goods_category_tree instanceof \think\Paginator): $kr = 0; $__LIST__ = $goods_category_tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($kr % 2 );++$kr;?>
					<div class="item">
						<?php if($v[level] == 1): ?>
						<div class="item-left">
							<h3 class="cata-nav-name">
								<i class="ico ico-nav-<?php echo $kr; ?>"></i>
								<a href="<?php echo U('Home/Goods/goodsList',array('id'=>$v[id])); ?>" title="<?php echo $v[name]; ?>"><?php echo $v[mobile_name]; ?></a>
							</h3>
						</div>
						<?php endif; ?>
						<div class="cata-nav-layer" style="margin-left: -200px;">
							<div class="cata-nav-left" >
							
								<div class="subitems">
									<?php if(is_array($v['tmenu']) || $v['tmenu'] instanceof \think\Collection || $v['tmenu'] instanceof \think\Paginator): if( count($v['tmenu'])==0 ) : echo "" ;else: foreach($v['tmenu'] as $k2=>$v2): if($v2[parent_id] == $v['id']): ?>
										<dl class="clearfix">
											<dt><a href="<?php echo U('Home/Goods/goodsList',array('id'=>$v2[id])); ?>" target="_blank"><?php echo $v2[name]; ?></a></dt>
											<dd class="clearfix">
												<?php if(is_array($v2['sub_menu']) || $v2['sub_menu'] instanceof \think\Collection || $v2['sub_menu'] instanceof \think\Paginator): if( count($v2['sub_menu'])==0 ) : echo "" ;else: foreach($v2['sub_menu'] as $k3=>$v3): if($v3[parent_id] == $v2['id']): ?>
													<a href="<?php echo U('Home/Goods/goodsList',array('id'=>$v3[id])); ?>" target="_blank"><?php echo $v3[name]; ?></a>
													<?php endif; endforeach; endif; else: echo "" ;endif; ?>
											</dd>
										</dl>
									<?php endif; endforeach; endif; else: echo "" ;endif; ?>
								</div>
							</div>
							<div class="advertisement_down">
								<?php $pid =10+$kr;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1511485200 and end_time > 1511485200 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("5")->select();
if(is_array($ad_position) && !in_array($pid,array_keys($ad_position)) && $pid)
{
  M("ad_position")->insert(array(
         "position_id"=>$pid,
         "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ",
         "is_open"=>1,
         "position_desc"=>CONTROLLER_NAME."页面",
  ));
  delFile(RUNTIME_PATH); // 删除缓存
  \think\Cache::clear();  
}


$c = 5- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && I("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "ad_code" => "/public/images/not_adv.jpg",
          "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid",
          "title"   =>"暂无广告图片",
          "not_adv" => 1,
          "target" => 0,
      );  
    }
}
foreach($result as $key=>$v3):       
    
    $v3[position] = $ad_position[$v3[pid]]; 
    if(I("get.edit_ad") && $v3[not_adv] == 0 )
    {
        $v3[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v3[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v3[ad_id]";        
        $v3[title] = $ad_position[$v3[pid]][position_name]."===".$v3[ad_name];
        $v3[target] = 0;
    }
    ?>
								<a href="<?php echo $v3[ad_link]; ?>" <?php if($v3['target'] == 1): ?>target="_blank"<?php endif; ?>>
									<img class="w-100" src="<?php echo $v3[ad_code]; ?>" title="<?php echo $v3[title]; ?>"/>
								</a>
								<?php endforeach; ?>
							</div>
							<?php $pid =51;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1511485200 and end_time > 1511485200 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
if(is_array($ad_position) && !in_array($pid,array_keys($ad_position)) && $pid)
{
  M("ad_position")->insert(array(
         "position_id"=>$pid,
         "position_name"=>CONTROLLER_NAME."页面自动增加广告位 $pid ",
         "is_open"=>1,
         "position_desc"=>CONTROLLER_NAME."页面",
  ));
  delFile(RUNTIME_PATH); // 删除缓存
  \think\Cache::clear();  
}


$c = 1- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && I("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "ad_code" => "/public/images/not_adv.jpg",
          "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid",
          "title"   =>"暂无广告图片",
          "not_adv" => 1,
          "target" => 0,
      );  
    }
}
foreach($result as $key=>$az):       
    
    $az[position] = $ad_position[$az[pid]]; 
    if(I("get.edit_ad") && $az[not_adv] == 0 )
    {
        $az[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $az[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$az[ad_id]";        
        $az[title] = $ad_position[$az[pid]][position_name]."===".$az[ad_name];
        $az[target] = 0;
    }
    ?>
							<a href="<?php echo $az[ad_link]; ?>" class="cata-nav-rigth" <?php if($az['target'] == 1): ?>target="_blank"<?php endif; ?>>
								<!--<img class="w-100" src="<?php echo $az[ad_code]; ?>" title="<?php echo $az[title]; ?>" />-->
							</a>
							<?php endforeach; ?>
						</div>
					</div>
					<?php endforeach; endif; else: echo "" ;endif; ?>					
				</div>
				<script>
					$('#cata-nav').find('.item').hover(function () {
						$(this).addClass('nav-active').siblings().removeClass('nav-active');
					},function () {
						$(this).removeClass('nav-active');
					})
				</script>
			</div>
			<!--全部商品分类-e-->
		</div>
		<ul class="navitems clearfix" id="navitems">
			<li>
				<a href="<?php echo U('Index/index'); ?>">首页</a>
			</li>
			<!--<?php
                                   
                                $md5_key = md5("SELECT * FROM `__PREFIX__navigation` where is_show = 1 ORDER BY `sort` DESC");
                                $result_name = $sql_result_v = S("sql_".$md5_key);
                                if(empty($sql_result_v))
                                {                            
                                    $result_name = $sql_result_v = \think\Db::query("SELECT * FROM `__PREFIX__navigation` where is_show = 1 ORDER BY `sort` DESC"); 
                                    S("sql_".$md5_key,$sql_result_v,60);
                                }    
                              foreach($sql_result_v as $k=>$v): ?>-->
				<!--<?php if($k != 7): ?>-->
					<!--<li><a href="<?php echo $v[url]; ?>" <?php if($v[is_new] == 1): ?>target="_blank" <?php endif; ?> ><?php echo $v[name]; ?></a></li>-->
				<!--<?php endif; ?>-->
			<!--<?php endforeach; ?>-->
		</ul>
	</div>
</div>
	<script>
		$('#navitems').find('li').eq(0).addClass('selected');
		$('#navitems').find('li').click(function () {
			$(this).addClass('selected').siblings().removeClass('selected');
		});
	</script>
<!--header-e-->
<div class="search-box p">
    <div class="w1224">
        <div class="search-path fl">
            <?php if(is_array($navigate_goods) || $navigate_goods instanceof \think\Collection || $navigate_goods instanceof \think\Paginator): if( count($navigate_goods)==0 ) : echo "" ;else: foreach($navigate_goods as $k=>$v): ?>
                <a href="<?php echo U('/Home/Goods/goodsList',array('id'=>$k)); ?>"><?php echo $v; ?></a>
                <i class="litt-xyb"></i>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <div class="havedox">
                <span><?php echo $goods['goods_name']; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="details-bigimg p">
    <div class="w1224">
        <div class="detail-img">
            <div class="product-gallery">
                <div class="product-photo" id="photoBody">
                    <!-- 商品大图介绍 start [[-->
                    <div class="product-img jqzoom">
                        <img id="zoomimg" src="<?php echo goods_thum_images($goods['goods_id'],400,400); ?>" jqimg="<?php echo goods_thum_images($goods['goods_id'],800,800); ?>">
                    </div>
                    <!-- 商品大图介绍 end ]]-->
                    <!-- 商品小图介绍 start [[-->
                    <div class="product-small-img fn-clear"> <a href="javascript:;" class="next-left next-btn fl disabled"></a>
                        <div class="pic-hide-box fl">
                            <ul class="small-pic" style="left:0;">
                                <?php if(is_array($goods_images_list) || $goods_images_list instanceof \think\Collection || $goods_images_list instanceof \think\Paginator): if( count($goods_images_list)==0 ) : echo "" ;else: foreach($goods_images_list as $k=>$v): ?>
                                    <li class="small-pic-li <?php if($k == 0): ?>active<?php endif; ?>">
                                    <a href="javascript:;">
                                        <img src="<?php echo get_sub_images($v,$v[goods_id],60,60); ?>" data-img="<?php echo get_sub_images($v,$v[goods_id],400,400); ?>" data-big="<?php echo get_sub_images($v,$v[goods_id],800,800); ?>">
                                        <i></i>
                                    </a>
                                    </li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div>
                        <a href="javascript:;" class="next-right next-btn fl"></a> </div>
                    <!-- 商品小图介绍 end ]]-->
                </div>
                <!-- 收藏商品 start [[-->
                <div class="collect">
                    <a href="javascript:void(0);" id="collectLink"><i class="collect-ico collect-ico-null"></i>
                        <span class="collect-text">收藏商品</span>
                        <em class="J_FavCount"></em></a>
                    <!--<a href="javascript:void(0);" id="collectLink"><i class="collect-ico collect-ico-ok"></i>已收藏<em class="J_FavCount">(20)</em></a>-->
                </div>
                <!-- 分享商品 -->
               <!-- <div class="share">
                    <div class="jiathis_style">
                        <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt" target="_blank"><img src="http://v3.jiathis.com/code_mini/images/btn/v1/jiathis1.gif" border="0" /></a>
                    </div>
                    <script>
                        var is_distribut = getCookie('is_distribut');
                        var user_id = getCookie('user_id');
                        var jiathis_config = {
                            url:"http://<?php echo $_SERVER[HTTP_HOST]; ?>/index.php?m=Home&c=Goods&a=goodsInfo&id=<?php echo $_GET[id]; ?>&user_id="+user_id,
                            pic:"http://<?php echo $_SERVER[HTTP_HOST]; ?><?php echo goods_thum_images($goods[goods_id],400,400); ?>",
                        }
                        // 如果已经登录了, 并且是分销商
                        if(parseInt(is_distribut) == 1 && parseInt(user_id) > 0)
                        {
                            jiathis_config.url = jiathis_config.url + "&first_leader="+user_id;
                        }
                    </script>
                    <script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js" charset="utf-8"></script>
                </div>-->

                <div onclick="tupian()" style="margin-left: 75%;margin-top: 10px;color: #6C6C6C;">商品二维码</div>
                <img id="magnify" style="display: none;" src="<?php echo $qrcode; ?>" width="540px" height="500px;">

            </div>
        </div>
        <form id="buy_goods_form" name="buy_goods_form" method="post" >
            <input type="hidden" name="goods_prom_type" value="<?php echo $goods['prom_type']; ?>"/><!-- 活动类型 -->
            <input type="hidden" name="shop_price" value="<?php echo $goods['shop_price']; ?>"/><!-- 活动价格 -->
            <input type="hidden" name="store_count" value="<?php echo $goods['store_count']; ?>"/><!-- 活动库存 -->
            <input type="hidden" name="market_price" value="<?php echo $goods['market_price']; ?>"/><!-- 商品原价 -->
            <input type="hidden" name="start_time" value="<?php echo $goods['start_time']; ?>"/><!-- 活动开始时间 -->
            <input type="hidden" name="end_time" value="<?php echo $goods['end_time']; ?>"/><!-- 活动结束时间 -->
            <input type="hidden" name="activity_title" value="<?php echo $goods['activity_title']; ?>"/><!-- 活动标题 -->
            <input type="hidden" name="prom_detail" value="<?php echo $goods['prom_detail']; ?>"/><!-- 促销活动的促销类型 -->
            <input type="hidden" name="activity_is_on" value=""/><!-- 活动是否正在进行中 -->
            <input type="hidden" name="item_id" value="<?php echo \think\Request::instance()->param('item_id'); ?>"/><!-- 商品规格id -->
            <input type="hidden" id="fen_bi" value="<?php echo $goods['percent']; ?>"/><!-- 分期比例id -->
            <input type="hidden" id="fen_num" value="<?php echo $goods['fenqi_num']; ?>"/><!-- 分期最少数量 -->
            <div class="detail-ggsl">
                <h1><?php echo $goods['goods_name']; ?></h1>
                <div class="presale-time" style="display: none">
                    <div class="pre-icon fl">
                        <span class="ys"><i class="detai-ico"></i><span id="activity_type">抢购活动</span></span>
                    </div>
                    <div class="pre-icon fr">
                        <span class="per" style="display: none"><i class="detai-ico"></i><em id="order_user_num">0</em>人预定</span>
                        <span class="ti" id="activity_time"><i class="detai-ico"></i>剩余时间：<span id="overTime"></span></span>
                        <span class="ti" id="prom_detail"></span>
                    </div>
                </div>
                <div class="shop-price-cou">
                    <div class="shop-price-le">
                        <ul>
                            <li class="jaj"><span id="goods_price_title">商城价：</span></li>
                            <li>
                                <span class="bigpri_jj" id="goods_price"><em>￥</em></span>
                            </li>
                        </ul>
                        <ul>
                            <li class="jaj"><span id="market_price_title">市场价：</span></li>
                            <li class="though-line"><span><em>￥</em><span id="market_price"><?php echo $goods['market_price']; ?></span></span></li>
                        </ul>

                        <ul id="activity_title_div" style="display: none">
                            <li class="jaj"><span id="activity_label"></span></li>
                            <li><span id="activity_title" style="color: #df3033;background: 0 0;border: 1px solid #df3033;padding: 2px 3px;"></span></li>
                        </ul>
                        <?php if($goods['give_integral'] > 0): ?>
                            <ul>
                                <li class="jaj ls4"><span>赠送积分：</span></li>
                                <li><span class="fullminus"><?php echo $goods['give_integral']; ?></span></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div class="shop-cou-ri">
                        <div class="allcomm"><p>累计评价</p><p class="f_blue"><?php echo $goods['comment_count']; ?></p></div>
                        <div class="br1"></div>
                        <div class="allcomm"><p>累计销量</p><p class="f_blue"><?php echo $goods['sales_sum']; ?></p></div>
                    </div>
                </div>
                <div class="standard p">
                    <!-- 收货地址，物流运费 -start-->
                    <ul class="list1">
                        <li class="jaj"><span>配&nbsp;&nbsp;送：</span></li>
                        <li class="summary-stock though-line">
                            <div class="dd shd_address">
                                <!--<div class="addrID"><div></div><b></b></div>-->
                                <div class="store-selector add_cj_p">
                                    <div class="text" style="width: 150px;"><div></div><b></b></div>
                                    <div onclick="$(this).parent().removeClass('hover')" class="close"></div>
                                </div>
                                <?php if($goods['is_free_shipping'] == 1): ?>
                                    <a style="font-size: 18px;color: #FF0000;">包邮(分期不包邮)</a>
                                    <?php else: ?><a  style="font-size: 18px;color: #FF0000;">货到付运费</a>
                                <?php endif; ?>
                            </div>
                        </li>

                    </ul>
                    <script src="__STATIC__/js/location.js"></script>
                    <!-- 收货地址，物流运费 -end-->
                </div>
                <div class="standard p">
                    <ul>
                        <li class="jaj"><span>服&nbsp;&nbsp;务：</span></li>
                        <li class="lawir"><span class="service">由<a ><?php echo $tpshop_config['shop_info_store_name']; ?></a>发货并提供售后服务</span></li>
                    </ul>
                </div>
                <!--<?php if($goods['exchange_integral'] > 0): ?>-->
                    <!--<div class="standard p">-->
                        <!--<ul>-->
                            <!--<li class="jaj"><span>可&nbsp;&nbsp;用：</span></li>-->
                            <!--<li class="lawir"><span class="service"><?php echo $goods['shop_price']-$goods['exchange_integral']/$point_rate; ?>+<?php echo $goods['exchange_integral']; ?>积分</span></li>-->
                        <!--</ul>-->
                    <!--</div>-->
                <!--<?php endif; ?>-->

                <!-- 规格 start [[-->
                <?php if(is_array($filter_spec) || $filter_spec instanceof \think\Collection || $filter_spec instanceof \think\Paginator): if( count($filter_spec)==0 ) : echo "" ;else: foreach($filter_spec as $k=>$v): ?>
                    <div class="spec_goods_price_div standard p">
                        <ul>
                            <li class="jaj"><span><?php echo $k; ?>：</span></li>
                            <li class="lawir colo">
                                <?php if(is_array($v) || $v instanceof \think\Collection || $v instanceof \think\Paginator): if( count($v)==0 ) : echo "" ;else: foreach($v as $k2=>$v2): ?>
                                    <input type="radio" hidden id="goods_spec_<?php echo $v2[item_id]; ?>" name="goods_spec[<?php echo $k; ?>]" value="<?php echo $v2[item_id]; ?>"/>
                                    <!--<a id="goods_spec_a_<?php echo $v2[item_id]; ?>" onclick="switch_zooming('<?php echo $v2[src]; ?>'); select_filter(this);" <?php if(!empty($v2['src'])): ?>onclick="$('#zoomimg').attr('src','<?php echo $v2[src]; ?>');"<?php endif; ?>><?php echo $v2[item]; ?></a>-->
                                    <?php if($v2[src] != ''): ?>
                                        <a id="goods_spec_a_<?php echo $v2[item_id]; ?>" onclick="switch_zooming('<?php echo $v2[src]; ?>');select_filter(this); $('#zoomimg').attr('src','<?php echo $v2[src]; ?>')">
                                            <img src="<?php echo $v2[src]; ?>" style="width: 40px;height: 40px;"/>
                                            <span class="dis_alintro"><?php echo $v2[item]; ?></span>
                                        </a>
                                        <?php else: ?>
                                        <a id="goods_spec_a_<?php echo $v2[item_id]; ?>" onclick="switch_zooming('<?php echo $v2[src]; ?>'); select_filter(this);"><?php echo $v2[item]; ?></a>
                                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </li>
                        </ul>
                    </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>

                <div class="standard">
                    <ul class="p">
                        <li class="jaj"><span>重&nbsp;&nbsp;量：</span></li>
                        <li class="lawir">
                            <span><?php if($goods['weight']): ?><?php echo $goods['weight']; ?>g <?php else: ?>不详<?php endif; ?></span>

                        </li>
                    </ul>
                </div>

                <!-- 规格end ]]-->
                <div class="standard">
                    <ul class="p">
                        <li class="jaj"><span>数&nbsp;&nbsp;量：</span></li>
                        <li class="lawir">
                            <div class="minus-plus">
                                <a class="mins" href="javascript:void(0);" onclick="altergoodsnum(-1)">-</a>
                                <input class="buyNum" id="number" type="text" name="goods_num" value="1" onblur="altergoodsnum(0)" max="" readonly="readonly"/>
                                <a class="add" href="javascript:void(0);" onclick="altergoodsnum(1)">+</a>
                            </div>
                            <div class="sav_shop">库存：<span id="spec_store_count"><?php echo $goods['store_count']; ?></span></div>
                        </li>
                    </ul>
                </div>
                <?php if($goods['is_fenqi'] == 1): ?>
                    <div class="spec_goods_price_div standard p" style="margin-top: 10px;">
                        <ul class="myjaj">
                            <li class="jaj"><span>分期购：</span></li>
                            <li class="lawir colo">
                                <input type="radio" hidden id="fenqi"    name="is_fenqi" value="0" checked/>
                                <input type="radio" hidden  id="is_fenqi" name="is_fenqi" value="2"/>
                                <a id="no_myred">不分期</a>
                                <?php if($goods['is_free_shipping'] == 1): ?>
                                    <a id="baoyou">包邮</a>
                                    <?php else: ?><a id="hdfyf">货到付运费</a>
                                <?php endif; ?>
                                <a id="myred">分36期</a>
                                <a id="bili" style="display: none"></a>
                                <a id="huan" style="display: none"></a>
                                <a id="hdfyf2" style="display: none">货到付运费</a>
                            </li>

                        </ul>
                    </div>
                <?php endif; ?>

                <div class="standard p">
                    <input type="hidden" name="goods_id" value="<?php echo $goods['goods_id']; ?>" />
                    <a id="join_cart_now" class="paybybill" href="javascript:;" onclick="AjaxAddCart(<?php echo $goods['goods_id']; ?>,1,1);">立即购买</a>
                    <a id="join_cart" class="addcar" href="javascript:;" onclick="AjaxAddCart(<?php echo $goods['goods_id']; ?>,1,0);"><i class="sk"></i>加入购物车</a>
                    <a id="no_join_cart_now" class="paybybill" style="display:none;background: #ebebeb;color: #999;cursor: not-allowed">立即购买</a>
                    <a id="no_join_cart" class="addcar" style="display:none;background: #ebebeb;color: #999;cursor: not-allowed"><i class="sk"></i>加入购物车</a>
                </div>
            </div>
        </form>
        <!--看了又看-s-->
        <div class="detail-ry p">
            <div class="type_more" >
                <div class="type-top">
                    <h2>看了又看<a class="update_h fr" href="javascript:;" onclick="replace_look();">换一换</a></h2>
                </div>
                <div id="see_and_see">
                </div>
            </div>
        </div>
        <!--看了又看-s-->
    </div>
</div>
<div class="detail-main p">
    <div class="w1224">
        <div class="deta-le-ma">
            <div class="type_more">
                <div class="type-top">
                    <h2>热搜推荐</h2>
                </div>
                <div class="type-bot">
                    <ul class="xg_typ">
                        <?php if(is_array($tpshop_config['hot_keywords']) || $tpshop_config['hot_keywords'] instanceof \think\Collection || $tpshop_config['hot_keywords'] instanceof \think\Paginator): if( count($tpshop_config['hot_keywords'])==0 ) : echo "" ;else: foreach($tpshop_config['hot_keywords'] as $k=>$wd): ?>
                            <li><a href="<?php echo U('Home/Goods/search',array('q'=>$wd)); ?>"><?php echo $wd; ?></a></li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
            <div class="type_more ma-to-20">
                <div class="type-top">
                    <h2>推荐热卖</h2>
                </div>
                <div class="tjhot-shoplist type-bot">
                    <?php
                                   
                                $md5_key = md5("select goods_id,goods_name,shop_price from __PREFIX__goods where is_recommend=1 and is_on_sale = 1 order by goods_id desc limit 10");
                                $result_name = $sql_result_vo = S("sql_".$md5_key);
                                if(empty($sql_result_vo))
                                {                            
                                    $result_name = $sql_result_vo = \think\Db::query("select goods_id,goods_name,shop_price from __PREFIX__goods where is_recommend=1 and is_on_sale = 1 order by goods_id desc limit 10"); 
                                    S("sql_".$md5_key,$sql_result_vo,60);
                                }    
                              foreach($sql_result_vo as $k=>$vo): ?>
                        <div class="alone-shop">
                            <a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$vo[goods_id])); ?>"><img src="<?php echo goods_thum_images($vo['goods_id'],206,206); ?>" style="display: inline;"></a>
                            <p class="line-two-hidd"><a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$vo[goods_id])); ?>"><?php echo getSubstr($vo['goods_name'],0,30); ?></a></p>
                            <p class="price-tag"><span class="li_xfo">￥</span><span><?php echo $vo['shop_price']; ?></span></p>
                            <!--<p class="store-alone"><a href="">恒要达食品专享店</a></p>-->
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="deta-ri-ma">
            <div class="introduceshop">
                <div class="datail-nav-top">
                    <ul>
                        <li class="red"><a href="javascript:void(0);">商品介绍</a></li>
                        <li><a href="javascript:void(0);">规格及包装</a></li>
                        <!--<li><a href="javascript:void(0);">评价<em>(<?php echo $commentStatistics['c0']; ?>)</em></a></li>-->
                        <li><a href="javascript:void(0);">售后服务</a></li>
                    </ul>
                </div>
                <!--<div class="he-nav"></div>-->
                <div class="shop-describe shop-con-describe p">
                    <div class="deta-descri">
                        <p class="shopname_de"><span>商品名称：</span><span><?php echo $goods['goods_name']; ?></span></p>
                        <div class="ma-d-uli p">
                            <ul>
                                <!--<li><span>品牌：</span><span><?php echo $goods['brand_name']; ?></span></li>-->
                                <li><span>货号：</span><span><?php echo $goods['goods_sn']; ?></span></li>
                                <?php if(is_array($goods_attr_list) || $goods_attr_list instanceof \think\Collection || $goods_attr_list instanceof \think\Paginator): if( count($goods_attr_list)==0 ) : echo "" ;else: foreach($goods_attr_list as $k=>$v): ?>
                                    <li><span><?php echo $goods_attribute[$v[attr_id]]; ?>：</span><span><?php echo $v[attr_value]; ?></span></li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div>
                        <p class="shopname_de"><span>简介：</span><span><?php echo $goods['goods_remark']; ?></span></p>

                        <div class="moreparameter">
                            <!--
                            <a href="">跟多参数<em>>></em></a>
                            -->
                        </div>
                    </div>
                    <div class="detail-img-b">
                        <?php echo htmlspecialchars_decode($goods['goods_content']); ?>
                    </div>
                </div>
                <div class="shop-describe shop-con-describe p" style="display: none;">
                    <div class="deta-descri">
                        <!--
                        <p class="shopname_de"><span>如果您发现商品信息不准确，<a class="de_cb" href="">欢迎纠错</a></span></p>
                        -->
                        <h2 class="shopname_de">属性</h2>
                        <?php if(is_array($goods_attr_list) || $goods_attr_list instanceof \think\Collection || $goods_attr_list instanceof \think\Paginator): if( count($goods_attr_list)==0 ) : echo "" ;else: foreach($goods_attr_list as $k=>$v): ?>
                            <div class="twic_a_alon">
                                <p class="gray_t"><?php echo $goods_attribute[$v[attr_id]]; ?></p>
                                <p><?php echo $v[attr_value]; ?></p>
                            </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <!--<div class="shop-con-describe p" style="display: none;">-->
                    <!--<div class="shop-describe p">-->
                        <!--<div class="comm_stsh ma-to-20">-->
                            <!--<div class="deta-descri">-->
                                <!--<h2>商品评价</h2>-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="deta-descri p">-->
                            <!--<ul class="tebj">-->
                                <!--<li class="percen"><span><?php echo $commentStatistics['rate1']; ?>%</span></li>-->
                                <!--<li class="co-cen">-->
                                    <!--<div class="comm_gooba">-->
                                        <!--<div class="gg_c">-->
                                            <!--<span class="hps">好评</span>-->
                                            <!--<span class="hp">（<?php echo $commentStatistics['rate1']; ?>%）</span>-->
                                            <!--<span class="zz_rg"><i style="width: <?php echo $commentStatistics['rate1']; ?>%;"></i></span>-->
                                        <!--</div>-->
                                        <!--<div class="gg_c">-->
                                            <!--<span class="hps">中评</span>-->
                                            <!--<span class="hp">（<?php echo $commentStatistics['rate2']; ?>%）</span>-->
                                            <!--<span class="zz_rg"><i style="width: <?php echo $commentStatistics['rate2']; ?>%;"></i></span>-->
                                        <!--</div>-->
                                        <!--<div class="gg_c">-->
                                            <!--<span class="hps">差评</span>-->
                                            <!--<span class="hp">（<?php echo $commentStatistics['rate3']; ?>%）</span>-->
                                            <!--<span class="zz_rg"><i style="width: <?php echo $commentStatistics['rate3']; ?>%;"></i></span>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                <!--</li>-->
                                <!--<li class="tjd-sum">-->
                                    <!--&lt;!&ndash;<p class="tjd">推荐点：</p>&ndash;&gt;-->
                                    <!--<div class="tjd-a">-->
                                        <!--买家评论事项：购买后有什么问题, 满意, 或者不不满, 都可以在这里评论出来, 这里评论全部源于真实的评论.-->
                                    <!--</div>-->
                                <!--</li>-->
                                <!--<li class="te-cen">-->
                                    <!--<div class="nchx_com">-->
                                        <!--<p>您可以对已购的商品进行评价</p>-->
                                        <!--<a class="jfnuv" href="<?php echo U('Home/User/comment'); ?>">发表评论</a>-->
                                        <!--&lt;!&ndash;<p class="xja"><span>详见</span><a class="de_cb" href="">积分规则</a></p>&ndash;&gt;-->
                                    <!--</div>-->
                                <!--</li>-->
                            <!--</ul>-->
                        <!--</div>-->
                        <!--<div class="deta-descri p">-->
                            <!--<div class="cte-deta">-->
                                <!--<ul id="fy-comment-list">-->
                                    <!--<li data-t="1" class="red">-->
                                        <!--<a href="javascript:void(0);" class="selected">全部评论（<?php echo $commentStatistics['c0']; ?>）</a>-->
                                    <!--</li>-->
                                    <!--<li data-t="2">-->
                                        <!--<a href="javascript:void(0);">好评（<?php echo $commentStatistics['c1']; ?>）</a>-->
                                    <!--</li>-->
                                    <!--<li data-t="3">-->
                                        <!--<a href="javascript:void(0);">中评（<?php echo $commentStatistics['c2']; ?>）</a>-->
                                    <!--</li>-->
                                    <!--<li data-t="4">-->
                                        <!--<a href="javascript:void(0);">差评（<?php echo $commentStatistics['c3']; ?>）</a>-->
                                    <!--</li>-->
                                    <!--<li data-t="5">-->
                                        <!--<a href="javascript:void(0);">有图（<?php echo $commentStatistics['c4']; ?>）</a>-->
                                    <!--</li>-->
                                <!--</ul>-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="line-co-sunall"  id="ajax_comment_return">-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="shop-con-describe p" style="display: none;">
                    <div class="shop-describe p">
                        <div class="comm_stsh ma-to-20">
                            <div class="deta-descri">
                                <h2>售后保障</h2>
                            </div>
                        </div>
                        <div class="deta-descri p">
                            <div class="securi-afr">
                                <ul>
                                    <li class="frhe"><i class="detai-ico msz1"></i></li>
                                    <li class="wnuzsuhe">
                                        <h2>卖家服务</h2>
                                        <p>全国联保一年</p>
                                    </li>
                                </ul>
                                <ul>
                                    <li class="frhe"><i class="detai-ico msz2"></i></li>
                                    <li class="wnuzsuhe">
                                        <h2>商城承诺</h2>
                                        <p>商城平台卖家销售并发货的商品，由平台卖家提供发票和相应的售后服务。请您放心购买！
                                            注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。
                                            只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</p>
                                    </li>
                                </ul>
                                <ul>
                                    <li class="frhe"><i class="detai-ico msz3"></i></li>
                                    <li class="wnuzsuhe">
                                        <h2>正品行货</h2>
                                        <p>商城向您保证所售商品均为正品行货，商城自营商品开具机打发票或电子发票。</p>
                                    </li>
                                </ul>
                                <ul>
                                    <li class="frhe"><i class="detai-ico msz4"></i></li>
                                    <li class="wnuzsuhe">
                                        <h2>全国联保</h2>
                                        <p>凭质保证书及商城发票，可享受全国联保服务（奢侈品、钟表除外；奢侈品、钟表由联系保修，享受法定三包售后服务），与您亲临商场选购的商品享
                                            受相同的质量保证。商城还为您提供具有竞争力的商品价格和运费政策，请您放心购买！ </p>
                                    </li>
                                </ul>
                                <ul>
                                    <li class="frhe"><i class="detai-ico msz5"></i></li>
                                    <li class="wnuzsuhe">
                                        <h2>退货无忧</h2>
                                        <p>客户购买商城自营商品7日内（含7日，自客户收到商品之日起计算），在保证商品完好的前提下，可无理由退货。（部分商品除外，详情请见各商品细则）</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="comm_stsh ma-to-20">
                            <div class="deta-descri">
                                <h2>退款说明</h2>
                            </div>
                        </div>
                        <div class="deta-descri p">
                            <div class="fetbajc">
                                <p>1.若您购买的家电商品已经拆封过，需要退换货，需请联系原厂开具鉴定检测单</p>
                                <p>2.签收商品隔日起七日内提交退货申请，2-3天快递员与您联系安排取回商品</p>
                                <p>3.商品退回检验，且必须附上检测单</p>
                                <p>5.若退回商品有缺件、影响二次销售状况时，退款作业将暂时停止，飞牛网会依商品状况报价，后由客服人员与您联系说明并于订单内扣除费用后退回剩余款项，
                                    或您可以取消退货申请；若符合退货条件者将于商品取回后约1-2个工作日内完成退款</p>
                                <p>4.通过线上支付的订单办理退货，商品退回检验无误后，商城将提交退款申请, 实际款项会依照各银行作业时间返还至您原支付方式 若您采用货到付款，请于
                                    办理退货时提供退款账户，亦于商品退回检验无误后，将退款汇至您的银行账户中</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--footer-s-->
<div class="tpshop-service">
	<ul class="w1224 clearfix">
		<!--<li>-->
			<!--<i class="ico ico-day7"></i>-->
			<!--<p class="service">7天无理由退货</p>-->
		<!--</li>-->
		<!--<li>-->
			<!--<i class="ico ico-day15"></i>-->
			<!--<p class="service">15天免费换货</p>-->
		<!--</li>-->
		<!--<li>-->
			<!--<i class="ico ico-quality"></i>-->
			<!--<p class="service">正品行货 品质保障</p>-->
		<!--</li>-->
		<!--<li>-->
			<!--<i class="ico ico-service"></i>-->
			<!--<p class="service">专业售后服务</p>-->
		<!--</li>-->
	</ul>
</div>
<div class="footer">
	<div class="w1224 clearfix">
		<div class="left-help-list clearfix">
		<?php
                                   
                                $md5_key = md5("select * from `__PREFIX__article_cat` where parent_id = 2 limit 5");
                                $result_name = $sql_result_v = S("sql_".$md5_key);
                                if(empty($sql_result_v))
                                {                            
                                    $result_name = $sql_result_v = \think\Db::query("select * from `__PREFIX__article_cat` where parent_id = 2 limit 5"); 
                                    S("sql_".$md5_key,$sql_result_v,60);
                                }    
                              foreach($sql_result_v as $k=>$v): ?>
			<dl>
				<dt><?php echo $v[cat_name]; ?></dt>
				<?php
                                   
                                $md5_key = md5("select * from `__PREFIX__article` where cat_id = $v[cat_id]  and is_open=1 limit 5");
                                $result_name = $sql_result_v2 = S("sql_".$md5_key);
                                if(empty($sql_result_v2))
                                {                            
                                    $result_name = $sql_result_v2 = \think\Db::query("select * from `__PREFIX__article` where cat_id = $v[cat_id]  and is_open=1 limit 5"); 
                                    S("sql_".$md5_key,$sql_result_v2,60);
                                }    
                              foreach($sql_result_v2 as $k2=>$v2): ?>
				<dd><a href="<?php echo U('Home/Article/detail',array('article_id'=>$v2[article_id])); ?>"><?php echo $v2[title]; ?></a></dd>
				<?php endforeach; ?>
			</dl>
		<?php endforeach; ?>
		</div>
		<div class="right-contact-us">
			<h3 class="title">联系我们</h3>
			<span class="phone"><?php echo $tpshop_config['shop_info_phone']; ?></span>
			<div class="qr-code-list clearfix">
				<a class="qr-code" href="javascript:;"><img class="w-100" src="__STATIC__/images/qrcode.png" alt="" /></a>
				<a class="qr-code qr-code-tpshop" href="javascript:;"><img class="w-100" src="__STATIC__/images/qrcode.png" alt="" /></a>
			</div>
		</div>
	</div>
</div>
<div class="soubao-sidebar">
    <div class="soubao-sidebar-bg"></div>
    <div class="sidertabs tab-lis-1">
        <div class="sider-top-stra sider-midd-1">
            <div class="icon-tabe-chan">
                <a href="<?php echo U('Home/User/index'); ?>">
                    <i class="share-side share-side1"></i>
                    <i class="share-side tab-icon-tip triangleshow"></i>
                </a>

                <div class="dl_login">
                    <div class="hinihdk">
                        <img src="__STATIC__/images/dl.png"/>

                        <p class="loginafter nologin"><span>你好，请先</span><a href="<?php echo U('Home/user/login'); ?>">登录！</a></p>
                        <!--未登录-e--->
                        <!--登录后-s--->
                        <p class="loginafter islogin">
                            <span class="id_jq userinfo">陈xxxxxxx</span>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;</span><a href="<?php echo U('Home/user/logout'); ?>" title="点击退出">退出！</a>
                        </p>
                        <!--未登录-s--->
                    </div>
                </div>
            </div>
            <div class="icon-tabe-chan shop-car">
                <a href="javascript:void(0);" onclick="ajax_side_cart_list()">
                    <div class="tab-cart-tip-warp-box">
                        <div class="tab-cart-tip-warp">
                            <i class="share-side share-side1"></i>
                            <i class="share-side tab-icon-tip"></i>
                            <span class="tab-cart-tip">购物车</span>
                            <span class="tab-cart-num J_cart_total_num" id="tab_cart_num">0</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="icon-tabe-chan massage">
                <a href="<?php echo U('Home/User/message_notice'); ?>" target="_blank">
                    <i class="share-side share-side1"></i>
                    <!--<i class="share-side tab-icon-tip"></i>-->
                    <span class="tab-tip">消息</span>
                </a>
            </div>
        </div>
        <div class="sider-top-stra sider-midd-2">
            <div class="icon-tabe-chan mmm">
                <a href="<?php echo U('Home/User/goods_collect'); ?>" target="_blank">
                    <i class="share-side share-side1"></i>
                    <!--<i class="share-side tab-icon-tip"></i>-->
                    <span class="tab-tip">收藏</span>
                </a>
            </div>
            <div class="icon-tabe-chan hostry">
                <a href="<?php echo U('Home/User/visit_log'); ?>" target="_blank">
                    <i class="share-side share-side1"></i>
                    <!--<i class="share-side tab-icon-tip"></i>-->
                    <span class="tab-tip">足迹</span>
                </a>
            </div>
            <!--<div class="icon-tabe-chan sign">-->
                <!--<a href="" target="_blank">-->
                    <!--<i class="share-side share-side1"></i>-->
                    <!--&lt;!&ndash;<i class="share-side tab-icon-tip"></i>&ndash;&gt;-->
                    <!--<span class="tab-tip">签到</span>-->
                <!--</a>-->
            <!--</div>-->
        </div>
    </div>
    <div class="sidertabs tab-lis-2">
        <div class="icon-tabe-chan advice">
            <a title="点击这里给我发消息" href="tencent://message/?uin=<?php echo $tpshop_config['shop_info_qq2']; ?>&amp;Site=TPshop商城&amp;Menu=yes" target="_blank">
                <i class="share-side share-side1"></i>
                <!--<i class="share-side tab-icon-tip"></i>-->
                <span class="tab-tip">在线咨询</span>
            </a>
        </div>
        <div class="icon-tabe-chan request">
            <a href="" target="_blank">
                <i class="share-side share-side1"></i>
                <!--<i class="share-side tab-icon-tip"></i>-->
                <span class="tab-tip">意见反馈</span>
            </a>
        </div>
        <div class="icon-tabe-chan qrcode">
            <a href="" target="_blank">
                <i class="share-side share-side1"></i>
                <i class="share-side tab-icon-tip triangleshow"></i>
                <span class="tab-tip qrewm">
                    <img src="__STATIC__/images/qrcode.png"/>
                    扫一扫下载APP
                </span>
            </a>
        </div>
        <div class="icon-tabe-chan comebacktop">
            <a href="" target="_blank">
                <i class="share-side share-side1"></i>
                <!--<i class="share-side tab-icon-tip"></i>-->
                <span class="tab-tip">返回顶部</span>
            </a>
        </div>
    </div>
    <div class="shop-car-sider">

    </div>
</div>
<script src="__STATIC__/js/common.js"></script>
<!--看了又看-s-->
<div style="display: none" id="look_see">
    <?php if(is_array($look_see) || $look_see instanceof \think\Collection || $look_see instanceof \think\Paginator): if( count($look_see)==0 ) : echo "" ;else: foreach($look_see as $k=>$look): ?>
        <div class="tjhot-shoplist type-bot">
            <div class="alone-shop">
                <a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$look[goods_id])); ?>"><img class="wiahides" src="<?php echo goods_thum_images($look['goods_id'],206,206); ?>" style="display: inline;"></a>
                <p class="shop_name2">
                    <a href="<?php echo U('Home/Goods/goodsInfo',array('id'=>$look[goods_id])); ?>"><?php echo $look['goods_name']; ?></a>
                </p>
                <p class="price-tag">
                    <span class="li_xfo">￥</span><span><?php echo $look['shop_price']; ?></span>
                </p>
            </div>
        </div>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    <!--看了又看-s-->
</div>
<!--footer-e-->
<script src="__STATIC__/js/lazyload.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="__STATIC__/js/headerfooter.js" ></script>
<script type="text/javascript">
   var money_qie=0;
    /**
     *
     * 弹框样式  显示
     */
    function tupian(ima){
        layer.open({
            type: 1,
           /* skin: 'layui-layer-rim', //加上边框*/
            area: ['552px', '553.5px'], //宽高
            zIndex:88,
            content: $('#magnify')
        });
        $(".layui-layer-title").css('background-color','#8D8D8D');
        $(".layui-layer-title").css('color','white');
        $(".layui-layer-title").html('<span style="margin-left: 50%;">产品二维码</span>');
        $(".form-control").css('margin-top','-28px ');
        $(".form-control").css('margin-left','100px ');
        $(".riqi").css('margin-top','20px ');
    }






    var commentType = 1;// 默认评论类型
    var spec_goods_price = <?php echo (isset($spec_goods_price) && ($spec_goods_price !== '')?$spec_goods_price:'null'); ?>;//规格库存价格
    $(document).ready(function () {
        /*商品缩略图放大镜*/
        $(".jqzoom").jqueryzoom({
            xzoom: 500,
            yzoom: 500,
            offset: 1,
            position: "right",
            preload: 1,
            lens: 1
        });
        replace_look();
        initSpec();
        initGoodsPrice();
//        $("#is_fenqi").attr("checked",false);
//        $("input[name='is_fenqi']").attr("checked",false);
    });
    //有规格id的时候，解析规格id选中规格
    function initSpec(){
        var item_id = $("input[name='item_id']").val();
        $.each(spec_goods_price,function(i, o){
            if(o.item_id == item_id){
                var spec_key_arr = o.key.split("_");
                $.each(spec_key_arr,function(index,item){
                    var spec_radio = $("#goods_spec_"+item);
                    var goods_spec_a = $("#goods_spec_a_"+item);
                    spec_radio.attr("checked","checked");
                    goods_spec_a.addClass('red');
                })
            }
        })
        if(item_id > 0 && !$.isEmptyObject(spec_goods_price)){
            var item_arr = [];
            $.each(spec_goods_price,function(i, o){
                item_arr.push(o.item_id);
            })
            //规格id不存在商品里
            if($.inArray(parseInt(item_id), item_arr) < 0){
                initFirstSpec();
            }else{
                $.each(spec_goods_price,function(i, o){
                    if(o.item_id == item_id){
                        var spec_key_arr = o.key.split("_");
                        $.each(spec_key_arr,function(index,item){
                            var spec_radio = $("#goods_spec_"+item);
                            var goods_spec_a = $("#goods_spec_a_"+item);
                            spec_radio.attr("checked","checked");
                            goods_spec_a.addClass('red');
                        })
                    }
                })
            }
        }else{
            initFirstSpec();
        }
    }

    //默认让每种规格第一个选中
    function initFirstSpec(){
        $('.spec_goods_price_div').each(function (i, o) {
            var firstSpecRadio = $(this).find("input[type='radio']").eq(0);
            firstSpecRadio.attr('checked','checked').prop('checked','checked');
            firstSpecRadio.parent().find('a').eq(0).addClass('red');
        })
    }

    /**
     * 切换规格
     */
    function select_filter(obj)
    {
        $(obj).addClass('red').siblings('a').removeClass('red');
        $(obj).siblings('input').removeAttr('checked');
        $(obj).prev('input').attr('checked','checked').prop('checked','checked');
        // 更新商品价格
        initGoodsPrice();
    }

    //看了又看切换
    var tmpindex = 0;
    var look_see_length = $('#look_see').children().length;
    function replace_look(){
        var listr='';
        if(tmpindex*2>=look_see_length) tmpindex = 0;
        $('#look_see').children().each(function(i,o){
            if((i>=tmpindex*2) && (i<(tmpindex+1)*2)){
                listr += '<div class="tjhot-shoplist type-bot">'+$(o).html()+'</div>';
            }
        });
        tmpindex++;
        $('#see_and_see').empty().append(listr);
    }
    //缩略图切换
    $('.small-pic-li').each(function (i, o) {
        var lilength = $('.small-pic-li').length;
        $(o).hover(function () {
            $(o).siblings().removeClass('active');
            $(o).addClass('active');
            $('#zoomimg').attr('src', $(o).find('img').attr('data-img'));
            $('#zoomimg').attr('jqimg', $(o).find('img').attr('data-big'));

            $('.next-btn').removeClass('disabled');
            if (i == 0) {
                $('.next-left').addClass('disabled');
            }
            if (i + 1 == lilength) {
                $('.next-right').addClass('disabled');
            }
        });
    })

    //前一张缩略图
    $('.next-left').click(function () {
        var newselect = $('.small-pic>.active').prev();
        $('.small-pic>.active').removeClass('active');
        $(newselect).addClass('active');
        $('#zoomimg').attr('src', $(newselect).find('img').attr('data-img'));
        $('#zoomimg').attr('jqimg', $(newselect).find('img').attr('data-big'));
        var index = $('.small-pic>li').index(newselect);
        if (index == 0) {
            $('.next-left').addClass('disabled');
        }
        $('.next-right').removeClass('disabled');
    })

    //后前一张缩略图
    $('.next-right').click(function () {
        var newselect = $('.small-pic>.active').next();
        $('.small-pic>.active').removeClass('active');
        $(newselect).addClass('active');
        $('#zoomimg').attr('src', $(newselect).find('img').attr('data-img'));
        $('#zoomimg').attr('jqimg', $(newselect).find('img').attr('data-big'));
        var index = $('.small-pic>li').index(newselect);
        if (index + 1 == $('.small-pic>li').length) {
            $('.next-right').addClass('disabled');
        }
        $('.next-left').removeClass('disabled');
    })
    $(function(){
        $("#area").click(function (e) {
            SelCity(this,e);
        });
    })

    $(function() {
        ajaxComment(1,1);
        // 好评差评 切换
        $('.cte-deta ul li').click(function(){
            $(this).addClass('red').siblings().removeClass('red');
            commentType = $(this).data('t');// 评价类型   好评 中评  差评
            ajaxComment(commentType,1);
        })
    });
    $(function(){
        $('.datail-nav-top ul li').click(function(){
            $(this).addClass('red').siblings().removeClass('red');
            var er = $('.datail-nav-top ul li').index(this);
            $('.shop-con-describe').eq(er).show().siblings('.shop-con-describe').hide();
        })
    })

    /**
     * 加减数量
     * n 点击一次要改变多少
     * maxnum 允许的最大数量(库存)
     * number ，input的id
     */
    function altergoodsnum(n){
        var num = parseInt($('#number').val());
        var maxnum = parseInt($('#number').attr('max'));
        num += n;
        num <= 0 ? num = 1 :  num;
        if(num >= maxnum){
            $(this).addClass('no-mins');
            num = maxnum;
        }
        $('#store_count').text(maxnum-num); //更新库存数量
        var type = $("#is_fenqi").is(":checked");//查看分期是否被选中
        if(type === true){
            var fen_num = $("#fen_num").val();//最低分期数量  分期的话不能少于这个数
            if(num>=fen_num){
                $('#number').val(num);
            }
        }else{
            $('#number').val(num);
        }
        goods_price = money_qie; // 找到对应规格的价格
        var fenbi= $("#fen_bi").val();
        var money_all = (goods_price*(1-fenbi)*$("#number").val())/100;
        var shou =  (goods_price*(fenbi)*$("#number").val()).toFixed(2);
        var falot = money_all.toFixed(2);
        $("#bili").html('首付:'+shou);
        $("#huan").html('还款:'+falot+'/期');
    }

    //初始化商品价格库存
    function initGoodsPrice() {
        var goods_id = $('input[name="goods_id"]').val();
        if (!$.isEmptyObject(spec_goods_price)) {
            var goods_spec_arr = [];
            $("input[name^='goods_spec']").each(function () {
                if($(this).attr('checked') == 'checked'){
                    goods_spec_arr.push($(this).val());
                }
            });
            var spec_key = goods_spec_arr.sort(sortNumber).join('_');  //排序后组合成 key
            var item_id = spec_goods_price[spec_key]['item_id'];
            $('input[name=item_id]').val(item_id);
        }
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: {goods_id: goods_id, item_id: item_id},
            url: "<?php echo U('Home/Goods/activity'); ?>",
            success: function (data) {
                if (data.status == 1) {
                    $('input[name="goods_prom_type"]').attr('value', data.result.goods.prom_type);//商品活动类型
                    $('input[name="shop_price"]').attr('value', data.result.goods.shop_price);//商品价格
                    $('input[name="store_count"]').attr('value', data.result.goods.store_count);//商品库存
                    $('input[name="market_price"]').attr('value', data.result.goods.market_price);//商品原价
                    $('input[name="start_time"]').attr('value', data.result.goods.start_time);//活动开始时间
                    $('input[name="end_time"]').attr('value', data.result.goods.end_time);//活动结束时间
                    $('input[name="activity_title"]').attr('value', data.result.goods.activity_title);//活动标题
                    $('input[name="prom_detail"]').attr('value', data.result.goods.prom_detail);//促销详情
                    $('input[name="activity_is_on"]').attr('value', data.result.goods.activity_is_on);//活动是否正在进行中
                    goods_activity_theme();
                }
            }
        });
    }


    //商品价格库存显示
    function goods_activity_theme(){
        var goods_prom_type = $('input[name="goods_prom_type"]').attr('value');
        var activity_is_on = $('input[name="activity_is_on"]').attr('value');
        if(activity_is_on == 0){
            setNormalGoodsPrice();
        }else{
            if(goods_prom_type == 0){
                //普通商品
                setNormalGoodsPrice();
            }else if(goods_prom_type == 1){
                //抢购
                setFlashSaleGoodsPrice();
            }else if(goods_prom_type == 2){
                //团购
                setGroupByGoodsPrice();
            }else if(goods_prom_type == 3){
                //优惠促销
                setPromGoodsPrice();
            }else{

            }
        }
        var buy_num  = $('#number').val();//购买数
        var store = $('#spec_store_count').html();//实际库存数量
        if(store<= 0){
            joinCart(false);
        }else{
            joinCart(true);
        }
        if(store<=0){
            $('.buyNum').val(store);
        }else{
            $('.buyNum').val(1);
        }
    }

    //普通商品库存和价格
    function setNormalGoodsPrice(){
        var goods_price = $("input[name='shop_price']").attr('value');// 商品本店价
        var market_price =  $("input[name='market_price']").attr('value');// 商品市场价
        var store_count = $("input[name='store_count']").attr('value');// 商品库存
        // 如果有属性选择项
        if(!$.isEmptyObject(spec_goods_price))
        {
            var goods_spec_arr = [];
            $("input[name^='goods_spec']").each(function () {
                if($(this).attr('checked') == 'checked'){
                    goods_spec_arr.push($(this).val());
                }
            });
            var spec_key = goods_spec_arr.sort(sortNumber).join('_');  //排序后组合成 key
            goods_price = spec_goods_price[spec_key]['price']; // 找到对应规格的价格

            store_count = spec_goods_price[spec_key]['store_count']; // 找到对应规格的库存
        }
        money_qie=goods_price;
        $('#market_price_title').empty().html('市场价：');
        $('#market_price').empty().html(market_price);
        $("#goods_price").html("<em>￥</em>"+goods_price); //变动价格显示
        $('#spec_store_count').html(store_count);
        $('.presale-time').hide();
        $('#number').attr('max',store_count);
        var fenbi= $("#fen_bi").val();
        var money_all = (goods_price*(1-fenbi)*$("#number").val())/100;
        var shou =  (goods_price*(fenbi)*$("#number").val()).toFixed(2);
        var falot = money_all.toFixed(2);
        $("#bili").html('首付:'+shou);
        $("#huan").html('还款:'+falot+'/期')
    }

    /**
     * 分期/不分期切换
     */
    $(function(){
        $("#fenqi").prop("checked",true);
    })
   $('#myred').click(function(){
       var fen_num =$("#fen_num").val();//最少分期数量
       $("#number").val(fen_num);//将数量改为最少分期数
       var fenbi= $("#fen_bi").val();
       var money_all = (money_qie*(1-fenbi)*$("#number").val())/100;
       var shou =  (money_qie*(fenbi)*$("#number").val()).toFixed(2);
       var falot = money_all.toFixed(2);
       $("#bili").html('首付:'+shou);
       $("#huan").html('还款:'+falot+'/期')
       $(".bao").html('货到付运费');
       $("#bili"). show();
       $("#huan"). show();
       $("#hdfyf"). hide();
       $("#hdfyf2").show();
       $(this).css('border','1px solid #e23435');  //红色粗
       $(this).css('color','#e23435');
       $("#is_fenqi").prop("checked",true);
       $("#fenqi").prop("checked",false);
       $('#no_myred').css('border','1px solid #dadada');
       $('#no_myred').css('color','#333');

   });

   $('#no_myred').click(function(){
      var bao1 ="<?php echo $goods['is_free_shipping']; ?>";
       if(bao1 ==1){
           $(".bao").html('包邮');
       }else{
           $(".bao").html('货到付运费');
       }
       $("#bili"). hide();
       $("#huan"). hide();
       $("#hdfyf"). show();
       $("#hdfyf2"). hide();
       $(this).css('border','1px solid #e23435');  //红色粗
       $(this).css('color','#e23435');
       $("#is_fenqi").prop("checked",false);
       $("#fenqi").prop("checked",true);
       $('#myred').css('border','1px solid #dadada');
       $('#myred').css('color','');
   });




    //秒杀商品库存和价格
    function setFlashSaleGoodsPrice(){
        var flash_sale_price = $("input[name='shop_price']").attr('value');
        var flash_sale_count = $("input[name='store_count']").attr('value');
        var market_price = $("input[name='market_price']").attr('value');
        var start_time = $("input[name='start_time']").attr('value');
        var end_time = $("input[name='end_time']").attr('value');
        var activity_title = $("input[name='activity_title']").attr('value');
        $("#goods_price").html("<em>￥</em>"+flash_sale_price); //变动价格显示
        $('#spec_store_count').html(flash_sale_count);
        $('#goods_price_title').html('抢购价：');
        $('#market_price_title').empty().html('原&nbsp;&nbsp;价：');
        $('#activity_label').empty().html('抢&nbsp;&nbsp;购：');
        $('#activity_title').empty().html(activity_title);
        $('#activity_title_div').show();
        $('#market_price').empty().html(market_price);
        $('.presale-time').show();
        $('#prom_detail').hide();
        $('#number').attr('max',flash_sale_count);
        setInterval(activityTime, 1000);
    }

    //团购商品库存和价格
    function setGroupByGoodsPrice(){
        var group_by_price = $("input[name='shop_price']").attr('value');
        var group_by_count = $("input[name='store_count']").attr('value');
        var market_price = $("input[name='market_price']").attr('value');
        var start_time = $("input[name='start_time']").attr('value');
        var end_time = $("input[name='end_time']").attr('value');
        var activity_title = $("input[name='activity_title']").attr('value');
        $("#goods_price").empty().html("<em>￥</em>"+group_by_price); //变动价格显示
        $('#spec_store_count').empty().html(group_by_count);
        $('#activity_type').empty().html('团购');
        $('#goods_price_title').empty().html('团购价：');
        $('#market_price_title').empty().html('原&nbsp;&nbsp;价：');
        $('#activity_label').empty().html('团&nbsp;&nbsp;购：');
        $('#activity_title').empty().html(activity_title);
        $('#activity_title_div').show();
        $('#market_price').empty().html(market_price);
        $('.presale-time').show();
        $('#prom_detail').hide();
        $('#number').attr('max',group_by_count);
        setInterval(activityTime, 1000);
    }

    //促销商品库存和价格
    function setPromGoodsPrice(){
        var prom_goods_price = $("input[name='shop_price']").attr('value');
        var prom_goods_count = $("input[name='store_count']").attr('value');
        var market_price = $("input[name='market_price']").attr('value');
        var start_time = $("input[name='start_time']").attr('value');
        var end_time = $("input[name='end_time']").attr('value');
        var activity_title = $("input[name='activity_title']").attr('value');
        var prom_detail = $("input[name='prom_detail']").attr('value');
        $("#goods_price").empty().html("<em>￥</em>"+prom_goods_price); //变动价格显示
        $('#spec_store_count').empty().html(prom_goods_count);
        $('#activity_type').empty().html('促销');
        $('.presale-time').show();
        $('#prom_detail').empty().html(prom_detail).show();
        $('#activity_time').hide();
        $('#goods_price_title').empty().html('促销价：');
        $('#market_price_title').empty().html('原&nbsp;&nbsp;价：');
        $('#activity_label').empty().html('促&nbsp;&nbsp;销：');
        $('#activity_title').empty().html(activity_title);
        $('#activity_title_div').show();
        $('#market_price').empty().html(market_price);
        $('#number').attr('max',prom_goods_count);
    }

    // 倒计时
    function activityTime() {
        var end_time = parseInt($("input[name='end_time']").attr('value'));
        var timestamp = Date.parse(new Date());
        var now = timestamp/1000;
        var end_time_date = formatDate(end_time*1000);
        var text = GetRTime(end_time_date);
        //活动时间到了就刷新页面重新载入
        if(now > end_time){
            layer.msg('该商品活动已结束',function(){
                location.reload();
            });
        }
        $("#overTime").text(text);
    }
    //时间戳转换
    function add0(m){return m<10?'0'+m:m }
    function  formatDate(now)   {
        var time = new Date(now);
        var y = time.getFullYear();
        var m = time.getMonth()+1;
        var d = time.getDate();
        var h = time.getHours();
        var mm = time.getMinutes();
        var s = time.getSeconds();
        return y+'/'+add0(m)+'/'+add0(d)+' '+add0(h)+':'+add0(mm)+':'+add0(s);
    }

    /***用作 sort 排序用*/
    function sortNumber(a,b)
    {
        return a - b;
    }

    /***收藏商品**/
    $('#collectLink').click(function(){
        if(getCookie('user_id') == ''){
            layer.msg('请先登录！', {icon: 1});
        }else{
            $.ajax({
                type:'post',
                dataType:'json',
                data:{goods_id:$('input[name="goods_id"]').val()},
                url:"<?php echo U('Home/Goods/collect_goods'); ?>",
                success:function(res){
                    if(res.status == 1){
                        layer.msg('成功添加至收藏夹', {icon: 1});
                    }else{
                        layer.msg(res.msg, {icon: 3});
                    }
                }
            });
        }
    });

    /***用ajax分页显示评论**/
    function ajaxComment(commentType,page){
        $.ajax({
            type : "GET",
            url:"/index.php?m=Home&c=goods&a=ajaxComment&goods_id=<?php echo $goods['goods_id']; ?>&commentType="+commentType+"&p="+page,//+tab,
            success: function(data){
                $("#ajax_comment_return").html('').append(data);
            }
        });
    }
    /**
     * 切换图片
     */
    function switch_zooming(img)
    {
        if(img != ''){
            $('#zoomimg').attr('jqimg', img).attr('src', img);
        }
    }
</script>
</body>
</html>