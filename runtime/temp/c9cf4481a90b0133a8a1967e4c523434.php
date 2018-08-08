<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:39:"./template/mobile/new2/index\index.html";i:1516270596;s:45:"./template/mobile/new2/index\ajaxGetMore.html";i:1516262072;s:41:"./template/mobile/new2/public\footer.html";i:1510988499;s:45:"./template/mobile/new2/public\footer_nav.html";i:1508133937;s:43:"./template/mobile/new2/public\wx_share.html";i:1508133937;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>首页-<?php echo $tpshop_config['shop_info_store_title']; ?></title>
    <link rel="stylesheet" href="__STATIC__/css/style.css">
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/iconfont.css"/>
    <script src="__STATIC__/js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <!--<script src="__STATIC__/js/zepto-1.2.0-min.js" type="text/javascript" charset="utf-8"></script>-->
    <script src="__STATIC__/js/mobile-util.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/swipeSlide.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/layer.js"  type="text/javascript" ></script>
</head>
<style>
    html,body{height:100%;}
    .fll_acc li{
        text-align: center;
    }
</style>
<body>
    <!--顶部搜索栏-s-->
    <header>
        <div class="content">
            <div class="ds-in-bl logo">
                <a href=""><img src="<?php echo $logo; ?>" alt="LOGO"></a>
            </div>
            <div class="ds-in-bl search">
                <div class="sea-box  ">
                    <span ></span>
                    <form action=""  method="post">
                        <div class="sear-input">
                            <a href="<?php echo U('Goods/ajaxSearch'); ?>">
                                <input type="text" name="q" id="search_text" class="search_text"   value="" placeholder="请输入您所搜索的商品">
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="ds-in-bl login">
                <span>
                <?php if($user_id > 0): ?>
                    <a href="<?php echo U('Mobile/User/index'); ?>"> <img class="after_login" src="__STATIC__/images/my.png"></a>
                <?php else: ?>
                    <a href="<?php echo U('Mobile/User/login'); ?>"> 登录</a>
                <?php endif; ?>
            </span>
            </div>
        </div>
    </header>
    <!--顶部搜索栏-e-->

    <!--顶部滚动广告栏-s-->
    <div class="banner ban1">
        <div class="mslide" id="slideTpshop">
            <ul>
                <!--广告表-->
                <?php $pid =9;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1516269600 and end_time > 1516269600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("5")->select();
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
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>
                    <li><a href="<?php echo $v['ad_link']; ?>">
                        <img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>" alt="">
                    </a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <!--顶部滚动广告栏-e-->
    <div class="yincang" style="width: 100%;height: 8%;display: none;"></div>
    <!--菜单-start-->
    <div class="floor dh">
        <nav>
            <a href="<?php echo U('Goods/categoryList'); ?>">
                <span>
                    <img src="__STATIC__/images/icon_03.png" alt="全部分类" /><br />
                    <span>全部分类</span>
                </span>
            </a>
            <!--<a href="<?php echo U('Goods/integralMall'); ?>">-->
                <!--<span>-->
                    <!--<img src="__STATIC__/images/icon_05.png" alt="积分商城" /><br />-->
                    <!--<span>积分商城</span>-->
                <!--</span>-->
            <!--</a>-->
            <!--<a href="<?php echo U('Goods/brandstreet'); ?>">-->
                <!--<span>-->
                    <!--<img src="__STATIC__/images/icon_07.png" alt="品牌街" /><br />-->
                    <!--<span>品牌街</span>-->
                <!--</span>-->
            <!--</a>-->
            <!--<a href="<?php echo U('Activity/promote_goods'); ?>">-->
                <!--<span>-->
                    <!--<img src="__STATIC__/images/icon_09.png" alt="优惠活动" /><br />-->
                    <!--<span>优惠活动</span>-->
                <!--</span>-->
            <!--</a>-->
            <!--<a href="<?php echo U('Activity/group_list'); ?>">-->
                <!--<span>-->
                    <!--<img src="__STATIC__/images/icon_15.png" alt="团购" /><br />-->
                    <!--<span>团购</span>-->
                <!--</span>-->
            <!--</a>-->
            <a href="<?php echo U('User/order_list'); ?>">
                <span>
                    <img src="__STATIC__/images/icon_16.png" alt="我的订单" /><br />
                    <span>我的订单</span>
                </span>
            </a>
            <!--<a href="shopcar.html">-->
            <a href="<?php echo U('Cart/index'); ?>">
                <span>
                    <img src="__STATIC__/images/icon_17.png" alt="购物车" /><br />
                    <span>购物车</span>
                </span>
            </a>
            <!--<a href="my.html">-->
            <a href="<?php echo U('User/index'); ?>">
                <span>
                    <img src="__STATIC__/images/icon_19.png" alt="个人中心" /><br />
                    <span>个人中心</span>
                </span>
            </a>
        </nav>
    </div>
    <!--菜单-end-->

    <!--广告位-start-->
    <!--<div class="banner ma-to-20">-->
        <!--<?php $pid =400;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1516269600 and end_time > 1516269600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
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
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>-->
            <!--<a href="<?php echo $v['ad_link']; ?>">-->
            <!--<img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>"/>-->
            <!--</a>-->
        <!--<?php endforeach; ?>-->
    <!--</div>-->
    <!--<div class="floor advertisement">-->
        <!--<div class="content">-->
            <!--<div class="le lefhe fl">-->
                <!--<?php $pid =301;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1516269600 and end_time > 1516269600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
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
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>-->
                    <!--<a href="<?php echo $v['ad_link']; ?>">-->
                        <!--<div class="td">-->
                            <!--<img src="<?php echo $v[ad_code]; ?>">-->
                        <!--</div>-->
                    <!--</a>-->
                <!--<?php endforeach; ?>-->
                <!--<?php $pid =302;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1516269600 and end_time > 1516269600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
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
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>-->
                    <!--<a href="<?php echo $v['ad_link']; ?>">-->
                        <!--<div class="td">-->
                            <!--<img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>">-->
                        <!--</div>-->
                    <!--</a>-->
                <!--<?php endforeach; ?>-->
            <!--</div>-->
            <!--<div class="le re fr">-->
                <!--<?php $pid =300;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1516269600 and end_time > 1516269600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
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
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>-->
                    <!--<a href="<?php echo $v['ad_link']; ?>">-->
                        <!--<div class="td">-->
                            <!--<img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>">-->
                        <!--</div>-->
                    <!--</a>-->
                <!--<?php endforeach; ?>-->

            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
    <!--广告位-end-->

    <!--新品上市-start-->
    <!--<div class="floor newshop">-->
        <!--<div class="banner">-->
            <!--<img src="__STATIC__/images/ind_22.jpg" alt="新品上市"/>-->
        <!--</div>-->
        <!--<div class="advertisement">-->
            <!--<div class="content">-->
                <!--<div class="le re fl">-->
                    <!--<?php $pid =303;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1516269600 and end_time > 1516269600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
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
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>-->
                        <!--<a href="<?php echo $v[ad_link]; ?>" >-->
                            <!--<div class="td">-->
                                <!--<img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>"/>-->
                            <!--</div>-->
                        <!--</a>-->
                    <!--<?php endforeach; ?>-->
                <!--</div>-->
                <!--<div class="le lefhe fr">-->
                    <!--<?php $pid =304;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1516269600 and end_time > 1516269600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("2")->select();
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


$c = 2- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
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
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>-->
                        <!--<a href="<?php echo $v[ad_link]; ?>" >-->
                            <!--<div class="td">-->
                                <!--<img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>"/>-->
                            <!--</div>-->
                        <!--</a>-->
                    <!--<?php endforeach; ?>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
    <!--新品上市-end-->

    <!--热销商品-start-->
    <!--<div class="floor hotshop index_hot">-->
        <!--<div class="banner">-->
            <!--<img src="__STATIC__/images/ind_33.jpg" alt="热销商品"/>-->
        <!--</div>-->
        <!--<div class="hotsome">-->
            <!--<div class="bloc hottop">-->
                <!--<?php $pid =305;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1516269600 and end_time > 1516269600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
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
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>-->
                    <!--<div class="le fl">-->
                        <!--<a href="<?php echo $v[ad_link]; ?>" >-->
                            <!--<div class="td">-->
                                <!--<img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>"/>-->
                            <!--</div>-->
                        <!--</a>-->
                    <!--</div>-->
                <!--<?php endforeach; ?>-->
                <!--<?php $pid =306;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1516269600 and end_time > 1516269600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("1")->select();
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
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>-->
                    <!--<div class="le fr">-->
                        <!--<a href="<?php echo $v[ad_link]; ?>" >-->
                            <!--<div class="td">-->
                                <!--<img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>"/>-->
                            <!--</div>-->
                        <!--</a>-->
                    <!--</div>-->
                <!--<?php endforeach; ?>-->
            <!--</div>-->
            <!--<div class="bloc">-->
                <!--<div class="le foura">-->
                    <!--<?php $pid =307;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->column("position_id,position_name,ad_width,ad_height","position_id");$result = M("ad")->where("pid=$pid  and enabled = 1 and start_time < 1516269600 and end_time > 1516269600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("4")->select();
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


$c = 4- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
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
foreach($result as $key=>$v):       
    
    $v[position] = $ad_position[$v[pid]]; 
    if(I("get.edit_ad") && $v[not_adv] == 0 )
    {
        $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]";        
        $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name];
        $v[target] = 0;
    }
    ?>-->
                        <!--<a href="<?php echo $v[ad_link]; ?>" >-->
                            <!--<img src="<?php echo $v[ad_code]; ?>" title="<?php echo $v[title]; ?>" style="<?php echo $v[style]; ?>"/>-->
                        <!--</a>-->
                    <!--<?php endforeach; ?>-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
    <!--热销商品-end-->

    <!--猜您喜欢-start-->
    <div class="floor guesslike"  id="pullrefresh" style="overflow-y: scroll;height: 100%;padding-bottom: 80px;">
        <div class="banner">
            <!--<img src="__STATIC__/images/ind_52.jpg" alt="猜您喜欢"/>-->
        </div>
        <div class="likeshop">
            <div id="J_ItemList">
                <ul class="product single_item info">
                   <?php if(is_array($favourite_goods) || $favourite_goods instanceof \think\Collection || $favourite_goods instanceof \think\Paginator): $i = 0; $__LIST__ = $favourite_goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
<li class='fll_acc'>
	<div class="similer-product products_kuang">
		<a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id])); ?>" title="<?php echo $v['goods_name']; ?>">
		<img src="<?php echo goods_thum_images($v[goods_id],400,400); ?>"/>
		<span class="similar-product-text"><?php echo getSubstr($v[goods_name],0,20); ?></span>
		</a>
		<span class="similar-product-price">
			¥<span class="big-price"><?php echo $v[shop_price]; ?></span>
			<a href="<?php echo U('Goods/goodsList',['id'=>$v['cat_id']]); ?>" title="<?php echo $v['goods_name']; ?>">
				<span class="guess-button J_ping">看相似</span>
			</a>
		</span>
	</div>
</li>
<?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <!--猜您喜欢-end-->

    <!--底部-start-->
    <footer>
    <div class="flool1">
        <ul>
            <?php if(!empty($_COOKIE['user_id'])): ?>
                <li><a href="<?php echo U('Mobile/User/index'); ?>"><?php echo getSubstr(urldecode($_COOKIE['uname']),0,3);?></a></li>
                <li><a href="<?php echo U('Mobile/User/logout'); ?>">退出</a></li>
            <?php else: ?>
                <li><a href="<?php echo U('Mobile/User/login'); ?>">登录</a></li>
                <li><a href="<?php echo U('Mobile/User/reg'); ?>">注册</a></li>
            <?php endif; ?>
            <li><a href="tel:<?php echo $tpshop_config['shop_info_phone']; ?>">反馈</a></li>
            <li class="comebackTop">回到顶部</li>
        </ul>
    </div>
    <div class="flool2">
        <ul>
            <li>
                <a href="?">
                    <div class="icon">
                        <img src="__STATIC__/images/ind_70.png"/>
                        <p>客户端</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('Mobile/Index/index'); ?>">
                    <div class="icon black">
                        <img src="__STATIC__/images/ind_72.png"/>
                        <p>触屏版</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('Home/Index/index'); ?>">
                    <div class="icon">
                        <img src="__STATIC__/images/ind_74.png"/>
                        <p>电脑版</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <!--<div class="flool3">-->
        <!--<p>Copyright © 2004-2016 TPshop开源商城99soubao.com版权所有</p>-->
    <!--</div>-->
</footer>
    <!--底部-end-->

    <!--底部导航-start-->
    <div class="foohi">
    <div class="footer">
        <ul>
            <li>
                <a <?php if(CONTROLLER_NAME == 'Index'): ?>class="yello" <?php endif; ?>  href="<?php echo U('Index/index'); ?>">
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
                <a <?php if(CONTROLLER_NAME == 'User'): ?>class="yello" <?php endif; ?> href="<?php echo U('User/index'); ?>">
                    <div class="icon">
                        <i class="icon-wode iconfont"></i>
                        <p>我的</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	  var cart_cn = getCookie('cn');
	  if(cart_cn == ''){
		$.ajax({
			type : "GET",
			url:"/index.php?m=Home&c=Cart&a=header_cart_list",//+tab,
			success: function(data){								 
				cart_cn = getCookie('cn');
				$('#cart_quantity').html(cart_cn);						
			}
		});	
	  }
	  $('#cart_quantity').html(cart_cn);
});
</script>
<!-- 微信浏览器 调用微信 分享js-->
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="__PUBLIC__/js/global.js"></script>
<script type="text/javascript">
<?php if(ACTION_NAME == 'goodsInfo'): ?>
   var ShareLink = "http://<?php echo $_SERVER[HTTP_HOST]; ?>/index.php?m=Mobile&c=Goods&a=goodsInfo&id=<?php echo $goods[goods_id]; ?>"; //默认分享链接
   var ShareImgUrl = "http://<?php echo $_SERVER[HTTP_HOST]; ?><?php echo goods_thum_images($goods[goods_id],400,400); ?>"; // 分享图标
<?php else: ?>
   var ShareLink = "http://<?php echo $_SERVER[HTTP_HOST]; ?>/index.php?m=Mobile&c=Index&a=index"; //默认分享链接
   var ShareImgUrl = "http://<?php echo $_SERVER[HTTP_HOST]; ?><?php echo $tpshop_config['shop_info_store_logo']; ?>"; //分享图标
<?php endif; ?>

var is_distribut = getCookie('is_distribut'); // 是否分销代理
var user_id = getCookie('user_id'); // 当前用户id
//alert(is_distribut+'=='+user_id);
// 如果已经登录了, 并且是分销商
if(parseInt(is_distribut) == 1 && parseInt(user_id) > 0)
{									
	ShareLink = ShareLink + "&first_leader="+user_id;									
}

$(function() {
	if(isWeiXin() && parseInt(user_id)>0){
		$.ajax({
			type : "POST",
			url:"/index.php?m=Mobile&c=Index&a=ajaxGetWxConfig&t="+Math.random(),
			data:{'askUrl':encodeURIComponent(location.href.split('#')[0])},		
			dataType:'JSON',
			success: function(res)
			{
				//微信配置
				wx.config({
				    debug: false, 
				    appId: res.appId,
				    timestamp: res.timestamp, 
				    nonceStr: res.nonceStr, 
				    signature: res.signature,
				    jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone','hideOptionMenu'] // 功能列表，我们要使用JS-SDK的什么功能
				});
			},
			error:function(){
				return false;
			}
		}); 

		// config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在 页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready 函数中。
		wx.ready(function(){
		    // 获取"分享到朋友圈"按钮点击状态及自定义分享内容接口
		    wx.onMenuShareTimeline({
		        title: "<?php echo (isset($goods['goods_name']) && ($goods['goods_name'] !== '')?$goods['goods_name']:$tpshop_config['shop_info_store_title']); ?>", // 分享标题
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
		    });

		    // 获取"分享给朋友"按钮点击状态及自定义分享内容接口
		    wx.onMenuShareAppMessage({
		        title: "<?php echo $tpshop_config['shop_info_store_title']; ?>", // 分享标题
		        desc: "<?php echo (isset($goods['goods_name']) && ($goods['goods_name'] !== '')?$goods['goods_name']:$tpshop_config['shop_info_store_desc']); ?>", // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
		    });
			// 分享到QQ
			wx.onMenuShareQQ({
		        title: "<?php echo $tpshop_config['shop_info_store_title']; ?>", // 分享标题
		        desc: "<?php echo (isset($goods['goods_name']) && ($goods['goods_name'] !== '')?$goods['goods_name']:$tpshop_config['shop_info_store_desc']); ?>", // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
			});	
			// 分享到QQ空间
			wx.onMenuShareQZone({
		        title: "<?php echo $tpshop_config['shop_info_store_title']; ?>", // 分享标题
		        desc: "<?php echo (isset($goods['goods_name']) && ($goods['goods_name'] !== '')?$goods['goods_name']:$tpshop_config['shop_info_store_desc']); ?>", // 分享描述
		        link:ShareLink,
		        imgUrl:ShareImgUrl // 分享图标
			});

		   <?php if(CONTROLLER_NAME == 'User'): ?> 
				wx.hideOptionMenu();  // 用户中心 隐藏微信菜单
		   <?php endif; ?>	
		});
	}
});

function isWeiXin(){
    var ua = window.navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i) == 'micromessenger'){
        return true;
    }else{
        return false;
    }
}
</script>
<!--微信关注提醒 start-->
<?php if(\think\Session::get('subscribe') == 0): endif; ?>
<button class="guide" style="display:none;" onclick="follow_wx()">关注公众号</button>
<style type="text/css">
.guide{width:1rem;height:4rem;text-align: center;border-radius: 0.2rem ;font-size:0.5rem;padding:0.2rem 0;border:1px solid #adadab;color:#000000;background-color: #fff;position: fixed;right: 0.1rem;bottom: 10rem;}
#cover{display:none;position:absolute;left:0;top:0;z-index:18888;background-color:#000000;opacity:0.7;}
#guide{display:none;position:absolute;top:0.1rem;z-index:19999;}
#guide img{width: 70%;height: auto;display: block;margin: 0 auto;margin-top: 0.2rem;}
</style>
<script type="text/javascript">
  //关注微信公众号二维码	 
function follow_wx()
{
	layer.open({
		type : 1,  
		title: '关注公众号',
		content: '<img src="<?php echo $wx_qr; ?>" width="100%">',
		style: ''
	});
}
  
$(function(){
	if(isWeiXin()){
		var subscribe = getCookie('subscribe'); // 是否已经关注了微信公众号		
		if(subscribe == 0)
			$('.guide').show();
	}else{
		$('.guide').hide();
	}
})
 
</script> 

<!--微信关注提醒  end-->
<!-- 微信浏览器 调用微信 分享js  end-->
    <!--底部导航-end-->
<script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/sourch_submit.js"  type="text/javascript" ></script>
<script type="text/javascript">
    /**
     * 秒杀模块倒计时
     * */
//    function GetRTime(end_time){
//        var NowTime = new Date();
//        var t = (end_time*1000) - NowTime.getTime();
//        var d=Math.floor(t/1000/60/60/24);
//        var h=Math.floor(t/1000/60/60%24);
//        var m=Math.floor(t/1000/60%60);
//        var s=Math.floor(t/1000%60);
//        if(s >= 0)
//            return (d * 24 + h) + '时' + m + '分' +s+'秒';
//    }
//    function GetRTime2(){
//        var text = GetRTime('<?php echo $end_time; ?>');
//        if (text== 0){
//            $(".hms").text('活动已结束');
//        }else{
//            $(".hms").text(text);
//        }
//    }
//    setInterval(GetRTime2,1000);

    /**
     * 继续加载猜您喜欢
     * */
    var before_request = 1; // 上一次请求是否已经有返回来, 有才可以进行下一次请求
    var page = 2;
    function ajax_sourch_submit(){
        if(before_request == 0)// 上一次请求没回来 不进行下一次请求
            return false;
        before_request = 0;
        page++;
        $.ajax({
            type : "get",
            url:"/index.php?m=Mobile&c=Index&a=ajaxGetMore&p="+page,
            success: function(data)
            {
                if(data){
                    $("#J_ItemList>ul").append(data);
                    before_request = 1;
                }else{
                    $('.get_more').hide();
                }
            }
        });
    }
</script>
	</body>
</html>
