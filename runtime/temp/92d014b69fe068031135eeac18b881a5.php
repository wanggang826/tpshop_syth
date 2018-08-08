<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:42:"./application/admin/view2/order\print.html";i:1508133827;s:44:"./application/admin/view2/public\layout.html";i:1508133828;}*/ ?>
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
<style>
.ncap-order-style .ncap-order-details{
	margin:20px auto;
	border:1px solid #e6e6e6;

}

.ncap-order-details table thead th{
	background-color:#FFFFFF
}


dd:before{
	margin-left:3px;
	content:' '
}

</style>
<div class="page">
  <div class="fixed-bar no-print">
    <div class="item-title"><a class="back" href="javascript:history.back(-1)" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subject">
        <h3>打印订单</h3>
        <h5>商城实物商品交易订单查询及管理</h5>
      </div>
    </div>
  </div>
  <div class="ncap-order-style">
    <div class="titile">
      <h3></h3>
    </div>

    <div class="ncap-order-details">
      
      <div class="tabs-panels" id="printDiv">
      	 <div class="goods-info">
          <h4>商品信息</h4>
          <table>
            <thead>
              <tr>
                <th>商品名称</th>
                <th>状态</th>
                <th>商品货号</th>
                <th>规格属性</th>
                <th>数量</th>
                <th>单价</th>
                <th>单品小计</th>
              </tr>
            </thead>
            <tbody>
            <?php if(is_array($orderGoods) || $orderGoods instanceof \think\Collection || $orderGoods instanceof \think\Paginator): $i = 0; $__LIST__ = $orderGoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$good): $mod = ($i % 2 );++$i;?>
           	<tr>
                <td style="text-align: left;"><?php echo $good['goods_name']; ?></td>
                <td class="w80">
                    <?php if($good['is_send'] == 0): ?>未发货<?php endif; if($good['is_send'] == 1): ?>已发货<?php endif; if($good['is_send'] == 2): ?>已退货<?php endif; if($good['is_send'] == 3): ?>已换货<?php endif; ?>
                </td>
                <td class="w80"><?php echo $good['goods_sn']; ?></td>
                <td class="w60"><?php echo $good['spec_key_name']; ?></td>
                <td class="w100"><?php echo $good['goods_num']; ?></td>
                <td class="w60"><?php echo $good['goods_price']; ?></td>
                <td class="w80"><?php echo $good['goods_total']; ?></td>
              </tr>
              <?php endforeach; endif; else: echo "" ;endif; ?>
          </table>
        </div>
        <div class="total-amount contact-info">
          订单总额：￥<?php echo $order['goods_price']; ?> 
        </div>
        
        <div class="misc-info">
           <h3>收货人信息</h3>
           		<dl>
		            <dt>收件人：</dt>
		            <dd><?php echo $order['consignee']; ?></dd>
		            <dt>联系电话：</dt>
		            <dd><?php echo $order['mobile']; ?></dd>
		            <dt>邮编：</dt>
		            <dd><?php echo $order['zipcode']; ?></dd>
		          </dl>
		          <dl>
	              	<dt>邮箱：</dt>
		            <dd><?php echo $order['email']; ?></dd>
		           </dl>
	              <dl>
	              	<dt>收货地址：</dt>
		            <dd><?php echo $order['full_address']; ?></dd>
			       </dl>
        	</div>
        
        <div class="contact-info">
          <h3>订单详情</h3>
          <dl>
            <dt>下单日期：</dt>
            <dd><?php echo date('Y-m-d H:i:s',$order['add_time']); ?></dd>
            <dt>订单号：</dt>
            <dd><?php echo $order['order_sn']; ?></dd>
            <dt>支付方式：</dt>
            <dd><?php echo $order['pay_name']; ?></dd>
          </dl>
          <dl>
            <dt>配送方式：</dt>
            <dd><?php echo $order['shipping_name']; ?></dd>
            <dt>订单总价：</dt>
            <dd><?php echo $order['total_amount']; ?></dd>
            <dt>商品价格：</dt>
            <dd><?php echo $order['goods_price']; ?></dd>
          </dl>
          <dl>
            <dt>配送费用：</dt>
            <dd><?php echo $order['shipping_price']; ?></dd>
            <dt>订单优惠：</dt>
            <dd><?php echo $order['coupon_price']; ?></dd>
            <dt>使用积分：</dt>
            <dd><?php echo $order['integral']; ?></dd>
          </dl>
          <dl>
            <dt>使用余额：</dt>
            <dd><?php echo $order['user_money']; ?></dd>
            <dt>应付金额：</dt>
            <dd><strong style="color:#777"><?php echo $order['order_amount']; ?></strong></dd>
            <dt>发票抬头：</dt>
            <dd><?php echo $order['invoice_title']; ?></dd>
          </dl>
            <dl>
                <dt>用户留言：</dt>
                <dd><?php echo $order['user_note']; ?></dd>
            </dl>
        </div>
		 
      </div>
  	</div>

	<div style="width:1000px" class="no-print">
      		<a href="javascript:printDiv();" style="float:center" class="ncap-btn-big ncap-btn-green" ><i class="fa fa-print"></i>打印订单</a>
      </div>
  </div>
</div>
<script type="text/javascript">
    function printDiv()
    {
        var oldStr = document.body.innerHTML;
        $('.no-print').hide();
        window.print();
        document.body.innerHTML = oldStr;
    }
</script>
</body>
</html>