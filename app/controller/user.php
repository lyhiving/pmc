<?php if ( ! defined('BASE_PATH')) exit('Access IS NOT allowed');

/**
 * 用户操作
 */
class user extends controller{

    /**
     * 用户注册
     * @return int
     */
    public function join(){
        if( $_COOKIE['pmc_user_nick'] && $_COOKIE['pmc_user_id'] ) redirect();
        if( $_POST ){
            if ( $this->load_model('user_model')->join_check() ) {
                if ( $this->load_model('user_model')->join_do() ) {
                    redirect( 'user/login' );
                }
            }
        }
        $this->title = '注册会员 - ' . SITE_TITLE;
        $this->notice_title = '注册会员';
        $this->notice_content = '请您填写正确的信息，确保注册成功';
        $this->display('user_join');
    }

    /**
     * 用户登录
     * @return int
     */
    public function login(){
        if( $_COOKIE['pmc_user_nick'] && $_COOKIE['pmc_user_id'] ) redirect();
        if( $_POST ) {
            if ( $this->load_model('user_model')->login_do() ) {
                redirect();
            }
        }
        $this->title = '会员登录 - ' . SITE_TITLE;
        $this->notice_title = '会员登录';
        $this->notice_content = '登陆您的会员帐号';
        $this->display('user_login');
    }

    /**
     * 登录退出
     * @return int
     */
    public function logout(){
        setcookie('pmc_user_nick', '', time()-3600, APP_PATH);
        setcookie('pmc_user_id', '', time()-3600, APP_PATH);
        if( $_COOKIE['pmc_superman'] ) setcookie('pmc_superman', '', time()-3600, APP_PATH);
        redirect();
    }

    /**
     * 修改密码
     * @return int
     */
    public function password(){
        if( ! $_COOKIE['pmc_user_nick'] && ! $_COOKIE['pmc_user_id'] ) redirect();
        if( $_POST ) {
            if ( $this->load_model('user_model')->password_do() ) {
                header("Refresh:3;url=".url_convert('user/logout'));
            }
        }
        $this->title = '修改密码 - ' . SITE_TITLE;
        $this->notice_title = '修改密码';
        $this->notice_content = '请输入>=6位的密码';
        $this->display('user_password');
    }
}

// End app/contoller/user.php