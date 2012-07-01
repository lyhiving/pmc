<div id="content">
<table class="table">
    <thead>
        <tr>
            <th width="20%">排序</th>
            <th width="60%">名称</th>
            <th width="20%">操作</th>
        </tr>
    </thead>
    <tbody>
        <form action="<?php echo url_convert('topic/tag_admin')?>" method="post" onsubmit="return check_tag()">
        <tr>
            <td><input type="text" name="tag_order" id="tag_order" class="input" ></td>
            <td><input type="text" name="tag_name" id="tag_name" class="input" ></td>
            <td><input type="submit" value="添加" class="btn"></td>
        </tr>
        </form>
        <?php foreach ($data as $key => $value) {?>
            <tr id="tag-<?php echo $value['_id'];?>" class="tag-list">
                <input type="hidden" name="tag_id" id="tag_id" value="<?php echo $value['_id']?>" >
                <td><input type="text" name="tag_order" id="tag_order" class="input" value="<?php echo $value['order']?>" ></td>
                <td><input type="text" name="tag_name" id="tag_name" class="input" value="<?php echo $value['name']?>" ></td>
                <td><a class="btn" href="javascript:del_tag('<?php echo $value['_id'];?>')">删除</a></td>
            </tr>
        <?php }?>
    </tbody>
</table>
</div>