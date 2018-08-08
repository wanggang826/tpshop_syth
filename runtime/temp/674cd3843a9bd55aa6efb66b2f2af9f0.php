<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:41:"./template/pc/rainbow/article\detail.html";i:1508133945;s:40:"./template/pc/rainbow/public\header.html";i:1511170667;s:40:"./template/pc/rainbow/public\footer.html";i:1508900007;s:46:"./template/pc/rainbow/public\sidebar_cart.html";i:1508133946;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="content-language" content="zh-cn"/>
    <meta name="renderer" content="webkit|ie-comp|ie-stand"/>
    <meta http-equiv="Cache-control" content="public" max-age="no-cache"/>
    <title>详情-<?php echo $tpshop_config['shop_info_store_title']; ?></title>
    <meta name="keywords" content="<?php echo $tpshop_config['shop_info_store_keyword']; ?>"/>
    <meta name="description" content="<?php echo $tpshop_config['shop_info_store_desc']; ?>"/>
    <script src="__STATIC__/js/jquery-1.11.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/help.css"/>
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/tpshop.css"/>
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
								<?php $pid =10+$kr;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1516244400 and end_time > 1516244400 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("5")->select();
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
							<?php $pid =51;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1516244400 and end_time > 1516244400 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
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
<!--E头部-->
<!-- <div style="clear: both; height:45px"></div> -->
<div id="pageContent" class="pageContent">
    <div class="hc-warp" id="page">
        <div class="hc-crumbs"><a class="p-fb" href="" target="_blank">帮助中心</a>&gt; <a><?php echo $cat_name; ?></a></div>
        <div class="hc-column">
            <?php
                                   
                                $md5_key = md5("select * from `__PREFIX__article_cat` where parent_id=2");
                                $result_name = $sql_result_v = S("sql_".$md5_key);
                                if(empty($sql_result_v))
                                {                            
                                    $result_name = $sql_result_v = \think\Db::query("select * from `__PREFIX__article_cat` where parent_id=2"); 
                                    S("sql_".$md5_key,$sql_result_v,60);
                                }    
                              foreach($sql_result_v as $k=>$v): ?>
                <div class="hc-column-box">
                    <h2><a href="" target="_self"><?php echo $v[cat_name]; ?></a></h2>
                    <ul>
                        <?php
                                   
                                $md5_key = md5("select * from `__PREFIX__article` where cat_id = $v[cat_id]");
                                $result_name = $sql_result_v2 = S("sql_".$md5_key);
                                if(empty($sql_result_v2))
                                {                            
                                    $result_name = $sql_result_v2 = \think\Db::query("select * from `__PREFIX__article` where cat_id = $v[cat_id]"); 
                                    S("sql_".$md5_key,$sql_result_v2,60);
                                }    
                              foreach($sql_result_v2 as $k2=>$v2): ?>
                            <li><a href="<?php echo U('Home/Article/detail',array('article_id'=>$v2[article_id])); ?>"><?php echo $v2[title]; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
        <!--可编辑区域开始-->
        <div id="content"> <!--可编辑区域开始-->
            <div style="width: 1050px; overflow: hidden; font-family: Verdana,Helvetica; float: right;">
                <div style="border: 1px solid rgb(233, 234, 236); margin-bottom: 25px;">
                    <h2 style="height: 34px; line-height: 34px; border-bottom-color: rgb(233, 234, 236); border-bottom-width: 1px; border-bottom-style: solid;"><span style="color: rgb(60, 60, 60); padding-top: 4px; padding-bottom: 4px; padding-left: 10px; font-size: 14px; font-weight: bold; border-left-color: rgb(242, 46, 0); border-left-width: 3px; border-left-style: solid;"><?php echo $article['title']; ?></span>
                    </h2>
                    <div style="padding: 20px 30px 0px; color: rgb(60, 60, 60); font-size: 12px;">
                        <?php echo htmlspecialchars_decode($article['content']); ?>
                    </div>
                </div>
            </div>
            <!--可编辑区域结束--> </div>
        <!--可编辑区域结束-->
    </div>
</div>
<div class="footer p">
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
</div>
<script src="__STATIC__/js/lazyload.min.js" type="text/javascript" charset="utf-8"></script>
<script src="__STATIC__/js/headerfooter.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>