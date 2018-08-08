<?php

use think\Model;
use think\Request;
use think\Session;

/**
 * 微信扫码登录处理类
 */
class weixin extends Model
{
    public $return_url;   //回调地址
    public $app_id;
    public $app_secret;
    public $state;
    public function __construct($config)
    {
//		if($_COOKIE['is_mobile'] == 1)
//			$this->return_url = "http://".$_SERVER['HTTP_HOST']."/index.php?m=Mobile&c=LoginApi&a=callback&oauth=qq";
//		else
//	    $this->return_url = "http://".$_SERVER['HTTP_HOST']."/index.php?m=Home&c=LoginApi&a=callback&oauth=qq";
        //$this->return_url = "http://".$_SERVER['HTTP_HOST']."/index.php/Home/LoginApi/callback/oauth/weixin";
        $this->return_url = "http://www.sygwsc.cn/index.php/Home/LoginApi/callback/oauth/weixin";
        $this->app_id = $config['appid'];
        $this->app_secret = $config['secret'];
        $this->state = "sysy";
    }


    /**
     * 微信登录扫码界面拉取
     */
    public function login()
    {
        if(is_weixin()){
            //手机微信的话直接拉取网页授权页面
            $return_url = "http://www.sygwsc.cn/index.php/Mobile/LoginApi/callback/oauth/weixin";
            $dialog_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $this->app_id . "&redirect_uri=" . urlencode($return_url) . "&response_type=code&scope=snsapi_login&state=" . $this->state . "#wechat_redirect";
            echo("<script> top.location.href='" . $dialog_url . "'</script>");
            exit;
        }else{
            //拼接URL  这是一个二维码，扫码后就进入到网页授权页面，确认后就可以获取code
            $dialog_url = "https://open.weixin.qq.com/connect/qrconnect?appid=" . $this->app_id . "&redirect_uri=" . urlencode($this->return_url) . "&response_type=code&scope=snsapi_login&state=" . $this->state . "#wechat_redirect";
            echo("<script> top.location.href='" . $dialog_url . "'</script>");
            exit;
        }
    }

    /**
     * 微信授权登录后回调方法里面调用该方法
     * @return
     */
    public function respon()
    {
        //验证state参数
        //$state = Session::get('state');
        if ($_REQUEST['state'] == $this->state) {
            //取得了code
            $code = $_REQUEST["code"];
            //拼接URL，通过code等取得access_token 和openid等
            $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $this->app_id . "&secret=" . $this->app_secret . "&code=" . $code . "&grant_type=authorization_code";
            $response = $this->get_contents($token_url);//获取微信返回的用户openid等信息
            $user = json_decode($response,true); //转换成数组
            //通过access_token获取到用户信息（openid，昵称等微信的用户信息）返回，调用此方法的地方去存入数据库。
            $openid = $user['openid'];
            //拼接获取用户信息接口
            $user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $user['access_token'] . "&openid=" . $openid . "&lang=zh_CN";
            $res = $this->get_contents($user_info_url);
            $res = json_decode($res, true);
            unset($this->state);  //删除state
            //返回用户信息
            $data = ['openid' => $openid, 'oauth' => 'weixin', 'nickname' => $res['nickname'], 'head_pic' => $res['headimgurl']];
            return $data;
        } else {
            return false;
        }
    }


    public function get_contents($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        curl_close($ch);

        //-------请求为空
        if (empty($response)) {
            exit("50001");
        }

        return $response;
    }

}


?>
