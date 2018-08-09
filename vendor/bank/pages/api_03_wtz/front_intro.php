﻿测试卡号：与银联测试环境联调使用的卡号 <a href="https://open.unionpay.com/ajweb/help/faq/list?id=4&level=0&from=0" target="_blank">测试卡号</a><br><br>
交易流程：<br>
<b>开通流程：首先根据卡号调用“开通状态查询”交易 如果未开通则调用前台开通交易，开通成功后则走消费流程。
消费流程：如果已开通则直接消费（如果消费需要发送短信则消费前调用消费短信交易）</b><br><br>

<b>注：本前台开通因测试商户号777290058110097银联后台配置了 借记卡只支持前台开通，贷记卡只支持后台开通，故本银联侧样例中使用借记卡测试才有权限。</b><br><br>

银联侧开通：前台交易，有前台返回商户按钮（前台通知）和后台通知<br><br>
开通状态查询：后台同步交易，根据卡号查询卡号的开通状态<br><br>
消费短信：后台同步交易，上送手机号+卡号<br><br>
消费：后台异步交易，有后台通知。一般只需送短信验证码+卡号即可，验证码看业务配置（默认要短信验证码）<br><br>

交易状态查询说明：<br>
origrespcode=00成功，03、04、05重新查询，其他为失败。<br><br>
消费撤销交易与退货：<br>
消费撤销和退货有什么区别？<br>
消费撤销仅能对当天的消费做，必须为全额，一般当日或第二日到账，可能存在极少数银行不支持。<br>
退货能对11个月内的消费做（包括当天），支持部分退货或全额退货，到账时间较长，一般1-10天（多数发卡行5天内，但工行可能会10天），所有银行都支持。<br>
注：以上的天均指清算日，一般前一日23点至当天23点为一个清算日。测试环境为测试需要，13:30左右日切，所以13:30到13:30为一个清算日。<br><br>
对账文件下载：<br>
对账文件什么时候能下载？<br>
测试环境一般下午5点出，文件内包含的交易的时间范围是13:30-13:30。<br>
生产环境一般早上9点出，文件内包含的交易的时间范围是23:00-23:00。<br><br>
对账文件获取后会落地成一个zip文件，zip文件中的ZM，ZME文件各个字段的拆分解析可以参考DemoBase.java中的parseZMFile parseZMEFile 方法。<br>
