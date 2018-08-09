<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:46:"./application/admin/view2/ad/positionList.html";i:1508133826;s:44:"./application/admin/view2/public/layout.html";i:1508133828;}*/ ?>
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
        <h3>广告位列表</h3>
        <h5>广告位与管理</h5>
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
      <li>广告位置在前台模板标签里面调用.</li>
      <li>当模板标签调用时程序会自动判断 pid 不存在则自动添加一个广告位</li>      
    </ul>
  </div>
  <div class="flexigrid">
    <div class="mDiv">
      <div class="ftitle">
        <h3>广告位置列表</h3>
        <h5>(共<?php echo $pager->totalRows; ?>条记录)</h5>
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
                <div style="text-align: left; width: 50px;" class="">广告id</div>
              </th>
              <th align="left" abbr="ac_id" axis="col4" class="">
                <div style="text-align: left; width: 200px;" class="">广告位名称</div>
              </th>
              <th align="center" abbr="article_show" axis="col5" class="">
                <div style="text-align: center; width: 60px;" class="">广告位宽度</div>
              </th>
              <th align="center" abbr="article_time" axis="col6" class="">
                <div style="text-align: center; width: 60px;" class="">广告位高度</div>
              </th>     
              <th align="center" abbr="article_time" axis="col6" class="">
                <div style="text-align: center; width: 100px;" class="">广告位描述</div>
              </th>     
              <th align="center" abbr="article_time" axis="col6" class="">
                <div style="text-align: center; width: 50px;" class="">状态</div>
              </th>
              <th align="center" abbr="article_time" axis="col6" class="">
                <div style="text-align: center; width: 100px;" class="">操作</div>
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
        <div class="fbutton"><a href="<?php echo U('Admin/Ad/position'); ?>"><div class="add" title="新增广告位"><span><i class="fa fa-plus"></i>新增广告位</span></div></a></div>
      </div>
      <div style="clear:both"></div>
    </div>
    <div class="bDiv" style="height: auto;">
      <div id="flexigrid" cellpadding="0" cellspacing="0" border="0">
        <table>
          <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $k=>$vo): ?>
              <tr>
                <td class="sign">
                  <div style="width: 24px;"><i class="ico-check"></i></div>
                </td>
                <td align="left" class="">
                  <div style="text-align: left; width: 50px;"><?php echo $vo[position_id]; ?></div>
                </td>
                <td align="left" class="">
                  <div style="text-align: left; width: 200px;"><?php echo $vo['position_name']; ?></div>
                </td>                
                <td align="left" class="">
                  <div style="text-align: left; width: 60px;"><?php echo $vo['ad_width']; ?></div>
                </td>
                <td align="left" class="">
                  <div style="text-align: left; width: 60px;"><?php echo $vo['ad_height']; ?></div>
                </td>            
                <td align="left" class="">
                  <div style="text-align: left; width: 100px;"><?php echo $vo['position_desc']; ?></div>
                </td>               
                <td align="center" class="">
                  <div style="text-align: center; width: 50px;">
                    <?php if($vo[is_open] == 1): ?>
                      <span class="yes" onClick="changeTableVal('ad_position','position_id','<?php echo $vo['position_id']; ?>','is_open',this)" ><i class="fa fa-check-circle"></i>是</span>
                      <?php else: ?>
                      <span class="no" onClick="changeTableVal('ad_position','position_id','<?php echo $vo['position_id']; ?>','is_open',this)" ><i class="fa fa-ban"></i>否</span>
                    <?php endif; ?>
                  </div>
                </td>             
                <td align="center" class="handle">
                  <div style="text-align: center; width: 150px;">                    
                    <a class="btn blue" href="<?php echo U('Admin/Ad/adList',array('pid'=>$vo['position_id'])); ?>"><i class="fa fa-search"></i>查看广告</a>                                                            
                    <a href="<?php echo U('Admin/Ad/position',array('act'=>'edit','position_id'=>$vo['position_id'])); ?>" class="btn blue"><i class="fa fa-pencil-square-o"></i>编辑</a>
                    <a class="btn blue" href="javascript:;" onclick="copyToClipBoard(<?php echo $vo['position_id']; ?>, 1)">代码调用</a>
                  </div>
                </td>
                <td align="" class="" style="width: 100%;">
                  <div>&nbsp;</div>
                </td>
              </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </tbody>
        </table>
	 <!--分页位置--> 
    <?php echo $page; ?> </div>        
      </div>       
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

    /**
     * 代码调用js
     * @param id  position_id
     * @param limit 条数
     */
    function copyToClipBoard(id, limit) {
      var advstr = "<adv pid='" + id + "' limit='" + limit + "' item='v'></adv";
      var contentdiv = '<div class="dialog_content" style="margin: 0px; padding: 0px;"><dl style="padding:10px 30px;line-height:30px"><dd>JavaScript:</dd>'
      contentdiv += '<dd><input type="text" style=" width:400px;" value="<script type=&quot;text/javascript&quot; src=&quot;http://' + '<?php echo \think\Request::instance()->server('http_host'); ?>' + '/index.php?m=Home&amp;c=Api&amp;a=ad_show&amp;pid=' + id + '&amp;limit='+limit+'&quot;><\/script>"></dd>'
      contentdiv += '<dd>PHP:</dd>'
      contentdiv += '<input type="text" style=" width:400px;" value="' + advstr + '>">'
      contentdiv += '<dd style="border-top: dotted 1px #E7E7E7; color: #F60;">请将JavaScript或PHP代码复制并粘贴到对应模板文件中！</dd></dl></div>'
      layer.open({
        type: 1,
        skin: 'layui-layer-demo',
        area: ['480px', '220px'], //宽高
        content: contentdiv
      });
    }

</script>
</body>
</html>