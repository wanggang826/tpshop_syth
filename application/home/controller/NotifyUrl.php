<?php
namespace app\home\controller;
class NotifyUrl extends Base
{
    /* *
   * 功能：支付宝服务器异步通知页面
   * 版本：2.0
   * 修改日期：2016-11-01
   * 说明：
   * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

   *************************页面功能说明*************************
   * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
   * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
   * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
   */
    public function index()
    {
        vendor('alipay.AlipayTradeService');
        $merchant_private_key = 'MIIEpQIBAAKCAQEAwjnNaZvBL2DNmr+dWsW/cNzACmEvpKkuWqyOWHpwf35F92Ge4TATm+YMO0YZLRsRyOMLnftk97cbivQsqu8c7OV4UUH03F+dbwutJ3hfjOjfqVRb6OBHT3R2JYpDL/nvzdlhBkhiqI8Tqb4FUkJiYyMqXSSUGBK9ijKzUw2Ih9/ySABSpXEB1bHcLNgM/8ZeZdJy2iLxlmeEOcJVauLnjkssjZ3kctcSA18Rvh7iOJ0fPOzievPYjHg9HBDRz1tH7W8aVpIjn8bBK2QxpMKnfJHD1q2M/U+/HQXu7g2xZuCBxsAzDpS1i/rBqNgOQAjGFrnDSh3JPJt0T2E17jt/3QIDAQABAoIBADV6bum+PiIKeHI8glolCsJLtgDlo5WmE6JZ0tPf2qvwG9myommEsFGDtSh486OsyWfTxDYaq0FdxJKtCsOCFSfRQyC0lXQ8S3/w6httFHobAMKB/NCROHFTMtjBSiCio/m8+e8d7TRWOObK8HIm3ypG23pMAQ7j0haEQUYD+uzWLNC6VBq2nET3S88wIODLW1PRPpLufKOB9RKYKJDynDSf+Pthpxhu2ZMYAax0JD+dKoo6nlW1r51dhQP0/62LdqjIIzeu7Ccnfz4jNtY1Ehr4DEPfl2JO0ErNQynHrlO5JVodCkpX2LirHD9Q2rlIDJzYiBswk9fS+dpRhTISDOECgYEA6k88APQkyscsGZMgrVxWbKL2YK0Ccz0JSRbfEX5zWF/0tWJ3q9Gfc5Q3mpAiPVXWuyo1Dkp/pd8/wUsu83V5vNyaWWdqxjEQSP302vRg2HUU3Rco0cIuaY8EHe9/So8Oq7OI7WUy7Y/Bjz0xnDfGzf+squW5FcWTaHmp0G2lv6UCgYEA1DSlqfZDeezHQ3ryNIMEaDQ0JqjSBL2Eo/f0kiXY2enbEx5YBi4xG2f3qNOl8/sAA+yCynA1eUTq7vaMRVbX0oj+6qyWaDL6MP5XtDAbUxCX92PqqNir2/5t5D7EiXBVs3hKfUvyL/BAj6K4wo3qEcijj4lXFM8Mct56f+jeSdkCgYEAoiwVK9PPY0pXi5v5kgPHDYn9XQxiFcC5HI1n94O98fz4MlLk4VdFNYnwslnwWOOArCqabjnB/9x1FCQlavx0NfO6IQcjL+nli5+6SZG7NhZTSnMtHYF4/jaucsnBIKnDTbQFocnZZfOJ1MpV+/ne79V2fRJi+F63mCgdENXTUsECgYEAwDRvWOKVe3nbgmN5vdZtx3SBSALhNynxWhLckwN0xuvqYga5898i24/v4hrR1YsjGGrAjFvWE2E46fimVKe0FB3Bxw1LrlV+B6JYDf0EwtfkzU7S3NxjzX9GSdYQbewxs7zgu1xuoL0bvP3GG3Iu8KyqePgMx+xBeknI6tIhhQECgYEAosy+lDqWcGgtbkFfBZb4gYAKyurGynmDwrrbSxj+1eJE3un8BOTtAWjdxlQQiCgAjs9kdb91LAi7xpiTOWsX8UOaVU2AV4BxlB1v2980S9XnHchaqHRE+H8yCg7pZlYP1f1GPgTF+I/vBPuGmzwtrrpPa5rvRX1AO5BmSWHQe4c=';//file_get_contents("http://sy.baogt.com/vendor/alipay/rsa_private_key.pem");//gong
        $merchant_public_key = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwjnNaZvBL2DNmr+dWsW/cNzACmEvpKkuWqyOWHpwf35F92Ge4TATm+YMO0YZLRsRyOMLnftk97cbivQsqu8c7OV4UUH03F+dbwutJ3hfjOjfqVRb6OBHT3R2JYpDL/nvzdlhBkhiqI8Tqb4FUkJiYyMqXSSUGBK9ijKzUw2Ih9/ySABSpXEB1bHcLNgM/8ZeZdJy2iLxlmeEOcJVauLnjkssjZ3kctcSA18Rvh7iOJ0fPOzievPYjHg9HBDRz1tH7W8aVpIjn8bBK2QxpMKnfJHD1q2M/U+/HQXu7g2xZuCBxsAzDpS1i/rBqNgOQAjGFrnDSh3JPJt0T2E17jt/3QIDAQAB';
        //配置
        $config = array(
            'app_id' => "2017101909390719",//应用ID,您的APPID。
            'merchant_private_key' => $merchant_private_key,//商户私钥，您的原始格式RSA私钥
            'notify_url' => "http://sygwsc.cn/index.php/Home/NotifyUrl/ajax_url",//异步通知地址
            'return_url' => "http://sygwsc.cn/index.php/Home/NotifyUrl/index", //同步跳转
            'charset' => "UTF-8", //编码格式
            'sign_type' => "RSA2",//签名方式
            'gatewayUrl' => "https://openapi.alipay.com/gateway.do",//支付宝网关
            'alipay_public_key' => $merchant_public_key,//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        );
        $arr = input();
        $alipaySevice = new \AlipayTradeService($config);
        // $result = $alipaySevice->check($arr);
        //通过返回参数查看是否是想要的结果
        if (stripos($arr['out_trade_no'], 'recharge') !== false) {//充值
            $order = M('recharge')->where(['order_sn' => $arr['out_trade_no'],'account'=>$arr['total_amount']])->find();//
            $user_id = $order['user_id'];
            if ($order) {
                M('users')->where(['user_id' => $user_id])->setInc('pay_points', $arr['total_amount']);
                update_pay_status($arr['out_trade_no']); // 修改订单支付状态
                echo 'success';
                return $this->success('充值成功!', U('Home/User/account'));
            } else {
                return $this->error('充值失败!', U('Home/Index/index'));
            }
        } else {//购物
             $login_type = isMobile();//判断登录设备   true为移动端访问  false为PC端访问
             $order = M('order')->where(['order_sn' => $arr['out_trade_no'],'order_amount'=>$arr['total_amount']])->find();//实际支付金额要与该订单相符合,
            if($order && $order['pay_status']==0){
                 $user_id = $order['user_id'];
                 $money = round(($order['total_amount'] - $order['xinyong']), 2);//应该支付的金额
                 $out_trade_no = $arr['out_trade_no']; //商户订单号
                 $trade_no = $arr['trade_no']; //支付宝交易号
                 $trade_status = $arr['trade_status'];//交易状态
                 $money = round(($order['total_amount'] - $order['xinyong']), 2);//支付的金额
                 accountLog($user_id, "-$money", '', '下单消费', '', $order['order_id'], $order['order_sn']); //支付成功添加积分交易记录
                 //rewards($user_id,$order['order_id']);//各种经理返奖励
                // rebates($order['order_id']);//购物返点
                 update_pay_status($order['order_sn']);//支付成功改订单状态
                 echo 'success';//请不要修改或删除
                 if(isMobile()){
                     return $this->success('支付成功!', U('Mobile/User/order_list'));
                 }else{
                     return $this->success('支付成功!', U('Home/Order/order_list'));
                 }
             }else{
                 if($order['pay_status']==1){
                     if(isMobile()){
                         return $this->success('支付成功!', U('Mobile/User/order_list'));
                     }else{
                         return $this->success('支付成功!', U('Home/Order/order_list'));
                     }
                 }else{
                     echo "fail";	//请不要修改或删除
                     if(isMobile()){
                         return $this->success('非法操作!', U('Mobile/Index/index'));
                     } else {
                         return $this->success('非法操作!', U('Home/Index/index'));
                     }
                 }
             }
        }
    }

    /**
     * 异步回调地址
     */
    public function ajax_url(){
        file_put_contents('name.txt','212135');
    }
}

?>
<title>支付宝手机网站支付接口</title>
</head>
<body>
</body>
</html>

