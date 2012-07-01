<?php if ( ! defined('BASE_PATH')) exit('Access IS NOT allowed');
/**
 * 信息提示
 */
class notice {
    static public $error   = null;
    static public $success = null;
    static public $block   = null;
    static public $info    = null;

    /**
     * 显示错误信息
     * @param  string  $data       错误信息
     * @param  boolean $close      是否可以关闭信息提示
     * @param  string  $heading    标题
     * @return string
     */
    static public function show_error( $data = '' , $close = false, $heading = '' ){
        if( ! empty( $data ) ) self::$error = $data;
        return self::show('error', $close, $heading );
    }

    /**
     * 显示成功信息
     * @param  string  $data       成功信息
     * @param  boolean $close      是否可以关闭信息提示
     * @param  string  $heading    标题
     * @return string
     */
    static public function show_success( $data = '' , $close = false, $heading = '' ) {
        if( ! empty( $data ) ) self::$success = $data;
        return self::show('success', $close, $heading );
    }

   /**
     * 显示警告信息
     * @param  string  $data       警告信息
     * @param  boolean $close      是否可以关闭信息提示
     * @param  string  $heading    标题
     * @return string
     */
    static public function show_block( $data = '' , $close = false, $heading = '' ) {
        if( ! empty( $data ) ) self::$block = $data;
        return self::show('block', $close, $heading );
    }

   /**
     * 显示提示信息
     * @param  string  $data       提示信息
     * @param  boolean $close      是否可以关闭信息提示
     * @param  string  $heading    标题
     * @return string
     */
    static public function show_info( $data = '' , $close = false, $heading = '' ) {
        if( ! empty( $data ) ) self::$info = $data;
        return self::show('info', $close, $heading );
    }

    /**
     * 显示信息
     * @param  string  $alert_type 错误信息 类型 ：block、error、success、info
     * @param  boolean $close      是否可以关闭信息提示
     * @param  string  $heading    标题
     * @return string
     */
    static public function show($alert_type = 'error', $close = false, $heading = '')
    {
        if( ! is_null( self::$$alert_type ) ) {
            $data  = '<div class="alert alert-' . $alert_type . '">';

            if( ! $close ) {
                $data .= '<a class="close" data-dismiss="alert" href="#">×</a>';
            }

            if ( ! empty( $heading ) ) {
                $data .= '<h4 class="alert-heading">' . $heading . '</h4>';
            }

            if( is_array( self::$$alert_type ) ) {
                foreach (self::$$alert_type as $key => $value) {
                    $data .=  ($key + 1) . ' . ' . $value . '<br />';
                }
            } else {
                $data .= self::$$alert_type;
            }
            $data .= '</div>';

            return $data;
        }

        return false;

    }

    /**
     * 析构函数
     */
    function __destruct() {
        self::$info    = null;
        self::$success = null;
        self::$block   = null;
        self::$info    = null;
    }
}
// End app/lib/core/notice.php