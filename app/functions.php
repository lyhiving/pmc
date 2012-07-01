<?php if ( ! defined('BASE_PATH')) exit('Access IS NOT allowed');

// markdown
include_once "lib/markdown.php";

/**
 * 内容转换
 * @param  string $s
 * @return string
 */
function utf8_entities( $s ) {
    return htmlentities($s, ENT_COMPAT, 'UTF-8');
}

/**
 * 检查邮箱合法性
 * @param  string  $user_email
 * @return boolean
 */
function is_email( $user_email ) {
    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if ( strpos($user_email, '@') !== false && strpos($user_email, '.') !== false ){
        if ( preg_match($chars, $user_email) ){
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * 检测XSS攻击
 * @return string
 */
function check_xss() {
    $temp = strtoupper( urldecode( urldecode( $_SERVER['REQUEST_URI'] ) ) );
    if( strpos($temp, '<') !== false || strpos($temp, '"') !== false || strpos($temp, 'CONTENT-TRANSFER-ENCODING') !== false ) {
        exit('request_tainting');
    }
    return true;
}

/**
 * 格式化时间
 * @param  string $time
 * @return string
 */
function format_time( $time ) {
    $dur = $_SERVER['REQUEST_TIME'] - $time;
    if( $dur < 60 ){
        return $dur . '秒前';
    } else {
        if( $dur < 3600 ){
            return floor( $dur / 60 ) . '分钟前';
        } else {
            if( $dur < 86400 ){
                return floor( $dur / 3600 ) . '小时前';
            } else {
                if( $dur < 259200 ){
                    return floor( $dur / 86400 ) . '天前';
                } else {
                    return date('Y-m-d H:i', $time);
                }
            }
        }
    }
}

/**
 * 网站地址
 * @return string
 */
function site_url() {
    return rtrim(url_convert(), '/');
}

/**
 * 地址转换
 * @param  string $url
 * @return string
 */
function url_convert( $url = '' ) {
    return rtrim(BASE_PATH, '/') . '/' . trim(APP_PATH, '/') . '/' . trim($url, '/');
}

/**
 * 获取操作系统
 * @param  string $AGENT
 * @return string
 */
function get_os( $AGENT = '' ){
    if( empty($AGENT) ){
        $AGENT = $_SERVER["HTTP_USER_AGENT"];
    }
    if(strpos($AGENT,"Windows NT 5.0")) $os = "Windows 2000";
    elseif(strpos($AGENT,"Windows NT 5.1")) $os = "Windows XP";
    elseif(strpos($AGENT,"Windows NT 5.2")) $os = "Windows 2003";
    elseif(strpos($AGENT,"Windows NT 6.0")) $os = "Windows Vista";
    elseif(strpos($AGENT,"Windows NT 6.1")) $os = "Windows 7";
    elseif(strpos($AGENT,"Windows NT")) $os = "Windows NT";
    elseif(strpos($AGENT,"Windows CE")) $os = "Windows CE";
    elseif(strpos($AGENT,"ME")) $os = "Windows ME";
    elseif(strpos($AGENT,"Windows 9")) $os = "Windows 98";
    elseif(strpos($AGENT,"unix")) $os = "Unix";
    elseif(strpos($AGENT,"linux")) $os = "Linux";
    elseif(strpos($AGENT,"SunOS")) $os = "SunOS";
    elseif(strpos($AGENT,"OpenBSD")) $os = "OpenBSD";
    elseif(strpos($AGENT,"FreeBSD")) $os = "FreeBSD";
    elseif(strpos($AGENT,"AIX")) $os = "AIX";
    elseif(strpos($AGENT,"Mac")) $os = "Mac";
    else $os = "Other";
    return $os;
}

/**
 * 获取avatar头像
 * @param  string  $email
 * @param  integer $s
 * @param  string  $d
 * @param  string  $r
 * @return string
 */
function get_gravatar( $email, $s = 48, $d = 'mm', $r = 'g' ) {
    $url = 'http://cn.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    return $url;
}

/**
 * 地址转跳
 * @param  string  $uri
 * @param  string  $method
 * @param  integer $http_response_code
 * @return int
 */
function redirect($uri = '', $method = 'location', $http_response_code = 302) {
    if( $uri ) {
        if ( ! preg_match('#^https?://#i', $uri)) {
            $uri = url_convert($uri);
        }
    } else {
        $uri = site_url();
    }

    if ( !headers_sent() ) {
        switch($method) {
            case 'refresh'  : header("Refresh:0;url=".$uri);
                    break;
            default         : header("Location: ".$uri, TRUE, $http_response_code);
                break;
        }
        exit;
    } else {
        exit("<meta http-equiv='Refresh' content='0;URL={$uri}'>");
    }
}

/**
 * 分页显示
 * @param  string  $url 分页路径
 * @param  integer $p   当前页面
 * @param  integer $c   数据总数
 * @param  integer $l   偏移
 * @param  integer $n   显示几个分页
 * @return string
 */
function show_page($url = '', $p = 1, $c = 100, $l = 20, $n = 2){
    if (empty($url)) return false;

    $url  = url_convert($url) . '/';

    $total = ceil($c / $l);

    if( $total == 1 ) return false;

    $a = ceil( $n / 3 );
    $b = $n - $a;

    $prevs = $p - $a;
    if ( $prevs <= 0) { $prevs = 1; }

    $prev  = $prevs - 1;
    if ( $prev <= 0) {$prev = 1;}

    $nexts = $p + $b;
    if ( $nexts > $total) { $nexts = $total; }

    $next  = $nexts + 1;
    if ( $next > $total) {$next = $total;}

    $str  = '<div class="pagination"><ul>';

    if( $p > 1 ) $str .= '<li><a href="'.$url.($p-1).'">Prev</a></li>';

    for ( $i = $prevs; $i <= $p-1; $i++ ) {
        $str .= '<li><a href="'.$url.$i.'">'.$i.'</a></li>';
    }

    $str .= '<li class="active"><a href="'.$url.$p.'">'.$p.'</a></li>';

    for ( $i = $p+1; $i <= $nexts; $i++ ) {
        $str .= '<li><a href="'.$url.$i.'">'.$i.'</a></li>';
    }

    if( $p < $total ) $str .= '<li><a href="'.$url.($p+1).'">Next</a></li>';

    $str .= '</ul></div>';

    return $str;
}

//End app/functions.php