<div id="content">
    <div class="box">
        <div id="topic-form">
            <form action="<?php echo url_convert('topic/add')?>" method="post" onsubmit="return check_topic()">
                <input type="text" name="topic_title" id="topic_title" class="input" >
                <div class="topic_tag">
                <?php if( ! empty($tag) ){ foreach ($tag as $key => $value) { ?>
                <label>&nbsp;<input type="radio" name="tag_id" value="<?php echo $value['_id']?>"><?php echo $value['name']?></label>
                <?php }}?>
                </div>
                <textarea name="topic_content" id="topic_content" class="textarea"></textarea>
                <input type="submit" value="发表主题" class="btn">
            </form>
        </div>
    </div>
</div>