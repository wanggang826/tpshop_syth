<?php
///**
// * 定时任务(每月一号分期扣款)
// * Created by pengqiang.
// * User: Administrator
// * Date: 2017/10/23 0023
// * Time: 下午 1:51
// */
date_default_timezone_set('PRC');
header('Content-type:text/html;carset:UTF-8');
define('MYSQL_SERVER','192.168.124.222:3306');
define('MYSQL_USER','syth');
define('MYSQL_PASSWORD','syth');
define('MYSQL_DATABASE','syth');
define('MYSQL_DECODE','UTF8');

$fp = @fopen("D:/phpStudy/WWW/syth/auto.txt", "a+");
fwrite($fp, "自动播报时间：" . date("Y-m-d H:i:s")."\n");
fclose($fp);

/**
 * 链接数据库
 */
function  getmysql(){
    $con=@mysqli_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASSWORD,MYSQL_DATABASE) or die("链接mysql数据库失败。错误信息：".mysqli_error($con));
    return $con;
}

/**
 * 获取需要还款订单
 */
function reimbursement(){
    $con = getmysql();//链接数据库
    $months_xinyong = "UPDATE `sh_users` SET `months_xinyong`=50000"; //每月月初  每隔人信用金使用额度恢复5000;
    $con->query($months_xinyong);//每月月初  每隔人信用金使用额度恢复5000;
    $sql = "SELECT * FROM `sh_staging` WHERE (`status`=0 AND `surplus_nper` > 0)";//本月需要还款的信息
    $list = $con->query($sql);//本月需要还款的信息
    foreach ($list as $row){
        $user_id= $row['user_id'];//用户ID
        $pay_points=round(($row['percent_money']*1/100),2) ;//还款金额
        $add_xinyong = round(($pay_points*25/9),2);//还款之后添加信用金
        $order_id= $row['order_id'];//订单ID
        $id= $row['id'];//分期ID
        $surplus_money = round(($row['surplus_money']-$pay_points),2);//剩下还款金额
        $surplus_nper  =$row['surplus_nper']-1;
        if($surplus_nper ==0){
            $status =1;
        }else{
            $status =0;
        }
        $time = time();
        $user_sql = "UPDATE `sh_users` SET `pay_points`=`pay_points`-$pay_points AND `xinyongjin`=`xinyongjin`+$add_xinyong WHERE `user_id`=$user_id";//扣除用户表积分
        $con->query($user_sql);
        $account_log="INSERT INTO `sh_account_log` (`user_id`, `pay_points`,`desc`,`order_id`,`change_time`) VALUES ($user_id,-$pay_points,'商品分期抵扣',$order_id,$time)";//消费记录表添加消费记录
        $con->query($account_log);
        $staging = "UPDATE `sh_staging` SET `surplus_money`=$surplus_money,`surplus_nper`=$surplus_nper,`status`=$status,`update_time`=$time WHERE `id`=$id";//修改分期表
        $con->query($staging);
        //-------------------------奖励机制开始------------------------------------//
        $sql = "SELECT `position`,`client`,`business`,`area` FROM `sh_users` WHERE (`user_id`=$user_id)";//该用户所有上级
        $lead = $list = $con->query($sql);
        $member_arr=[];//参与提成人员以及提成比例
        //会员还款成功之后客户经理奖励总扣款积分客户经理奖励的15%，业务经理奖励3%，区域经理0.5%。
        if($lead['position']){//用户有职称
            if($lead['position']==1){//还款用户为区域经理
                $member_arr[$user_id] =18.5;//区域经理还款,区域经理提成18.5%
            }elseif($lead['position']==2){//还款用户为业务经理
                if($lead['area']){
                    $member_arr[$lead['area']] =0.5;//业务经理还款,区域经理提成0.5%
                }
                $member_arr[$user_id] =3;//业务经理还款,业务经理提成18.5%
            }elseif($lead['position']==3){//还款用户为客户经理
                if($lead['business']){//客户经理还款,如果客户有业务经理
                    $member_arr[$lead['business']] =3;//客户经理还款,业务经理提成3%
                    if($lead['area']){//客户经理还款,如果同时有业务经理和区域经理
                        $member_arr[$lead['area']] =0.5;//业务经理购买,区域经理提成0.5%
                    }
                }else{//如果此客户经理 没有业务经理
                    if($lead['area']){//客户经理还款,如果没有业务经理,只有区域经理
                        $member_arr[$lead['area']] =3.5;//业务经理还款,区域经理提成3.5%
                    }
                }
                $member_arr[$lead['area']] =15;//客户经理还款,客户经理提成15%
            }
        }else{//用户满意职称
            if($lead['area'] && $lead['business'] && $lead['client']){//会员的3个上级都存在
                $member_arr[$lead['area']] =0.5;//会员还款,区域经理提成0.5%
                $member_arr[$lead['business']] =3;//会员还款,业务经理提成3%
                $member_arr[$lead['client']] =15;//会员还款,客户经理提成15%
            }elseif($lead['area'] && $lead['business']){//会员只有业务经理 和区域经理
                $member_arr[$lead['area']] =0.5;//会员还款,区域经理提成0.5%
                $member_arr[$lead['business']] =18;//会员还款,业务经理提成18%
            }elseif($lead['area'] &&  $lead['client']){//会员只有客户经理 和区域经理
                $member_arr[$lead['area']] =3.5;//会员还款,区域经理提成3.5%
                $member_arr[$lead['client']] =15;//会员还款,客户经理提成15%
            }elseif( $lead['business'] && $lead['client']){//会员只有业务经理 和客户经理
                $member_arr[$lead['business']] =3;//会员还款,业务经理提成3%
                $member_arr[$lead['client']] =15;//会员还款,客户经理提成15%
            }elseif($lead['client']){//会员只有客户经理
                $member_arr[$lead['client']] =15;//会员还款,客户经理提成15%
            }elseif( $lead['business']){//会员只有业务经理
                $member_arr[$lead['business']] =18;//会员还款,业务经理提成18%
            }elseif($lead['area'] ){//会员只有区域经理
                $member_arr[$lead['area']] =18.5;//会员还款,区域经理提成18.5%
            }
        }
        foreach ($member_arr as $p =>$q){
            $member_money = $pay_points*$q/100;
            $user_sql = "UPDATE `sh_users` SET `pay_points`=`pay_points`+$pay_points  WHERE `user_id`=$p";//上级添加提成积分
            $con->query($user_sql);
            $account_log="INSERT INTO `sh_account_log` (`user_id`, `pay_points`,`desc`,`order_id`,`change_time`) VALUES ($user_id,$member_money,'下级分期还款提成',$order_id,$time)";//消费记录表添加消费记录
            $con->query($account_log);
        }
        //----------------------------奖励机制结束-----------------------------//
    }
}
reimbursement();
