<?php
ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ERROR);

require_once dirname(dirname(__FILE__)) . "/lib/WxPay.Api.php";
require_once dirname(dirname(__FILE__)) . "/lib/WxPay.Notify.php";
require_once 'log.php';

$f = dirname(dirname(__FILE__));
//初始化日志
$logHandler = new CLogFileHandler($f . "/logs/" . date('Y-m-d') . '.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        Log::DEBUG("query:" . json_encode($result));
        if (array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS") {
            return true;
        }
        return false;
    }

    //重写回调处理函数 支付结果回调，请求到这里(修改订单，各种后续操作等等)
    public function NotifyProcess($data, &$msg)
    {
        Log::DEBUG("call back:" . json_encode($data));
        if (!array_key_exists("transaction_id", $data)) {
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if (!$this->Queryorder($data["transaction_id"])) {
            $msg = "订单查询失败";
            return false;
        }
        $order_sn = $out_trade_no = $data['out_trade_no']; //商户系统的订单号，与请求一致。
        if (strlen($order_sn) > 18) {
            $order_sn = substr($order_sn, 0, 18);
        }
        //用户在线充值
        if (stripos($order_sn, 'rec') !== false) {
            $order_amount = M('recharge')->where(['order_sn' => $order_sn, 'pay_status' => 0])->value('account');
        } else {
            $order_amount = M('order')->where(['order_sn' => "$order_sn"])->value('order_amount');
        }
        if (($order_amount * 100) != $data['total_fee'])
            return false; //验证失败
        logger("微信支付成功啦：正在进入common类update_pay_status:" . $order_sn);
        update_pay_status($order_sn, array('transaction_id' => $data["transaction_id"])); // 修改订单支付状态

        return true;
    }
}

//Log::DEBUG("begin notify");
//$notify = new PayNotifyCallBack();
//$notify->Handle(false);
