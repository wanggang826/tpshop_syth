<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:56:"./application/admin/view2/plugin\shipping_list_edit.html";i:1508133828;s:44:"./application/admin/view2/public\layout.html";i:1508133828;}*/ ?>
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
<body style="background-color: #FFF; overflow: auto;">
<div id="toolTipLayer" style="position: absolute; z-index: 9999; display: none; visibility: visible; left: 95px; top: 573px;"></div>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title"><a class="back" href="javascript:history.back();" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
            <div class="subject">
                <h3>物流插件管理 - <?php echo $plugin['name']; ?>配送区域配置</h3>
                <h5>网站系统物流插件管理</h5>
            </div>
        </div>
    </div>
    <form class="form-horizontal" id="editForm" method="post">
        <input type="hidden" name="id" value="<?php echo $setting['shipping_area_id']; ?>">
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>配送区域名称</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $setting['shipping_area_name']; ?>" name="shipping_area_name" class="input-txt">
                    <span class="err"></span>
                    <p class="notic">配送区域名称</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>
                        首&nbsp;&nbsp;重
                        <select name="config[first_weight]">
                            <?php $__FOR_START_7963__=500;$__FOR_END_7963__=8000;for($v=$__FOR_START_7963__;$v < $__FOR_END_7963__;$v+=500){ ?>
                                <option value="<?php echo $v; ?>" <?php if($setting[config][first_weight] == $v): ?>selected="selected"<?php endif; ?> ><?php echo $v; ?></option>
                            <?php } ?>
                        </select>
                        克以内费用：
                    </label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $setting['config']['money']; ?>" name="config[money]" class="input-txt"/>
                    <span class="err"></span>
                    <p class="notic">单位：元</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>
                        续重每
                        <select name="config[second_weight]">
                            <?php $__FOR_START_25870__=500;$__FOR_END_25870__=8000;for($v=$__FOR_START_25870__;$v < $__FOR_END_25870__;$v+=500){ ?>
                                <option value="<?php echo $v; ?>" <?php if($setting[config][second_weight] == $v): ?>selected="selected"<?php endif; ?> ><?php echo $v; ?></option>
                            <?php } ?>
                        </select>
                        克或其零数的费用：
                    </label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $setting['config']['add_money']; ?>" name="config[add_money]" class="input-txt">
                    <span class="err"></span>
                    <p class="notic">单位：元</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>配送区域</label>
                </dt>
                <dd class="opt" id="area_list">
                    <?php if(is_array($select_area) || $select_area instanceof \think\Collection || $select_area instanceof \think\Paginator): $i = 0; $__LIST__ = $select_area;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$area): $mod = ($i % 2 );++$i;?>
                        <input class="area_list" type="checkbox" checked name="area_list[]" value="<?php echo $area['region_id']; ?>"><?php echo $area['name']; endforeach; endif; else: echo "" ;endif; ?>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>配送区域名称</label>
                </dt>
                <dd class="opt">
                    <select id="province" size="10"  onblur="get_city(this,0)">
                        <option value="0">请选择省份</option>
                        <?php if(is_array($province) || $province instanceof \think\Collection || $province instanceof \think\Paginator): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <select id="city" size="10"  onblur="get_area(this)">
                        <option value="0">请选择城市</option>
                    </select>
                    <select id="district" size="10">
                        <option value="0">请选择</option>
                    </select>
                    <button onclick="addArea()" class="btn btn-info" type="button">
                        <i class="ace-icon fa fa-plus bigger-110"></i>
                    </button>
                </dd>
            </dl>
            <div class="bot"><a href="JavaScript:void(0);" onclick="check_form();" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认提交</a></div>
        </div>
    </form>
</div>
<script>
    function check_form(){
        if ($('input[name="area_list\[\]"]:checked').length == 0){
            layer.msg('请至少选择一个区域！', {icon: 2,time: 1000});
            return false;
        }
        $('#editForm').submit();
    }

    //  添加配送区域
    function addArea(){
        //
        var province = $("#province").val(); // 省份
        var city = $("#city").val();        // 城市
        var district = $("#district").val(); // 县镇
        var text = '';  // 中文文本
        var tpl = ''; // 输入框 html
        var is_set = 0; // 是否已经设置了

        // 设置 县镇
        if(district > 0){
            text = $("#district").find('option:selected').text();
            tpl = '<input class="area_list" type="checkbox" checked name="area_list[]" value="'+district+'">'+text;
            is_set = district; // 街道设置了不再设置市
        }
        // 如果县镇没设置 就获取城市
        if(is_set == 0 && city > 0){
            text = $("#city").find('option:selected').text();
            tpl = '<input class="area_list" type="checkbox" checked name="area_list[]" value="'+city+'">'+text;
            is_set = city;  // 市区设置了不再设省份

        }
        // 如果城市没设置  就获取省份
        if(is_set == 0 && province > 0){
            text = $("#province").find('option:selected').text();
            tpl = '<input class="area_list" type="checkbox" checked name="area_list[]" value="'+province+'">'+text;
            is_set = province;

        }

        var obj = $("input[class='area_list']"); // 已经设置好的复选框拿出来
        var exist = 0;  // 表示下拉框选择的 是否已经存在于复选框中
        $(obj).each(function(){
            if($(this).val() == is_set){  //当前下拉框的如果已经存在于 复选框 中
                layer.alert('已经存在该区域', {icon: 2});  // alert("已经存在该区域");
                exist = 1; // 标识已经存在
            }
        })
        if(!exist)
            $('#area_list').append(tpl); // 不存在就追加进 去
    }
</script>
</body>
</html>