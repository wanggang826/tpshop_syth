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
class Users extends Model
{
    /**
     * 下级列表
     * @param $user_id 用户ID
     * $pagennum  数据起始点
     */
 public function getList($data ,$pagennum ='') {
     if($pagennum != ''){
         $where=$data;
         $list=  $this->where($where)->field('user_id,nickname,mobile,pay_points,level,last_login,position')->order('reg_time desc')->limit($pagennum,10)->select();
     }else{
         $page = $data['page'];
         unset($data['page']);
         $query=$where=$data;
         $list=  $this->where($where)->field('user_id,nickname,mobile,pay_points,level,last_login,position')->order('reg_time desc')->paginate('10',false,[$page,$query]);
     }
     return $list;
 }


}
