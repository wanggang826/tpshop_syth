<?php

namespace app\mobile\controller;

use think\Request;

class Payment extends MobileBase
{

    public $payment; //  具体的支付类
    public $pay_code; //  具体的支付code

    /**
     * 析构流函数
     */
    public function __construct()
    {
        parent::__construct();
        // 订单支付方式提交
        $pay_radio = $_REQUEST['pay_radio'];
        if (!empty($pay_radio)) {
            $pay_radio = parse_url_param($pay_radio);
            $this->pay_code = $pay_radio['pay_code']; // 支付 code
        }
        //else // 第三方 支付商返回
//        {
//            $this->pay_code = I('get.pay_code');
//            unset($_GET['pay_code']); // 用完之后删除, 以免进入签名判断里面去 导致错误
//        }
        $this->pay_code = 'weixin'; //此处写定weixin算了
        if (empty($this->pay_code))
            exit('pay_code 不能为空');
        // 导入具体的支付类文件                
        include_once "plugins/payment/{$this->pay_code}/{$this->pay_code}.class.php"; // D:\wamp\www\svn_tpshop\www\plugins\payment\alipay\alipayPayment.class.php
        $code = '\\' . $this->pay_code; //
        $this->payment = new $code();   //实例化支付的插件类
       // include_once "plugins/payment/weixin/Wxpay/WxPayOrderQuery.class.php";
//        include_once "plugins/payment/weixin/lib/WxPay.Api.php";
    }

    /**
     * 提交支付方式
     */
    public function getCode()
    {
        header("Content-type:text/html;charset=utf-8");
        $order_id = I('order_id/d'); // 订单id
        $type = I('type'); //  是否是积分充值行为
        if($order_id){
            session('order_id',$order_id);
            session('type',$type);
        }else{
            $order_id =  session('order_id');
            $type     =  session('type');
        }
        if ($type === 'recharge') {
            $order = M('recharge')->where(array("order_id" => $order_id))->find();  //从充值表获取这条充值的基本信息
            $order['real_num'] = $order['account'];  //实际支付的钱
        } else {
            $payment_arr = M('Plugin')->where("`type` = 'payment'")->getField("code,name");
            M('order')->where("order_id", $order_id)->save(array('pay_code' => $this->pay_code, 'pay_name' => $payment_arr[$this->pay_code]));
            $order = M('order')->where("order_id", $order_id)->find();
            //此处是用微信支付，应该除开分期的信用金支付的，只支付剩下的积分支付的金额
            $order['real_num'] = round(($order['total_amount'] - $order['xinyong']), 2);//本次下单需要支付的钱
        }
        if (!session('user')) $this->error('请先登录', U('User/login'));

        if ($order['pay_status'] == 1) {
            $this->error('此订单，已完成支付!');
        }
        //微信JS支付
        if (strstr($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
            $code_str = $this->getJSAPI($order);
            echo $code_str;exit;
        } else {
            $code_str = $this->payment->weixin_h5_pay($order); //生成h5支付页面地址
            //手机H5支付
            header('Location: ' . urldecode($code_str));  //跳转到微信h5支付链接页面
        }
    }


    /**
     * 微信服务器回调地址
     */
    public function notifyUrl()
    {
        $this->payment->response();
        exit();
    }
//-----------------公众号支付单独走支付流程------------------------//
    /**
     * JS(公众号)支付
     * @param $order
     * @return string
     */
    function getJSAPI($order)
    {
        include_once "plugins/payment/weixin/lib/WxPay.Api.php"; // 微信扫码支付demo 中的文件
        include_once "plugins/payment/weixin/example/WxPay.NativePay.php";
        include_once "plugins/payment/weixin/example/WxPay.JsApiPay.php";
        if($order['order_sn']) {
            if (stripos($order['order_sn'], 'recharge') !== false) {//充值回跳地址
                $go_url = U('Mobile/User/points', array('type' => 'recharge'));
                $back_url = U('Mobile/User/recharge', array('order_id' => $order['order_id']));
            } else {//购物回跳地址
                $go_url = U('Mobile/User/order_list', array('order_id' => $order['order_id']));
                $back_url = U('Mobile/Cart/cart4', array('order_id' => $order['order_id']));
            }
            //①、获取用户openid
            $tools = new \JsApiPay();
            $openId = $tools->GetOpenid();
            //②、统一下单
            $input = new \WxPayUnifiedOrder();
            $input->SetBody("顺亿特惠商城支付：" . $order['order_sn']);
            $input->SetAttach("weixin");
            $input->SetOut_trade_no($order['order_sn']);
            $input->SetTotal_fee($order['real_num'] * 100);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            $input->SetGoods_tag("tp_wx_pay");
            $input->SetNotify_url(SITE_URL . '/Mobile/Payment/getJsRequery/');
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($openId);
            $order2 = \WxPayApi::unifiedOrder($input);
            $jsApiParameters = $tools->GetJsApiParameters($order2);
            $html = <<<EOF
	<script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',$jsApiParameters,
			function(res){
				//WeixinJSBridge.log(res.err_msg);
				 if(res.err_msg == "get_brand_wcpay_request:ok") {			
				    location.href='$go_url';
				 }else{
				 	alert(res.err_code+res.err_desc+res.err_msg);
				    location.href='$back_url';
				 }
			}
		);
	}
	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	callpay();
	</script>
EOF;
            return $html;
        }
    }
//-----------------公众号支付单独走支付流程------------------------//

   //------------JS(公众号)支付单独回调------------------//
    public function getJsRequery(){
        $streamData = isset($GLOBALS['HTTP_RAW_POST_DATA'])? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
        if(empty($streamData)) {
            $streamData = file_get_contents('php://input');
        }
        $xmlstring = simplexml_load_string($streamData, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring),true);
        if($val['return_code']=='SUCCESS'){
            $order_sn=$val["out_trade_no"];//订单号
            if (stripos($order_sn, 'recharge') !== false) {//充值
                $order = M('recharge')->where(['order_sn' =>$order_sn])->find();//
                $user_id = $order['user_id'];
                if ($order) {
//                    file_put_contents('aa.txt',$order['account']);
//                    M('users')->where(['user_id' => $user_id])->setInc('pay_points', $order['account']);
                    update_pay_status($order_sn); // 修改订单支付状态
                    echo 'success';
                    return $this->success('充值成功!', U('Mobile/User/account'));
                } else {
                    echo "fail";	//请不要修改或删除
                    return $this->error('充值失败!', U('Mobile/Index/index'));
                }
            } else {//购物
                $order = M('order')->where(['order_sn' => $order_sn])->find();//
                if($order && $order['pay_status']==0){
                    $user_id = $order['user_id'];
                    $money = round(($order['total_amount'] - $order['xinyong']), 2);//支付的金额
                    accountLog($user_id, "-$money", '', '下单消费', '', $order['order_id'], $order['order_sn']); //支付成功添加积分交易记录
                    update_pay_status($order['order_sn']);//支付成功改订单状态
                    echo 'success';//请不要修改或删除
                     return $this->success('支付成功!', U('Mobile/User/order_list'));
                }else{
                    if($order['pay_status']==1){
                        echo 'success';//请不要修改或删除
                        return $this->success('支付成功!', U('Mobile/User/order_list'));
                    }
                }
            }
        }else{
            echo "fail";	//请不要修改或删除
            return $this->success('支付失败!', U('Mobile/User/order_list'));
        }
    }
//------------JS(公众号)支付单独回调------------------//


    /** 支付结果通过cart4页面的一个ajax请求API控制器判断订单支付状态，根据状态来进行页面跳转（其实可以直接请求)
     * @return mixed
     */
    public function returnUrl()
    {
        $order_id = I('order_id/d'); //订单id
        $order_sn = I('order_sn'); //订单id
        if (stripos($order_sn, 'recharge') !== false) {
            $order = M('recharge')->where("order_sn", $order_sn)->find();
            $this->assign('order', $order);
            if ($order['pay_status'] == 1)
                return $this->fetch('recharge_success');
            else
                return $this->fetch('recharge_error');
            exit();
        }
        $order = M('order')->where("order_id", $order_id)->find();
        $this->assign('order', $order);
        if ($order['pay_status'] == 1) {
            return $this->fetch('success');
        } else {
            return $this->fetch('error');
        }

    }
}
