<div id="content">

        <form action="<?php echo url_convert('user/join');?>" method="post" id="join_form" onsubmit="return check_join()">
            <?php echo notice::show_error(); ?>
            <table cellspacing="15">
                <tr>
                <td align="right">邮箱：</td>
                <td><input type="text" name="user_login" id="user_login" class="input" size="50"  tabindex="1"/></td>
                <td><a href="<?php echo url_convert('user/login');?>">登录会员</a></td>
                </tr>

                <tr>
                <td align="right">密码：</td>
                <td><input type="password" name="user_key" id="user_key" class="input" size="50" maxlength="20"  tabindex="2"/></td>
                <!-- <td><a href="<?php echo url_convert('user/forget');?>">找回密码</a></td> -->
                </tr>

                <tr>
                <td align="right">确认：</td>
                <td><input type="password" name="user_key_confirm" id="user_key_confirm" class="input" size="50" maxlength="20"  tabindex="3"/></td>
                </tr>

                <tr>
                <td align="right">昵称：</td>
                <td><input type="text" name="user_nickname" id="user_nickname" class="input" size="30" maxlength="10"  tabindex="4"/></td>
                <td></td>
                </tr>

                <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value=" 注册 " id="user_submit" class="btn"/></td>
                <td></td>
                </tr>
             </table>
        </form>
</div>