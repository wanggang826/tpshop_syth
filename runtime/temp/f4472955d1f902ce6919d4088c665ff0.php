<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:52:"./application/admin/view2/plugin\shipping_print.html";i:1508133828;s:44:"./application/admin/view2/public\layout.html";i:1508133828;}*/ ?>
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
<script src="__PUBLIC__/js/jquery.event.drag.js" type="text/javascript"></script>
<style>
    .waybill_design .item { background-color: #FEF5E6; width: 90px; height: 20px; padding: 1px 5px 4px 5px !important; border-color: #FFBEBC; border-style: solid; border-width: 1px 1px 1px 1px; cursor: move; position: absolute; left: 0; top: 0;}
    .waybill_design .item pre {
        height: 100%;
        float: left;
        padding: 0;
        margin: 0;
        border:0;
        cursor: move;
    }

    .waybill_design textarea {
        padding-left: 0px;
        margin: 0px;
        font-size: 12px;
        resize: none;
        outline: none;
        overflow: hidden;
        border: none;
    }

    .waybill_design .resize {
        height: 6px;
        width: 6px;
        position: absolute;
        bottom: 0px;
        right: 0px;
        overflow: hidden;
        cursor: nw-resize;
        background-color: #aaaaaa;
    }
    .waybill_design .selected {
        filter: alpha(opacity = 100);
        -moz-opacity: 1;
        opacity: 1;
        border: 1px solid #ff6600;
    }

</style>
<body style="background-color: #FFF; overflow: auto;">
<div id="toolTipLayer" style="position: absolute; z-index: 9999; display: none; visibility: visible; left: 95px; top: 573px;"></div>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
    <!-- 页面导航 -->
    <div class="fixed-bar">
        <div class="item-title"><a class="back" href="<?php echo U('plugin/index',array('type'=>'shipping')); ?>" title="返回运单模板列表"><i class="fa fa-arrow-circle-o-left"></i></a>
            <div class="subject">
                <h3>运单模板 - “<?php echo $plugin['name']; ?>”运单模板</h3>
                <h5>预设供商家选择的运单快递模板</h5>
            </div>

        </div>
    </div>
    <!-- 操作说明 -->
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示"></span> </div>
        <ul>
            <li>勾选需要打印的项目，勾选后可以用鼠标拖动确定项目的位置、宽度和高度，也可以点击项目后边的微调按钮手工录入</li>
            <li>设置完成后点击提交按钮完成设计</li>
        </ul>
    </div>

    <form action="" id="inputForm" method="post"  onsubmit="return checkForm()">
        <input type="hidden" id="content_map" name="content" value="<?php echo $plugin['config_value']; ?>">
        <input type="hidden" name="code" value="<?php echo $plugin['code']; ?>">
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label for="width"><em>*</em>宽度</label>
                </dt>
                <dd class="opt">
                    <input type="text" name="width" value="<?php echo (isset($config['width']) && ($config['width'] !== '')?$config['width']:'840'); ?>" id="width" class="input-txt">
                    <span class="err"></span>
                    <p class="notic">运单宽度，单位为毫米(mm)</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="height"><em>*</em>高度</label>
                </dt>
                <dd class="opt">
                    <input type="text" id="height" name="height" value="<?php echo (isset($config['height']) && ($config['height'] !== '')?$config['height']:'480'); ?>" class="input-txt">
                    <span class="err"></span>
                    <p class="notic">运单高度度，单位为毫米(mm)</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="offset_x"><em>*</em>左偏移量</label>
                </dt>
                <dd class="opt">
                    <input type="text" id="offset_x" name="offset_x" value="<?php echo (isset($config['offset_x']) && ($config['offset_x'] !== '')?$config['offset_x']:'0'); ?>" class="input-txt">
                    <span class="err"></span>
                    <p class="notic">运单模板左偏移量，单位为毫米(mm)</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="offset_y"><em>*</em>上偏移量</label>
                </dt>
                <dd class="opt">
                    <input type="text" id="offset_y" name="offset_y" value="<?php echo (isset($config['offset_y']) && ($config['offset_y'] !== '')?$config['offset_y']:'0'); ?>" class="input-txt">
                    <span class="err"></span>
                    <p class="notic">运单模板上偏移量，单位为毫米(mm)</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>模板图片</label>
                </dt>
                <dd class="opt">
                    <div class="input-file-show">
                    <span class="show">
                        <a class="nyroModal" rel="gal" href="<?php echo $config['background']; ?>">
                            <i class="fa fa-picture-o" onmouseover="layer.tips('<img src=<?php echo $config['background']; ?>>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"></i>
                        </a>
                    </span>
                    <span class="type-file-box">
                        <input id="background_input" name="background" value="<?php echo $config['background']; ?>" class="type-file-text" type="text">
                        <input name="button" id="button1" value="选择上传..." class="type-file-button" type="button">
                        <input class="type-file-file" onclick="GetUploadify(1,'background_input','plugins','setImg')" size="30" hidefocus="true" nc_type="change_site_logo" title="点击前方预览图可查看大图，点击按钮选择文件并提交表单后上传生效">
                    </span>
                    </div>
                    <span class="err"></span>
                    <p class="notic">请上传扫描好的运单图片，图片尺寸必须与快递单实际尺寸相符</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">选择打印项</dt>
                <dd class="opt">
                    <select class="form-control" id="tagOption">
                        <option value="">添加标签</option>
                        <option value="发货点-名称">发货点-名称</option>
                        <option value="发货点-联系人">发货点-联系人</option>
                        <option value="发货点-电话">发货点-电话</option>
                        <option value="发货点-省份">发货点-省份</option>
                        <option value="发货点-城市">发货点-城市</option>
                        <option value="发货点-区县">发货点-区县</option>
                        <option value="发货点-手机">发货点-手机</option>
                        <option value="发货点-详细地址">发货点-详细地址</option>
                        <option value="收件人-姓名">收件人-姓名</option>
                        <option value="收件人-手机">收件人-手机</option>
                        <option value="收件人-电话">收件人-电话</option>
                        <option value="收件人-省份">收件人-省份</option>
                        <option value="收件人-城市">收件人-城市</option>
                        <option value="收件人-区县">收件人-区县</option>
                        <option value="收件人-邮编">收件人-邮编</option>
                        <option value="收件人-详细地址">收件人-详细地址</option>
                        <option value="时间-年">时间-年</option>
                        <option value="时间-月">时间-月</option>
                        <option value="时间-日">时间-日</option>
                        <option value="时间-当前日期">时间-当前日期</option>
                        <option value="订单-订单号">订单-订单号</option>
                        <option value="订单-备注">订单-备注</option>
                        <option value="订单-配送费用">订单-配送费用</option>
                    </select>
                    <a id="deleteTag" class="ncap-btn"><i class="fa fa-trash-o"></i>删除标签</a>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">打印项偏移校正</dt>
                <dd class="opt">
                    <div class="waybill_area" style="position: relative; width: <?php echo (isset($config['width']) && ($config['width'] !== '')?$config['width']:'840'); ?>px; height: <?php echo (isset($config['height']) && ($config['height'] !== '')?$config['height']:'480'); ?>px;">
                        <div class="waybill_back" style="position: relative; width: <?php echo (isset($config['width']) && ($config['width'] !== '')?$config['width']:'840'); ?>px; height: <?php echo (isset($config['height']) && ($config['height'] !== '')?$config['height']:'480'); ?>px;"> <img id="tp-img" src="<?php echo $config['background']; ?>" style="width: <?php echo (isset($config['width']) && ($config['width'] !== '')?$config['width']:'840'); ?>px; height: <?php echo (isset($config['height']) && ($config['height'] !== '')?$config['height']:'480'); ?>px;" alt=""> </div>
                        <div class="waybill_design" style="position: absolute; left: <?php echo (isset($config['offset_x']) && ($config['offset_x'] !== '')?$config['offset_x']:'0'); ?>px; top: <?php echo (isset($config['offset_y']) && ($config['offset_y'] !== '')?$config['offset_y']:'0'); ?>px; width: <?php echo (isset($config['width']) && ($config['width'] !== '')?$config['width']:'840'); ?>px; height: <?php echo (isset($config['height']) && ($config['height'] !== '')?$config['height']:'480'); ?>px;">
                            <?php echo htmlspecialchars_decode($plugin['config_value']); ?>
                        </div>
                    </div>
                </dd>
            </dl>
            <div class="bot"><a onclick="$('#inputForm').submit();" class="ncap-btn-big ncap-btn-green">确认提交</a></div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $().ready(function () {
        var $tagOption = $("#tagOption");
        var $deleteTag = $("#deleteTag");
        var $container = $(".waybill_design");
        var $background = $("#background_input");
        var $width = $("#width");
        var $height = $("#height");
        var zIndex = 1;
        bind($container.find("div.item"));
        // 标签选项
        $tagOption.change(function () {
            var value = $(this).find("option:selected").val();
            if (value != "") {
                bind($('<div class="item"><pre>' + value + '<\/pre><div class="resize"><\/div><\/div>').appendTo($container));
            }
            return false;
        });

        // 绑定
        function bind($item) {
            $item.drag("start", function (ev, dd) {
                var $this = $(this);
                dd.width = $this.width();
                dd.height = $this.height();
                dd.limit = {
                    right: $container.innerWidth() - $this.outerWidth(),
                    bottom: $container.innerHeight() - $this.outerHeight()
                };
                dd.isResize = $(ev.target).hasClass("resize");
            }).drag(function (ev, dd) {
                var $this = $(this);
                if (dd.isResize) {
                    $this.css({
                        width: Math.max(20, Math.min(dd.width + dd.deltaX, $container.innerWidth() - $this.position().left) - 2),
                        height: Math.max(20, Math.min(dd.height + dd.deltaY, $container.innerHeight() - $this.position().top) - 2)
                    }).find("textarea").blur();
                } else {
                    $this.css({
                        top: Math.min(dd.limit.bottom, Math.max(0, dd.offsetY)),
                        left: Math.min(dd.limit.right, Math.max(0, dd.offsetX))
                    });
                }
            }, {relative: true}).mousedown(function () {
                $(this).css("z-index", zIndex++);
            }).click(function () {
                var $this = $(this);
                $container.find("div.item").not($this).removeClass("selected");
                $this.toggleClass("selected");
            }).dblclick(function () {
                var $this = $(this);
                if ($this.find("textarea").size() == 0) {
                    var $pre = $this.find("pre");
                    var value = $pre.hide().text($pre.html()).html();
                    $('<textarea>' + value + '<\/textarea>').replaceAll($pre).width($this.innerWidth() - 6).height($this.innerHeight() - 6).blur(function () {
                        var $this = $(this);
                        $this.replaceWith('<pre>' + $this.val() + '<\/pre>');
                    }).focus();
                }
            });
        }
        // 删除标签
        $deleteTag.click(function () {
            $container.find("div.selected").remove();
            return false;
        });
        $background.bind("input propertychange change", function () {
            $container.css({
                background: "url(/" + $background.val() + ") 0px 0px no-repeat"
            });
        });

        // 宽度
        $width.bind("input propertychange change", function () {
            $container.width($width.val());
        });

        // 高度
        $height.bind("input propertychange change", function () {
            $container.height($height.val());
        });


    });

    function checkForm(e) {
        if (e == null) {
            if ($.trim($(".waybill_design").html()) == "") {
                layer.alert("模板内容不能为空！",{icon:2});
                return false;
            }
            if ($("#background_input").val() == "") {
                layer.alert("请上传物流打印背景图片！",{icon:2});
                return false;
            }
            $("#content_map").val($(".waybill_design").html());
            return true;
        }
    }

    function setImg(value) {
        $("#background_input").val(value);
        $(".waybill_design").css({
            background: "url(" + value + ") 0px 0px no-repeat"
        });
        $('#tp-img').hide();
    }
</script>
</body>
</html>