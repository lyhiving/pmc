<?php if ( ! defined('BASE_PATH')) exit('Access IS NOT allowed');

class topic_model extends model {

    /**
     * 添加主题
     */
    public function add(){
        $data = array();
        if( $_POST['tag_id'] ) $data['tag_id']  = trim($_POST['tag_id']);
        $data['topic_title']   = trim($_POST['topic_title']);
        $data['topic_content'] = trim($_POST['topic_content']);
        $data['create_at']     = time();
        $data['update_at']     = time();
        $data['last_reply_at'] = time();
        $data['avatar_id']     = $_POST['avatar_id'];
        $data['reply_count']   = 0;
        $this->db->topics->insert($data);
        $this->db->users->update(array('_id'=>new MongoId($data['avatar_id'])),array('$inc'=>array('topic_count'=>1)));
        if( $data['_id'] ) {
            return $data['_id'];
        } else {
            return false;
        }
    }

    /**
     * 删除
     * @param  string $str
     * @return int
     */
    public function del($str){
        $id = new  MongoId($str);
        $this->db->topics->remove(array('_id' => $id), array('fsync' => true, 'justOne' => true));
        $this->db->replys->remove(array('topic_id' => $str), array('fsync' => true, 'justOne' => false));
    }

    /**
     * 添加回复
     * @return string
     */
    public function reply_add(){
        $data = $topic_data = array();
        $data['topic_id']      = trim($_POST['topic_id']);
        $data['reply_content'] = trim($_POST['reply_content']);
        $data['create_at']     = time();
        $data['update_at']     = time();
        $data['avatar_id']     = $_POST['avatar_id'];
        $this->db->replys->insert($data);

        $topic_data['last_reply_at']        = time();
        $topic_data['last_reply_avatar_id'] = $_POST['avatar_id'];

        $this->db->topics->update(array('_id'=>new MongoId($data['topic_id'])),array('$set'=>$topic_data, '$inc'=>array('reply_count'=>1)));

        $this->db->users->update(array('_id'=>new MongoId($data['avatar_id'])),array('$inc'=>array('reply_count'=>1)));

        if( $data['_id'] ) {
            return $data['_id'];
        } else {
            return false;
        }
    }

    /**
     * 首页显示
     * @return array
     */
    public function index(){
        return $this->tag_list();
    }

    /**
     * tag 数据显示
     * @param  array $arr
     * @return array
     */
    public function tag_list( $arr = array() ){
        $data = $res = array();
        if( empty($arr) ){
            $data = $this->db->topics->find()->sort(array('last_reply_at'=>-1))->limit(10);
        } else {
            if ( $arr[0] == 'more' ){
                $condition = array();
                $res['title'] = '更多数据';
            } else {
                $tmp_t = $this->db->tags->findOne(array('_id'=>new MongoId($arr[0])));
                $res['title'] = $tmp_t['name'];
                $condition = array('tag_id'=>$arr[0]);
            }
            $res['page']['p'] = empty($arr[1]) ? 1 : $arr[1];
            $res['page']['l'] = 10;
            $res['page']['c'] = $this->db->topics->count($condition);
            $skip = empty($arr[1]) ? 0 : ($res['page']['p'] - 1) * $res['page']['l'];
            $data = $this->db->topics->find($condition)->sort(array('last_reply_at'=>-1))->skip($skip)->limit($res['page']['l']);
        }

        foreach ($data as $key => $value) {
            $res[$key] = $value;
            $tmp = $this->db->users->findOne(array('_id' => new MongoId($value['avatar_id'])));
            $res[$key]['avatar_name']  = $tmp['user_nickname'];
            $res[$key]['avatar_email'] = $tmp['user_login'];
            $res[$key]['avatar_topic_count'] = $tmp['topic_count'] ? $tmp['topic_count'] : 0 ;
            $res[$key]['avatar_reply_count'] = $tmp['reply_count'] ? $tmp['reply_count'] : 0;
            if( $value['tag_id'] ){
                $tmp_1 = $this->db->tags->findOne(array('_id' => new MongoId($value['tag_id'])));
                $res[$key]['tag_id']    = $tmp_1['_id'];
                $res[$key]['tag_name']  = $tmp_1['name'];
            }
            if( $value['last_reply_avatar_id'] ){
                $tmp_2 = $this->db->users->findOne(array('_id' => new MongoId($value['last_reply_avatar_id'])));
                $res[$key]['last_reply_avatar_name']  = $tmp_2['user_nickname'];
            }
        }
        return empty($res) ? array() : $res ;
    }

    /**
     * 详细内容
     * @param  int   $id
     * @return array
     */
    public function show( $id ){
        $data  = $res = array();
        $data  = $this->db->topics->findOne(array('_id' => new MongoId($id)));
        if( empty($data) ) return array();
        //$data['topic_content'] = Markdown($data['topic_content']);
        $tmp = $this->db->users->findOne(array('_id' => new MongoId($data['avatar_id'])));
        $data['avatar_name']  = $tmp['user_nickname'];
        $data['avatar_email'] = $tmp['user_login'];

        if ( $_COOKIE['pmc_user_nick'] && $_COOKIE['pmc_user_id'] ) {
            $tmp = $this->db->users->findOne(array('_id' => new MongoId($_COOKIE['pmc_user_id'])));
            $data['pmc_user_email']  = $tmp['user_login'];
        }

        $tmp_1 = $this->db->replys->find(array('topic_id' => $id))->sort(array('create_at'=>1));
        foreach ($tmp_1 as $key => $value) {
            $res[$key] = $value;
            $tmp = $this->db->users->findOne(array('_id' => new MongoId($value['avatar_id'])));
            $res[$key]['avatar_name']  = $tmp['user_nickname'];
            $res[$key]['avatar_email'] = $tmp['user_login'];
        }
        if( ! empty($res) ) $data['replys'] = $res;
        return $data;
    }


}
// End app/model/topic_model.php