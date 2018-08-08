<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:43:"./application/admin/view2/goods\_goods.html";i:1511157032;s:44:"./application/admin/view2/public\layout.html";i:1508133828;}*/ ?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link href="__PUBLIC__/static/css/main.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/css/page.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/font/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="__PUBLIC__/static/font/css/font-awesome-ie7.min.css">
<![endif]-->
<link href="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<link href="__PUBLIC__/static/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css"/>
<style type="text/css">html, body { overflow: visible;}</style>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/layer/layer.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
<script type="text/javascript" src="__PUBLIC__/static/js/admin.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.mousewheel.js"></script>
<script src="__PUBLIC__/js/myFormValidate.js"></script>
<script src="__PUBLIC__/js/myAjax2.js"></script>
<script src="__PUBLIC__/js/global.js"></script>
    <script type="text/javascript">
    function delfunc(obj){
    	layer.confirm('确认删除？', {
    		  btn: ['确定','取消'] //按钮
    		}, function(){
    		    // 确定
   				$.ajax({
   					type : 'post',
   					url : $(obj).attr('data-url'),
   					data : {act:'del',del_id:$(obj).attr('data-id')},
   					dataType : 'json',
   					success : function(data){
						layer.closeAll();
   						if(data==1){
   							layer.msg('操作成功', {icon: 1});
   							$(obj).parent().parent().parent().remove();
   						}else{
   							layer.msg(data, {icon: 2,time: 2000});
   						}
   					}
   				})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }
    
    function selectAll(name,obj){
    	$('input[name*='+name+']').prop('checked', $(obj).checked);
    }   
    
    function get_help(obj){
        layer.open({
            type: 2,
            title: '帮助手册',
            shadeClose: true,
            shade: 0.3,
            area: ['70%', '80%'],
            content: $(obj).attr('data-url'), 
        });
    }
    
    function delAll(obj,name){
    	var a = [];
    	$('input[name*='+name+']').each(function(i,o){
    		if($(o).is(':checked')){
    			a.push($(o).val());
    		}
    	})
    	if(a.length == 0){
    		layer.alert('请选择删除项', {icon: 2});
    		return;
    	}
    	layer.confirm('确认删除？', {btn: ['确定','取消'] }, function(){
    			$.ajax({
    				type : 'get',
    				url : $(obj).attr('data-url'),
    				data : {act:'del',del_id:a},
    				dataType : 'json',
    				success : function(data){
						layer.closeAll();
    					if(data == 1){
    						layer.msg('操作成功', {icon: 1});
    						$('input[name*='+name+']').each(function(i,o){
    							if($(o).is(':checked')){
    								$(o).parent().parent().remove();
    							}
    						})
    					}else{
    						layer.msg(data, {icon: 2,time: 2000});
    					}
    				}
    			})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);	
    }
</script>  

</head>
<!--物流配置 css -start-->
<style>
    ul.group-list {
        width: 96%;min-width: 1000px; margin: auto 5px;list-style: disc outside none;
    }
    ul.group-list li {
        white-space: nowrap;float: left;
        width: 150px; height: 25px;
        padding: 3px 5px;list-style-type: none;
        list-style-position: outside;border: 0px;margin: 0px;
    }
    .row .table-bordered td .btn,.row .table-bordered td img{
        vertical-align: middle;
    }
    .row .table-bordered td{
      padding: 8px;
      line-height: 1.42857143;
    }
    .table-bordered{
      width: 100%
    }
    .table-bordered tr td{
      border: 1px solid #f4f4f4;
    }
    .btn-success {
        color: #fff;background-color: #449d44;border-color: #398439 solid 1px;
    }
    .btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}
.col-xs-8 {
    width: 66.66666667%;
}
.col-xs-4 {
    width: 33.33333333%;
}
.col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
    float: left;
}
.row .tab-pane h4{
  padding: 10px 0;
}
.row .tab-pane h4 input{
  vertical-align: middle;
}
.table-striped>tbody>tr:nth-of-type(odd) {
    background-color: #f9f9f9;
}
.ncap-form-default .title{
  border-bottom: 0
}
.ncap-form-default dl.row, .ncap-form-all dd.opt{
    /*border-color: #F0F0F0;*/
    border: none;
}
.ncap-form-default dl.row:hover, .ncap-form-all dd.opt:hover{
    border: none;box-shadow: inherit;
}
.addprine{display: inline; }
.alisth{margin-top: 10px}
.p_plus strong{cursor: pointer;margin-left: 4px;}
</style>
<!--物流配置 css -end-->
<!--以下是在线编辑器 代码 -->
<script type="text/javascript" src="__ROOT__/public/plugins/Ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="__ROOT__/public/plugins/Ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="__ROOT__/public/plugins/Ueditor/lang/zh-cn/zh-cn.js"></script>
<!--以上是在线编辑器 代码  end-->
<body style="background-color: #FFF; overflow: auto;">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>商品设置</h3>
                <h5>商品基本信息设置</h5>
            </div>
            <ul class="tab-base nc-row">
                <li><a href="javascript:void(0);" data-index='1' class="tab current"><span>通用信息</span></a></li>
                <li><a href="javascript:void(0);" data-index='2' class="tab"><span>商品相册</span></a></li>
                <li><a href="javascript:void(0);" data-index='3' class="tab"><span>商品模型</span></a></li>
                <li><a href="javascript:void(0);" data-index='4' class="tab"><span>商品物流</span></a></li>
                <li><a href="javascript:void(0);" data-index='5' class="tab"><span>积分折扣</span></a></li>
            </ul>
        </div>
    </div>
    <!-- 操作说明 -->
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示"></span> </div>
        <ul>
            <li>请务必正确填写商品信息</li>
        </ul>
    </div>
    <!--表单数据-->
    <form  method ="post" id="addEditGoodsForm">
        <input type="hidden" value="<?php echo \think\Request::instance()->param('is_distribut'); ?>" name="is_distribut" class="input-txt"/>
<!--通用信息-->
        <div class="ncap-form-default tab_div_1">
            <dl class="row">
                <dt class="tit">
                    <label>购买对象</label>
                </dt>
                <dd class="opt">
                    <div class="onoff">
                        <label for="buy_obj1" class="cb-enable <?php if($goodsInfo[buy_obj] == 1): ?>selected<?php endif; ?>">全部会员</label>
                        <label for="buy_obj0" class="cb-disable <?php if($goodsInfo[buy_obj] == 0): ?>selected<?php endif; ?>">VIP会员</label>
                        <input id="buy_obj1" name="buy_obj" value="1" type="radio" <?php if($goodsInfo[buy_obj] == 1): ?> checked="checked"<?php endif; ?>>
                        <input id="buy_obj0" name="buy_obj" value="0" type="radio" <?php if($goodsInfo[buy_obj] == 0): ?> checked="checked"<?php endif; ?>>
                    </div>
                    <p class="notic"></p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>是否支持分期</label>
                </dt>
                <dd class="opt">
                    <div class="onoff">
                        <label for="is_fenqi1" class="cb-enable <?php if($goodsInfo[is_fenqi] == 1): ?>selected<?php endif; ?>">是</label>
                        <label for="is_fenqi0" class="cb-disable <?php if($goodsInfo[is_fenqi] == 0): ?>selected<?php endif; ?>">否</label>
                        <input id="is_fenqi1" class="enable" name="is_fenqi" value="1" type="radio" <?php if($goodsInfo[is_fenqi] == 1): ?> checked="checked"<?php endif; ?>>
                        <input id="is_fenqi0" class="enable" name="is_fenqi" value="0" type="radio" <?php if($goodsInfo[is_fenqi] == 0): ?> checked="checked"<?php endif; ?>>

                    </div>
                    <p class="notic"></p>
                </dd>
            </dl>


                <dl class="row percent" style="display: none">
                    <dt class="tit">
                        <label>现金支付比例</label>
                    </dt>
                    <dd class="opt">
                        <input type="text" name="percent" id="percent" value="<?php echo $goodsInfo['percent']; ?>" onchange="percent_bili(this.value)"><span>%</span>
                        <p class="notic"></p>
                    </dd>
                </dl>


            <dl class="row fenqi_num" style="display: none">
                <dt class="tit">
                    <label>分期最低购买数量</label>
                </dt>
                <dd class="opt">
                    <input type="text" name="fenqi_num" id="fenqi_num" value="<?php echo $goodsInfo['fenqi_num']; ?>">
                    <p class="notic"></p>
                </dd>
            </dl>
            <dl class="row fan_num" >
                <dt class="tit">
                    <label>返点比例</label>
                </dt>
                <dd class="opt">
                    <input type="text" name="rebates" id="rebates" value="<?php echo $goodsInfo['rebates']; ?>">%
                    <p class="notic"></p>
                </dd>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label>是否包邮</label>
                </dt>
                <dd class="opt">
                    <div class="onoff">
                        <label for="is_free_shipping1" class="cb-enable <?php if($goodsInfo[is_free_shipping] == 1): ?>selected<?php endif; ?>">是</label>
                        <label for="is_free_shipping0" class="cb-disable <?php if($goodsInfo[is_free_shipping] == 0): ?>selected<?php endif; ?>">否</label>
                        <input id="is_free_shipping1" name="is_free_shipping" value="1" type="radio" <?php if($goodsInfo[is_free_shipping] == 1): ?> checked="checked"<?php endif; ?>>
                        <input id="is_free_shipping0" name="is_free_shipping" value="0" type="radio" <?php if($goodsInfo[is_free_shipping] == 0): ?> checked="checked"<?php endif; ?>>
                    </div>
                    <p class="notic"></p>
                </dd>
            </dl>


            <dl class="row">
                <dt class="tit">
                    <label for="record_no">商品名称</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $goodsInfo['goods_name']; ?>" name="goods_name" class="input-txt"/>
                    <span class="err" id="err_goods_name" style="color:#F00; display:none;"></span>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="store_name">商品简介</label>
                </dt>
                <dd class="opt">
                    <textarea rows="3" cols="80" name="goods_remark" class="input-txt"><?php echo $goodsInfo['goods_remark']; ?></textarea>
                    <span id="err_goods_remark" class="err" style="color:#F00; display:none;"></span>
                </dd>
            </dl>
			<dl class="row">
                <dt class="tit">
                    <label for="record_no">商品货号</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $goodsInfo['goods_sn']; ?>" name="goods_sn" class="input-txt"/>
                    <span class="err" id="err_goods_sn" style="color:#F00; display:none;"></span>
                    <p class="notic">如果不填会自动生成</p>
                </dd>
            </dl>
            <!--<dl class="row">-->
                <!--<dt class="tit">-->
                    <!--<label for="record_no">SPU</label>-->
                <!--</dt>-->
                <!--<dd class="opt">-->
                    <!--<input type="text" value="<?php echo $goodsInfo['SPU']; ?>" name="SPU" class="input-txt"/>-->
                    <!--<span class="err" id="err_SPU" style="color:#F00; display:none;"></span>-->
                <!--</dd>-->
            <!--</dl>    -->
            <!--<dl class="row">-->
                <!--<dt class="tit">-->
                    <!--<label for="record_no">SKU</label>-->
                <!--</dt>-->
                <!--<dd class="opt">-->
                    <!--<input type="text" value="<?php echo $goodsInfo['SKU']; ?>" name="SKU" class="input-txt"/>-->
                    <!--<span class="err" id="err_SKU" style="color:#F00; display:none;"></span>-->
                <!--</dd>-->
            <!--</dl> -->
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">商品分类</label>
                </dt>
                <dd class="opt">
                      <select name="cat_id" id="cat_id"  class="small form-control">
                        <option value="0">请选择商品分类</option>
                             <?php if(is_array($cat_list) || $cat_list instanceof \think\Collection || $cat_list instanceof \think\Paginator): if( count($cat_list)==0 ) : echo "" ;else: foreach($cat_list as $k=>$v): ?>
                               <option value="<?php echo $v['id']; ?>" <?php if($v['id'] == $level_cat['1']): ?>selected="selected"<?php endif; ?> >
                                    <?php echo $v['name']; ?>
                               </option>
                             <?php endforeach; endif; else: echo "" ;endif; ?>
                      </select>
                      <select name="cat_id_2" id="cat_id_2" onChange="get_category(this.value,'cat_id_3','0');" class="small form-control">
                        <option value="0">请选择商品分类</option>
                      </select>
                      <select name="cat_id_3" id="cat_id_3" class="small form-control">
                        <option value="0">请选择商品分类</option>
                      </select>
                    <span class="err" id="err_cat_id" style="color:#F00; display:none;"></span>
                </dd>
            </dl>
            <!--<dl class="row">-->
                <!--<dt class="tit">-->
                    <!--<label for="record_no">扩展分类</label>-->
                <!--</dt>-->
                <!--<dd class="opt">-->
                  <!--<select name="extend_cat_id" id="extend_cat_id" class="small form-control">-->
                    <!--<option value="0">请选择商品分类</option>-->
                         <!--<?php if(is_array($cat_list) || $cat_list instanceof \think\Collection || $cat_list instanceof \think\Paginator): if( count($cat_list)==0 ) : echo "" ;else: foreach($cat_list as $k=>$v): ?>-->
                           <!--<option value="<?php echo $v['id']; ?>" <?php if($v['id'] == $level_cat2['1']): ?>selected="selected"<?php endif; ?> >-->
                                <!--<?php echo $v['name']; ?>-->
                           <!--</option>-->
                         <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                  <!--</select>-->
                  <!--<select name="extend_cat_id_2" id="extend_cat_id_2" onChange="get_category(this.value,'extend_cat_id_3','0');" class="small form-control">-->
                    <!--<option value="0">请选择商品分类</option>-->
                  <!--</select>-->
                  <!--<select name="extend_cat_id_3" id="extend_cat_id_3" class="small form-control">-->
                    <!--<option value="0">请选择商品分类</option>-->
                  <!--</select>-->
                    <!--<span class="err" id="extend_cat_id" style="color:#F00; display:none;"></span>-->
                <!--</dd>-->
            <!--</dl>-->
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">商品品牌</label>
                </dt>
                <dd class="opt">
                <select name="brand_id" id="brand_id"  class="small form-control">
                         <option value="">所有品牌</option>
                        <?php if(is_array($brandList) || $brandList instanceof \think\Collection || $brandList instanceof \think\Paginator): if( count($brandList)==0 ) : echo "" ;else: foreach($brandList as $k=>$v): ?>
                           <option value="<?php echo $v['id']; ?>"  <?php if($v['id'] == $goodsInfo['brand_id']): ?>selected="selected"<?php endif; ?>>
                                <?php echo $v['name']; ?>
                           </option>
                         <?php endforeach; endif; else: echo "" ;endif; ?>
                  </select>
                </dd>
            </dl>
			<dl class="row">
                <dt class="tit">
                    <label for="record_no">供应商</label>
                </dt>
                <dd class="opt">
                <select name="suppliers_id" id="suppliers_id" class="small form-control">
                    <option value="0">不指定供应商属于本店商品</option>
                    <?php if(is_array($suppliersList) || $suppliersList instanceof \think\Collection || $suppliersList instanceof \think\Paginator): if( count($suppliersList)==0 ) : echo "" ;else: foreach($suppliersList as $k=>$v): ?>
                        <option value="<?php echo $v['suppliers_id']; ?>"  <?php if($v['suppliers_id'] == $goodsInfo['suppliers_id']): ?>selected="selected"<?php endif; ?>>
                        <?php echo $v['suppliers_name']; ?>
                        </option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">本店售价</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $goodsInfo['shop_price']; ?>" name="shop_price" class="t_mane" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />
                    <span class="err" id="err_shop_price" style="color:#F00; display:none;"></span>
                </dd>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label for="record_no">市场价</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $goodsInfo['market_price']; ?>" name="market_price" class="t_mane" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />
                    <span class="err" id="err_market_price" style="color:#F00; display:none;"></span>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">成本价</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $goodsInfo['cost_price']; ?>" name="cost_price" class="t_mane" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />
                    <span class="err" id="err_cost_price" style="color:#F00; display:none;"></span>
                </dd>
            </dl>
            <!--<dl class="row">-->
                <!--<dt class="tit">-->
                    <!--<label for="record_no">佣金</label>-->
                <!--</dt>-->
                <!--<dd class="opt">-->
                    <!--<input type="text" value="<?php echo $goodsInfo['commission']; ?>" name="commission" class="t_mane" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />-->
                    <!--<span class="err" id="err_commission" style="color:#F00; display:none;"></span>-->
                    <!--<p class="notic">用于分销的分成金额</p>-->
                <!--</dd>-->
            <!--</dl>-->

            <dl class="row">
                <dt class="tit">
                    <label>图片上传</label>
                </dt>
                <dd class="opt">
                    <div class="input-file-show">
            <span class="show">
                <a id="img_a" target="_blank" class="nyroModal" rel="gal" href="<?php echo $goodsInfo['original_img']; ?>">
                    <i id="img_i" class="fa fa-picture-o" onMouseOver="layer.tips('<img src=<?php echo $goodsInfo['original_img']; ?>>',this,{tips: [1, '#fff']});" onMouseOut="layer.closeAll();"></i>
                </a>
            </span>
            <span class="type-file-box">
                <input type="text" id="imagetext" name="original_img" value="<?php echo $goodsInfo['original_img']; ?>" class="type-file-text">
                <input type="button" name="button" id="button1" value="选择上传..." class="type-file-button">
                <input class="type-file-file" onClick="GetUploadify(1,'','goods','img_call_back')" size="30" hidefocus="true" nc_type="change_site_logo" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
            </span>
                    </div>
                    <span class="err"></span>
                    <p class="notic">请上传图片格式文件</p>
                </dd>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label for="record_no">商品重量</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $goodsInfo['weight']; ?>" name="weight" class="t_mane" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />
                    <span class="err" id="err_weight" style="color:#F00; display:none;"></span>
                    <p class="notic"> 务必设置商品重量, 用于计算物流费.以克为单位</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">总库存</label>
                </dt>
                <dd class="opt">
                    <?php if($goodsInfo[goods_id] > 0): ?>
                        <input type="text" value="<?php echo $goodsInfo['store_count']; ?>" class="t_mane" name="store_count" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />
                    <?php else: ?>
                        <input type="text" value="<?php echo $tpshop_config[basic_default_storage]; ?>" class="t_mane" name="store_count" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />
                    <?php endif; ?>
                    <span class="err" id="err_store_count" style="color:#F00; display:none;"></span>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">商品关键词</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $goodsInfo['keywords']; ?>" name="keywords" class="input-txt"/>
                    <span class="err" id="err_keywords" style="color:#F00; display:none;"></span>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="record_no">商品详情描述</label>
                </dt>
                <dd class="opt">
                    <textarea class="span12 ckeditor" id="goods_content" name="goods_content" title=""><?php echo $goodsInfo['goods_content']; ?></textarea>
                    <span class="err" id="err_goods_content" style="color:#F00; display:none;"></span>
                </dd>
            </dl>
        </div>
<!--通用信息-->
<!-- 商品相册-->
		<div class="ncap-form-default tab_div_2" style="display:none;">
            <dl class="row">
                 <div class="tab-pane" id="tab_goods_images">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>
                            <?php if(is_array($goodsImages) || $goodsImages instanceof \think\Collection || $goodsImages instanceof \think\Paginator): if( count($goodsImages)==0 ) : echo "" ;else: foreach($goodsImages as $k=>$vo): ?>
                                <div style="width:100px; text-align:center; margin: 5px; display:inline-block;" class="goods_xc">
                                    <input type="hidden" value="<?php echo $vo['image_url']; ?>" name="goods_images[]">
                                    <a onClick="" href="<?php echo $vo['image_url']; ?>" target="_blank"><img width="100" height="100" src="<?php echo $vo['image_url']; ?>"></a>
                                    <br>
                                    <a href="javascript:void(0)" onClick="ClearPicArr2(this,'<?php echo $vo['image_url']; ?>')">删除</a>
                                </div>
                            <?php endforeach; endif; else: echo "" ;endif; ?>

                                <div class="goods_xc" style="width:100px; text-align:center; margin: 5px; display:inline-block;">
                                    <input type="hidden" name="goods_images[]" value="" />
                                    <a href="javascript:void(0);" onClick="GetUploadify(10,'','goods','call_back2');"><img src="/public/images/add-button.jpg" width="100" height="100" /></a>
                                    <br/>
                                    <a href="javascript:void(0)">&nbsp;&nbsp;</a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </dl>
        </div>
<!-- 商品相册-->
<!-- 商品模型-->
		<div class="ncap-form-default tab_div_3" style="display:none;">
            <dl class="row">
                        <div class="tab-pane" id="tab_goods_spec">
                            <table class="table table-bordered" id="goods_spec_table">
                                <tr>
                                    <td>商品模型:</td>
                                    <td>
                                      <select name="goods_type" id="spec_type" class="form-control" style="width:250px;">
                                        <option value="0">选择商品模型</option>
                                        <?php if(is_array($goodsType) || $goodsType instanceof \think\Collection || $goodsType instanceof \think\Paginator): if( count($goodsType)==0 ) : echo "" ;else: foreach($goodsType as $k=>$vo): ?>
                                            <option value="<?php echo $vo['id']; ?>"<?php if($goodsInfo[goods_type] == $vo[id]): ?> selected="selected" <?php endif; ?> ><?php echo $vo['name']; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                      </select>
                                    </td>
                                </tr>
                            </table>
                            <div class="row">
                            	<!-- ajax 返回规格-->
                            	<div id="ajax_spec_data" class="col-xs-8" ></div>
                            	<div id="" class="col-xs-4" >
                            	    <table class="table table-bordered" id="goods_attr_table">
		                                <tr>
		                                    <td><b>商品属性</b>：</td>
		                                </tr>
		                            </table>
                            	</div>
                            </div>
                        </div>
            </dl>
        </div>
<!-- 商品模型-->
<!-- 商品物流-->
		<div class="ncap-form-default tab_div_4" style="display:none;">
            <dl class="row">
                        <div class="tab-pane" id="tab_goods_shipping">
                            <h4><b>物流配送：</b><input type="checkbox" onClick="choosebox(this)">全选</h4>
                            <table class="table table-bordered table-striped dataTable" id="goods_shipping_table">
                                <?php if(is_array($plugin_shipping) || $plugin_shipping instanceof \think\Collection || $plugin_shipping instanceof \think\Paginator): if( count($plugin_shipping)==0 ) : echo "" ;else: foreach($plugin_shipping as $kk=>$shipping): ?>
                                    <tr>
                                        <td class="title left" style="padding-right:50px;">
                                            <b><?php echo $shipping[name]; ?>：</b>
                                            <label class="right"><input type="checkbox" value="1" cka="mod-<?php echo $kk; ?>">全选</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <ul class="group-list">
                                                <?php if(is_array($shipping_area) || $shipping_area instanceof \think\Collection || $shipping_area instanceof \think\Paginator): if( count($shipping_area)==0 ) : echo "" ;else: foreach($shipping_area as $key=>$vv): if($vv[shipping_code] == $shipping[code]): ?>
                                                        <li><label><input type="checkbox" name="shipping_area_ids[]" value="<?php echo $vv['shipping_area_id']; ?>" <?php if(in_array($vv['shipping_area_id'],$goods_shipping_area_ids)): ?>checked='checked='<?php endif; ?> ck="mod-<?php echo $kk; ?>"><?php echo $vv['shipping_area_name']; ?></label></li>
                                                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                                <div class="clear-both"></div>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </table>
                        </div>
            </dl>
        </div>
<!-- 商品物流-->
<!--积分折扣-->
		<div class="ncap-form-default tab_div_5" style="display:none;">
            <dl class="row">
                <dt class="tit">
                    <label>价格阶梯</label>
                </dt>
                <dd class="opt">
                    <div class="alisth0" id="alisth_0">
                        单次购买个数达到<input type="text" class="input-number addprine" name="ladder_amount[]" <?php if($goodsInfo['price_ladder']): ?>value="<?php echo $goodsInfo['price_ladder'][0]['amount']; ?>"<?php endif; ?> onpaste="this.value=this.value.replace(/[^\d.]/g,'')" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" style="width: 100px;" >&nbsp;
                        价格<input type="text" class="input-number addprine" name="ladder_price[]"  <?php if($goodsInfo['price_ladder']): ?>value="<?php echo $goodsInfo['price_ladder'][0]['price']; ?>"<?php endif; ?> onpaste="this.value=this.value.replace(/[^\d.]/g,'')" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" style="width: 100px;" >
                        <a class="p_plus" href="javascript:;"><strong>[+]</strong></a>
                    </div>
                    <?php if(is_array($goodsInfo['price_ladder']) || $goodsInfo['price_ladder'] instanceof \think\Collection || $goodsInfo['price_ladder'] instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($goodsInfo['price_ladder']) ? array_slice($goodsInfo['price_ladder'],1,null, true) : $goodsInfo['price_ladder']->slice(1,null, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <div class="alisth">
                            单次购买个数达到<input type="text" class="input-number addprine" name="ladder_amount[]" value="<?php echo $vo['amount']; ?>" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')" style="width: 100px;" >&nbsp;
                            价格<input type="text" class="input-number addprine" name="ladder_price[]" value="<?php echo $vo['price']; ?>" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')" style="width: 100px;" >
                            <a class="p_plus" onclick='$(this).parent().remove();'><strong>[-]</strong></a>
                        </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <!--<span class="err" style="color:#F00;"></span>-->
                </dd>
                <script>
                    $(function(){
                        $('.p_plus').click(function() {
                            var html = "<div class='alisth'>"
                                    + "单次购买个数达到"
                                    + "<input type='text' class='input-number addprine' name='ladder_amount[]' style='width: 100px;' value=''/>"
                                    + "&nbsp;&nbsp;价格"
                                    + "<input type='text' class='input-number addprine' name='ladder_price[]' style='width: 100px;' value=''>"
                                    + "<a class='p_plus' onclick='$(this).parent().remove();'>&nbsp;<strong>[-]</strong></a>"
                                    + "</div>";
                            $('#alisth_0').after(html);
                        });
                    })
                </script>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label for="record_no">赠送积分</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $goodsInfo['give_integral']; ?>" name="give_integral" class="t_mane" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />	订单完成后赠送积分
                    <span class="err" id="err_give_integral" style="color:#F00; display:none;"></span>
                </dd>
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label for="record_no">兑换积分</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $goodsInfo['exchange_integral']; ?>" name="exchange_integral" class="t_mane" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" />	如果设置0，则不支持积分抵扣
                    <span class="err" id="err_exchange_integral" style="color:#F00; display:none;"></span>
                </dd>
            </dl>

        </div>

		<div class="ncap-form-default">
            <div class="bot">
                <input type="hidden" name="goods_id" value="<?php echo $goodsInfo['goods_id']; ?>">
                <input type="hidden" name="__token__" value="<?php echo \think\Request::instance()->token(); ?>" />
                <a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onClick="ajax_submit_form('addEditGoodsForm','<?php echo U('Goods/addEditGoods?is_ajax=1'); ?>');">确认提交</a>
            </div>
        </div>
     </form>
    <!--表单数据-->
</div>
<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
<script>
    //分期比例默认显示/隐藏
    $(function(){
        var  check = "<?php echo $goodsInfo['is_fenqi']; ?>";
        if(check == 1){
            $('.percent').css('display','block');
            $('.fenqi_num').css('display','block');
        }else{
            $('.fenqi_num').css('display','none');
        }

    })
    //选择分期,分期比例显示 反之隐藏
    $(".enable").on('click',function(){
        var num = $(this).val();
        if(num == 1){
            $('.percent').css('display','block');
            $('.fenqi_num').css('display','block');
        }else{
            $('.percent').css('display','none');
            $('.fenqi_num').css('display','none');
        }
    })
    /**
     *检测分期比例的正确性
     */
    function  percent_bili(val){
        if(val <= 100){
            var reg=/(^[1-9]{1}[0-9]*$)|(^[0-9]*\.[0-9]{2}$)/;
            if(!reg.test(val)){
                $("#percent").val('');
                layer.msg('请输入有效的比例值,比如:8 ; 8.8 ; 8.88',{icon:5});
            }
        }else{
            $("#percent").val('');
            layer.msg('请输入有效的比例值,比如:8 ; 8.8 ; 8.88',{icon:5});
        }
    }


    //选择分类
    $(function(){
        $(document).on("change",'#cat_id',function(){
            get_category($(this).val(),'cat_id_2','0');
            $('#cat_id_3').empty().html("<option value='0'>请选择商品分类</option>");
        })
    })
    $(function(){
        $(document).on("change",'#extend_cat_id',function(){
            get_category($(this).val(),'extend_cat_id_2','0');
            $('#extend_cat_id_3').empty().html("<option value='0'>请选择商品分类</option>");
        })
    })
    // 物流设置相 关
     $(document).ready(function(){
        $(":checkbox[cka]").click(function(){
            var $cks = $(":checkbox[ck='"+$(this).attr("cka")+"']");
            if($(this).is(':checked')){
                $cks.each(function(){$(this).prop("checked",true);});
            }else{
                $cks.each(function(){$(this).removeAttr('checked');});
            }
        });
    });

     var url="<?php echo url('Admin/Ueditor/index',array('savePath'=>'goods')); ?>";
     var ue = UE.getEditor('goods_content',{
         serverUrl :url,
         zIndex: 999,
         initialFrameWidth: "100%", //初化宽度
         initialFrameHeight: 300, //初化高度
         focus: false, //初始化时，是否让编辑器获得焦点true或false
         maximumWords: 99999, removeFormatAttributes: 'class,style,lang,width,height,align,hspace,valign',//允许的最大字符数 'fullscreen',
         pasteplain:false, //是否默认为纯文本粘贴。false为不使用纯文本粘贴，true为使用纯文本粘贴
         autoHeightEnabled: true
     });

    // 物流设置相 关
    function choosebox(o){
        var vt = $(o).is(':checked');
        if(vt){
            $('input[type=checkbox]').prop('checked',vt);
        }else{
            $('input[type=checkbox]').removeAttr('checked');
        }
    }
    /*
     * 以下是图片上传方法
     */
    // 上传商品图片成功回调函数
    function call_back(fileurl_tmp){
        $("#original_img").val(fileurl_tmp);
    	$("#original_img2").attr('href', fileurl_tmp);
    }

    // 上传商品相册回调函数
    function call_back2(paths){

        var  last_div = $(".goods_xc:last").prop("outerHTML");
        for (i=0;i<paths.length ;i++ )
        {
            $(".goods_xc:eq(0)").before(last_div);	// 插入一个 新图片
                $(".goods_xc:eq(0)").find('a:eq(0)').attr('href',paths[i]).attr('onclick','').attr('target', "_blank");// 修改他的链接地址
            $(".goods_xc:eq(0)").find('img').attr('src',paths[i]);// 修改他的图片路径
                $(".goods_xc:eq(0)").find('a:eq(1)').attr('onclick',"ClearPicArr2(this,'"+paths[i]+"')").text('删除');
            $(".goods_xc:eq(0)").find('input').val(paths[i]); // 设置隐藏域 要提交的值
        }
    }
    /*
     * 上传之后删除组图input     
     * @access   public
     * @val      string  删除的图片input
     */
    function ClearPicArr2(obj,path)
    {
    	$.ajax({
                    type:'GET',
                    url:"<?php echo U('Admin/Uploadify/delupload'); ?>",
                    data:{action:"del", filename:path},
                    success:function(){
                           $(obj).parent().remove(); // 删除完服务器的, 再删除 html上的图片
                    }
		});
		// 删除数据库记录
    	$.ajax({
                    type:'GET',
                    url:"<?php echo U('Admin/Goods/del_goods_images'); ?>",
                    data:{filename:path},
                    success:function(){
                          //
                    }
		});
    }


/** 以下 商品属性相关 js*/

// 属性输入框的加减事件
function addAttr(a)
{
	var attr = $(a).parent().parent().prop("outerHTML");
	attr = attr.replace('addAttr','delAttr').replace('+','-');
	$(a).parent().parent().after(attr);
}
// 属性输入框的加减事件
function delAttr(a)
{
   $(a).parent().parent().remove();
}


/** 以下 商品规格相关 js*/
$(document).ready(function(){
    // 商品模型切换时 ajax 调用  返回不同的属性输入框
    $("#spec_type").change(function(){
        var goods_id = '<?php echo $goodsInfo['goods_id']; ?>';
        var spec_type = $(this).val();
            $.ajax({
                    type:'GET',
                    data:{goods_id:goods_id,spec_type:spec_type},
                    url:"<?php echo U('admin/Goods/ajaxGetSpecSelect'); ?>",
                    success:function(data){
                           $("#ajax_spec_data").html('')
                           $("#ajax_spec_data").append(data);
			   ajaxGetSpecInput();	// 触发完  马上触发 规格输入框
                    }
            });
            //商品类型切换时 ajax 调用  返回不同的属性输入框     
            $.ajax({
                 type:'GET',
                 data:{goods_id:goods_id,type_id:spec_type},
                 url:"/index.php/admin/Goods/ajaxGetAttrInput",
                 success:function(data){
                         $("#goods_attr_table tr:gt(0)").remove()
                         $("#goods_attr_table").append(data);
                 }
           });
    });
	// 触发商品规格
	$("#spec_type").trigger('change');

    $("input[name='exchange_integral']").blur(function(){
        var shop_price = parseInt($("input[name='shop_price']").val());
        var exchange_integral = parseInt($(this).val());
        if (shop_price * 100 < exchange_integral) {

        }
    });
});

/** 以下是编辑时默认选中某个商品分类*/
$(document).ready(function(){

	<?php if($level_cat['2'] > 0): ?>
		 // 商品分类第二个下拉菜单
		 get_category('<?php echo $level_cat[1]; ?>','cat_id_2','<?php echo $level_cat[2]; ?>');
	<?php endif; if($level_cat['3'] > 0): ?>
		// 商品分类第二个下拉菜单
		 get_category('<?php echo $level_cat[2]; ?>','cat_id_3','<?php echo $level_cat[3]; ?>');
	<?php endif; ?>

    //  扩展分类
	<?php if($level_cat2['2'] > 0): ?>
		 // 商品分类第二个下拉菜单
		 get_category('<?php echo $level_cat2[1]; ?>','extend_cat_id_2','<?php echo $level_cat2[2]; ?>');
	<?php endif; if($level_cat2['3'] > 0): ?>
		// 商品分类第二个下拉菜单
		 get_category('<?php echo $level_cat2[2]; ?>','extend_cat_id_3','<?php echo $level_cat2[3]; ?>');
	<?php endif; ?>

});


    $(document).ready(function(){
        //插件切换列表
        $('.tab-base').find('.tab').click(function(){
            $('.tab-base').find('.tab').each(function(){
                $(this).removeClass('current');
            });
            $(this).addClass('current');
			var tab_index = $(this).data('index');
			$(".tab_div_1, .tab_div_2, .tab_div_3, .tab_div_4,.tab_div_5").hide();
			$(".tab_div_"+tab_index).show();
		});

    });

    function img_call_back(fileurl_tmp)
    {
        $("#imagetext").val(fileurl_tmp);
        $("#img_a").attr('href', fileurl_tmp);
        $("#img_i").attr('onmouseover', "layer.tips('<img src="+fileurl_tmp+">',this,{tips: [1, '#fff']});");
    }
</script>
</body>
</html>