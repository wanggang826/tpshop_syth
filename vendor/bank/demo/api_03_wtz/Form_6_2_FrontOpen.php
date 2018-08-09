<?php
header ( 'Content-type:text/html;charset=utf-8' );
include_once $_SERVER ['DOCUMENT_ROOT'] . '/upacp_demo_wtz/sdk/acp_service.php';

/**
 * 重要：联调测试时请仔细阅读注释！
 * 
 * 产品：无跳转产品<br>
 * 交易：银联侧开通：前台交易，有前台通知后台通知<br>
 * 日期： 2015-09<br>
 * 版本： 1.0.0
 * 版权： 中国银联<br>
 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
 * 交易说明:后台通知或者发起开通查询交易确认卡是否已经开通。
 */

//TODO 填寫卡信息
$accNo = '6226090000000048';
$customerInfo = array(
 		'phoneNo' => '18100000000', //手机号
		'certifTp' => '01', //证件类型，01-身份证
		'certifId' => '510265790128303', //证件号，15位身份证不校验尾号，18位会校验尾号，请务必在前端写好校验代码
		'customerNm' => '张三', //姓名
//   		'cvn2' => '248', //cvn2
//   		'expired' => '1912', //有效期，YYMM格式，持卡人卡面印的是MMYY的，请注意代码设置倒一下
);

$params = array(
		
		//以下信息非特殊情况不需要改动
		'version' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->version,//版本号
		'signMethod' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->signMethod,//签名方法
		'encoding' => 'utf-8',		           //编码方式
		'txnType' => '79',				      //交易类型
		'txnSubType' => '00',				  //交易子类
		'bizType' => '000301',				  //业务类型
		'accessType' => '0',		          //接入类型
		'channelType' => '07',	              //渠道类型，07-PC，08-手机
		'encryptCertId' => com\unionpay\acp\sdk\AcpService::getEncryptCertId(), //验签证书序列号
		'frontUrl' =>  com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->frontUrl,  //前台通知地址
		'backUrl' => com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->backUrl, //后台通知地址	
		
		//TODO 以下信息需要填写
		'merId' => $_POST["merId"],		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
		'orderId' => $_POST["orderId"],	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
		'txnTime' => $_POST["txnTime"],	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
// 		'reserved' => '{customPage=true}',	//如果开通页面需要使用嵌入页面的话，请上送此用法

// 		'accNo' => $accNo,     //卡号，旧规范请按此方式填写
// 		'customerInfo' => com\unionpay\acp\sdk\AcpService::getCustomerInfo($customerInfo), //持卡人身份信息，旧规范请按此方式填写
		'accNo' => com\unionpay\acp\sdk\AcpService::encryptData($accNo),     //卡号，新规范请按此方式填写
		'customerInfo' => com\unionpay\acp\sdk\AcpService::getCustomerInfoWithEncrypt($customerInfo), //持卡人身份信息，新规范请按此方式填写

		// 订单超时时间。
		// 超过此时间后，除网银交易外，其他交易银联系统会拒绝受理，提示超时。 跳转银行网银交易如果超时后交易成功，会自动退款，大约5个工作日金额返还到持卡人账户。
		// 此时间建议取支付时的北京时间加15分钟。
		// 超过超时时间调查询接口应答origRespCode不是A6或者00的就可以判断为失败。
		'payTimeout' => date('YmdHis', strtotime('+15 minutes')),
);

com\unionpay\acp\sdk\AcpService::sign ( $params );
$url = com\unionpay\acp\sdk\SDKConfig::getSDKConfig()->frontTransUrl;
$html_form = com\unionpay\acp\sdk\AcpService::createAutoFormHtml( $params, $url );
echo $html_form;
