<div id="content">
    <div class="box">
        <table class="item-list table table-striped"cellspacing="0" cellpadding="0">
            <thead>
             <tr>
             <th colspan="2"><script src="<?php echo site_url();?>/static/js/mingyan.js"></script></th>
             </tr>
            </thead>
            <tbody>
            <?php if( ! empty($data) ) foreach ($data as $key => $value) {?>
            <tr id="topic-<?php echo $key;?>">
                <td class="avatar"><a href="#"  rel="popover" data-content="主题：<?php echo $value['avatar_topic_count'];?> 回复：<?php echo $value['avatar_reply_count'];?>" data-original-title="<?php echo $value['avatar_name'];?>"><img src="<?php echo get_gravatar($value['avatar_email']);?>"></a></td>
                <td class="content">
                    <h3><a href="<?php echo url_convert('topic/show').'/'.$value['_id'];?>"><?php echo $value['topic_title'];?></a></h3>
                    <div class="info">
                        <?php if($value['tag_id']){?>
                        <span class="label"><a href="<?php echo url_convert('topic/tag').'/'.$value['tag_id'];?>"><?php echo $value['tag_name'];?></a></span>
                        <?php }?>
                        <span class="author"><?php echo $value['avatar_name'];?></span>
                        <span class="time">创建于 <time datetime="<?php echo date('Y-m-d H:i', $value['create_at']);?>"><?php echo format_time($value['create_at']);?></time>
                            <?php if( $value['reply_count'] > 0 ) { ?>, <span class="author"><?php echo $value['last_reply_avatar_name'];?></span>
回复于 <time datetime="<?php echo date('Y-m-d H:i', $value['last_reply_at']);?>"><?php echo format_time($value['last_reply_at'])?></time><?php }?></span>
                    </div>
                </td>
                <td class="reply-count last"><?php if( $value['reply_count'] > 0 ) { ?><a href="<?php echo url_convert('topic/show').'/'.$value['_id'];?>"><span class="badge badge-info"><?php echo $value['reply_count'];?></span></a><?php }?> <?php if ( $_COOKIE['pmc_user_nick'] && $_COOKIE['pmc_user_id'] && $_COOKIE['pmc_superman'] ) { ?><a class="close" href="<?php echo url_convert('topic/del/'.$value['_id']);?>">&times;</a><?php }?></td>
            </tr>
            <?php }?>
            </tbody>
            <tfoot>
                <!-- page -->
            </tfoot>
        </table>
    </div>
    <?php if ( isset($page) ) echo show_page($page['url'], $page['p'], $page['c'], $page['l']);?>
    <?php if ( isset($index) ) {?>
    <ul class="pager">
        <li class="previous">
            <a  href="<?php echo url_convert('topic/tag/more');?>"><i class="icon-plus-sign"></i>更多数据...</a>
        </li>
    </ul>
    <?php }?>
</div>