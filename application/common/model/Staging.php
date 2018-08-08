<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 下午 4:27
 */
namespace app\common\model;
use think\Model;

class Staging extends Model{
    public function getStaging($data){
    $page = $data['page'];
    unset($data['page']);
    $query=$data;
    return $this->where(['user_id'=>$data['user_id'],'status'=>0])->order('create_time desc')->paginate('15',false,[$page,$query]);

    }
}