<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:51:"./application/admin/view2/plugin\shipping_list.html";i:1508133828;s:44:"./application/admin/view2/public\layout.html";i:1508133828;}*/ ?>
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
<body style="background-color: rgb(255, 255, 255); overflow: auto; cursor: default; -moz-user-select: inherit;">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>物流插件管理 - <?php echo $plugin['name']; ?>配送管理</h3>
                <h5>网站系统<?php echo $plugin['name']; ?>配送管理</h5>
            </div>
        </div>
    </div>
    <!-- 操作说明 -->
    <div id="explanation" class="explanation" style="color: rgb(44, 188, 163); background-color: rgb(237, 251, 248); width: 99%; height: 100%;">
        <div id="checkZoom" class="title"><i class="fa fa-lightbulb-o"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span title="收起提示" id="explanationZoom" style="display: block;"></span>
        </div>
    </div>
    <div style="margin: 10px 0px;">
        <label for="desc" style="font-size:16px;">物流描述：</label>
        <span id="desc_span" ondblclick="show_input(this)" style="display: inline;font-size:16px;color: #999;">申通物流插件(双击修改)</span>
        <input onblur="change_desc('shentong')" value="申通物流插件" id="desc" style="width: 80%; display: none;font-size:16px;color: #999;" type="text">
    </div>
    <div class="flexigrid">
        <div class="mDiv">
            <div class="ftitle">
                <h3><?php echo $plugin['name']; ?>配送列表</h3>
                <h5>(共<?php echo count($shipping_list); ?>条记录)</h5>
            </div>
            <div title="刷新数据" class="pReload"><i class="fa fa-refresh"></i></div>
        </div>
        <div class="hDiv">
            <div class="hDivBox">
                <table cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th class="sign" axis="col0">
                            <div style="width: 24px;"><i class="ico-check"></i></div>
                        </th>
                        <th align="left" abbr="article_title" axis="col3" class="">
                            <div style="text-align: left; width: 120px;" class="">配送区名称</div>
                        </th>
                        <th align="left" abbr="ac_id" axis="col4" class="">
                            <div style="text-align: left; width: 120px;" class="">配送区域 </div>
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
        <div class="tDiv">
            <div class="tDiv2">
                <div class="fbutton">
                    <a href="<?php echo U('Admin/Plugin/shipping_list_edit',array('id'=>$list[shipping_area_id],'type'=>$plugin['type'],'code'=>$plugin['code'])); ?>">
                        <div class="add" title="新增配送区域">
                            <span><i class="fa fa-plus"></i>新增配送区域</span>
                        </div>
                    </a>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
        <!--支付插件-->
        <div class="bDiv" id="tab_pay" style="height: auto;<?php if($type != 'payment' AND $type != ''): ?>display: none;<?php endif; ?>">
        <div id="flexigrid" cellpadding="0" cellspacing="0" border="0">
            <table>
                <tbody>
                <?php if(is_array($shipping_list) || $shipping_list instanceof \think\Collection || $shipping_list instanceof \think\Paginator): $i = 0; $__LIST__ = $shipping_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td class="sign">
                            <div style="width: 24px;"><i class="ico-check"></i></div>
                        </td>
                        <td align="left" class="">
                            <div style="text-align: left; width: 120px;"><?php echo $list['shipping_area_name']; ?></div>
                        </td>
                        <td align="left" class="">
                            <div style="text-align: left; width: 120px;"><?php echo $list['region_list']; if($list['is_default'] == 1): ?>
                                    全国其他地区
                                <?php endif; ?>
                            </div>
                        </td>
                        <td align="center" class="handle">
                            <div style="text-align: center; width: 170px; max-width:170px;">
                                <a href="<?php echo U('Admin/Plugin/shipping_list_edit',array('id'=>$list[shipping_area_id],'type'=>$plugin['type'],'code'=>$plugin['code'],'edit'=>1,'default'=>$list['is_default'])); ?>" class="btn blue"><i class="fa fa-pencil-square-o"></i>编辑</a>
                                <?php if($list['is_default'] != 1): ?>
                                    <a class="btn red" data-href="<?php echo U('Admin/Plugin/del_area',array('id'=>$list[shipping_area_id],'type'=>$plugin['type'],'code'=>$plugin['code'])); ?>" onclick="del('<?php echo $list[shipping_area_id]; ?>',this)"><i class="fa fa-trash-o"></i>删除</a>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td align="" class="" style="width: 100%;">
                            <div>&nbsp;</div>
                        </td>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--支付插件-->
</div>
</div>
<script>
    $(document).ready(function(){
        // 表格行点击选中切换
        $('#flexigrid > table>tbody >tr').click(function(){
            $(this).toggleClass('trSelected');
        });

        // 点击刷新数据
        $('.fa-refresh').click(function(){
            location.href = location.href;
        });

    });
    // 删除操作
    function del(id,t)
    {
        if(!confirm('确定要删除吗?'))
            return false;

        location.href = $(t).data('href');
    }
    function change_desc(code){
        var desc = $('#desc').val();
        $.post("<?php echo U('Admin/Plugin/shipping_desc'); ?>",{code:code,desc:desc},function(data){
            data = $.parseJSON(data);
            $('#desc_span').show();
            $('#desc').hide();
            if(data.status == 1){
                $('#desc_span').text(desc);
            }else{
                layer.alert('修改失败', {icon: 2});  // alert('修改失败');
            }
        })
    }

    function show_input(t){
        $(t).hide();
        $('#desc').show();
    }
</script>
</body>
</html>