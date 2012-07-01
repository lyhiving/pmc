<?php if ( ! defined('BASE_PATH')) exit('Access IS NOT allowed');

class user_model extends model {

    /**
     * 检测用户注册信息
     * @return boolen
     */
    function join_check() {

        $arr = array('admin','root');

        $sign = true;

        if( ! $_POST['user_login'] || ! $_POST['user_key'] || ! $_POST['user_key_confirm'] || ! $_POST['user_nickname']) {
            notice::$error[] = '请填写所有字段！';
            $sign = false;
        }

        if( in_array($_POST['user_nickname'], $arr) ){
            notice::$error[] = '请更换昵称！';
            $sign = false;
        }

        if ( $_POST['user_key'] != $_POST['user_key_confirm'] ) {
            notice::$error[] = '两次输入的秘密不一致！';
            $sign = false;
        }

        if ( ! is_email( $_POST['user_login'] ) ) {
            notice::$error[] = '邮箱格式不正确！';
            $sign = false;
        }

        $email = $this->db->users->findOne(array('user_login'=>$_POST['user_login']));
        if( ! empty($email['user_login']) ){
            notice::$error[] = '邮箱已经存在！';
            $sign = false;
        }

        $nick = $this->db->users->findOne(array('user_nickname'=>$_POST['user_nickname']));
        if( ! empty($nick['user_login']) ){
            notice::$error[] = '昵称已经存在！';
            $sign = false;
        }

        return $sign;

    }

    /**
     * 注册处理
     * @return string
     */
    public function join_do() {
        $data = array();
        $s = $this->db->users->findOne(array('superman'=>'Clark'));
        if( empty($s['_id']) ) $data['superman'] = 'Clark';
        $data['user_login'] = trim($_POST['user_login']);
        $data['password']   = md5(trim($_POST['user_key']));
        $data['create_at']  = time();
        $data['user_nickname'] = trim($_POST['user_nickname']);

        $this->db->users->insert($data);
        if ( isset( $data['_id'] ) ) {
            return $data['_id'];
        } else {
            return false;
        }
    }

    /**
     * 登录处理
     * @return string
     */
    public function login_do() {
        $data = array();
        $data['user_login'] = trim($_POST['user_login']);
        $data['password']   = md5(trim($_POST['user_key']));

        $res = $this->db->users->findOne($data);
        if ( $res['_id'] ) {
            setcookie('pmc_user_nick', $res['user_nickname'], null, APP_PATH);
            setcookie('pmc_user_id', $res['_id'], null, APP_PATH);
            if($res['superman']) setcookie('pmc_superman', $res['superman'], null, APP_PATH);
            return $res['_id'];
        } else {
            notice::$error = '登录失败，请确认您的帐户或密码！';
            return false;
        }
    }

    /**
     * 密码处理
     * @return string
     */
    public function password_do(){
        $data = array();
        $data['password']   = md5(trim($_POST['user_key_old']));
        $data['user_nickname'] = $_COOKIE['pmc_user_nick'];
        $data['_id'] = new MongoId($_COOKIE['pmc_user_id']);

        $res = $this->db->users->findOne($data);
        if( $res['_id'] ){
            $this->db->users->update(array('_id'=>$res['_id']), array('$set'=>array('password'=>md5(trim($_POST['user_key'])))));
            notice::$success = '修改成功,3秒后自动退出！';
            return $res['_id'];
        } else {
            notice::$error = '原密码不正确！';
            return false;
        }
    }

}

// End app/model/user_model.php