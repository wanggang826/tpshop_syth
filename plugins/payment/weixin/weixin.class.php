<?php

use think\Model;

/**
 * 支付 逻辑定义
 * Class
 * @package Home\Payment
 */
class weixin extends Model
{
    public $tableName = 'plugin'; // 插件表        
    public $alipay_config = array();// 支付宝支付配置参数

    /**
     * 析构流函数
     */
    public function __construct()
    {
        parent::__construct();

        require_once("lib/WxPay.Api.php"); // 微信扫码支付demo 中的文件         
        require_once("example/WxPay.NativePay.php");
        require_once("example/WxPay.JsApiPay.php");

        $paymentPlugin = M('Plugin')->where("code='weixin' and  type = 'payment' ")->find(); // 找到微信支付插件的配置
        $config_value = unserialize($paymentPlugin['config_value']); // 配置反序列化        
        WxPayConfig::$appid = $config_value['appid']; // * APPID：绑定支付的APPID（必须配置，开户邮件中可查看）
        WxPayConfig::$mchid = $config_value['mchid']; // * MCHID：商户号（必须配置，开户邮件中可查看）
        WxPayConfig::$smchid = isset($config_value['smchid']) ? $config_value['smchid'] : ''; // * SMCHID：服务商商户号（必须配置，开户邮件中可查看）
        WxPayConfig::$key = $config_value['key']; // KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）
        WxPayConfig::$appsecret = $config_value['appsecret']; // 公众帐号secert（仅JSAPI支付的时候需要配置)，
    }

    /**
     *生成支付代码(扫码支付)
     * @param   array $order 订单信息
     */
    function get_code($order)
    {
        $notify_url = SITE_URL . '/index.php/Home/Payment/notifyUrl/'; // 接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数。
        //$notify_url = C('site_url').U('Home/Payment/notifyUrl',array('pay_code'=>'weixin')); // 接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数。
        //$notify_url = C('site_url')."/index.php?m=Home&c=Payment&a=notifyUrl&pay_code=weixin";
        $input = new WxPayUnifiedOrder();    //统一下单
        $input->SetBody("顺亿特惠商城支付"); // 商品描述
        $input->SetAttach("weixin"); // 附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据
        $input->SetOut_trade_no($order['order_sn'] . time()); // 商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号
        $input->SetTotal_fee($order['real_num'] * 100); // 订单总金额，单位为分，详见支付金额
        $input->SetNotify_url($notify_url); // 接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数。
        $input->SetTrade_type("NATIVE"); // 交易类型   取值如下：JSAPI，NATIVE，APP，详细说明见参数规定    NATIVE--原生扫码支付
        $input->SetProduct_id("123456789"); // 商品ID trade_type=NATIVE，此参数必传。此id为二维码中包含的商品ID，商户自行定义。
        $notify = new NativePay();
        $result = $notify->GetPayUrl($input); // 获取生成二维码的地址
        $url2 = $result["code_url"];
        return '<img alt="模式二扫码支付" src="/index.php?m=Home&c=Index&a=qr_code&data=' . urlencode($url2) . '" style="width:150px;height:150px;"/>';
    }

    /**
     * 服务器点对点响应操作给支付接口方调用
     */
    function response()
    {
        require_once("example/notify.php");
        $notify = new PayNotifyCallBack();
        $notify->Handle(false);
    }



    function transfer($data)
    {
        header("Content-type: text/html; charset=utf-8");
        exit('待开发');
    }

    /**
     * 将一个数组转换为 XML 结构的字符串
     * @param array $arr 要转换的数组
     * @param int $level 节点层级, 1 为 Root.
     * @return string XML 结构的字符串
     */
    function array2xml($arr, $level = 1)
    {
        $s = $level == 1 ? "<xml>" : '';
        foreach ($arr as $tagname => $value) {
            if (is_numeric($tagname)) {
                $tagname = $value['TagName'];
                unset($value['TagName']);
            }
            if (!is_array($value)) {
                $s .= "<{$tagname}>" . (!is_numeric($value) ? '<![CDATA[' : '') . $value . (!is_numeric($value) ? ']]>' : '') . "</{$tagname}>";
            } else {
                $s .= "<{$tagname}>" . $this->array2xml($value, $level + 1) . "</{$tagname}>";
            }
        }
        $s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
        return $level == 1 ? $s . "</xml>" : $s;
    }

    function http_post($url, $param, $wxchat)
    {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        if (is_string($param)) {
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach ($param as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
        if ($wxchat) {
            curl_setopt($oCurl, CURLOPT_SSLCERT, dirname(THINK_PATH) . $wxchat['api_cert']);
            curl_setopt($oCurl, CURLOPT_SSLKEY, dirname(THINK_PATH) . $wxchat['api_key']);
            curl_setopt($oCurl, CURLOPT_CAINFO, dirname(THINK_PATH) . $wxchat['api_ca']);
        }
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }

    //支付金额原路退还
    public function payment_refund($data)
    {
        header("Content-type: text/html; charset=utf-8");
        exit('待开发');
    }


    /** h5网页调微信支付
     * H5支付
     * @param $order
     * @return string h5 pay url
     */
    public function weixin_h5_pay($order)
    {
        $notify_url = SITE_URL . '/index.php/Mobile/Payment/notifyUrl/'; // 接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数。
        //统一下单
        $input = new WxPayUnifiedOrder();    //统一下单
        $input->SetBody("顺亿特惠商城支付"); // 商品描述
        $input->SetOut_trade_no($order['order_sn'] . time()); // 商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号
        $input->SetTotal_fee($order['real_num'] * 100); // 订单总金额，单位为分，详见支付金额$order['real_num']
        $input->SetNotify_url($notify_url); // 接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数。
        $input->SetTrade_type("MWEB"); // 交易类型   取值如下：JSAPI，NATIVE，APP，MWEB，详细说明见参数规定    MWEB--H5微信支付
        $input->SetSceneInfo('{"h5_info": {"type":"Wap","wap_url": "https://pay.qq.com","wap_name": "腾讯充值"}}');
        $result = WxPayApi::unifiedOrder($input);
        $url = $result["mweb_url"];
        return urlencode($url);  //得到支付跳转的h5链接并返回给控制器，控制器用redirect跳转即可
    }


}