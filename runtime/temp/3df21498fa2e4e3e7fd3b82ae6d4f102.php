<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:47:"./application/admin/view2/plugin\_shipping.html";i:1508133827;s:44:"./application/admin/view2/public\layout.html";i:1508133828;}*/ ?>
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
                <h3>物流管理 - 添加物流</h3>
                <h5>网站系统物流索引和管理</h5>
            </div>
        </div>
    </div>
    <form class="form-horizontal" id="addEditshipping" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $shipping['id']; ?>">
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label for="name"><em>*</em>物流编码</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $shipping['code']; ?>" id="code" name="code" class="input-txt">
                    <span class="err" id="err_code" style="color:#F00; display:none;">物流编码不能为空!!</span>
                    <p class="notic">一般为物流公司拼音组成,不得含有英文以外的字符。<a href="http://www.ickd.cn/api/list.html" target="_blank" class="ncap-btn"><i class="fa fa-truck"></i>
                        参考查询编码</a></p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="name"><em>*</em>物流公司名字</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $shipping['name']; ?>" id="name" name="name" class="input-txt">
                    <span class="err" id="err_name" style="color:#F00; display:none;">名称不得为空</span>
                    <p class="notic">物流公司名字</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="desc">简短描述</label>
                </dt>
                <dd class="opt">
                    <input type="text" value="<?php echo $shipping['desc']; ?>" id="desc"  name="desc" class="input-txt">
                    <span class="err"></span>
                    <p class="notic">简短描述</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>物流图片图标</label>
                </dt>
                <dd class="opt">
                    <input type="file" class="input-button" value="上传图片" accept="image/*" name="shipping_img" style="display:inherit"/>
                    <span class="err"></span>
                    <p class="notic">默认网站LOGO,通用头部显示，最佳显示尺寸为240*60像素</p>
                </dd>
            </dl>
            <div class="bot"><a href="JavaScript:void(0);" onclick="checkSubmit();" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认提交</a></div>
        </div>
    </form>
</div>
<script type="text/javascript">
    // 判断输入框是否为空
    $("input[type='text']").focus(function(){
        $('span[id^="err_"]').hide();
    });

    function checkSubmit(){

        var code = $.trim($("#code").val());
        var name = $.trim($("#name").val());

        (code.length == 0) && $('#err_code').show();
        (name.length == 0) && $('#err_name').show();

        if($('span[id^="err_"]:visible').length > 0)
            return false;
        $('#addEditshipping').submit();
    }
</script>
</body>
</html>