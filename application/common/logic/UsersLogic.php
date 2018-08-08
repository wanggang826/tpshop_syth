<?php
/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * 采用TP5助手函数可实现单字母函数M D U等,也可db::name方式,可双向兼容
 * ============================================================================
 * Author: IT宇宙人
 * Date: 2015-09-09
 */

namespace app\common\logic;

use app\common\model\UserAddress;

use org\ImgHelper;
use org\ImgUpDownHelper;
use org\QRcode;
use think\Model;
use think\Page;
use think\db;
use think\Request;

/**
 * 分类逻辑定义
 * Class CatsLogic
 * @package Home\Logic
 */
class UsersLogic extends Model
{
    /*
     * 登陆
     */
    public function login($username,$password){
    	$result = array();
        if(!$username || !$password)
           $result= array('status'=>0,'msg'=>'请填写账号或密码');
        $user = M('users')->where("mobile",$username)->whereOr('email',$username)->find();
        if(!$user){
           $result = array('status'=>-1,'msg'=>'账号不存在!');
        }elseif(encrypt($password) != $user['password']){
           $result = array('status'=>-2,'msg'=>'密码错误!');
        }elseif($user['is_lock'] == 1){
           $result = array('status'=>-3,'msg'=>'账号异常已被锁定！！！');
        }else{
            //查询用户信息之后, 查询用户的登记昵称
            $levelId = $user['level'];
            $levelName = M("user_level")->where("level_id", $levelId)->getField("level_name");
            $user['level_name'] = $levelName;

           $result = array('status'=>1,'msg'=>'登陆成功','result'=>$user);
        }
        return $result;
    }

    /*
     * app端登陆
     */
    public function app_login($username, $password, $capache, $push_id=0)
    {
    	$result = array();
        if(!$username || !$password)
           $result= array('status'=>0,'msg'=>'请填写账号或密码');
        $user = M('users')->where("mobile|email","=",$username)->find();
        if(!$user){
           $result = array('status'=>-1,'msg'=>'账号不存在!');
        }elseif($password != $user['password']){
           $result = array('status'=>-2,'msg'=>'密码错误!');
        }elseif($user['is_lock'] == 1){
           $result = array('status'=>-3,'msg'=>'账号异常已被锁定！！！');
        }else{
            //查询用户信息之后, 查询用户的登记昵称
            $levelId = $user['level'];
            $levelName = M("user_level")->where("level_id", $levelId)->getField("level_name");
            $user['level_name'] = $levelName;
            $user['token'] = md5(time().mt_rand(1,999999999));
            $data = ['token' => $user['token'], 'last_login' => time()];
            $push_id && $data['push_id'] = $push_id;
            M('users')->where("user_id", $user['user_id'])->save($data);
            $result = array('status'=>1,'msg'=>'登陆成功','result'=>$user);
        }
        return $result;
    }

    /*
     * app端登出
     */
    public function app_logout($token = '')
    {
        if (empty($token)){
            ajaxReturn(['status'=>-100, 'msg'=>'已经退出账户']);
        }

        $user = M('users')->where("token", $token)->find();
        if (empty($user)) {
            ajaxReturn(['status'=>-101, 'msg'=>'用户不在登录状态']);
        }

        M('users')->where(["user_id" => $user['user_id']])->save(['last_login' => 0, 'token' => '']);
        session(null);

        return ['status'=>1, 'msg'=>'退出账户成功'];
    }

    //绑定账号
    public function oauth_bind($data = array()){
    	$user = session('user');
    	if(empty($user['openid'])){
    		if(M('users')->where(array('openid'=>$data['openid']))->count()>0){
    			return array('status'=>-1,'msg'=>'您的'.$data['oauth'].'账号已经绑定过账号');
    		}else{
    			 M('users')->where(array('user_id'=>$user['user_id']))->save($data);
    			 return array('status'=>1,'msg'=>'绑定成功','result'=>$data);
    		}
    	}else{
    		return array('status'=>-1,'msg'=>'您的账号已绑定过，请不要重复绑定');
    	}
    }


    /*
     * 第三方登录
     */
    public function thirdLogin($data=array()){
        $openid = $data['openid']; //第三方返回唯一标识
        $oauth = $data['oauth']; //来源
        if(!$openid || !$oauth)
            return array('status'=>-1,'msg'=>'参数有误','result'=>'');
        //获取用户信息
        if(!empty($data['unionid'])){
        	$map['unionid'] = $data['unionid'];
        	$user = get_user_info($data['unionid'],4,$oauth);
        }else{
        	$user = get_user_info($openid,3,$oauth);
        }
        $data['push_id'] && $map['push_id'] = $data['push_id'];
        $map['token'] = md5(time().mt_rand(1,999999999));
        $map['last_login'] = time();
        if (!$user) {
            //账户不存在 注册一个
            $map['password'] = '';
            $map['openid'] = $openid;
            $map['nickname'] = $data['nickname'];
            $map['reg_time'] = time();
            $map['oauth'] = $oauth;
            if(!empty($data['head_pic'])){
                //上传头像到本地服务器
                $path = '/public/upload/head_pic/';
                $savepath = '.'.$path;
                $img = ImgHelper::downImg($data['head_pic'], $savepath);
                $imgUrl = $path.$img;
                if (!$img) {
                    return ['status'=>-1,'msg'=>'头像上传失败','result'=>$user];
                }
                $map['head_pic'] = $imgUrl;
            }
            $map['sex'] = empty($data['sex']) ? 0 : $data['sex'];
            $row_id = M('users')->insertGetId($map);
            $user = M('users')->where("user_id", $row_id)->find();
        } else {
            M('users')->where("user_id", $user['user_id'])->save($map);
            $user['token'] = $map['token'];
            $user['last_login'] = $map['last_login'];
        }
        return array('status'=>1,'msg'=>'登陆成功','result'=>$user);
    }


    /**
     * 注册
     * @param $username  邮箱或手机
     * @param $password  密码
     * @param $password2 确认密码
     * @return array
     */
    public function reg($username,$password,$password2, $push_id=0,$invite){

        if(strlen($password) < 6 ||strlen($password2) < 6)
            return array('status'=>-1,'msg'=>'密码最少6位');

        if(!$username || !$password)
            return array('status'=>-1,'msg'=>'请输入用户名或密码');

        //验证两次密码是否匹配
        if($password2 != $password)
            return array('status'=>-1,'msg'=>'两次输入密码不一致');
        //验证是否存在用户名
        if(get_user_info($username,1)||get_user_info($username,2))
            return array('status'=>-1,'msg'=>'账号已存在');
        $map['mobile'] = $username;
        $map['password'] = encrypt($password);
        $map['reg_time'] = time();
		if(!empty($invite)) {
            //邀请人用户id  根据邀请人的id确定身份
            $manager_data = invite($invite);
            $map['first_leader'] = $invite;
            //dump($manager_data);die;
            if (is_array($manager_data)) {
                #1如果是经理级别则找到他的级别和上级经理，写入到这个新用户绑定的各个经理字段，
                $map = array_merge($manager_data, $map);
            }
            #2如果是普通会员则写入推广人leaders字段，把它的上级信息查出来写入新用户first_leader字段（数据库还有second_leader third_leader 两个字段暂时不用了）
            $leaders = M('users')->where(array('user_id' => $invite))->getField('leaders');
            if (empty($leaders)) {
                $map['leaders'] = '.' . $invite . '.';
            } else {
                $map['leaders'] = $leaders . $invite . '.';
            }
        }

        $map['push_id'] = $push_id; //推送id
        $map['token'] = md5(time().mt_rand(1,999999999));
        $map['last_login'] = time();
        //读取后台设置的红包奖励， 是否是注册的时候自动发放，是的话才赠送
        $auto_red_package = tpCache('basic.auto_red_package');
        $reg_integral = tpCache('basic.reg_integral');
        if($auto_red_package == 1 && $reg_integral > 0){
            $map['pay_points'] = $reg_integral;
            $map['got_red_package'] = 1;  //已经领取注册红包
        }
        $user_id = M('users')->insertGetId($map);
        if($user_id === false)
            return array('status'=>-1,'msg'=>'注册失败');

//        $pay_points = tpCache('basic.reg_integral'); // 会员注册赠送积分
//        if($pay_points > 0){
//            accountLog($user_id, 0,$pay_points, '会员注册赠送积分'); // 记录日志流水
//        }

        //生成注册的推广的二维码,加一个当前用户的id，别人扫码带这个参数请求注册接口，知道是当前用户的推广过来的
        $url_data = Request::instance()->domain().'/mobile/user/reg/invite/'.$user_id;  //二维码带推广用户id跳转到注册页面
        $qrcode_img = $this->createQrcode($url_data, $user_id);
        M('users')->where('user_id', $user_id)->save(array('qrcode'=>$qrcode_img));  //存数据库
        $user = M('users')->where("user_id", $user_id)->find();
        return array('status'=>1,'msg'=>'注册成功','result'=>$user);
    }

     /*
      * 获取当前登录用户信息
      */
    public function get_info($user_id)
    {
        if (!$user_id) {
            return array('status'=>-1, 'msg'=>'缺少参数');
        }

        $user = M('users')->where('user_id', $user_id)->find();
        if (!$user) {
            return false;
        }

        $activityLogic = new \app\common\logic\ActivityLogic;             //获取能使用优惠券个数
        $user['coupon_count'] = $activityLogic->getUserCouponNum($user_id, 0);

        $user['collect_count'] = $this->getGoodsCollectNum($user_id);; //获取收藏数量
        $user['return_count'] = M('return_goods')->where("user_id=$user_id and status<2")->count();   //退换货数量

        $user['waitPay']     = M('order')->where("user_id = :user_id ".C('WAITPAY'))->bind(['user_id'=>$user_id])->count(); //待付款数量
        $user['waitSend']    = M('order')->where("user_id = :user_id ".C('WAITSEND'))->bind(['user_id'=>$user_id])->count(); //待发货数量
        $user['waitReceive'] = M('order')->where("user_id = :user_id ".C('WAITRECEIVE'))->bind(['user_id'=>$user_id])->count(); //待收货数量
        $user['order_count'] = $user['waitPay'] + $user['waitSend'] + $user['waitReceive'];

        $commentLogic = new CommentLogic;
        $user['comment_count'] = $commentLogic->getHadCommentNum($user_id); //已评论数
        $user['uncomment_count'] = $commentLogic->getWaitCommentNum($user_id); //待评论数

        return ['status' => 1, 'msg' => '获取成功', 'result' => $user];
     }

    /*
      * 获取当前登录用户信息
      */
    public function getApiUserInfo($user_id)
    {
        if (!$user_id) {
            return array('status'=>-1, 'msg'=>'账户未登陆');
        }

        $user = M('users')->where('user_id', $user_id)->find();
        if (!$user) {
            return false;
        }

        $activityLogic = new \app\common\logic\ActivityLogic;             //获取能使用优惠券个数
        $user['coupon_count'] = $activityLogic->getUserCouponNum($user_id, 0);

        $user['collect_count'] = $this->getGoodsCollectNum($user_id);; //获取收藏数量
        $user['visit_count']   = M('goods_visit')->where('user_id', $user_id)->count();   //商品访问记录数
        $user['return_count'] = M('return_goods')->where("user_id=$user_id and status<2")->count();   //退换货数量

        $user['waitPay']     = M('order')->where("user_id = :user_id ".C('WAITPAY'))->bind(['user_id'=>$user_id])->count(); //待付款数量
        $user['waitSend']    = M('order')->where("user_id = :user_id ".C('WAITSEND'))->bind(['user_id'=>$user_id])->count(); //待发货数量
        $user['waitReceive'] = M('order')->where("user_id = :user_id ".C('WAITRECEIVE'))->bind(['user_id'=>$user_id])->count(); //待收货数量
        $user['order_count'] = $user['waitPay'] + $user['waitSend'] + $user['waitReceive'];

        $messageLogic = new \app\common\logic\MessageLogic();
        $user['message_count'] = $messageLogic->getUserMessageCount();

        $commentLogic = new CommentLogic;
        $user['comment_count'] = $commentLogic->getHadCommentNum($user_id); //已评论数
        $user['uncomment_count'] = $commentLogic->getWaitCommentNum($user_id); //待评论数

        $cartLogic = new CartLogic();
        $cartLogic->setUserId($user_id);
        $user['cart_goods_num'] = $cartLogic->getUserCartGoodsNum();

         return ['status' => 1, 'msg' => '获取成功', 'result' => $user];
     }

    /*
     * 获取最近一笔订单
     */
    public function get_last_order($user_id){
        $last_order = M('order')->where("user_id", $user_id)->order('order_id DESC')->find();
        return $last_order;
    }


    /*
     * 获取订单商品
     */
    public function get_order_goods($order_id){
        $sql = "SELECT og.*,g.commission FROM __PREFIX__order_goods og LEFT JOIN __PREFIX__goods g ON g.goods_id = og.goods_id WHERE order_id = :order_id";
        $bind['order_id'] = $order_id;
        $goods_list = DB::query($sql,$bind);

        $return['status'] = 1;
        $return['msg'] = '';
        $return['result'] = $goods_list;
        return $return;
    }

    /**
     * 获取账户资金记录
     * @param $user_id|用户id
     * @param int $account_type|收入：1,支出:2 所有：0
     * @return mixed
     */
    public function get_account_log($user_id,$account_type = 0){
        $account_log_where = ['user_id'=>$user_id];
        if($account_type == 1){
            $account_log_where['user_money|pay_points'] = ['gt',0];
        }
        if($account_type == 2){
            $account_log_where['user_money|pay_points'] = ['lt',0];
        }
        $count = M('account_log')->where($account_log_where)->count();
        $Page = new Page($count,16);
        $account_log = M('account_log')->where($account_log_where)
            ->order('change_time desc')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        $return = [
            'status'    =>1,
            'msg'       =>'',
            'result'    =>$account_log,
            'show'      =>$Page->show()
        ];
        return $return;
    }

    /**
     * 提现记录
     * @author lxl 2017-4-26
     * @param $user_id
     * @param int $withdrawals_status 提现状态 0:申请中 1:申请成功 2:申请失败
     * @return mixed
     */
    public function get_withdrawals_log($user_id,$withdrawals_status=''){
        $withdrawals_log_where = ['user_id'=>$user_id];
        if($withdrawals_status){
            $withdrawals_log_where['status']=$withdrawals_status;
        }
        $count = M('withdrawals')->where($withdrawals_log_where)->count();
        $Page = new Page($count, 15);
        $withdrawals_log = M('withdrawals')->where($withdrawals_log_where)
            ->order('id desc')
            ->limit($Page->firstRow . ',' . $Page->listRows)
            ->select();
        $return = [
            'status'    =>1,
            'msg'       =>'',
            'result'    =>$withdrawals_log,
            'show'      =>$Page->show()
        ];
        return $return;
    }

    /**
     * 用户充值记录
     * $author lxl 2017-4-26
     * @param $user_id 用户ID
     * @param int $pay_status 充值状态0:待支付 1:充值成功 2:交易关闭
     * @return mixed
     */
    public function get_recharge_log($user_id,$pay_status=0){
        $recharge_log_where = ['user_id'=>$user_id];
        if($pay_status){
            $pay_status['status']=$pay_status;
        }
        $count = M('recharge')->where($recharge_log_where)->count();
        $Page = new Page($count, 15);
        $recharge_log = M('recharge')->where($recharge_log_where)
            ->order('order_id desc')
            ->limit($Page->firstRow . ',' . $Page->listRows)
            ->select();
        $return = [
            'status'    =>1,
            'msg'       =>'',
            'result'    =>$recharge_log,
            'show'      =>$Page->show()
        ];
        return $return;
    }
    /*
     * 获取优惠券
     */
    public function get_coupon($user_id, $type =0, $orderBy = null,$order_money = 0)
    {
        $activityLogic = new \app\common\logic\ActivityLogic;
        $count = $activityLogic->getUserCouponNum($user_id, $type, $orderBy,$order_money );

        $page = new Page($count, 10);
        $list = $activityLogic->getUserCouponList($page->firstRow, $page->listRows, $user_id, $type, $orderBy,$order_money);

        $return['status'] = 1;
        $return['msg'] = '获取成功';
        $return['result'] = $list;
        $return['show'] = $page->show();
        return $return;
    }

    public function getGoodsCollectNum($user_id)
    {
        $count = M('goods_collect')->alias('c')
                ->join('goods g','g.goods_id = c.goods_id','INNER')
                ->where('user_id', $user_id)
                ->count();
        return $count;
    }

    /**
     * 获取商品收藏列表
     * @param $user_id  用户id
     */
    public function get_goods_collect($user_id){
        $count = $this->getGoodsCollectNum($user_id);
        $page = new Page($count,10);
        $show = $page->show();
        //获取我的收藏列表
            $result = M('goods_collect')->alias('c')
            ->field('c.collect_id,c.add_time,g.goods_id,g.goods_name,g.shop_price,g.is_on_sale,g.store_count,g.cat_id ')
            ->join('goods g','g.goods_id = c.goods_id','INNER')
            ->where("c.user_id = $user_id")
            ->limit($page->firstRow,$page->listRows)
            ->select();
        $return['status'] = 1;
        $return['msg'] = '获取成功';
        $return['result'] = $result;
        $return['show'] = $show;
        return $return;
    }

    /**
     * 获取评论列表
     * @param $user_id 用户id
     * @param $status  状态 0 未评论 1 已评论 2全部
     * @return mixed
     */
    public function get_comment($user_id,$status=2){
        if($status == 1){
            //已评论
            $commented_count = Db::name('comment')
                ->alias('c')
                ->join('__ORDER_GOODS__ g','c.goods_id = g.goods_id and c.order_id = g.order_id', 'inner')
                ->where('c.user_id',$user_id)
                ->count();
            $page = new Page($commented_count,10);
            $comment_list = Db::name('comment')
                ->alias('c')
                ->field('c.*,g.*,(select order_sn from  __PREFIX__order where order_id = c.order_id ) as order_sn')
                ->join('__ORDER_GOODS__ g','c.goods_id = g.goods_id and c.order_id = g.order_id', 'inner')
                ->where('c.user_id',$user_id)
                ->order('c.add_time desc')
                ->limit($page->firstRow,$page->listRows)
                ->select();
        }else{
            $comment_where = ['o.user_id'=>$user_id,'og.is_send'=>1,'o.order_status'=>['in',[2,4]]];
            if($status == 0){
                $comment_where['og.is_comment'] = 0;
                $comment_where['o.order_status'] = 2;
            }
            $comment_count = Db::name('order_goods')->alias('og')->join('__ORDER__ o','o.order_id = og.order_id','left')->where($comment_where)->count();
            $page = new Page($comment_count,10);
            $comment_list = Db::name('order_goods')
                ->alias('og')
                ->join('__ORDER__ o','o.order_id = og.order_id','left')
                ->where($comment_where)
                ->order('o.order_id desc')
                ->limit($page->firstRow,$page->listRows)
                ->select();
        }
        $show = $page->show();
        if($comment_list){
        	$return['result'] = $comment_list;
        	$return['show'] = $show; //分页
        	return $return;
        }else{
        	return array();
        }
    }

    /**
     * 添加评论
     * @param $add
     * @return array
     */
    public function add_comment($add){
        if(!$add['order_id'] || !$add['goods_id'])
            return array('status'=>-1,'msg'=>'非法操作','result'=>'');

        //检查订单是否已完成
        $order = M('order')->field('order_status')->where("order_id", $add['order_id'])->where('user_id', $add['user_id'])->find();
        if($order['order_status'] != 2)
            return array('status'=>-1,'msg'=>'该笔订单还未确认收货','result'=>'');

        //检查是否已评论过
        $goods = M('comment')->where(['order_id'=>$add['order_id'],'goods_id'=>$add['goods_id']])->find();
        if($goods)
            return array('status'=>-1,'msg'=>'您已经评论过该商品','result'=>'');

        $row = M('comment')->add($add);
        if($row)
        {
            //更新订单商品表状态
            M('order_goods')->where(array('goods_id'=>$add['goods_id'],'order_id'=>$add['order_id']))->save(array('is_comment'=>1));
            M('goods')->where(array('goods_id'=>$add['goods_id']))->setInc('comment_count',1); // 评论数加一
            // 查看这个订单是否全部已经评论,如果全部评论了 修改整个订单评论状态
            $comment_count   = M('order_goods')->where("order_id", $add['order_id'])->where('is_comment', 0)->count();
            if($comment_count == 0) // 如果所有的商品都已经评价了 订单状态改成已评价
            {
                M('order')->where("order_id",$add['order_id'])->save(array('order_status'=>4));
            }
            return array('status'=>1,'msg'=>'评论成功','result'=>'');
        }
        return array('status'=>-1,'msg'=>'评论失败','result'=>'');
    }

    /**
     * 邮箱或手机绑定
     * @param $email_mobile  邮箱或者手机
     * @param int $type  1 为更新邮箱模式  2 手机
     * @param int $user_id  用户id
     * @return bool
     */
    public function update_email_mobile($email_mobile,$user_id,$type=1){
        //检查是否存在邮件
        if($type == 1)
            $field = 'email';
        if($type == 2)
            $field = 'mobile';
        $condition['user_id'] = array('neq',$user_id);
        $condition[$field] = $email_mobile;

        $is_exist = M('users')->where($condition)->find();
        if($is_exist)
            return false;
        unset($condition[$field]);
        $condition['user_id'] = $user_id;
        $validate = $field.'_validated';
        M('users')->where($condition)->save(array($field=>$email_mobile,$validate=>1));
        return true;
    }

    /**
     * 更新用户信息
     * @param $user_id
     * @param $post  要更新的信息
     * @return bool
     */
    public function update_info($user_id,$post=array()){
        $model = M('users')->where("user_id", $user_id);
        $row = $model->setField($post);
        if($row === false)
           return false;
        return true;
    }

    /**
     * 地址添加/编辑
     * @param $user_id 用户id
     * @param $user_id 地址id(编辑时需传入)
     * @return array
     */
    public function add_address($user_id,$address_id=0,$data){
        $post = $data;
        if($address_id == 0)
        {
            $c = M('UserAddress')->where("user_id", $user_id)->count();
            if($c >= 20)
                return array('status'=>-1,'msg'=>'最多只能添加20个收货地址','result'=>'');
        }

        //检查手机格式
        if($post['consignee'] == '')
            return array('status'=>-1,'msg'=>'收货人不能为空','result'=>'');
        if(!$post['province'] || !$post['city'] || !$post['district'])
            return array('status'=>-1,'msg'=>'所在地区不能为空','result'=>'');
        if(!$post['address'])
            return array('status'=>-1,'msg'=>'地址不能为空','result'=>'');
        if(!check_mobile($post['mobile']))
            return array('status'=>-1,'msg'=>'手机号码格式有误','result'=>'');

        //编辑模式
        if($address_id > 0){

            $address = M('user_address')->where(array('address_id'=>$address_id,'user_id'=> $user_id))->find();
            if($post['is_default'] == 1 && $address['is_default'] != 1)
                M('user_address')->where(array('user_id'=>$user_id))->save(array('is_default'=>0));
            $row = M('user_address')->where(array('address_id'=>$address_id,'user_id'=> $user_id))->save($post);
            if(!$row)
                return array('status'=>-1,'msg'=>'操作完成','result'=>'');
            return array('status'=>1,'msg'=>'编辑成功','result'=>'');
        }
        //添加模式
        $post['user_id'] = $user_id;

        // 如果目前只有一个收货地址则改为默认收货地址
        $c = M('user_address')->where("user_id", $post['user_id'])->count();
        if($c == 0)  $post['is_default'] = 1;

        $address_id = M('user_address')->add($post);
        //如果设为默认地址
        $insert_id = DB::name('user_address')->getLastInsID();
        $map['user_id'] = $user_id;
        $map['address_id'] = array('neq',$insert_id);

        if($post['is_default'] == 1)
            M('user_address')->where($map)->save(array('is_default'=>0));
        if(!$address_id)
            return array('status'=>-1,'msg'=>'添加失败','result'=>'');


        return array('status'=>1,'msg'=>'添加成功','result'=>$address_id);
    }

    /**
     * 添加自提点
     * @author dyr
     * @param $user_id
     * @param $post
     * @return array
     */
    public function add_pick_up($user_id, $post)
    {
        //检查用户是否已经有自提点
        $user_pickup_address_id = M('user_address')->where(['user_id'=>$user_id,'is_pickup'=>1])->getField('address_id');
        $pick_up = M('pick_up')->where(array('pickup_id' => $post['pickup_id']))->find();
        $post['address'] = $pick_up['pickup_address'];
        $post['is_pickup'] = 1;
        $post['user_id'] = $user_id;
        $user_address = new UserAddress();
        if (!empty($user_pickup_address_id)) {
            //更新自提点
            $user_address_save_result = $user_address->allowField(true)->validate(true)->save($post,['address_id'=>$user_pickup_address_id]);
        } else {
            //添加自提点
            $user_address_save_result = $user_address->allowField(true)->validate(true)->save($post);
        }
        if (false === $user_address_save_result) {
            return array('status' => -1, 'msg' => '保存失败', 'result' => $user_address->getError());
        } else {
            return array('status' => 1, 'msg' => '保存成功', 'result' => '');
        }
    }

    /**
     * 设置默认收货地址
     * @param $user_id
     * @param $address_id
     */
    public function set_default($user_id,$address_id){
        M('user_address')->where(array('user_id'=>$user_id))->save(array('is_default'=>0)); //改变以前的默认地址地址状态
        $row = M('user_address')->where(array('user_id'=>$user_id,'address_id'=>$address_id))->save(array('is_default'=>1));
        if(!$row)
            return false;
        return true;
    }

    /**
     * 修改密码
     * @param $user_id  用户id
     * @param $old_password  旧密码
     * @param $new_password  新密码
     * @param $confirm_password 确认新 密码
     * @param bool|true $is_update
     * @return array
     */
    public function password($user_id,$old_password,$new_password,$confirm_password,$is_update=true){
        $user = M('users')->where('user_id', $user_id)->find();
        if(strlen($new_password) < 6)
            return array('status'=>-1,'msg'=>'密码不能低于6位字符','result'=>'');
        if($new_password != $confirm_password)
            return array('status'=>-1,'msg'=>'两次密码输入不一致','result'=>'');
        //验证原密码
        if($is_update && ($user['password'] != '' && encrypt($old_password) != $user['password']))
            return array('status'=>-1,'msg'=>'密码验证失败','result'=>'');
        $row = M('users')->where("user_id", $user_id)->save(array('password'=>encrypt($new_password)));
        if(!$row)
            return array('status'=>-1,'msg'=>'修改失败','result'=>'');
        return array('status'=>1,'msg'=>'修改成功','result'=>'');
    }

    /**
     *  针对 APP 修改密码的方法
     * @param $user_id  用户id
     * @param $old_password  旧密码
     * @param $new_password  新密码
     * @param $confirm_password 确认新 密码
     */
    public function passwordForApp($user_id,$old_password,$new_password,$is_update=true){
        $user = M('users')->where('user_id', $user_id)->find();
        if(strlen($new_password) < 6){
            return array('status'=>-1,'msg'=>'密码不能低于6位字符','result'=>'');
        }
        //验证原密码
        if($is_update && ($user['password'] != '' && $old_password != $user['password'])){
            return array('status'=>-1,'msg'=>'旧密码错误','result'=>'');
        }

        $row = M('users')->where("user_id='{$user_id}'")->update(array('password'=>$new_password));
        if(!$row){
            return array('status'=>-1,'msg'=>'密码修改失败','result'=>'');
        }
        return array('status'=>1,'msg'=>'密码修改成功','result'=>'');
    }

    /**
     * 设置支付密码
     * @param $user_id  用户id
     * @param $new_password  新密码
     * @param $confirm_password 确认新 密码
     */
    public function paypwd($user_id,$new_password,$confirm_password){
        if(strlen($new_password) < 6)
            return array('status'=>-1,'msg'=>'密码不能低于6位字符','result'=>'');
        if($new_password != $confirm_password)
            return array('status'=>-1,'msg'=>'两次密码输入不一致','result'=>'');
        $row = M('users')->where("user_id",$user_id)->update(array('paypwd'=>encrypt($new_password)));
        if(!$row){
            return array('status'=>-1,'msg'=>'修改失败','result'=>'');
        }
        return array('status'=>1,'msg'=>'修改成功','result'=>'');
    }

    /**
     * 取消订单 lxl 2017-4-29
     * @param $user_id  用户ID
     * @param $order_id 订单ID
     * @param string $action_note 操作备注
     * @return array
     */
    public function cancel_order($user_id,$order_id,$action_note='您取消了订单'){
        $order = M('order')->where(array('order_id'=>$order_id,'user_id'=>$user_id))->find();
        //检查是否未支付订单 已支付联系客服处理退款
        if(empty($order))
            return array('status'=>-1,'msg'=>'订单不存在','result'=>'');
        if($order['order_status'] == 3){
            return array('status'=>-1,'msg'=>'该订单已取消','result'=>'');
        }
        //检查是否未支付的订单
        if($order['pay_status'] > 0 || $order['order_status'] > 0)
            return array('status'=>-1,'msg'=>'支付状态或订单状态不允许','result'=>'');
        //获取记录表信息
        //$log = M('account_log')->where(array('order_id'=>$order_id))->find();
        //有余额支付的情况
        if($order['user_money'] > 0 || $order['integral'] > 0){
            accountLog($user_id,$order['user_money'],$order['integral'],"订单取消，退回{$order['user_money']}元,{$order['integral']}积分");
        }

		if($order['coupon_price'] >0){
			$res = array('use_time'=>0,'status'=>0,'order_id'=>0);
			M('coupon_list')->where(array('order_id'=>$order_id,'uid'=>$user_id))->save($res);
		}

        $row = M('order')->where(array('order_id'=>$order_id,'user_id'=>$user_id))->save(array('order_status'=>3));

        $data['order_id'] = $order_id;
        $data['action_user'] = 0;
        $data['action_note'] = $action_note;
        $data['order_status'] = 3;
        $data['pay_status'] = $order['pay_status'];
        $data['shipping_status'] = $order['shipping_status'];
        $data['log_time'] = time();
        $data['status_desc'] = '用户取消订单';
        M('order_action')->add($data);//订单操作记录

        if(!$row)
            return array('status'=>-1,'msg'=>'操作失败','result'=>'');
        return array('status'=>1,'msg'=>'操作成功','result'=>'');

    }

    /**
     * 自动取消订单
     * @author lxl 2014-4-29
     * @param $order_id         订单id
     * @param $user_id  用户ID
     * @param $orderAddTime 订单添加时间
     * @param $setTime  自动取消时间/天 默认1天
     */
    public function  abolishOrder($user_id,$order_id,$orderAddTime='',$setTime=1){
        $abolishtime = strtotime("-$setTime day");
       if($orderAddTime<$abolishtime) {
           $action_note = '超过' . $setTime . '天未支付自动取消';
           $result = $this->cancel_order($user_id,$order_id,$action_note);
           return $result;
       }
    }

    /**
     * 发送验证码: 该方法只用来发送邮件验证码, 短信验证码不再走该方法
     * @param $sender 接收人
     * @param $type 发送类型
     * @return json
     */
    public function send_email_code($sender){
    	$sms_time_out = tpCache('sms.sms_time_out');
    	$sms_time_out = $sms_time_out ? $sms_time_out : 180;
    	//获取上一次的发送时间
    	$send = session('validate_code');
//    	if(!empty($send) && $send['time'] > time() && $send['sender'] == $sender){
//    		//在有效期范围内 相同号码不再发送
//    		$res = array('status'=>-1,'msg'=>'规定时间内,不要重复发送验证码');
//            return $res;
//    	}
    	$code =  mt_rand(100000,999999);
		//检查是否邮箱格式
		if(!check_email($sender)){
			$res = array('status'=>-1,'msg'=>'邮箱码格式有误');
            return $res;
		}
		$send = send_email($sender,'验证码',$code);
    	if($send['status'] == 1){
    		$info['code'] = $code;
    		$info['sender'] = $sender;
    		$info['is_check'] = 0;
    		$info['time'] = time() + $sms_time_out; //有效验证时间
    		session('validate_code',$info);
    		$res = array('status'=>1,'msg'=>'验证码已发送，请注意查收');
    	}else{
    		$res = $send;
    	}
    	return $res;
    }

    /**
     * 检查短信/邮件验证码验证码
     * @param unknown $code
     * @param unknown $sender
     * @param unknown $session_id
     * @return multitype:number string
     */
    public function check_validate_code($code, $sender, $type ='email', $session_id=0 ,$scene = -1){

        $timeOut = time();
        $inValid = true;  //验证码失效

        //短信发送否开启
        //-1:用户没有发送短信
        //空:发送验证码关闭
        $sms_status = checkEnableSendSms($scene);

        //邮件证码是否开启
        $reg_smtp_enable = tpCache('smtp.regis_smtp_enable');

        if($type == 'email'){
            if(!$reg_smtp_enable){//发生邮件功能关闭
                $validate_code = session('validate_code');
                $validate_code['sender'] = $sender;
                $validate_code['is_check'] = 1;//标示验证通过
                session('validate_code',$validate_code);
                return array('status'=>1,'msg'=>'邮件验证码功能关闭, 无需校验验证码');
            }
            if(!$code)return array('status'=>-1,'msg'=>'请输入邮件验证码');
            //邮件
            $data = session('validate_code');
            $timeOut = $data['time'];
            if($data['code'] != $code || $data['sender']!=$sender){
            	$inValid = false;
            }
        }else{
            if($scene == -1){
                return array('status'=>-1,'msg'=>'参数错误, 请传递合理的scene参数');
            }elseif($sms_status['status'] == 0){
                $data['sender'] = $sender;
                $data['is_check'] = 1; //标示验证通过
                session('validate_code',$data);
                return array('status'=>1,'msg'=>'短信验证码功能关闭, 无需校验验证码');
            }

            if(!$code)return array('status'=>-1,'msg'=>'请输入短信验证码');
            //短信
            $sms_time_out = tpCache('sms.sms_time_out');
            $sms_time_out = $sms_time_out ? $sms_time_out : 180;
            $data = M('sms_log')->where(array('mobile'=>$sender,'session_id'=>$session_id , 'status'=>1))->order('id DESC')->find();
            //file_put_contents('./test.log', json_encode(['mobile'=>$sender,'session_id'=>$session_id, 'data' => $data]));
            if(is_array($data) && $data['code'] == $code){
            	$data['sender'] = $sender;
            	$timeOut = $data['add_time']+ $sms_time_out;
            }else{
            	$inValid = false;
            }
        }

       if(empty($data)){
           $res = array('status'=>-1,'msg'=>'请先获取验证码');
       }elseif($timeOut < time()){
           $res = array('status'=>-1,'msg'=>'验证码已超时失效');
       }elseif(!$inValid)
       {
           $res = array('status'=>-1,'msg'=>'验证失败,验证码有误');
       }else{
            $data['is_check'] = 1; //标示验证通过
            session('validate_code',$data);
            $res = array('status'=>1,'msg'=>'验证成功');
        }
        return $res;
    }


    /**
     * @time 2016/09/01
     * @author dyr
     * 设置用户系统消息已读
     */
    public function setSysMessageForRead()
    {
        $user_info = session('user');
        if (!empty($user_info['user_id'])) {
            $data['status'] = 1;
            M('user_message')->where(array('user_id' => $user_info['user_id'], 'category' => 0))->save($data);
        }
    }

    /**
     * 获取访问记录
     * @param type $user_id
     * @param type $p
     * @return type
     */
    public function getVisitLog($user_id, $p = 1)
    {
        $visit = M('goods_visit')->alias('v')
            ->field('v.visit_id, v.goods_id, v.visittime, g.goods_name, g.shop_price, g.cat_id')
            ->join('__GOODS__ g', 'v.goods_id=g.goods_id')
            ->where('v.user_id', $user_id)
            ->order('v.visittime desc')
            ->page($p, 20)
            ->select();

        /* 浏览记录按日期分组 */
        $curyear = date('Y');
        $visit_list = [];
        foreach ($visit as $v) {
            if ($curyear == date('Y', $v['visittime'])) {
                $date = date('m月d日', $v['visittime']);
            } else {
                $date = date('Y年m月d日', $v['visittime']);
            }
            $visit_list[$date][] = $v;
        }

        return $visit_list;
    }

    /**
     * 上传头像
     */
    public function upload_headpic($must_upload = true)
    {
        if ($_FILES['head_pic']['tmp_name']) {
            $file = request()->file('head_pic');
            $validate = ['size'=>1024 * 1024 * 3,'ext'=>'jpg,png,gif,jpeg'];
            $dir = 'public/upload/head_pic/';
            if (!($_exists = file_exists($dir))) {
                mkdir($dir);
            }
            $parentDir = date('Ymd');
            $info = $file->validate($validate)->move($dir, true);
            if ($info) {
                $pic_path = '/'.$dir.$parentDir.'/'.$info->getFilename();
            } else {
                return ['status' => -1, 'msg' => $file->getError()];
            }
        } elseif ($must_upload) {
            return ['status' => -1, 'msg' => "图片不存在！"];
        }
        return ['status' => 1, 'msg' => '上传成功', 'result' => $pic_path];
    }

    /**
     * 账户明细
     */
    public function account($user_id, $type='all'){
    	if($type == 'all'){
    		$count = M('account_log')->where("user_money!=0 and user_id=" . $user_id)->count();
    		$page = new Page($count, 16);
    		$account_log = M('account_log')->field("*,from_unixtime(change_time,'%Y-%m-%d %H:%i:%s') AS change_data")->where("user_money!=0 and user_id=" . $user_id)
                ->order('log_id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
    	}else{
    		$where = $type=='plus' ? " and user_money>0 " : " and user_money<0 ";
    		$count = M('account_log')->where("user_id=" . $user_id.$where)->count();
    		$page = new Page($count, 16);
    		$account_log = Db::name('account_log')->field("*,from_unixtime(change_time,'%Y-%m-%d %H:%i:%s') AS change_data")->where("user_id=" . $user_id.$where)
                ->order('log_id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
    	}
    	$result['account_log'] = $account_log;
    	$result['page'] = $page;
    	return $result;
    }

    /**
     * 积分明细
     */
    public function points($user_id, $type='all')
    {
 		 if($type == 'all'){
    		$count = M('account_log')->where("user_id=" . $user_id ." and pay_points!=0 ")->count();
    		$page = new Page($count, 16);
    		$account_log = M('account_log')->where("user_id=" . $user_id." and pay_points!=0 ")->order('log_id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
    	}else{
    		$where = $type=='plus' ? " and pay_points>0 " : " and pay_points<0 ";
    		$count = M('account_log')->where("user_id=" . $user_id.$where)->count();
    		$page = new Page($count, 16);
    		$account_log = M('account_log')->where("user_id=" . $user_id.$where)->order('log_id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
    	}

        $result['account_log'] = $account_log;
        $result['page'] = $page;
        return $result;
    }


    /***********************二次开发***************************/
    /**
     * 二维码生成
     */
    public function createQrcode($url_data,$user_id){
        $value = $url_data;                  //二维码内容
        $errorCorrectionLevel = 'L';    //容错级别
        $matrixPointSize = 5;           //生成图片大小
        //生成二维码图片
        $filename = './public/upload/qrcode/reg_qrcode'.md5($user_id.time()).'.png';
        QRcode::png($value,$filename , $errorCorrectionLevel, $matrixPointSize, 2);
        $QR = $filename;                //已经生成的原始二维码图片文件
        $QR = imagecreatefromstring(file_get_contents($QR));
        //输出图片
        imagepng($QR, 'reg_qrcode.png');
        imagedestroy($QR);
        $imgUrl = Request::instance()->domain().ltrim($filename,'.');
        return $imgUrl;
    }




    /**
     * 会员激活(升级)操作，修改积分信息
     */
    public function doUpgrade($user_id, $pay_points){
        $user = M('users');
        #1.1 会员激活：把激活字段设置为1 -> 扣除该会员积分 -> 送300000信用金
        $user_all = M('users')->where(['user_id'=>$user_id])->find();
        $need_point = tpCache('basic.jihuo'); // 升级会员所扣除的积分数量(配置表里面读取）
        $pay_points =$user_all['pay_points']-$need_point;
        $xinyongjin =tpCache('basic.xinyongjin');//读取信用金
        $data = ['is_jihuo'=>1, 'pay_points'=>$pay_points,'xinyongjin'=>$xinyongjin, 'level'=>5];
        $res = $user->where(array('user_id'=>$user_id))->save($data);
        #1.2 给各个经理奖励积分
       /* $userInfo = get_user_info($user_id);
        $manage['area'] = $userInfo['area'];
        $manage['business'] = $userInfo['business'];
        $manage['client'] = $userInfo['client'];
        foreach($manage as $k=>$v){
            if(!empty($v)){
                $award = "";
                switch ($k){
                    case 'client': $award = 680;   break;  //客户经理奖励680积分
                    case 'business': $award = 100; break;  //业务经理奖励100积分
                    case 'area': $award = 20;      break;  //区域经理奖励20积分
                }
                $manager_data = get_user_info($v); //查找经理的信息积分
                $pay_points = $manager_data['pay_points'];  //获取该经理的积分
                $pay_points = $pay_points + floatval($award); //增加奖励积分
                $user->where(array('user_id'=>$v))->save(array('pay_points'=>$pay_points));
            }else{
                continue;
            }
        }*/
        exchange($user_id);//奖励
        accountLog($user_id, '',"-1600", '换购信用金!'); //支付成功添加积分交易记录
        creditLog($user_id, '',"+300000", '充值'); //支付成功添加信用金交易记录
        if(!$res){
            return array('status'=>-1,'msg'=>'操作失败','result'=>'');
        }
        return array('status'=>1,'msg'=>'操作成功','result'=>'');
    }


    /**
     * 注册后有个红包，点击领取ajax请求增加用户积分和更新红包状态
     */
    public function get_red_package($user_id){
        $reg_integral= tpCache('basic.reg_integral'); // 会员注册赠送的红包
        $pay_points = M('users')->where(array('user_id'=>$user_id))->getField('pay_points');
        $pay_points = $pay_points + $reg_integral;
        $res = M('users')->where(array('user_id'=>$user_id))->save(array('got_red_package'=> 1,'pay_points'=> $pay_points));
        if(!$res){
            return ['code'=>-1, 'msg'=>'领取失败'];
        }
        return ['code'=>1, 'msg'=>'领取成功'];
    }
}