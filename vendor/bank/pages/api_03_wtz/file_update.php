<form class="api-form" method="post" action="demo/api_03_wtz/Form_7_3_FileUpdate.php" target="_blank">
<p>
<label>商户号：</label>
  <input id="merId" pattern="\d{15}" type="text" name="merId" placeholder="" value="777290058110097" title="默认商户号仅作为联调测试使用，正式上线还请使用正式申请的商户号" required="required"/>
</p>
<p>
  <label>订单发送时间：</label>
  <input id="txnTime" pattern="\d{14}" type="text" name="txnTime" placeholder="订单发送时间" value="<?php echo date('YmdHis')?>" title="取北京时间，YYYYMMDDhhmmss格式。如之前调用获取验证码接口，填写获取验证码时的txnTime。" required="required"/>
</p>
<p>
  <label>商户订单号：</label>
  <input id="orderId" pattern="[0-9a-zA-Z]{8,32}" type="text" name="orderId" placeholder="商户订单号" value="<?php echo date('YmdHis')?>" title="8-32位数字字母，自行定义内容。如之前调用获取验证码接口，填写获取验证码时的orderId。" required="required"/>
</p>
<p>
  <label>证书下载渠道：</label>
  <!--<label><input id="certType"  type="radio" name="certType" placeholder="" value="01" title="" required="required"/>敏感信息加密公钥</label> -->
  <label><input id="certType"  type="radio" name="certType" placeholder="" value="01" title="" required="required" checked="checked"/>敏感信息加密公钥</label> 

</p>
<p>
<br/>
 <input type="submit"  class="button" value="提交" />

</p>
</form>


