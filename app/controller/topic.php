<?php if ( ! defined('BASE_PATH')) exit('Access IS NOT allowed');

class topic extends controller{

    /**
     * 标签
     * @param  array $array
     * @return int
     */
    public function tag( $array ){
        $data = $this->load_model('topic_model')->tag_list( $array );
        $page = $data['page'] ? $data['page'] : array();
        $page['url'] = 'topic/tag/'.$array[0];
        unset($data['page']);
        $this->title = $data['title'] . ' - ' . SITE_TITLE;
        $this->notice_title   = $data['title'];
        $this->notice_content = $data['title'].' 主题数：'.$page['c'] . ' 当前页：' .$page['p'];
        unset($data['title']);
        $this->display('index', array('data'=>$data, 'page'=>$page));
    }

    /**
     * 管理tag
     * @return int
     */
    public function tag_admin(){
        if( ! $_COOKIE['pmc_user_nick'] && ! $_COOKIE['pmc_user_id'] && ! $_COOKIE['pmc_superman'] ) redirect();
        $data = $this->load_model('tag_model')->all();
        if( $_POST ){
            if ( $this->load_model('tag_model')->add() ) {
                redirect('topic/tag_admin');
            }
        }
        $this->title = $this->notice_title  = 'TAG管理';
        $this->notice_content = SITE_TITLE;
        $this->display('tag_admin', array('data' => $data));
    }

    /**
     * 删除tag
     * @return [type] [description]
     */
    public function tag_del(){
        $this->load_model('tag_model')->del();
        exit('1');
    }

    /**
     * 编辑tag
     * @return string
     */
    public function tag_edit(){
        $data = $this->load_model('tag_model')->edit();
        //var_dump($data);
        exit(strval($data));
    }

    /**
     * 删除
     * @param  array $arr
     * @return int
     */
    public function del( $arr ){
        $this->load_model('topic_model')->del($arr[0]);
        redirect();
    }

    /**
     * 添加主题
     * @param string
     */
    public function add( $tag = ''){
        $GLOBALS['close_add_topic_btn'] = TRUE;
        if( ! $_COOKIE['pmc_user_nick'] && ! $_COOKIE['pmc_user_id'] ) redirect();
        if( $_POST ){
            $_POST['avatar_id'] = $_COOKIE['pmc_user_id'];
            if ( $this->load_model('topic_model')->add() ) {
                redirect();
            }
        }
        $data = $this->load_model('tag_model')->all();
        $this->title = '发布消息 - ' . SITE_TITLE;
        $this->notice_title = '发布消息';
        $this->notice_content = '支持Markdown语法：http://gitcafe.com/riku/Markdown-Syntax-CN/blob/master/basics.md';
        $this->display('topic_add', array('tag'=>$data));
    }

    /**
     * 添加回复
     * @return string
     */
    public function reply_add(){
        if( $_POST ){
            $_POST['avatar_id'] = $_COOKIE['pmc_user_id'];
            if ( $this->load_model('topic_model')->reply_add() ) {
                redirect('topic/show/'.$_POST['topic_id']);
            }
        }
        redirect('topic/show/'.$_POST['topic_id']);
    }

    /**
     * 展示主题
     * @param  string #id
     * @return int
     */
    public function show( $id ){
        if( empty($id) ) redirect();
        $data = $this->load_model('topic_model')->show($id[0]);
        if( empty($data) ) {$this->load_view('404'); exit;} // 404
        $this->title = $data['topic_title'] . ' | ' . SITE_TITLE;
        $this->notice_title = $data['topic_title'];
        $this->notice_content = $data['avatar_name'].' 发表于 '. format_time($data['create_at']);
        $this->display('topic_show', array('data'=>$data));
    }
}

// End app/controller/topic.php