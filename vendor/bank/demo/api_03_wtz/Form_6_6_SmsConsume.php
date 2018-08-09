<?php
header ( 'Content-type:text/html;charset=utf-8' );
include_once $_SERVER ['DOCUMENT_ROOT'] . '/upacp_demo_wtz/sdk/acp_service.php';

/**
 * 重要：联调测试时请仔细阅读注释！
 * 
 * 产品：无跳转产品<br>
 * 交易：消费短信：后台交易，无通知<br>
 * 日期： 2015-09<br>
 * 版本： 1.0.0
 * 版权： 中国银联<br>
 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
 * 交易说明: 金额  + 卡号  + 手机号phoneNo（customerInfo域），同步应答确定交易成功。
 */

//TODO 填寫卡信息
$accNo = '6226388000000095';
$customerInfo = array(
		'phoneNo' => '18100000000', //手机号
);

$params = array(

		//以下信息非特殊情况不需要改动
		'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,//版本号
		'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,//签名方法
		'encoding' => 'utf-8',		           //编码方式
		'txnType' => '77',		             //交易类型
		'txnSubType' => '02',		           //交易子类
		'bizType' => '000301',		         //业务类型
		'accessType' => '0',		           //接入类型
		'channelType' => '07',		           //渠道类型
        'currencyCode' => '156',          //交易币种，境内商户勿改
		'encryptCertId' => com\unionpay\acp\sdk\AcpService::getEncryptCertId(), //验签证书序列号
		
		//TODO 以下信息需要填写
		'merId' => $_POST["merId"],		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
		'orderId' => $_POST["orderId"],	//商户订单号，填写开通并支付交易的orderId，此处默认取demo演示页面传递的参数
		'txnTime' => $_POST["txnTime"],	//订单发送时间，填写开通并支付交易的orderId，此处默认取demo演示页面传递的参数
		'txnAmt' => $_POST["txnAmt"],	//交易金额，单位分，如上送短信验证码，请填写获取验证码时一样的txnAmt，此处默认取demo演示页面传递的参数
		
// 		'accNo' => $accNo,     //卡号，旧规范请按此方式填写
// 		'customerInfo' => com\unionpay\acp\sdk\AcpService::getCustomerInfo($customerInfo), //持卡人身份信息，旧规范请按此方式填写
		'accNo' => com\unionpay\acp\sdk\AcpService::encryptData($accNo),     //卡号，新规范请按此方式填写
		'customerInfo' => com\unionpay\acp\sdk\AcpService::getCustomerInfoWithEncrypt($customerInfo), //持卡人身份信息，新规范请按此方式填写
		
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
    //TODO
    echo "交易成功。<br>\n";
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
