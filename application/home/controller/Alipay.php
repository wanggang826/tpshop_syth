<?php
namespace app\home\controller;
/**
 * 支付宝支付
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3 0003
 * Time: 下午 2:08
 */
header("Content-type: text/html; charset=utf-8");

class Alipay extends Base{
    /*public $payment; //  具体的支付类
    public $pay_code; //  具体的支付code*/

    /**
     * 支付宝支付方式
     */
    public function type_alipay()
    {
        vendor('alipay.AlipayTradeService');
        vendor('alipay.AlipayTradeWapPayContentBuilder');
//        $merchant_private_key = 'MIIEpQIBAAKCAQEAwjnNaZvBL2DNmr+dWsW/cNzACmEvpKkuWqyOWHpwf35F92Ge4TATm+YMO0YZLRsRyOMLnftk97cbivQsqu8c7OV4UUH03F+dbwutJ3hfjOjfqVRb6OBHT3R2JYpDL/nvzdlhBkhiqI8Tqb4FUkJiYyMqXSSUGBK9ijKzUw2Ih9/ySABSpXEB1bHcLNgM/8ZeZdJy2iLxlmeEOcJVauLnjkssjZ3kctcSA18Rvh7iOJ0fPOzievPYjHg9HBDRz1tH7W8aVpIjn8bBK2QxpMKnfJHD1q2M/U+/HQXu7g2xZuCBxsAzDpS1i/rBqNgOQAjGFrnDSh3JPJt0T2E17jt/3QIDAQABAoIBADV6bum+PiIKeHI8glolCsJLtgDlo5WmE6JZ0tPf2qvwG9myommEsFGDtSh486OsyWfTxDYaq0FdxJKtCsOCFSfRQyC0lXQ8S3/w6httFHobAMKB/NCROHFTMtjBSiCio/m8+e8d7TRWOObK8HIm3ypG23pMAQ7j0haEQUYD+uzWLNC6VBq2nET3S88wIODLW1PRPpLufKOB9RKYKJDynDSf+Pthpxhu2ZMYAax0JD+dKoo6nlW1r51dhQP0/62LdqjIIzeu7Ccnfz4jNtY1Ehr4DEPfl2JO0ErNQynHrlO5JVodCkpX2LirHD9Q2rlIDJzYiBswk9fS+dpRhTISDOECgYEA6k88APQkyscsGZMgrVxWbKL2YK0Ccz0JSRbfEX5zWF/0tWJ3q9Gfc5Q3mpAiPVXWuyo1Dkp/pd8/wUsu83V5vNyaWWdqxjEQSP302vRg2HUU3Rco0cIuaY8EHe9/So8Oq7OI7WUy7Y/Bjz0xnDfGzf+squW5FcWTaHmp0G2lv6UCgYEA1DSlqfZDeezHQ3ryNIMEaDQ0JqjSBL2Eo/f0kiXY2enbEx5YBi4xG2f3qNOl8/sAA+yCynA1eUTq7vaMRVbX0oj+6qyWaDL6MP5XtDAbUxCX92PqqNir2/5t5D7EiXBVs3hKfUvyL/BAj6K4wo3qEcijj4lXFM8Mct56f+jeSdkCgYEAoiwVK9PPY0pXi5v5kgPHDYn9XQxiFcC5HI1n94O98fz4MlLk4VdFNYnwslnwWOOArCqabjnB/9x1FCQlavx0NfO6IQcjL+nli5+6SZG7NhZTSnMtHYF4/jaucsnBIKnDTbQFocnZZfOJ1MpV+/ne79V2fRJi+F63mCgdENXTUsECgYEAwDRvWOKVe3nbgmN5vdZtx3SBSALhNynxWhLckwN0xuvqYga5898i24/v4hrR1YsjGGrAjFvWE2E46fimVKe0FB3Bxw1LrlV+B6JYDf0EwtfkzU7S3NxjzX9GSdYQbewxs7zgu1xuoL0bvP3GG3Iu8KyqePgMx+xBeknI6tIhhQECgYEAosy+lDqWcGgtbkFfBZb4gYAKyurGynmDwrrbSxj+1eJE3un8BOTtAWjdxlQQiCgAjs9kdb91LAi7xpiTOWsX8UOaVU2AV4BxlB1v2980S9XnHchaqHRE+H8yCg7pZlYP1f1GPgTF+I/vBPuGmzwtrrpPa5rvRX1AO5BmSWHQe4c=';//file_get_contents("http://sy.baogt.com/vendor/alipay/rsa_private_key.pem");//gong
//        $merchant_public_key = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwjnNaZvBL2DNmr+dWsW/cNzACmEvpKkuWqyOWHpwf35F92Ge4TATm+YMO0YZLRsRyOMLnftk97cbivQsqu8c7OV4UUH03F+dbwutJ3hfjOjfqVRb6OBHT3R2JYpDL/nvzdlhBkhiqI8Tqb4FUkJiYyMqXSSUGBK9ijKzUw2Ih9/ySABSpXEB1bHcLNgM/8ZeZdJy2iLxlmeEOcJVauLnjkssjZ3kctcSA18Rvh7iOJ0fPOzievPYjHg9HBDRz1tH7W8aVpIjn8bBK2QxpMKnfJHD1q2M/U+/HQXu7g2xZuCBxsAzDpS1i/rBqNgOQAjGFrnDSh3JPJt0T2E17jt/3QIDAQAB';
        $merchant_private_key ='MIIEowIBAAKCAQEA6FX5Cpj37uUBBwC0JuryTJlfxXh5uhCMLPHzpjb2yfJx7uDStsZu7cAUyPKp4CVolc6bq2f1dO6EaBa6DS5TYM+3QvrYhHw7eD9MspScZ3msMwuzojG5utexzSOWqH/3/IEmM/ARdKfrH50T73DKVkeGflj2nTUwjRaoTaX6P1by5Vk690PMZPhbamI4cMM7pI1jWrEL7kXj7Vhv+O5vtlbs6vL+l85qmYUWY2DhtxKKfmmkG0psQYI97jWDkP3e9cnHQd9NKmWbxs4RxIRjXAVzAW126bZw+/Sd0ZlAhaRiVlOTNwqCGDZIf8KbF+o5RrKn8mG3mWaenyif6aNkgQIDAQABAoIBAFMTesuJSw5HIIjqfYB0/lLZfN9VZuFbTWQ818yVVsV7RbYO+gmVBtFIn6YC7y9Q8QawLAWsVJ6NMxctGTXhXLr/Sx5OJ+GnsnQa3kf0z8BIR4SxKHhUo37l5ZPep950c638WDa2HufBq1dQiXJSuGcFiFfhY71u6X9pnKC3OrYuqJtFBkAY037u57rgkS1l7mHwSRhi606QwSOnas9XMBeWJFLP9fFvRrINHY3t5wMGW9wH6MyQVDfQl0uHk4QP3fogSe5EQzlzr30LCO3u5HQ7XO0HnfSQKSn/RIl7t+kq8ElMRl1DP8kfMfqBOrLd7UM5YbstkNa3uNm3VxgXdYECgYEA9tb7WtaeUg9sWkNor8Ri/ERwUXgXtlZl5rqW6dnW5EzEjCNPv5cPYw5pgnHcQ5UIhDAd7GHbE/u+i9v6bx0uH3Zyf6fFsid6ja3koMig3GHQL5NiHaa1txqBl6q1XXBWgYVyY4mhZXzFtZBvn0A4RDPPg805V181I9zCtQAAQdkCgYEA8PUzfpVIx1pklRdqUNQmcEYmbn53eO2WGa8zEOU8plJHVEAKzNnBR0h4uQfrNVvbf9LPXkVifUK3+P2NcAuwFshbJXJPxhP+bKwDREVpR7ah4cjA9x2pjZ0aKPLSevcI3Uu00MAS0ffkbM/1TkEhL+ZD8R9gIiFpLSMvcLKjZukCgYEAwuiMf3T6fKeLElcqAahb1QChg+MFLkhYnHD3m14Urh7kEBgN76XzU29c5tDLcV3r5J0t86ptWAEvu7YOsNBkzBk2XhB3La64ucj2v/LL+lkOD5McJXevAw9eBwmXvllnJUzfPzO9CqsUXsLXMPN/unMCx/sz7QbTqia2ZD/E9DkCgYBhfKMH3LgkR7MYCvAtoZenpwoXfD00BNPMsnBzrntaQ0GumXaFKLik8XI+UjDcVry4u37Agkv1p8+tAlB9+4yTux39SYFy/1XZe8KalYahyAc4xTMlB7A4pk4WMR/tNhM1DVMrffpfTu7xAzYZIgqeSYhFfs8zH9dgtrKT4wJvOQKBgDrLDjAv2dqCt26ZBuRlJTWdroeh5g3gwgfEB+5RaHyJHFrL1A5AikM59F2dJ3PdmmvxDmsM91oilVVJcjNvGBnrVsSJ2cBGhj34BiRMVj992OMRH5ihfyCL2kXUPD4TllQbls4Yr8F7NNgsR3Po7k+glA2+WTpIITCoR06G4Oue';
        $merchant_public_key ='MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA6FX5Cpj37uUBBwC0JuryTJlfxXh5uhCMLPHzpjb2yfJx7uDStsZu7cAUyPKp4CVolc6bq2f1dO6EaBa6DS5TYM+3QvrYhHw7eD9MspScZ3msMwuzojG5utexzSOWqH/3/IEmM/ARdKfrH50T73DKVkeGflj2nTUwjRaoTaX6P1by5Vk690PMZPhbamI4cMM7pI1jWrEL7kXj7Vhv+O5vtlbs6vL+l85qmYUWY2DhtxKKfmmkG0psQYI97jWDkP3e9cnHQd9NKmWbxs4RxIRjXAVzAW126bZw+/Sd0ZlAhaRiVlOTNwqCGDZIf8KbF+o5RrKn8mG3mWaenyif6aNkgQIDAQAB';
        //配置
        $config = array(
            'app_id' => '2017112400133708',//"2017101909390719",//应用ID,您的APPID。
            'merchant_private_key' => $merchant_private_key,//商户私钥，您的原始格式RSA私钥
            'notify_url' => "http://sygwsc.cn/index.php/Home/NotifyUrl/ajax_url",//异步通知地址
            'return_url' => "http://sygwsc.cn/index.php/Home/NotifyUrl/index", //同步跳转
            'charset' => "UTF-8", //编码格式
            'sign_type' => "RSA2",//签名方式
            'gatewayUrl' => "https://openapi.alipay.com/gateway.do",//支付宝网关
            'alipay_public_key' => $merchant_public_key,//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        );
        //订单信息
        $arr = input();
        $order_id = I('order_id'); //订单ID
        if(isset($arr['recharge'])){//充值
            $order = M('recharge')->where(['order_id' => $order_id, 'pay_status' => 0])->find();
        }else{//购物消费
            $order = M('order')->where(['order_id' => $order_id, 'pay_status' => 0])->find();
            if (!$order) $this->error('此订单，已完成支付!');
            $user_id = I('user_id')? I('user_id'):session('user.user_id');
            $member = M('Users')->where(['user_id'=>$user_id])->find();//获取用户信用金
            if($order['xinyong']>$member['xinyongjin']) return $this->error("信用金不足!");
            if($order['xinyong']>$member['months_xinyong']) return $this->error('本月剩余信用金额度不足!');
        }
        $out_trade_no = $order['order_sn']; //订单ID
        $subject = $order['order_sn']; //订单名称，必填
        $total_amount = round(($order['total_amount']-$order['xinyong']),2);//付款金额，必填
        $body = "test";//商品描述，可空
        $timeout_express = "1m";//超时时间
        //实例化类
        $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);
        $payResponse = new \AlipayTradeService($config);
        $result = $payResponse->wapPay($payRequestBuilder, $config['return_url'], $config['notify_url']);
        return;
    }


    /**
     * 银联支付
     */
    public function type_bank()
    {
        //订单信息
        $arr = input();
        dump($arr);die;
    }


}