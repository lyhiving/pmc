<?php if ( ! defined('BASE_PATH')) exit('Access IS NOT allowed');
/**
 * 基础控制器
 */
class controller extends app{

    public $view_data = array();
    public $title;
    public $notice_title;
    public $notice_content;

    /**
     * 构造方法
     */
    function __construct(){

    }

    /**
     * 默认方法
     * @return int
     */
    function index(){
        $this->load_view('404');
    }

    /**
     * 拓展试图
     * @param  string $filename 文件名
     * @param  array  $data     数据
     * @return int
     */
    function display($filename, $data = array()){
        $this->header();
        $this->load_view($filename, $data);
        $this->footer();
    }

    /**
     * 加载头部
     * @return int
     */
    function header(){
        $this->view_data['title']          = $this->title ? $this->title : SITE_TITLE; //网站标题
        $this->view_data['notice_title']   = $this->notice_title;
        $this->view_data['notice_content'] = $this->notice_content;
        $this->view_data['menu']           = $this->load_model('tag_model')->all();
        $this->load_view('header', $this->view_data);
    }

    /**
     * 加载底部
     * @return int
     */
    function footer(){
        $this->load_view('footer');
    }
}

// End app/lib/core/controller.php