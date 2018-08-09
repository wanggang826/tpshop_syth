<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:45:"./application/admin/view2/goods/specList.html";i:1508133826;s:44:"./application/admin/view2/public/layout.html";i:1508133828;}*/ ?>
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
        <h3>商品规格</h3>
        <h5>商品规格及管理</h5>
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
      <li>商品规格是购买商品时给用户选择的, 涉及到价格变动库存等, 例如:衣服的 颜色 尺寸 等</li>
    </ul>
  </div>
  <div class="flexigrid">
    <div class="mDiv">
      <div class="ftitle">
        <h3>规格列表</h3>
        <h5></h5>
      </div>
	 <form action="" id="search-form2" class="navbar-form form-inline" method="post" onsubmit="return false">
      <div class="sDiv">
        <div class="sDiv2"> 
          <select name="type_id" id="type_id"  class="select">
                <option value="">所有模型</option>
                <?php if(is_array($goodsTypeList) || $goodsTypeList instanceof \think\Collection || $goodsTypeList instanceof \think\Paginator): if( count($goodsTypeList)==0 ) : echo "" ;else: foreach($goodsTypeList as $k=>$v): ?>
                   <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
           </select>
            <!--排序规则-->             
          <input type="button" onclick="ajax_get_table('search-form2',1)" class="btn" value="搜索"  id="button-filter" />
        </div>
      </div>
     </form>
    </div>
    <div class="hDiv">
      <div class="hDivBox">
        <table cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th class="sign" axis="col6">
                <div style="width: 24px;"><i class="ico-check"></i></div>
              </th>         
              <th align="left" abbr="article_title" axis="col6" class="">
                <div style="text-align: left; width:50px;" class="">id</div>
              </th>
              <th align="left" abbr="ac_id" axis="col4" class="">
                <div style="text-align: left; width: 100px;" class="">规格名称</div>
              </th>
              <th align="center" abbr="article_show" axis="col6" class="">
                <div style="text-align: center; width: 100px;" class="">所属模型</div>
              </th>
              <th align="center" abbr="article_time" axis="col6" class="">
                <div style="text-align: center; width: 300px;" class="">规格项</div>
              </th>                           
              <th align="center" abbr="article_time" axis="col6" class="">
                <div style="text-align: center; width: 50px;" class="">筛选</div>
              </th>                       
              <th align="center" abbr="article_time" axis="col6" class="">
                <div style="text-align: center; width: 50px;" class="">排序</div>
              </th>             
              <th align="center" abbr="article_time" axis="col6" class="">
                <div style="text-align: center; width: 170px;" class="">操作</div>
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
          <a href="<?php echo U('Admin/goods/addEditSpec'); ?>">
          <div class="add" title="添加规格">
            <span><i class="fa fa-plus"></i>添加规格</span>
          </div>
          </a>          
          </div> 
      </div>
      <div style="clear:both"></div>
    </div>
    <div class="bDiv" style="height: auto;">
     <!--ajax 返回 --> 
      <div id="ajax_return" cellpadding="0" cellspacing="0" border="0"></div>      
    </div>

     </div>
</div> 
<script>
    $(document).ready(function(){		
		<?php
		    if($_GET['type_id'])
			{
			   echo "$('#type_id').val(".$_GET['type_id'].");"; 
			}
		?>
			$('#button-filter').trigger('click'); // 触发点击搜索按钮
			
		 // 表格行点击选中切换
		$('#ajax_return').on('click','table>tbody >tr',function(){
			 $(this).toggleClass('trSelected');	
			 			 						
			 var checked = $(this).hasClass('trSelected');	
			 $(this).find('input[type="checkbox"]').attr('checked',checked); 
			 //alert('aaa');
		});				
    });

    // ajax 抓取页面 form 为表单id  page 为当前第几页
    function ajax_get_table(form,page){
		cur_page = page; //当前页面 保存为全局变量
            $.ajax({
                type : "POST",
                url:"/index.php?m=Admin&c=goods&a=ajaxSpecList&p="+page,//+tab,
                data : $('#'+form).serialize(),// 你的formid
                success: function(data){
                    $("#ajax_return").html('');
                    $("#ajax_return").append(data);
                }
            });
        }			 	
	 
</script> 
</body>
</html>