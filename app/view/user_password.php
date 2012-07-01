<div id="content">
<form action="<?php echo url_convert('user/password');?>" method="post" id="forget_form" onsubmit="return check_change()">
<?php echo notice::show_error(); ?>
<?php echo notice::show_success(); ?>
<table cellspacing="15">
<tbody><tr>
<td align="right">请输入当前密码：</td>
<td><input type="password" name="user_key_old" id="user_key_old" class="input" size="30"></td>
</tr>

<tr>
<td align="right">请输入新的密码：</td>
<td><input type="password" name="user_key" id="user_key" class="input" size="30"></td>
</tr>

<tr>
<td>&nbsp;</td>
<td><input type="submit" value=" 提交 " id="user_submit" class="btn"></td>
<td></td>
</tr>
</tbody></table>
</form>
</div>