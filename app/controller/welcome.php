<?php if ( ! defined('BASE_PATH')) exit('Access IS NOT allowed');

class welcome extends controller{
    /**
     * 首页
     */
	function index(){
        $data = $this->load_model('topic_model')->index();
        $this->notice_title   = DEFAULT_NOTICE_TITLE;
        $this->notice_content = DEFAULT_NOTICE_CONTENT;
        $this->display('index', array('data'=>$data, 'index'=>true));
	}
}
// End app/controller/welcome.php