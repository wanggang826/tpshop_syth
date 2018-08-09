<?php
header ( 'Content-type:text/html;charset=utf-8' );
include_once $_SERVER ['DOCUMENT_ROOT'] . '/upacp_demo_wtz/sdk/acp_service.php';

/**
 * 重要：联调测试时请仔细阅读注释！
 * 
 * 产品：无跳转产品<br>
 * 交易：查询卡开通状态：后台交易，无通知<br>
 * 日期： 2015-09<br>
 * 版本： 1.0.0
 * 版权： 中国银联<br>
 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
 * 交易说明：根据卡号查询卡是否已经开通，同步应答确定交易成功。
 */

//TODO 填寫卡信息
$accNo = '6226090000000048';

$params = array(

		//以下信息非特殊情况不需要改动
		'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,//版本号
		'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,//签名方法
		'encoding' => 'utf-8',		           //编码方式
		'txnType' => '78',		               //交易类型
		'txnSubType' => '00',		           //交易子类
		'bizType' => '000301',		           //业务类型
		'accessType' => '0',		           //接入类型
		'channelType' => '07',		           //渠道类型
		'encryptCertId' => com\unionpay\acp\sdk\AcpService::getEncryptCertId(), //验签证书序列号
		
		//TODO 以下信息需要填写
		'merId' => $_POST["merId"],		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
		'orderId' => $_POST["orderId"],	//商户订单号，填写被查询开通交易的orderId，此处默认取demo演示页面传递的参数
		'txnTime' => $_POST["txnTime"],	//订单发送时间，填写被查询开通交易的txnTime，此处默认取demo演示页面传递的参数
		'accNo' => com\unionpay\acp\sdk\AcpService::encryptData($accNo),     //卡号，新规范请按此方式填写
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
    //开通成功
    //TODO
    echo "开通成功。<br>\n";
    
    //customerInfo子域的获取
    if (array_key_exists("customerInfo", $result_arr)) {
    	echo "customerInfo子域：<br>\n";
    	$customerInfo = com\unionpay\acp\sdk\AcpService::parseCustomerInfo($result_arr["customerInfo"]);
    	if (array_key_exists("phoneNo", $customerInfo)) {
    		$phoneNo = $customerInfo["phoneNo"]; //customerInfo其他子域均可参考此方式获取
    	}
    	foreach ($customerInfo as $key => $value) {
    		echo  $key . "=" . $value . "<br>\n";
    	}
    }
    	
} else if ($result_arr["respCode"] == "77") {
    //未开通
    //TODO
    echo "未开通<br>\n";
} else {
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
