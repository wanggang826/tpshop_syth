<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:44:"./template/pc/rainbow/goods\ajaxComment.html";i:1508133945;}*/ ?>
<script src="__PUBLIC__/js/viewer/viewer.min.js"></script>
<link rel="stylesheet" href="__PUBLIC__/css/viewer.min.css">
<?php if(is_array($commentlist) || $commentlist instanceof \think\Collection || $commentlist instanceof \think\Paginator): $i = 0; $__LIST__ = $commentlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
<div class="people-comment">
    <div class="deta-descri p">
        <div class="person-ph-name">
            <div class="per-img-n p">
                <?php if($v[is_anonymous] == 1): ?>
                    <div class="img-aroun"><img src="__STATIC__/images/headPic.jpg"/></div>
                    <div class="menb-name"> 匿名用户</div>
                <?php else: ?>
                    <div class="img-aroun"><img src="<?php echo (isset($v['head_pic']) && ($v['head_pic'] !== '')?$v['head_pic']:'__STATIC__/images/headPic.jpg'); ?>"/></div>
                    <div class="menb-name"><?php echo getsubstr($v['username'],0,6); ?></div>
                <?php endif; ?>
            </div>
            <!--<p class="member">金牌会员</p>-->
        </div>
        <!--评论-s-->
        <div class="person-com">
            <!--服务评星-s-->
            <div class="lifr4 p">
                <div class="dstar start5">
                   <i class="start start1" style="width:<?php echo ($v['goods_rank'] / 5 * 100); ?>%"></i>
                </div>
            </div>

            <!--评论内容-->
            <div class="lifr4 comfis p">
                <span class="faisf"><?php echo htmlspecialchars_decode($v['content']); ?></span>
            </div>
            <!--晒单图-->
            <div class="lifr4 requiimg p">
                <ul class="comment_images" id="comment_images_<?php echo $v[comment_id]; ?>">
                    <?php if(is_array($v['img']) || $v['img'] instanceof \think\Collection || $v['img'] instanceof \think\Paginator): if( count($v['img'])==0 ) : echo "" ;else: foreach($v['img'] as $key=>$v2): ?>
                        <a><li><img data-original="<?php echo $v2; ?>" src="<?php echo $v2; ?>"/></li></a>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <script>
                    var viewer = new Viewer(document.getElementById('comment_images_<?php echo $v[comment_id]; ?>'), {
                        url: 'data-original',
                        show: function() {
                            $('.soubao-sidebar').hide();
                        },
                        hide: function() {
                            $('.soubao-sidebar').show();
                        }
                    });
                </script>
            </div>
            <!--评论时间-->
            <div class="lifr4 bolist p">
                <span><?php echo date("Y-m-d H:i:s",$v['add_time']); ?></span>
            <!--购买商品规格-->
                <!--<span><?php echo htmlspecialchars_decode($v['spec_key_name']); ?></span>-->
            <!--评论者评论时间与购买时间差-->
                <!--<span>购买<?php echo round(($v['add_time']-$v['pay_time'])/3600/24); ?>天后评价</span>-->
                <!--<span>来自Android客户端</span>-->
            </div>
        </div>
        <!--评论-e-->

    <!--点赞，回复-->
        <div class="g_come">
            <a href="javascript:void(0);"><i class="detai-ico c-cen"></i><?php echo count($replyList[$v['comment_id']]); ?></a>
            <a  onclick="zan(this);"  data-comment-id="<?php echo $v['comment_id']; ?>"><i class="detai-ico z-ten"></i><span id="span_zan_<?php echo $v['comment_id']; ?>" data-io="<?php echo $v['zan_num']; ?>"><?php echo $v['zan_num']; ?></span></a>
        </div>
    </div>
    <!--回复框-->
    <!--<div class="reply-textarea">-->
        <!--<div class="reply-arrow"><b class="layer1"></b><b class="layer2"></b></div>-->
        <!--<div class="inner">-->
            <!--<textarea class="reply-input J-reply-input" data-id="replytext_<?php echo $v['comment_id']; ?>" placeholder="回复 <?php echo $v['nick_name']; ?>：" maxlength="120"></textarea>-->
            <!--<div class="operate-box">-->
                <!--<span class="txt-countdown">还可以输入<em>120</em>字</span>-->
                <!--<a class="reply-submit J-submit-reply J-submit-reply-lz" href="javascript:void(0);" target="_self">提交</a>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->
<!--商家回复-s-->
    <div class="comment-replylist">
        <?php if(is_array($replyList[$v['comment_id']]) || $replyList[$v['comment_id']] instanceof \think\Collection || $replyList[$v['comment_id']] instanceof \think\Paginator): if( count($replyList[$v['comment_id']])==0 ) : echo "" ;else: foreach($replyList[$v['comment_id']] as $k=>$v3): ?>
            <div class="comment-reply-item hide" data-vender="0" data-name="<?php echo $reply_list['user_name']; ?>" data-uid="" style="display: block;">
                <div class="reply-infor clearfix">
                    <div class="main">
                        <span class="user-name">商家回复：</span>
                        <span class="words"><?php echo $v3['content']; ?></span>
                    </div>
                    <div class="side">
                        <span class="date"><?php echo date('Y-m-d H:i:s',$v3['add_time']); ?></span>
                    </div>
                </div>
                <!--回复商家内容-s-->
                <!--<div class="comment-operate">-->
                    <!--<a class="reply J-reply-trigger" href="#none" target="_self">回复</a>-->
                    <!--<div class="reply-textarea">-->
                        <!--<div class="reply-arrow"><b class="layer1"></b><b class="layer2"></b></div>-->
                        <!--<div class="inner">-->
                            <!--<textarea class="reply-input J-reply-input" data-id="replytext_<?php echo $v['comment_id']; ?>" placeholder="回复<?php echo $reply_list['user_name']; ?>：" maxlength="120"></textarea>-->
                            <!--<div class="operate-box">-->
                                <!--<span class="txt-countdown">还可以输入<em>120</em>字</span>-->
                                <!--<a class="reply-submit J-submit-reply J-submit-reply-lz" href="javascript:void(0);" data-id="<?php echo $reply_list['reply_id']; ?>" onclick="" target="_self">提交</a>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
                <!--回复商家内容-e-->
            </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        <!--<?php if($v['reply_num'] > 5): ?>-->
            <!--<div class="view-all-reply show">-->
                <!--<a href="<?php echo U('Home/Goods/reply',array('comment_id'=>$v['comment_id'])); ?>" class="view-link reply">查看全部回复</a>-->
            <!--</div>-->
        <!--<?php endif; ?>-->
    </div>
<!--商家回复-e-->
</div>
<?php endforeach; endif; else: echo "" ;endif; ?>
<div class="operating fixed" id="bottom">
    <div class="fn_page clearfix">
        <?php echo $page; ?>
    </div>
</div>
<script>
    // 点击分页触发的事件
    $("#ajax_comment_return .pagination  a").click(function(){
        ajaxComment(commentType,$(this).data('p'));
    });
    /**
     * 点赞ajax
     * dyr
     * @param obj
     */
    function zan(obj) {
        var comment_id = $(obj).attr('data-comment-id');
        var zan_num = parseInt($("#span_zan_" + comment_id).text());
        $.ajax({
            type: "POST",
            data: {comment_id: comment_id},
            dataType: 'json',
            url: "/index.php?m=Home&c=user&a=ajaxZan",//
            success: function (res) {
                if (res.success) {
                    $("#span_zan_" + comment_id).text(zan_num + 1);
                } else {
                    layer.msg('只能点赞一次哟~', {icon: 2});
                }
            },
            error : function(res) {
                console.log(res);
                if( res.status == "200"){ // 兼容调试时301/302重定向导致触发error的问题
                    layer.msg("请先登录!", {icon: 2});
                    return;
                }
                layer.msg("请求失败!", {icon: 2});
                return;
            }
        });
    }
    //字数限制
    $(function() {
        $('.c-cen').click(function() {
            $(this).parents('.deta-descri').siblings('.reply-textarea').toggle();
        })
        $('.J-reply-trigger').click(function(){
            $(this).siblings('.reply-textarea').toggle();
        })
        $('.reply-input').keyup(function() {
            var nums = 120;
            var len = $(this).val().length;
            if(len > nums) {
                $(this).val($(this).val().substring(0, nums));
                layer.msg("超过字数限制！" , {icon: 2});
            }
            var num = nums - len;
            var su = $(this).siblings().find('.txt-countdown em');
            su.text(num);
        })

        $(document).on('click','.operate-box .reply-submit',function() {
            var content = $(this).parents('.inner').find('.reply-input').val();
            var comment_id = $(this).parents('.inner').find('.reply-input').attr('data-id').substr(10);
            var comment_name = $(this).parents('.comment-operate').siblings('.reply-infor').find('.main .user-name').text();
            var reply_id = $(this).attr('data-id');
            submit_reply(comment_id,content,comment_name,reply_id);
            $(this).parents('.reply-textarea').hide();
        });
    })

    /**
     * 回复
     * @param comment_id
     * @param content
     * @param to_name
     * @param reply_id
     */
//    function submit_reply(comment_id,content,to_name,reply_id)
//    {
//        $.ajax({
//            type: 'post',
//            dataType: 'json',
//            data: {comment_id: comment_id,content:content,to_name:to_name,reply_id:reply_id,goods_id:'<?php echo $goods_id; ?>'},
//            url: "<?php echo U('Home/User/reply_add'); ?>",
//            success: function (res) {
//                if (res.success) {
//                    layer.msg('回复已提交', {icon: 1});
//                } else {
//                    layer.msg(res.msg, {icon: 2});
//                }
//            },
//            error : function(res) {
//                if( res.status == "200"){ // 兼容调试时301/302重定向导致触发error的问题
//                    layer.msg("请先登录!",{icon: 2});
//                    return;
//                }
//                layer.msg("请求失败!",{icon: 2});
//            }
//        });
//    }

</script>
