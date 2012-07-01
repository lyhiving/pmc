<?php if ( ! defined('BASE_PATH')) exit('Access IS NOT allowed');

class tag_model extends model {

    /**
     * 全部Tag
     * @return [type] [description]
     */
    public function all(){
        $res = $this->db->tags->find()->sort(array('order'=>1));
        return $res;
    }

    /**
     * 添加Tag
     */
    public function add(){
        $data = array();
        $data['name']       = trim($_POST['tag_name']);
        $data['order']      = empty($_POST['tag_order'])? 1 : intval(trim($_POST['tag_order']));
        $data['create_at']  = time();
        $this->db->tags->insert($data);
        if( $data['_id'] ) {
            return $data['_id'];
        } else {
            return false;
        }
    }

    /**
     * 删除Tag
     * @return string
     */
    public function del(){
        $id = new MongoId($_POST['id']);
        $this->db->tags->remove(array('_id' => $id), array('fsync' => true, 'justOne' => true));
        $this->db->topics->update(array('tag_id'=>$_POST['id']), array('$set'=>array('tag_id'=>'')));
    }

    /**
     * 编辑Tag
     * @return string
     */
    public function edit(){
        $data = $condition = array();
        $condition['_id'] = new MongoId($_POST['id']);
        $attr = substr($_POST['attr'], 4);
        if($attr == 'order') $_POST['value'] = intval($_POST['value']);
        $data[$attr] = $_POST['value'];
        $this->db->tags->update($condition, array('$set'=> $data));
        return $data[$attr];
    }
}

// End app/model/tag_model.php