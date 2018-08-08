<?php
namespace app\home\controller;

use think\Request;

class Payment extends Base
{

    public $payment; //  具体的支付类
    public $pay_code; //  具体的支付code

    public function __construct()
    {
        parent::__construct();
        $pay_radio = $_REQUEST['pay_radio'];
        if (!empty($pay_radio)) {
            $pay_radio = parse_url_param($pay_radio);
            $this->pay_code = $pay_radio['pay_code']; // 支付 code
        }
//        else // 第三方 支付商返回
//        {
//            $this->pay_code = 'weixin';//I('get.pay_code');
//            unset($_GET['pay_code']); // 用完之后删除, 以免进入签名判断里面去 导致错误
//        }
        $this->pay_code = 'weixin';
//        if (empty($this->pay_code)) {
//            exit('pay_code 不能为空');
//        }
        // 导入具体的支付类文件                
        include_once "plugins/payment/{$this->pay_code}/{$this->pay_code}.class.php"; // D:\wamp\www\svn_tpshop\www\plugins\payment\alipay\alipayPayment.class.php
        $code = '\\' . $this->pay_code; // \alipay
        $this->payment = new $code();
    }

    /**
     * 点击了确认支付，提交支付请求
     */
    public function getCode()
    {
        header("Content-type:text/html;charset=utf-8");
        $order_id = I('order_id/d'); // 订单id
        $type = I('type'); //  是否是积分充值行为
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
        session('order_id', $order_id); // 最近支付的一笔订单 id
        if (!session('user')) $this->error('请先登录', U('User/login'));

        if ($order['pay_status'] == 1) {
            $this->error('此订单，已完成支付!');
        }

        //微信JS支付
        if ($this->pay_code == 'weixin' && $_SESSION['openid'] && strstr($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
            $code_str = $this->payment->getJSAPI($order);
            exit($code_str);
        } else {
            $code_str = $this->payment->get_code($order);
        }
        $this->assign('code_str', $code_str);
        $this->assign('order_id', $order_id);
        return $this->fetch('payment');  // 分跳转 和不 跳转
    }

    // 服务器点对点
    public function notifyUrl()
    {
        $this->payment->response();
        exit();
    }

    //充值成功与否返回不同页面
    public function recharge_result(){
        $order_id = I('order_id'); // 最近支付的一笔订单 id
        $order = M('recharge')->where("order_id", $order_id)->find();
        $this->assign('order', $order);
        if ($order['pay_status'] == 1)
            return $this->fetch('recharge_success');
        else
            return $this->fetch('recharge_error');
    }
}
