$(function(){
    init();
    $("a[rel=popover]").popover();
    $(".tag-list td input").blur(input_blur);
})

// 初始化
function init(){
    var info = $('#info');
    var info_html;
    if ( $.cookie('pmc_user_nick') && $.cookie('pmc_user_id')) {
        info_html = "<b style='color:red;'>"+$.cookie('pmc_user_nick')+"</b> , 欢迎您 ！ ";
        info_html += " <a href='"+site_url+"/user/password'>修改密码</a>";
        info_html += " <a href='"+site_url+"/user/logout'>退出</a>";
    } else {
        info_html = "<ul class='nav nav-pills'><li><a href='"+site_url+"/user/login'>登录</a></li>";
        info_html += " <li><a href='"+site_url+"/user/join'>注册</a></li></ul>";
    }
    info.append(info_html);
}

// 注册验证
function check_join(){
    $('#user_submit').attr("disabled",true).val("请稍候……");
    var user_login=$('#user_login').val();
    var user_key=$('#user_key').val();
    var user_nickname=$('#user_nickname').val();
    if($.trim(user_login)==''){
        alert('帐号不能为空');
        $('#user_login').focus();
        $('#user_submit').attr("disabled",false).val("注册");
        return false;
    }
    if($.trim(user_key)==''){
        alert('密码不能为空');
        $('#user_key').focus();
        $('#user_submit').attr("disabled",false).val("注册");
        return false;
    }
    if($.trim(user_nickname)==''){
        alert('昵称不能为空');
        $('#user_nickname').focus();
        $('#user_submit').attr("disabled",false).val("注册");
        return false;
    }
    return true;
}
// 检测主题
function check_topic(){
    var topic_title=$('#topic_title').val();
    var topic_content=$('#topic_content').val();
    if($.trim(topic_title)==''){
        alert('主题不能为空');
        $('#topic_title').focus();
        return false;
    }
    if(topic_title.length<5){
        alert('主题长度不能小于5');
        $('#topic_title').focus();
        return false;
    }
    if(topic_title.length>100){
        alert('主题长度不能大于100');
        $('#topic_title').focus();
        return false;
    }
    if($.trim(topic_content)==''){
        alert('内容不能为空');
        $('#topic_content').focus();
        return false;
    }
    if(topic_content.length<5){
        alert('内容长度不能小于5');
        $('#topic_content').focus();
        return false;
    }
    return true;
}

// 检测回复
function check_reply(){
    var reply_content=$('#reply_content').val();
    if($.trim(reply_content)==''){
        alert('内容不能为空');
        $('#reply_content').focus();
        return false;
    }
    if(reply_content.length<5){
        alert('内容长度不能小于5');
        $('#reply_content').focus();
        return false;
    }
    return true;
}

// 检测tag
function check_tag(){
    var tag_name=$('#tag_name').val();
    if($.trim(tag_name)==''){
        alert('名称不能为空');
        $('#tag_name').focus();
        return false;
    }
    return true;
}

// 检测密码
function check_change(){
    var user_key_old=$('#user_key_old').val();
    var user_key=$('#user_key').val();
    if($.trim(user_key_old)==''){
        alert('当前密码不能为空');
        $('#user_key_old').focus();
        return false;
    }
    if($.trim(user_key)==''){
        alert('新密码不能为空');
        $('#user_key').focus();
        return false;
    }
    if(user_key==user_key_old){
        alert('新密码等于老密码');
        $('#user_key').focus();
        return false;
    }
    return true;
}

// 删除tag
function del_tag (id) {
    $.post(site_url+"/topic/tag_del",{ id: id},function (msg) {
        if ('1'==msg) {
            $('#tag-'+id).remove();
            //window.location.reload();
        } else {
            alert(msg);
        }
    });
}

// tag 属性编辑
function input_blur(){

        var input = $(this);
        var id = input.parent().parent().children('#tag_id');

        $.post(site_url+"/topic/tag_edit", {id:id.val(), attr:input.attr("name"), value:input.val()},function(msg){
            input.val(msg);
        });

}