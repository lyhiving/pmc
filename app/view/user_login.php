<div id="content">
<form action="<?php echo url_convert('user/login');?>" method="post"  id="login_form" onsubmit="return check_login()">

<?php echo notice::show_error(); ?>
<table cellspacing="15">
<tr>
<td align="right">帐号：</td>
<td><input type="text" name="user_login" id="user_login" class="input" size="50" tabindex="1"/></td>
<td><a href="<?php echo url_convert('user/join');?>">注册会员</a></td>
</tr>
<tr>
<td align="right">密码：</td>
<td><input type="password" name="user_key" id="user_key" class="input"  size="50" tabindex="2"/></td>
<!-- <td><a href="<?php echo url_convert('user/forget');?>">找回密码</a></td> -->
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" value=" 登 录 " id="user_submit" class="btn" tabindex="3"/></td>
<td></td>
</tr>
</table>

</form>
</div>