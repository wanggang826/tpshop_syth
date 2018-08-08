<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tpshop.cn
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * 采用TP5助手函数可实现单字母函数M D U等,也可db::name方式,可双向兼容
 * ============================================================================
 * $Author: IT宇宙人 2015-08-10 $
 *
 */

namespace app\home\controller;
use app\common\logic\UserAddressLogic;
use app\common\logic\GoodsActivityLogic;
use app\common\logic\CartLogic;
use app\common\logic\OrderLogic;
use app\common\logic\UsersLogic;
use app\common\logic\PickupLogic;
use app\common\logic\GoodsLogic;
use think\Db;
class Cart extends Base {

    public $cartLogic; // 购物车逻辑操作类
    public $user_id = 0;
    public $is_fenqi = 0;//是否分期
    public $user = array();
    /**
     * 初始化函数
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->cartLogic = new CartLogic();
        if (session('?user')) {
            $user = session('user');
            $user = M('users')->where("user_id", $user['user_id'])->find();
            session('user', $user);  //覆盖session 中的 user
            $this->user = $user;
            $this->user_id = $user['user_id'];
            $this->assign('user', $user); //存储用户信息
            // 给用户计算会员价 登录前后不一样
            if ($user) {
                $user['discount'] = (empty($user['discount'])) ? 1 : $user['discount'];
                if($user['discount'] != 1)
                {
                    $c = Db::name('cart')->where(['user_id' => $user['user_id'], 'prom_type' => 0])->where('member_goods_price = goods_price')->count();
                    $c && Db::name('cart')->where(['user_id' => $user['user_id'], 'prom_type' => 0])->update(['member_goods_price' => ['exp', 'goods_price*' . $user['discount']]]);
                }
            }
        }
    }

    public function index(){
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user_id);
        $cartList = $cartLogic->getCartList();//用户购物车
        $userCartGoodsTypeNum = $cartLogic->getUserCartGoodsTypeNum();//获取用户购物车商品总数
        $this->assign('userCartGoodsTypeNum', $userCartGoodsTypeNum);
        $this->assign('cartList', $cartList);//购物车列表
        return $this->fetch();
    }

    /**
     * 更新购物车，并返回计算结果
     */
    public function AsyncUpdateCart()
    {
        $cart = input('cart/a', []);
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user_id);
        $result = $cartLogic->AsyncUpdateCart($cart);
        $this->ajaxReturn($result);
    }
    /**
     *  购物车加减
     */
    public function changeNum(){
        $cart = input('cart/a',[]);
        if (empty($cart)) {
            $this->ajaxReturn(['status' => 0, 'msg' => '请选择要更改的商品', 'result' => '']);
        }
        $cartLogic = new CartLogic();
        $result = $cartLogic->changeNum($cart['id'],$cart['goods_num']);
        $this->ajaxReturn($result);
    }
    /**
     * 删除购物车商品
     */
    public function delete(){
        $cart_ids = input('cart_ids/a',[]);
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user_id);
        $result = $cartLogic->delete($cart_ids);
        if($result !== false){
            $this->ajaxReturn(['status'=>1,'msg'=>'删除成功','result'=>$result]);
        }else{
            $this->ajaxReturn(['status'=>0,'msg'=>'删除失败','result'=>$result]);
        }
    }

    /**
     * ajax 将商品加入购物车
     */
    function ajaxAddCart()
    {
        $goods_id = I("goods_id/d"); // 商品id
        //查找是否是VIP或者全部会员购买  --- 字段buy_obj的值结合用户id判断是否可购买
        $buy_obj = M('goods')->where(array('goods_id'=>$goods_id))->field('buy_obj,shop_price,percent')->find();
        //会员等级 vip = 5 则是VIP会员 否则普通会员
        $level = M('users')->where(array('user_id'=>$this->user_id))->getField('level');

        if($buy_obj['buy_obj'] == 0 && $level == 1){
            $this->ajaxReturn(['status'=>0,'msg'=>'对不起，该商品只支持VIP会员购买','result'=>'']);
        }

        $this->is_fenqi = I("is_fenqi/d"); // 是否分期
        if($this->is_fenqi == 2){  //如果支持分期
            //会员是否激活，没激活的不能参与分期购买
            $is_jihuo = M('users')->where(array('user_id'=>$this->user_id))->field('is_jihuo,xinyongjin,months_xinyong')->find();
            if($is_jihuo['is_jihuo'] == 0){
                $this->ajaxReturn(['status'=>0,'msg'=>'对不起，分期购买只适用于已激活的会员','result'=>'']);
            }
            $money=round($buy_obj['shop_price']*(1-$buy_obj['percent']),2);//分期金额
            if($is_jihuo['months_xinyong'] >= $money){
                if($is_jihuo['xinyongjin']<$money){
                    $this->ajaxReturn(['status'=>0,'msg'=>'对不起，您的信用金仅剩: '.$is_jihuo['xinyongjin'].' ,不足本次分期!','result'=>'']);
                }
            }else{
                $this->ajaxReturn(['status'=>0,'msg'=>'对不起，您本月剩余信用金额度仅剩:'.$is_jihuo['months_xinyong'].' ,不足本次分期!','result'=>'']);
            }
        }

        $goods_num = I("goods_num/d");// 商品数量
        $item_id = I("item_id/d"); // 商品规格id
        if(empty($goods_id)){
            $this->ajaxReturn(['status'=>0,'msg'=>'请选择要购买的商品','result'=>'']);
        }
        if(empty($goods_num)){
            $this->ajaxReturn(['status'=>0,'msg'=>'购买商品数量不能为0','result'=>'']);
        }
        $cartLogic = new CartLogic();
        $cartLogic->setIsFenqi($this->is_fenqi);//是否分期
        $cartLogic->setUserId($this->user_id);
        $cartLogic->setGoodsModel($goods_id);
        if($item_id){
            $cartLogic->setSpecGoodsPriceModel($item_id);
        }
        $cartLogic->setGoodsBuyNum($goods_num);
        $result = $cartLogic->addGoodsToCart();
        $this->ajaxReturn($result);
    }

    /**
     * 购物车第二步确定页面
     */
    public function cart2()
    {
        if($this->user_id == 0){
            $this->error('请先登录',U('Home/User/login'));
        }
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user_id);
        if($cartLogic->getUserCartOrderCount() == 0 ){
            $this->error ('你的购物车没有选中商品','Cart/index');
        }
        $cartList = $cartLogic->getCartList(1); // 获取用户选中的购物车商品
        $cartPriceInfo = $cartLogic->getCartPriceInfo($cartList);
        $shippingList = M('Plugin')->where("`type` = 'shipping' and status = 1")->cache(true,TPSHOP_CACHE_TIME)->select();// 物流公司
        // 找出这个用户的优惠券 没过期的  并且 订单金额达到 condition 优惠券指定标准的
        $couponWhere = [
            'c2.uid' => $this->user_id,
            'c1.use_end_time' => ['gt', time()],
            'c1.use_start_time' => ['lt', time()],
            'c1.condition' => ['elt', $cartPriceInfo['total_fee']]
        ];
        $couponList = Db::name('coupon')->alias('c1')
            ->field('c1.name,c1.money,c1.condition,c2.*')
            ->join('__COUPON_LIST__ c2', ' c2.cid = c1.id and c1.type in(0,1,2,3) and order_id = 0', 'inner')
            ->where($couponWhere)
            ->select();
        $this->assign('couponList', $couponList); // 优惠券列表
        $this->assign('shippingList', $shippingList); // 物流公司
        $this->assign('cartList', $cartList); // 购物车的商品
        $this->assign('cartPriceInfo',$cartPriceInfo);
        return $this->fetch();
    }

    /*
     * ajax 获取用户收货地址 用于购物车确认订单页面
     */
    public function ajaxAddress(){
        $address_list = M('UserAddress')->where(['user_id'=>$this->user_id,'is_pickup'=>0])->select();
        if($address_list){
        	$area_id = array();
        	foreach ($address_list as $val){
        		$area_id[] = $val['province'];
                        $area_id[] = $val['city'];
                        $area_id[] = $val['district'];
                        $area_id[] = $val['twon'];
        	}
                $area_id = array_filter($area_id);
        	$area_id = implode(',', $area_id);
        	$regionList = M('region')->where("id", "in", $area_id)->getField('id,name');
        	$this->assign('regionList', $regionList);
        }
        $address_where['is_default'] = 1;
        $c = M('UserAddress')->where(['user_id'=>$this->user_id,'is_default'=>1,'is_pickup'=>0])->count(); // 看看有没默认收货地址
        if((count($address_list) > 0) && ($c == 0)) // 如果没有设置默认收货地址, 则第一条设置为默认收货地址
            $address_list[0]['is_default'] = 1;
        $this->assign('address_list', $address_list);
        return $this->fetch('ajax_address');
    }
    /**
     * @author dyr
     * @time 2016.08.22
     * 获取自提点信息
     */
    public function ajaxPickup()
    {
        $province_id = I('province_id/d');
        $city_id = I('city_id/d');
        $district_id = I('district_id/d');
        if (empty($province_id) || empty($city_id) || empty($district_id)) {
            exit("<script>alert('参数错误');</script>");
        }
        $user_address = new UserAddressLogic();
        $address_list = $user_address->getUserPickup($this->user_id);
        $pickup = new PickupLogic();
        $pickup_list = $pickup->getPickupItemByPCD($province_id, $city_id, $district_id);
        $this->assign('pickup_list', $pickup_list);
        $this->assign('address_list', $address_list);
        return $this->fetch('ajax_pickup');
    }

    /**
     * @author dyr
     * @time 2016.08.22
     * 更换自提点
     */
    public function replace_pickup()
    {
        $province_id = I('get.province_id/d');
        $city_id = I('get.city_id/d');
        $district_id = I('get.district_id/d');
        $region_model = M('region');
        $call_back = I('get.call_back');
        if (IS_POST) {
            echo "<script>parent.{$call_back}('success');</script>";
            exit(); // 成功
        }
        $address = array('province' => $province_id, 'city' => $city_id, 'district' => $district_id);
        $p = $region_model->where(array('parent_id' => 0, 'level' => 1))->select();
        $c = $region_model->where(array('parent_id' => $province_id, 'level' => 2))->select();
        $d = $region_model->where(array('parent_id' => $city_id, 'level' => 3))->select();
        $this->assign('province', $p);
        $this->assign('city', $c);
        $this->assign('district', $d);
        $this->assign('address', $address);
        $this->assign('call_back', $call_back);
        return $this->fetch();
    }

    /**
     * @author dyr
     * @time 2016.08.22
     * 更换自提点
     */
    public function ajax_PickupPoint()
    {
        $province_id = I('province_id/d');
        $city_id = I('city_id/d');
        $district_id = I('district_id/d');
        $pick_up_model = new PickupLogic();
        $pick_up_list = $pick_up_model->getPickupListByPCD($province_id,$city_id,$district_id);
        exit(json_encode($pick_up_list));
    }


    /**
     * ajax 获取订单商品价格 或者提交 订单
     */
    public function cart3(){
        if($this->user_id == 0){
            exit(json_encode(array('status'=>-100,'msg'=>"登录超时请重新登录!",'result'=>null))); // 返回结果状态
        }
        $address_id = I("address_id/d"); //  收货地址id
        $shipping_code =  0;//I("shipping_code"); //  物流编号
        $invoice_title = I('invoice_title'); // 发票
        $coupon_id =  I("coupon_id/d"); //  优惠券id
        $couponCode =  I("couponCode"); //  优惠券代码
        $pay_points =  I("pay_points/d",0); //  使用积分
        $user_money =  I("user_money/f",0); //  使用余额
        $user_note =  I("user_note",''); // 用户留言
        $paypwd =  I("paypwd",''); // 支付密码
        $user_money = $user_money ? $user_money : 0;

        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user_id);
        if($cartLogic->getUserCartOrderCount() == 0){
            exit(json_encode(array('status'=>-2,'msg'=>'你的购物车没有选中商品','result'=>null))); // 返回结果状态
        }
        if(!$address_id) exit(json_encode(array('status'=>-3,'msg'=>'请先填写收货人信息','result'=>null))); // 返回结果状态
        //if(!$shipping_code) exit(json_encode(array('status'=>-4,'msg'=>'请选择物流信息','result'=>null))); // 返回结果状态

		$address = M('UserAddress')->where("address_id", $address_id)->find();
		$order_goods = M('cart')->where(['user_id'=>$this->user_id,'selected'=>1])->select();
        $result = calculate_price($this->user_id,$order_goods,$shipping_code,0,$address['province'],$address['city'],$address['district'],$pay_points,$user_money,$coupon_id,$couponCode);
        if($result['status'] < 0) exit(json_encode($result));
		// 订单满额优惠活动
        $order_prom = get_order_promotion($result['result']['order_amount']);
        $result['result']['order_amount'] = $order_prom['order_amount'] ;
        $result['result']['order_prom_id'] = $order_prom['order_prom_id'] ;
        $result['result']['order_prom_amount'] = $order_prom['order_prom_amount'] ;
        $car_price = array(
            'couponFee'    => $result['result']['coupon_price'], // 优惠券
            'balance'      => $result['result']['user_money'], // 使用用户余额
            'pointsFee'    => $result['result']['integral_money'], // 积分支付
            'payables'     => number_format($result['result']['order_amount'], 2, '.', ''), // 应付金额
            'goodsFee'     => $result['result']['goods_price'],// 商品价格
            'order_prom_id' => $result['result']['order_prom_id'], // 订单优惠活动id
            'order_prom_amount' => $result['result']['order_prom_amount'], // 订单优惠活动优惠了多少钱
            'integral' =>$result['result']['integral'],//积分
            'xinyong' =>$result['result']['xinyong'],//信用金
        );

        // 提交订单
//        if(empty($coupon_id) && !empty($couponCode))
        if ($_REQUEST['act'] == 'submit_order') {
            $pay_name = '';
            if ($pay_points || $user_money) {
                if ($this->user['is_lock'] == 1) {
                    exit(json_encode(array('status'=>-5,'msg'=>"账号异常已被锁定，不能使用余额支付！",'result'=>null))); // 用户被冻结不能使用余额支付
                }
                if (empty($this->user['paypwd'])) {
                    exit(json_encode(array('status'=>-6,'msg'=>'请先设置支付密码','result'=>null)));
                }
                if (empty($paypwd)) {
                    exit(json_encode(array('status'=>-7,'msg'=>'请输入支付密码','result'=>null)));
                }
                if (encrypt($paypwd) !== $this->user['paypwd']) {
                    exit(json_encode(array('status'=>-8,'msg'=>'支付密码错误','result'=>null)));
                }
                $pay_name = $user_money ? '余额支付' : '积分兑换';
            }

            $coupon_id = M('CouponList')->where("code", $couponCode)->getField('id');
            $orderLogic = new OrderLogic();
            //是否分期
            $xinyong = $car_price['xinyong'];//使用信用金额度
            if($xinyong>0){
                $fenqi = 2;
            }else{
                $fenqi = 1;
            }
            $result = $orderLogic->addOrder($fenqi,$xinyong,$this->user_id,$address_id,$shipping_code,$invoice_title,$coupon_id,$car_price,$user_note,$pay_name); // 添加订单
            exit(json_encode($result));
        }

        $return_arr = array('status'=>1,'msg'=>'计算成功','result'=>$car_price); // 返回结果状态
        exit(json_encode($return_arr));
    }
    /**
     * ajax 获取订单商品价格 或者提交 订单
	 * 已经用心方法 这个方法 cart9  准备作废
     */

    /*
     * 订单支付页面
     */
    public function cart4(){
        $order_id = I('order_id/d');
        $order_where = ['user_id'=>$this->user_id,'order_id'=>$order_id];
        $order = M('order')->where($order_where)->find();
        if(empty($order)){
            $order = M('recharge')->where($order_where)->find();
            if(empty($order)){
                $this->error('订单错误',U("Home/index/index"));
            }
        }
        if($order['order_status'] == 3){
            $this->error('该订单已取消',U("Home/Order/order_detail",array('id'=>$order_id)));
        }
        if(empty($order) || empty($this->user_id)){
            $order_order_list = U("User/login");
            header("Location: $order_order_list");
            exit;
        }
        // 如果已经支付过的订单直接到订单详情页面. 不再进入支付页面
        if($order['pay_status'] == 1){
            if(stripos($order['order_sn'],'recharge') !== false){
                //跳转到充值成功页面
                $order_detail_url = U("Home/payment/recharge_result", array('order_id'=>$order_id));
                header("Location: $order_detail_url");
                exit;
            }
            $order_detail_url = U("Home/Order/order_detail",array('id'=>$order_id));
            header("Location: $order_detail_url");
            exit;
        }

        if($order['order_prom_type'] != 4){
            $userlogic = new UsersLogic();
            $res = $userlogic->abolishOrder($order['user_id'],$order['order_id'],$order['add_time']);  //检测是否超时没支付
            if($res['status']==1)
                $this->error('订单超时未支付已自动取消',U("Home/Order/order_detail",array('id'=>$order_id)));
        }
        $payment_where = array(
            'type'=>'payment',
            'status'=>1,
            'scene'=>array('in',array(0,2))
        );
        //预售和抢购暂不支持货到付款
        $orderGoodsPromType = M('order_goods')->where(['order_id'=>$order['order_id']])->getField('prom_type',true);
        if($order['order_prom_type'] == 4 || in_array(1,$orderGoodsPromType)){
            $payment_where['code'] = array('neq','cod');
        }
        $paymentList = M('Plugin')->where($payment_where)->select();
        $paymentList = convert_arr_key($paymentList, 'code');

        foreach($paymentList as $key => $val)
        {
            $val['config_value'] = unserialize($val['config_value']);
            if($val['config_value']['is_bank'] == 2)
            {
                $bankCodeList[$val['code']] = unserialize($val['bank_code']);
            }
        }
        $bank_img = include APP_PATH.'home/bank.php'; // 银行对应图片
        $this->assign('paymentList',$paymentList);
        $this->assign('bank_img',$bank_img);
        $this->assign('order',$order);
        $this->assign('bankCodeList',$bankCodeList);
        $this->assign('pay_date',date('Y-m-d', strtotime("+1 day")));
        $this->assign('order_id',$order_id);
        return $this->fetch();
    }


    //ajax 请求购物车列表
    public function header_cart_list()
    {
        $cartLogic = new CartLogic();
        $cartLogic->setUserId($this->user_id);
        $cartList = $cartLogic->getCartList();
        $cartPriceInfo = $cartLogic->getCartPriceInfo($cartList);
    	$this->assign('cartList', $cartList); // 购物车的商品
    	$this->assign('cartPriceInfo', $cartPriceInfo); // 总计
        $template = I('template','header_cart_list');
        return $this->fetch($template);
    }

    /**
     * 预售商品下单流程
     */
    public function pre_sell_cart()
    {
        $act_id = I('act_id/d');
        $goods_num = I('goods_num/d');
        if(empty($act_id)){
            $this->error('没有选择需要购买商品');
        }
        if(empty($goods_num)){
            $this->error('购买商品数量不能为0', U('Home/Activity/pre_sell', array('act_id' => $act_id)));
        }
        if($this->user_id == 0){
            $this->error('请先登录');
        }
        $pre_sell_info = M('goods_activity')->where(array('act_id' => $act_id, 'act_type' => 1))->find();
        if(empty($pre_sell_info)){
            $this->error('商品不存在或已下架',U('Home/Activity/pre_sell_list'));
        }
        $pre_sell_info = array_merge($pre_sell_info, unserialize($pre_sell_info['ext_info']));
        if ($pre_sell_info['act_count'] + $goods_num > $pre_sell_info['restrict_amount']) {
            $buy_num = $pre_sell_info['restrict_amount'] - $pre_sell_info['act_count'];
            $this->error('预售商品库存不足，还剩下' . $buy_num . '件', U('Home/Activity/pre_sell', array('id' => $act_id)));
        }
        $goodsActivityLogic = new GoodsActivityLogic();
        $pre_count_info = $goodsActivityLogic->getPreCountInfo($pre_sell_info['act_id'], $pre_sell_info['goods_id']);//预售商品的订购数量和订单数量
        $pre_sell_price['cut_price'] =$goodsActivityLogic->getPrePrice($pre_count_info['total_goods'], $pre_sell_info['price_ladder']);//预售商品价格
        $pre_sell_price['goods_num'] = $goods_num;
        $pre_sell_price['deposit_price'] = floatval($pre_sell_info['deposit']);
        // 提交订单
        if ($_REQUEST['act'] == 'submit_order') {
            $invoice_title = I('invoice_title'); // 发票
            $shipping_code =  I("shipping_code"); //  物流编号
            $address_id = I("address_id/d"); //  收货地址id
            if(empty($address_id)){
                exit(json_encode(array('status'=>-3,'msg'=>'请先填写收货人信息','result'=>null))); // 返回结果状态
            }
            if(empty($shipping_code)){
                exit(json_encode(array('status'=>-4,'msg'=>'请选择物流信息','result'=>null))); // 返回结果状态
            }
            $orderLogic = new OrderLogic();
            $result = $orderLogic->addPreSellOrder($this->user_id, $address_id, $shipping_code, $invoice_title, $act_id, $pre_sell_price); // 添加订单
            exit(json_encode($result));
        }
        $shippingList = M('Plugin')->where("`type` = 'shipping' and status = 1")->select();// 物流公司
        $this->assign('pre_sell_info', $pre_sell_info);// 购物车的预售商品
        $this->assign('shippingList', $shippingList); // 物流公司
        $this->assign('pre_sell_price',$pre_sell_price);
        return $this->fetch();
    }

    /**
     * 积分支付
     */
    public function jifen(){
        $user_id =  I('user_id')?I('user_id'):$this->user_id;
       $order_id = I('order_id');
        $pass = encrypt(trim(I('password')));
       $order_where = ['user_id'=>$user_id,'order_id'=>$order_id];
        $order = M('Order')->where($order_where)->find();//订单详情
        $member = M('Users')->where(['user_id'=>$user_id])->find();
        if($pass == $member['paypwd']){
            if($order['pay_status'] ==1)  return json_encode(array('status'=>-1,'msg'=>'该订单已付款!','result'=>null));
            $xinyongjin = $order['xinyong'];//需要支付的信用金
            $jifen = round(($order['total_amount']-$order['xinyong']),2);//需要支付的积分
            if($member['pay_points'] >= $jifen){
                $member['pay_points'] = $member['pay_points']-$jifen;//剩余的积分
                if($member['xinyongjin'] >= $order['xinyong']){
                    if($member['months_xinyong'] >= $order['xinyong']){
                        $reg = M('Users')->where(['user_id'=>$member['user_id']])->update($member);
                        if($reg ===1){
                             update_pay_status($order['order_sn']);//支付成功改订单状态
                           // staging_edit($order_id);//修改分期表
                           // rewards($this->user_id,$order_id);//调用奖励机制
                            accountLog($this->user_id, '',"-$jifen", '下单消费','',$order_id ,$order['order_sn']); //支付成功添加积分交易记录
                         //   rebates($order_id);//购物返点
                           if($xinyongjin>0){
                               creditLog($this->user_id, $order_id,"-$xinyongjin", '下单消费'); //支付成功添加信用金交易记录
                           }
                            return json_encode(array('status'=>1,'msg'=>'支付成功!','result'=>null));
                        }else{
                            return json_encode(array('status'=>-1,'msg'=>'支付失败!','result'=>null));
                        }
                    }else{
                        return json_encode(array('status'=>-1,'msg'=>'您本月信用金额度仅剩: '.$member['months_xinyong'].' ,不足以分期!','result'=>null));
                    }

                }else{
                    return json_encode(array('status'=>-1,'msg'=>'您的信用金额度仅剩: '.$member['xinyongjin'].' ,不足以分期!','result'=>null));
                }
            }else{
                return json_encode(array('status'=>-1,'msg'=>'积分不够支付订单金额!','result'=>null));
            }
        }else{
            return json_encode(array('status'=>-1,'msg'=>'支付密码有误!','result'=>null));
        }
    }



}
