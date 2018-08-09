<?php
use com\unionpay\acp\sdk\AcpService;
header ( 'Content-type:text/html;charset=utf-8' );
include_once $_SERVER ['DOCUMENT_ROOT'] . '/upacp_demo_wtz/sdk/acp_service.php';

/**
 * 
 * 银联加密公钥更新查询(只适用于使用RSA证书加密的方式<即signMethod=01>，其他signMethod=11，12密钥加密用不到此交易)
 * 商户定期（1天1次）向银联全渠道系统发起获取加密公钥信息交易.
 * 本交易成功后会自动替换配置文件acp_sdk.properties文件中acpsdk.encryptCert.path指定的文件，可用不用手工替换
 */
$params = array(

		//以下信息非特殊情况不需要改动
		'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,//版本号
		'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,//签名方法
		'encoding' => 'utf-8',		           //编码方式
		'txnType' => '95',		               //交易类型
		'txnSubType' => '00',		           //交易子类
		'bizType' => '000000',		           //业务类型
		'accessType' => '0',		           //接入类型
		'channelType' => '07',		           //渠道类型
		'certType' => '01',		               //01：敏感信息加密公钥(只有01可用)
		
		//TODO 以下信息需要填写
		'merId' => "777290058110048",		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
		'orderId' => date('YmdHis'),	//商户订单号，如上送短信验证码，请填写获取验证码时一样的orderId，此处默认取demo演示页面传递的参数
		'txnTime' => date('YmdHis'),	//订单发送时间，如上送短信验证码，请填写获取验证码时一样的txnTime，此处默认取demo演示页面传递的参数
);

com\unionpay\acp\sdk\AcpService::sign ( $params ); // 签名
$url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backTransUrl;

$result_arr = com\unionpay\acp\sdk\AcpService::post ( $params, $url );
if(count($result_arr)<=0) { //没收到200应答的情况
	printResult ( $url, $params, "" );
	return;
}

printResult ($url, $params, $result_arr ); //页面打印请求应答数据

if (!com\unionpay\acp\sdk\AcpService::validate ($result_arr) ){
	echo "应答报文验签失败<br>\n";
	return;
}


echo "应答报文验签成功<br>\n";
if ($result_arr["respCode"] == "00"){
    echo "交易成功。<br>\n";
    $resultCode = AcpService::updateEncryptCert($result_arr);
    if ($resultCode === 1){
    	echo "加密公钥更新成功。<br>\n";
    } else if ($resultCode === 0){
    	echo "加密公钥无更新。<br>\n";
    } else {
    	echo "加密公钥更新失败。<br>\n";
    }
}else {
    //其他应答码做以失败处理
     //TODO
     echo "失败：" . $result_arr["respMsg"] . "。<br>\n";
}

/**
 * 打印请求应答
 *
 * @param
 *        	$url
 * @param
 *        	$req
 * @param
 *        	$resp
 */
function printResult($url, $req, $resp) {
	echo "=============<br>\n";
	echo "地址：" . $url . "<br>\n";
	echo "请求：" . str_replace ( "\n", "\n<br>", htmlentities ( com\unionpay\acp\sdk\createLinkString ( $req, false, true ) ) ) . "<br>\n";
	echo "应答：" . str_replace ( "\n", "\n<br>", htmlentities ( com\unionpay\acp\sdk\createLinkString ( $resp , false, false )) ) . "<br>\n";
	echo "=============<br>\n";
}