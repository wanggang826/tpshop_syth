<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:49:"./application/admin/view2/order/ajaxdelivery.html";i:1508133826;}*/ ?>
<table>
 	<tbody>
 	<?php if(empty($orderList) == true): ?>
 		<tr data-id="0">
	        <td class="no-data" align="center" axis="col0" colspan="50">
	        	<i class="fa fa-exclamation-circle"></i>没有符合条件的记录
	        </td>
	     </tr>
	<?php else: if(is_array($orderList) || $orderList instanceof \think\Collection || $orderList instanceof \think\Paginator): $i = 0; $__LIST__ = $orderList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
  		<tr>
             <td class="sign" axis="col0">
               <div style="width: 24px;"><i class="ico-check"></i></div>
              
             </td>
             <td align="left" abbr="order_sn" axis="col3" class="">
               <div style="text-align: left; width: 140px;" class=""><?php echo $list['order_sn']; ?></div>
             </td>
             <td align="left" abbr="add_time" axis="col4" class="">
               <div style="text-align: left; width: 120px;" class=""><?php echo date('Y-m-d H:i',$list['add_time']); ?></div>
             </td>
             <td align="left" abbr="consignee" axis="col4" class="">
               <div style="text-align: left; width: 120px;" class=""><?php echo $list['consignee']; ?></div>
             </td>
             <td align="center" abbr="mobile" axis="col5" class="">
               <div style="text-align: center; width: 100px;" class=""><?php echo $list['mobile']; ?></div>
             </td>
             <td align="center" abbr="article_time" axis="col6" class="">
               <div style="text-align: center; width: 60px;" class=""><?php echo $list['shipping_name']; ?></div>
             </td>
             <td align="center" abbr="article_time" axis="col6" class="">
               <div style="text-align: center; width: 60px;" class=""><?php echo $list['shipping_price']; ?></div>
             </td>
             <td align="center" abbr="article_time" axis="col6" class="">
               <div style="text-align: center; width: 120px;" class="">
               	<?php if($list[pay_time] > 0): ?>
				  	<?php echo date('Y-m-d H:i',$list['pay_time']); else: ?>
					货到付款 
				<?php endif; ?>
               </div>
             </td>
             <td align="center" abbr="article_time" axis="col6" class="">
               <div style="text-align: center; width: 80px;" class=""><?php echo $list['total_amount']; ?></div>
             </td>
             <td align="center" axis="col1" class="handle">
               <div style="text-align: center; width: 150px;">
               	<?php if($list['shipping_status'] != 1): ?>
					<a class="btn green" href="<?php echo U('Admin/order/delivery_info',array('order_id'=>$list['order_id'])); ?>" data-toggle="tooltip" title="处理发货"><i class="fa fa-send-o"></i>去发货</a>
				<?php else: ?>
              		<a class="btn green" href="<?php echo U('Admin/order/delivery_info',array('order_id'=>$list['order_id'])); ?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情"><i class="fa fa-list-alt"></i>详情</a>
              		<a class="btn green" href="<?php echo U('Order/shipping_print',array('order_id'=>$list['order_id'])); ?>" data-toggle="tooltip" class="btn btn-default" title="打印快递单"><i class="fa fa-print"></i>快递单</a>
                <?php endif; ?> 
                <a class="btn green" href="<?php echo U('Order/order_print',array('order_id'=>$list['order_id'])); ?>" data-toggle="tooltip" class="btn btn-default" title="打印配货单"><i class="fa fa-print"></i>配货单</a>
               </div>
             </td>
             <td style="width:100%" axis="col7">
               <div></div>
             </td>
           </tr>
      <?php endforeach; endif; else: echo "" ;endif; endif; ?>
    </tbody>
</table>
<div class="row">
    <div class="col-sm-6 text-left"></div>
    <div class="col-sm-6 text-right"><?php echo $page; ?></div>
</div>
<script>
    $(".pagination  a").click(function(){
        var page = $(this).data('p');
        ajax_get_table('search-form2',page);
    });
    
 // 删除操作
    function del(obj) {
		confirm('确定要删除吗?', function(){
			location.href = $(obj).data('href');  
		});
	}
    
    $('.ftitle > h5 ').empty().html("(共<?php echo $pager->totalRows; ?>条记录)");
</script>