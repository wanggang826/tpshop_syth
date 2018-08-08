<?php
/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: IT宇宙人
 * Date: 2015-09-09
 */
namespace app\common\model;
use think\Model;
class AccountLog extends Model
{
    /**
     * 用户消费记录
     * @param $user_id 用户ID
     */
 public function getList($user_id,$page) {
     $where = "`user_id`=$user_id AND (`pay_points`< 0 OR `user_money`< 0)";
     $query = ['user_id'=>$user_id];
     $list=  $this->where($where)->order('change_time desc')->paginate('10',false,[$page,$query]);
     return $list;
 }


}
