<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * 采用TP5助手函数可实现单字母函数M D U等,也可db::name方式,可双向兼容
 * ============================================================================
 * 2015-11-21
 */
namespace app\mobile\controller;

use app\common\logic\CartLogic;
use app\common\logic\MessageLogic;
use app\common\logic\UsersLogic;
use app\common\logic\OrderLogic;
use think\Page;
use think\Request;
use think\Verify;
use think\db;

class Order extends MobileBase
{

    public $user_id = 0;
    public $user = array();

    public function _initialize()
    {
        parent::_initialize();
        if (session('?user')) {
            $user = session('user');
            $user = M('users')->where("user_id", $user['user_id'])->find();
            session('user', $user);  //覆盖session 中的 user
            $this->user = $user;
            $this->user_id = $user['user_id'];
            $this->assign('user', $user); //存储用户信息
            $this->assign('user_id', $this->user_id);
        } else {
            header("location:" . U('User/login'));
            exit;
        }
        $order_status_coment = array(
            'WAITPAY' => '待付款 ', //订单查询状态 待支付
            'WAITSEND' => '待发货', //订单查询状态 待发货
            'WAITRECEIVE' => '待收货', //订单查询状态 待收货
            'WAITCCOMMENT' => '待评价', //订单查询状态 待评价
        );
        $this->assign('order_status_coment', $order_status_coment);
    }

    //订单支付后取消订单
    public function refund_order()
    {
        $order_id = I('get.order_id/d');

        $order = M('order')
            ->field('order_id,pay_code,pay_name,user_money,integral_money,coupon_price,order_amount')
            ->where(['order_id' => $order_id, 'user_id' => $this->user_id])
            ->find();

        $this->assign('user',  $this->user);
        $this->assign('order', $order);
        return $this->fetch();
    }
    //申请取消订单
    public function record_refund_order()
    {
        $order_id   = input('post.order_id', 0);
        $user_note  = input('post.user_note', '');
        $consignee  = input('post.consignee', '');
        $mobile     = input('post.mobile', '');

        $logic = new \app\common\logic\OrderLogic;
        $return = $logic->recordRefundOrder($this->user_id, $order_id, $user_note, $consignee, $mobile);

        $this->ajaxReturn($return);
    }

}