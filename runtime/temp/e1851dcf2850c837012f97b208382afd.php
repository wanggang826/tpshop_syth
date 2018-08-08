<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:47:"./application/admin/view2/order\edit_order.html";i:1508133827;s:44:"./application/admin/view2/public\layout.html";i:1508133828;}*/ ?>
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
  
<style type="text/css">
html, body {
	overflow: visible;
}

a.btn {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #f5f5f5;
    border-radius: 4px;
    color: #999;
    cursor: pointer !important;
    display: inline-block;
    font-size: 12px;
    font-weight: normal;
    height: 20px;
    letter-spacing: normal;
    line-height: 20px;
    margin: 0 5px 0 0;
    padding: 1px 6px;
    vertical-align: top;
}

 a.red:hover {
    background-color: #e84c3d;
    border-color: #c1392b;
    color: #fff;
}

</style>  
<body style="background-color: #FFF; overflow: auto;">
<div id="toolTipLayer" style="position: absolute; z-index: 9999; display: none; visibility: visible; left: 95px; top: 573px;"></div>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title"><a class="back" href="javascript:history.back();" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3>修改订单</h3>
        <h5>修改订单商品信息和收货人信息</h5>
      </div>
    </div>
  </div>
  <form class="form-horizontal" action="<?php echo U('Admin/Order/edit_order'); ?>" id="order-add" method="post">    
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label><em></em>订单总额</label>
        </dt>
        <dd class="opt">
          <strong><?php echo $order['total_amount']; ?></strong>(商品总价:<?php echo $order['goods_price']; ?> 运费:<?php echo $order['shipping_price']; ?>)
          <span class="err"></span>
          <p class="notic">订单总额=商品总价+运费 </p>
        </dd>
      </dl>
	  <dl class="row">
        <dt class="tit">
          <label for="consignee">收货人</label>
        </dt>
        <dd class="opt">
          <input type="text" name="consignee" id="consignee" value="<?php echo $order['consignee']; ?>" class="input-txt" placeholder="收货人名字" />
        </dd>
      </dl>        
      <dl class="row">
        <dt class="tit">
          <label for="consignee">手机</label>
        </dt>
        <dd class="opt">
          <input type="text" name="mobile" id="mobile" value="<?php echo $order['mobile']; ?>" class="input-txt" placeholder="收货人联系电话" />
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="consignee">地址</label>
        </dt>
        <dd class="opt">
          <select onblur="get_city(this)" id="province" name="province" >
               <option value="0">选择省份</option>
               <?php if(is_array($province) || $province instanceof \think\Collection || $province instanceof \think\Paginator): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                   <option value="<?php echo $vo['id']; ?>" ><?php echo $vo['name']; ?></option>
               <?php endforeach; endif; else: echo "" ;endif; ?>
           </select>
           <select onblur="get_area(this)" id="city" name="city">
                <option value="0">选择城市</option>
                <?php if(is_array($city) || $city instanceof \think\Collection || $city instanceof \think\Paginator): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
            <select id="district" name="district" >
                <option value="0">选择区域</option>
                <?php if(is_array($area) || $area instanceof \think\Collection || $area instanceof \think\Paginator): $i = 0; $__LIST__ = $area;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
            <input type="text" name="address" id="address" value="<?php echo $order['address']; ?>" class="input-txt"   placeholder="详细地址"/>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="shipping">配送物流</label>
        </dt>
        <dd class="opt">
          <select id="shipping" name="shipping">
             <?php if(is_array($shipping_list) || $shipping_list instanceof \think\Collection || $shipping_list instanceof \think\Paginator): $i = 0; $__LIST__ = $shipping_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shipping): $mod = ($i % 2 );++$i;?>
                 <option <?php if($order[shipping_code] == $shipping[code]): ?>selected<?php endif; ?> value="<?php echo $shipping['code']; ?>" ><?php echo $shipping['name']; ?></option>
             <?php endforeach; endif; else: echo "" ;endif; ?>
         </select>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="payment">支付方式</label>
        </dt>
        <dd class="opt">
          <select id="payment" name="payment"  >
               <?php if(is_array($payment_list) || $payment_list instanceof \think\Collection || $payment_list instanceof \think\Paginator): $i = 0; $__LIST__ = $payment_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$payment): $mod = ($i % 2 );++$i;?>
                   <option <?php if($order[pay_code] == $payment[code]): ?>selected<?php endif; ?> value="<?php echo $payment['code']; ?>" ><?php echo $payment['name']; ?></option>
               <?php endforeach; endif; else: echo "" ;endif; ?>
           </select>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="invoice_title">发票抬头</label>
        </dt>
        <dd class="opt">
          <input type="text" name="invoice_title" value="<?php echo $order['invoice_title']; ?>" class="input-txt"  placeholder="发票抬头"/>
        </dd>
      </dl>
     <dl class="row">
        <dt class="tit">
          <label for="invoice_title">添加商品</label>
        </dt>
        <dd class="opt">
          <a href="javascript:void(0);" onclick="selectGoods()" class="ncap-btn-big ncap-btn-green" ><i class="fa fa-search"></i>添加商品</a>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="invoice_title">商品列表</label>
        </dt>
        <dd class="opt">
          	<div class="ncap-order-details">
		      <div class="hDivBox" id="ajax_return">
		        <table cellspacing="0" cellpadding="0" style="border:0px">
		          <thead>
			        	<tr>
			              <th class="sign" axis="col0">
			                <div style="width: 24px;"><i class="ico-check"></i></div>
			              </th>
			              <th align="left" abbr="order_sn" axis="col3" class="">
			                <div style="text-align: left; width: 560px;" class="">商品名称</div>
			              </th>
			              <th align="left" abbr="consignee" axis="col4" class="">
			                <div style="text-align: left; width: 120px;" class="">规格</div>
			              </th>
			              <th align="left" abbr="consignee" axis="col4" class="">
			                <div style="text-align: left; width: 120px;" class="">价格</div>
			              </th>
			              <th align="center" abbr="article_show" axis="col5" class="">
			                <div style="text-align: center; width: 80px;" class="">数量</div>
			              </th>
			              <th align="center" abbr="article_time" axis="col6" class="">
			                <div style="text-align: center; width: 80px;" class="">操作</div>
			              </th>
			              <th style="width:100%" axis="col7">
			                <div></div>
			              </th>
			            </tr>
			          </thead>
			          <tbody>
			          	<?php if(is_array($orderGoods) || $orderGoods instanceof \think\Collection || $orderGoods instanceof \think\Paginator): if( count($orderGoods)==0 ) : echo "" ;else: foreach($orderGoods as $key=>$vo): ?>
			          		<tr>
				              <td class="sign" axis="col0">
				                <div style="width: 24px;"><i class="ico-check"></i></div>
				              </td>
				              <td align="left" abbr="goods_name" axis="col3" class="">
				                <div style="text-align: left; width: 560px;" class=""><?php echo $vo['goods_name']; ?></div>
				              </td>
				              <td align="left" abbr="spec_key_name" axis="col4" class="">
				                <div style="text-align: left; width: 120px;" class=""><?php echo $vo['spec_key_name']; ?></div>
				              </td>
				              <td align="left" abbr="goods_price" axis="col4" class="">
				                <div style="text-align: left; width: 120px;" class=""><?php echo $vo['goods_price']; ?></div>
				              </td>
				              <td align="center" abbr="article_show" axis="col5" class="">
				                <div style="text-align: center; width: 80px;" class="">
				                	<input type="hidden" name="spec[]" rel="<?php echo $vo['goods_id']; ?>" value="<?php echo $vo['spec_key']; ?>">
				                	<input type="text" class="input-txt" style="width:60px !important;text-align:center" name="old_goods[<?php echo $vo['rec_id']; ?>]" value="<?php echo $vo['goods_num']; ?>" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" onpaste="this.value=this.value.replace(/[^\d.]/g,'')">
				                </div>
				              </td>
				              <td align="center" abbr="article_time" axis="col6" class="">
				                <div style="text-align: center; width: 80px;" class="">
				                	<a class="btn red" href="javascript:void(0);" onclick="javascript:$(this).parent().parent().parent().remove();"><i class="fa fa-trash-o"></i>删除</a>
				                </div>
				              </td>
				              <td style="width:100%" axis="col7">
				                <div></div>
				              </td>
				          	</tr>
				          <?php endforeach; endif; else: echo "" ;endif; ?>
			          </tbody>
		        </table>
		        <div class="form-group">                                       
                       <div class="col-xs-10" id="goods_td">
                       </div>                                                                                                                                                      
               </div>  
		      </div>
		    </div>
          	 
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">管理员备注</dt>
        <dd class="opt">
	      <textarea class="tarea" style="width:440px; height:150px;" name="admin_note" id="admin_note"><?php echo htmlspecialchars_decode($order['admin_note']); ?></textarea>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
      <div class="bot"><a href="JavaScript:void(0);" onClick="checkSubmit()" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认提交</a></div>
    </div>
        
  </form>
</div>
<script type="text/javascript">
/* 用户订单区域选择 */
$(document).ready(function(){
	$('#province').val(<?php echo $order['province']; ?>);
	$('#city').val(<?php echo $order['city']; ?>);
	$('#district').val(<?php echo $order['district']; ?>);
	$('#shipping_id').val(<?php echo $order['shipping_id']; ?>);
});
// 选择商品
function selectGoods(){
    var url = "<?php echo U('Admin/Order/search_goods'); ?>";
    layer.open({
        type: 2,
        title: '选择商品',
        shadeClose: true,
        shade: 0.8,
        area: ['60%', '60%'],
        content: url, 
    });
}

// 选择商品返回
function call_back(table_html)
{ 
	$('#goods_td').empty().html('<table id="new_table" class="table table-bordered">'+table_html+'</table>');
	//过滤选择重复商品
	$('input[name*="spec"]').each(function(i,o){
		if($(o).val()){
			var name='goods_id['+$(o).attr('rel')+']['+$(o).val()+'][goods_num]';
			$('input[name="'+name+'"]').parent().parent().parent().remove();
		}
	});
	layer.closeAll('iframe');
}

function delRow(obj){
	$(obj).parent().parent().parent().remove();
	var length = $("#goos_table tr").length;
	if(length == 0){
		$('#goods_td').empty();
	}
}

function checkSubmit()
{							
	$("span[id^='err_']").each(function(){
		$(this).hide();
	});
   ($.trim($('#consignee').val()) == '') && $('#err_consignee').show();
   ($.trim($('#province').val()) == '') && $('#err_address').show();
   ($.trim($('#city').val()) == '') && $('#err_address').show();
   ($.trim($('#district').val()) == '') && $('#err_address').show();
   ($.trim($('#address').val()) == '') && $('#err_address').show();
   ($.trim($('#mobile').val()) == '') && $('#err_mobile').show();						   						   						   	
   if(($("input[name^='goods_id']").length ==0) && ($("input[name^='old_goods']").length == 0)){
	   layer.alert('订单中至少要有一个商品', {icon: 2});  // alert('少年,订单中至少要有一个商品');
	   return false;
   }												   
   if($("span[id^='err_']:visible").length > 0 ) 
      return false;							  
   $('#order-add').submit();	  
}
</script>
</body>
</html>