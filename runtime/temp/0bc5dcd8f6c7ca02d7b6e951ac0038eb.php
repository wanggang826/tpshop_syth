<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:38:"./template/mobile/new2/user\login.html";i:1511167243;s:41:"./template/mobile/new2/public\header.html";i:1516181748;s:45:"./template/mobile/new2/public\header_nav.html";i:1508133937;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>登录--<?php echo $tpshop_config['shop_info_store_title']; ?></title>
    <link rel="stylesheet" href="__STATIC__/css/mui.min.css">
    <link rel="stylesheet" href="__STATIC__/css/style.css">
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/iconfont.css"/>
    <script src="__STATIC__/js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/mui.min.js"  type="text/javascript" ></script>
    <!--<script src="__STATIC__/js/zepto-1.2.0-min.js" type="text/javascript" charset="utf-8"></script>-->
    <script src="__STATIC__/js/style.js" type="text/javascript" charset="utf-8"></script>
    <script src="__STATIC__/js/mobile-util.js" type="text/javascript" charset="utf-8"></script>
    <script src="__PUBLIC__/js/global.js"></script>
    <script src="__STATIC__/js/layer.js"  type="text/javascript" ></script>
    <script src="__STATIC__/js/swipeSlide.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="__STATIC__/fonts/mui.ttf"/>
</head>
<body class="">

<div class="classreturn loginsignup ">
    <div class="content">
        <div class="ds-in-bl return">
            <a href="javascript:history.back(-1);"><img src="__STATIC__/images/return.png" alt="返回"></a>
        </div>
        <div class="ds-in-bl search center">
            <span>登录</span>
        </div>
        <div class="ds-in-bl menu">
            <a href="javascript:void(0);"><img src="__STATIC__/images/class1.png" alt="菜单"></a>
        </div>
    </div>
</div>
<div class="flool tpnavf">
    <div class="footer">
        <ul>
            <li>
                <a class="yello" href="<?php echo U('Index/index'); ?>">
                    <div class="icon">
                        <i class="icon-shouye iconfont"></i>
                        <p>首页</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('Goods/categoryList'); ?>">
                    <div class="icon">
                        <i class="icon-fenlei iconfont"></i>
                        <p>分类</p>
                    </div>
                </a>
            </li>
            <li>
                <!--<a href="shopcar.html">-->
                <a href="<?php echo U('Cart/index'); ?>">
                    <div class="icon">
                        <i class="icon-gouwuche iconfont"></i>
                        <p>购物车</p>
                    </div>
                </a>
            </li>
            <li>
                <a href="<?php echo U('User/index'); ?>">
                    <div class="icon">
                        <i class="icon-wode iconfont"></i>
                        <p>我的</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="flool loginsignup2">
<!--LOGO-->
    <img src="<?php echo $logo; ?>" alt="LOGO"/>
</div>
<div class="loginsingup-input">
<!--登录表单-s-->
    <form  id="loginform" method="post"  >
        <input type="hidden" name="referurl" id="referurl" value="<?php echo $referurl; ?>">
        <div class="content30">
            <div class="lsu">
                <span>账号</span>
                <input type="text" name="username" id="username" value=""  placeholder="请输入邮箱/手机号"/>
            </div>
            <div class="lsu">
                <span>密码</span>
                <input type="password" name="password" id="password" value="" placeholder="请输入密码"/>
                <i></i>
            </div>
            <?php if(!(empty($first_login) || (($first_login instanceof \think\Collection || $first_login instanceof \think\Paginator ) && $first_login->isEmpty()))): ?>
            <div class="lsu test">
                <span>请输入验证码</span>
                <input type="text" name="verify_code" id="verify_code" value="" placeholder="请输入验证码"/>
                <img  id="verify_code_img" src="<?php echo U('Mobile/User/verify'); ?>" onClick="verify()"/>
            </div>
            <?php endif; ?>
            <div class="lsu submit">
                <input type="button"  value="提交"  onclick="submitverify()" class="btn_big1"  />
            </div>
            <div class="radio">
            </div>
            <div class="signup-find p">
                <div class="note fl">
                    <img src="__STATIC__/images/not.png"/>
                    <a href="<?php echo U('User/reg'); ?>"><span>快速注册</span></a>
                </div>
                <div class="note fr">
                    <img src="__STATIC__/images/ru.png"/>
                    <a href="<?php echo U('User/forget_pwd'); ?>"><span>找回密码</span>
                </div>
            </div>
        </div>
    </form>
<!--登录表单-e-->
</div>

<!--第三方登陆-s-->
<div class="thirdlogin">
    <ul>
<?php
                                   
                                $md5_key = md5("select * from __PREFIX__plugin where type='login' AND status = 1");
                                $result_name = $sql_result_v = S("sql_".$md5_key);
                                if(empty($sql_result_v))
                                {                            
                                    $result_name = $sql_result_v = \think\Db::query("select * from __PREFIX__plugin where type='login' AND status = 1"); 
                                    S("sql_".$md5_key,$sql_result_v,60);
                                }    
                              foreach($sql_result_v as $k=>$v): if($v['code'] == 'weixin' AND is_weixin()): ?>
        <li>
            <a class="ta-weixin" href="<?php echo U('mobile/LoginApi/login',array('oauth'=>'weixin')); ?>" target="_blank" title="weixin">
               <div class="icon"><img src="__STATIC__/images/wechat.png"/><p>微信登陆</p></div>
            </a>
        </li>
    <?php endif; ?>

        <!--<li>-->
            <!--<a href="<?php echo U('LoginApi/login',array('oauth'=>'alipay')); ?>">-->
                <!--<div class="icon">-->
                    <!--<img src="__STATIC__/images/alpay.png"/>-->
                    <!--<p>支付宝</p>-->
                <!--</div>-->
            <!--</a>-->
        <!--</li>-->

    <!--<?php if($v['code'] == 'qq' AND is_qq() != 1): ?>-->
        <!--<li>-->
            <!--<a class="ta-qq" href="<?php echo U('LoginApi/login',array('oauth'=>'qq')); ?>" target="_blank" title="QQ">-->
                <!--<div class="icon">-->
                    <!--<img src="__STATIC__/images/qq.png"/>-->
                    <!--<p>qq登陆</p>-->
                <!--</div>-->
            <!--</a>-->
        <!--</li>-->
    <!--<?php endif; ?>-->
<?php endforeach; ?></ul>
</div>
<!--第三方登陆-e-->

<script type="text/javascript">
    function verify(){
        $('#verify_code_img').attr('src','/index.php?m=Mobile&c=User&a=verify&r='+Math.random());
    }

    //复选框状态
    function remember(obj){
         var che= $(obj).attr("class");
        if(che == 'che check_t'){
            $("#autologin").prop('checked',false);
        }else{
            $("#autologin").prop('checked',true);
        }
    }
    function submitverify()
    {
        var username = $.trim($('#username').val());
        var password = $.trim($('#password').val());
        var remember = $('#remember').val();
        var referurl = $('#referurl').val();
        var verify_code = $.trim($('#verify_code').val());
        if(username == ''){
            showErrorMsg('用户名不能为空!');
            return false;
        }
        if(!checkMobile(username) && !checkEmail(username)){
            showErrorMsg('账号格式不匹配!');
            return false;
        }
        if(password == ''){
            showErrorMsg('密码不能为空!');
            return false;
        }
        var codeExist = $('#verify_code').length;
        if (codeExist && verify_code == ''){
            showErrorMsg('验证码不能为空!');
            return false;
        }

        var data = {username:username,password:password,referurl:referurl};
        if (codeExist) {
            data.verify_code = verify_code;
        }
        $.ajax({
            type : 'post',
            url : '/index.php?m=Mobile&c=User&a=do_login&t='+Math.random(),
            data : data,
            dataType : 'json',
            success : function(data){
                if(data.status == 1){
                    var url = data.url.toLowerCase();
                    if (url.indexOf('user') !=  false && url.indexOf('login') != false || url == '') {
                        window.location.href = '/index.php/mobile';
                    }else{
                        window.location.href = data.url;
                    }
                }else{
                    showErrorMsg(data.msg);
                    if (codeExist) {
                        verify();
                    } else {
                        location.reload();
                    }
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                showErrorMsg('网络异常，请稍后重试');
            }
        })
    }
        //切换密码框的状态
        $(function(){
            $('.loginsingup-input .lsu i').click(function(){
                $(this).toggleClass('eye');
                if ($(this).hasClass('eye')) {
                    $(this).siblings('input').attr('type','text')
                } else{
                    $(this).siblings('input').attr('type','password')
                }
            });
        })
    </script>
</body>
</html>
