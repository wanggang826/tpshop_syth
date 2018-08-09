<?php
$merchant_private_key=file_get_contents("http://sy.baogt.com/vendor/alipay/rsa_private_key.pem");
$merchant_public_key=file_get_contents("http://sy.baogt.com/vendor/alipay/rsa_public_key.pem");
$config = array (
		//应用ID,您的APPID。
		'app_id' => "2088721411793618",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' =>  $merchant_private_key,
		
		//异步通知地址
		'notify_url' => "http://sy.baogt.com/index.php/Home/NotifyUrl",
		
		//同步跳转
		'return_url' => "http://sy.baogt.com/index.php/Home/NotifyUrl",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => $merchant_public_key,
		
	
);