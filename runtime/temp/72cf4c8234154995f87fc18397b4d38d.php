<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:46:"./application/admin/view2/order/order_log.html";i:1508133826;s:44:"./application/admin/view2/public/layout.html";i:1508133828;}*/ ?>
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
<script type="text/javascript" src="__ROOT__/public/static/js/layer/laydate/laydate.js"></script>

<body style="background-color: rgb(255, 255, 255); overflow: auto; cursor: default; -moz-user-select: inherit;">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3>订单日志</h3>
        <h5>所有用户操作订单生成的日志明细</h5>
      </div>
    </div>
  </div>
  <!-- 操作说明 -->
  <div id="explanation" class="explanation" style="color: rgb(44, 188, 163); background-color: rgb(237, 251, 248); width: 99%; height: 100%;">
    <div id="checkZoom" class="title"><i class="fa fa-lightbulb-o"></i>
      <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
      <span title="收起提示" id="explanationZoom" style="display: block;"></span>
    </div>
     <ul>
      <li>所有用户操作订单生成的日志明细</li>
    </ul>
  </div>
  <div class="flexigrid">
    <div class="mDiv">
      <div class="ftitle">
        <h3>订单操作列表</h3>
        <h5>(共<?php echo $page->totalRows; ?>条记录)</h5>
      </div>
      <div title="刷新数据" class="pReload"><i class="fa fa-refresh"></i></div>
	  <form class="navbar-form form-inline"  method="post" action="<?php echo U('Order/order_log'); ?>"  name="search-form2" id="search-form2">  
      <div class="sDiv">
      	<div class="sDiv2">	 
          <input type="text" size="30" name="order_sn" class="qsbox" placeholder="订单编号">
        </div>
        <div class="sDiv2">
        	<input type="text" size="30" id="timegap_begin" name="timegap_begin" value="<?php echo $timegap_begin; ?>" class="qsbox"  placeholder="开始时间">
        </div>
        <div class="sDiv2">
        	<input type="text" size="30" id="timegap_end" name="timegap_end" value="<?php echo $timegap_end; ?>" class="qsbox"  placeholder="截止时间">
        </div>
        <div class="sDiv2">	 
        	<select name="admin_id" >
            	<option value="0">选择管理员</option>
				<?php if(is_array($admin) || $admin instanceof \think\Collection || $admin instanceof \think\Paginator): if( count($admin)==0 ) : echo "" ;else: foreach($admin as $key=>$vv): ?>
                <option value="<?php echo $key; ?>"><?php echo $vv; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
        </div>
        <div class="sDiv2">	 
          <input type="submit"  class="btn" value="搜索">
        </div>
      </div>
     </form>
    </div>
    <div class="hDiv">
      <div class="hDivBox" id="ajax_return">
        <table cellspacing="0" cellpadding="0">
          <thead>
	        	<tr>
	              <th class="sign" axis="col0">
	                <div style="width: 24px;"><i class="ico-check"></i></div>
	              </th>
	              <th align="left" abbr="order_sn" axis="col3" class="">
	                <div style="text-align: left; width: 120px;" class="">订单ID</div>
	              </th>
	              <th align="left" abbr="consignee" axis="col4" class="">
	                <div style="text-align: left; width: 120px;" class="">操作动作</div>
	              </th>
	              <th align="center" abbr="article_show" axis="col5" class="">
	                <div style="text-align: center; width: 120px;" class="">操作员</div>
	              </th>
	              <th align="center" abbr="article_time" axis="col6" class="">
	                <div style="text-align: center; width: 260px;" class="">操作备注</div>
	              </th>
	              <th align="center" abbr="article_time" axis="col6" class="">
	                <div style="text-align: center; width: 160px;" class="">操作时间</div>
	              </th>
	              <th align="center" axis="col1" class="handle">
	                <div style="text-align: center; width: 150px;">操作</div>
	              </th>
	              <th style="width:100%" axis="col7">
	                <div></div>
	              </th>
	            </tr>
	          </thead>
        </table>
      </div>
    </div>
    <div class="bDiv" style="height: auto;">
      <div id="flexigrid" cellpadding="0" cellspacing="0" border="0">
        <table cellspacing="0" cellpadding="0">
          <tbody>
          	<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $k=>$vo): ?>
	        	<tr>
	              <td class="sign" axis="col0">
	                <div style="width: 24px;"><i class="ico-check"></i></div>
	              </td>
	              <td align="left" abbr="order_sn" axis="col3" class="">
	                <div style="text-align: left; width: 120px;" class=""><?php echo $vo['order_id']; ?></div>
	              </td>
	              <td align="left" abbr="consignee" axis="col4" class="">
	                <div style="text-align: left; width: 120px;" class=""><?php echo $vo['status_desc']; ?></div>
	              </td>
	              <td align="center" abbr="article_show" axis="col5" class="">
	                <div style="text-align: center; width: 120px;" class=""><?php if($vo['action_user'] != 0): ?>管理员：<?php echo $admin[$vo[action_user]]; else: ?>用户：<?php echo $users[$vo[order_id]]; endif; ?></div>
	              </td>
	              <td align="center" abbr="article_time" axis="col6" class="">
	                <div style="text-align: center; width: 260px;" class=""><?php echo $vo['action_note']; ?></div>
	              </td>
	              <td align="center" abbr="article_time" axis="col6" class="">
	                <div style="text-align: center; width: 160px;" class=""><?php echo date('Y-m-d H:i',$vo['log_time']); ?></div>
	              </td>
	              <td align="center" axis="col1" class="handle">
	                <div style="text-align: center; width: 150px;">
						<a class="btn green" href="<?php echo U('Order/detail',array('order_id'=>$vo['order_id'])); ?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情"><i class="fa fa-list-alt"></i>查看</a>
					</div>
	              </td>
	              <td style="width:100%" axis="col7">
	                <div></div>
	              </td>
	            </tr>
	            <?php endforeach; endif; else: echo "" ;endif; ?>
	          </tbody>
        </table>
      </div>
      <div class="iDiv" style="display: none;"></div>
    </div>
    <!--分页位置--> 
    <div class="row">
        <div class="col-sm-6 text-left"></div>
        <div class="col-sm-6 text-right"><?php echo $page; ?></div>
    </div>
   	</div>
</div>
<script type="text/javascript">

	 
    $(document).ready(function(){	
	   
     	$('#timegap_begin').layDate(); 
     	$('#timegap_end').layDate();
     	
		// 点击刷新数据
		$('.fa-refresh').click(function(){
			location.href = location.href;
		});
	 
		$('.ico-check ' , '.hDivBox').click(function(){
			$('tr' ,'.hDivBox').toggleClass('trSelected' , function(index,currentclass){
	    		var hasClass = $(this).hasClass('trSelected');
	    		$('tr' , '#flexigrid').each(function(){
	    			if(hasClass){
	    				$(this).addClass('trSelected');
	    			}else{
	    				$(this).removeClass('trSelected');
	    			}
	    		});  
	    	});
		});
		
		$('.ftitle>h5').empty().html("(共<?php echo $pager->totalRows; ?>条记录)");
	});
     
 // 点击排序
    function sort(field){
        $("input[name='order_by']").val(field);
        var v = $("input[name='sort']").val() == 'desc' ? 'asc' : 'desc';
        $("input[name='sort']").val(v);
        ajax_get_table('search-form2',cur_page);
    }
	
 	
	
	 
</script>
</body>
</html>