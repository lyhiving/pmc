<div id="content">

    <div class="topic-box" id='top'>
        <table class="topic-view">
            <tbody>
                <tr>
                    <td class="avatar">
                        <img src="<?php echo get_gravatar($data['avatar_email']);?>">
                    </td>
                    <td class="content">
                        <div class="well" style="width: 790px;">
                        <?php if(!empty($data['topic_content'])){echo Markdown($data['topic_content']);}else{echo '楼主太懒，没写内容！';}?>
                        <div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="line"></div>
    </div>
    <?php if( $data['reply_count'] > 0 ) { ?>
    <?php foreach ($data['replys'] as $key => $value) {?>
    <div class="topic-box">
        <table class="topic-view">
            <tbody>
                <tr>
                    <td class="avatar">
                        <img src="<?php echo get_gravatar($value['avatar_email']);?>">
                    </td>
                    <td class="content">
                        <div class="meta"> <b><?php echo $value['avatar_name'];?></b> 发表于<?php echo format_time($value['create_at']);?> </div>
                        <?php echo Markdown($value['reply_content']);?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="line"></div>
    </div>
    <?php }}?>
    <?php if ( isset($page) ) echo show_page();?>
    <?php if ( $_COOKIE['pmc_user_nick'] && $_COOKIE['pmc_user_id'] ) { ?>
    <form id="reply-form" action="<?php echo url_convert('topic/reply_add')?>" method="post" onsubmit="return check_reply()">
        <table class="topic-view">
            <tbody>
                <tr>
                    <td class="avatar">
                        <img src="<?php echo get_gravatar($data['pmc_user_email']);?>">
                    </td>
                    <td class="content">
                        <textarea name="reply_content" id="reply_content" class="textarea"></textarea>
                        <input type="submit" value="提交回复" class="btn">
                        <input type="hidden" name="topic_id" value="<?php echo $data['_id'];?>">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <?php }?>
</div>