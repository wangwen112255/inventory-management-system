<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件
use app\common\builder\Builder;


/**
 * @title 生成图片的缩略图
 * @param type $filename
 * @param type $width
 * @param type $height
 * @return boolean
 */
function img_resize($filename, $width, $height, $default = '') {
    //define('$res_path','E:/xampp552/htdocs/vv_mythink1.0/Res/');
    //define('RES_HTTP','http://127.0.0.1:8080/vv_mythink1.0/Res/');
    $res_path = APP_DIR . '/uploads/';
    $res_http = APP_URL . '/uploads/';
    //import('Common.Org.Image');
    if (!is_file($res_path . $filename)) {
        // echo 'eeee'. $res_path . $filename;exit;
        if (strpos($filename, 'http') !== false) {
            return $filename;
        } else {
            return $filename;            
        }
        //return false;
    }
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $old_image = $filename;
    $new_image = 'cache/' . iconv_substr($filename, 0, iconv_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
    //print_r(filemtime($res_path . $old_image));
    // print_r('<br />');
    // print_r(filemtime($res_path . $new_image));f
    if (is_file($res_path . $new_image)) {
        return $res_http . $new_image;
    } else {
        $path = '';
        $directories = explode('/', dirname(str_replace('../', '', $new_image)));
        foreach ($directories as $directory) {
            $path = $path . '/' . $directory;
            if (!is_dir($res_path . $path)) {
                @mkdir($res_path . $path, 0777);
            }
        }
        if (!is_file($res_path . $old_image)) {
            return '';
        }
        list($width_orig, $height_orig) = @getimagesize($res_path . $old_image);
        if ($height == 0) {
            $height = $width * $height_orig / $width_orig;
        }
        if ($width == 0) {
            $width = $height * $width_orig / $height_orig;
        }
        if ($width_orig == $width && $height_orig == $height) {
            copy($res_path . $old_image, $res_path . $new_image);
        } else {
            $image = new org\util\Image($res_path . $old_image);
            $image->resize($width, $height, $default);
            $image->save($res_path . $new_image, 75);
        }
        return $res_http . $new_image;
    }
}

function res_http($res_path) {
    if (is_file(APP_DIR . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR  . $res_path)) {
        return APP_URL . '/uploads/' . $res_path;
    }
}

/**
 * @title HASH值计算
 * @param type $u
 * @param type $s
 * @return type
 */
function hash_db($u, $s = 10) {
    $h = sprintf("%u", crc32($u));
    $h1 = intval(fmod($h, $s));
    return $h1;
}

/**
 * @title 配置读取
 * @param type $tag
 * @param type $default_value
 * @return type
 */
function config_value($tag, $default_value) {
    $arr = config($tag);
    return isset($arr[$default_value]) ? $arr[$default_value] : '';
}

/**
 * @title 仿laravel打印数据 
 * @param type $value
 */
function dd($value) {
    print_r($value);
    exit;
}

/**
 * @title 生成图片的缩略图
 * @param type $filename
 * @param type $width
 * @param type $height
 * @return boolean
 */
function sq_img_resize($filename, $width, $height, $default = '') {
    $res_path = APP_DIR . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
    $res_http = APP_URL . '/uploads/';
    if (!is_file($res_path . $filename)) {
        return false;
    }
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $old_image = $filename;
    $new_image = 'cache/' . iconv_substr($filename, 0, iconv_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
    if (is_file($res_path . $new_image)) {
        return $res_http . $new_image;
    } else {
        $path = '';
        $directories = explode('/', dirname(str_replace('../', '', $new_image)));
        foreach ($directories as $directory) {
            $path = $path . '/' . $directory;
            if (!is_dir($res_path . $path)) {
                @mkdir($res_path . $path, 0777);
            }
        }
        list($width_orig, $height_orig) = getimagesize($res_path . $old_image);
        if ($height == 0) {
            $height = $width * $height_orig / $width_orig;
        }
        if ($width == 0) {
            $width = $height * $width_orig / $height_orig;
        }
        if ($width_orig == $width && $height_orig == $height) {
            copy($res_path . $old_image, $res_path . $new_image);
        } else {
            $image = new org\util\Image($res_path . $old_image);
            $image->resize($width, $height, $default);
            $image->save($res_path . $new_image);
        }
        return $res_http . $new_image;
    }
}

/**
 * @title 获取构建器实例
 * @param  string $type 类型（list|form）
 * @return [type] [description]
 * @date   2018-02-02
 * @author 心云间、凝听 <981248356@qq.com>
 */
function builder($type = '') {
    $builder = Builder::run($type);
    return $builder;
}

/**
 * @title 数组对象转数组 
 * @param type $target
 * @return type
 */
function array_out($target) {
    $result = array();
    foreach ($target as $value) {
        $result[] = json_decode($value, true);
    }
    return $result;
}

/**
 * @title 解析配置文件的注释
 * @param type $cnt
 */
function parse_config_tit($cnt) {
    $regx_title = '/@(\w+)\s+(.*?)\s+(.*?)\s+(.*)/i';
    preg_match($regx_title, $cnt, $arr);
    if (isset($arr[2])) {
        return $arr[2];
    } else {
        return '';
    }
    print_r($cnt);
    exit;
}

/**
 * @title 替代scan_dir的方法
 * @param string $pattern 检索模式 搜索模式 *.txt,*.doc; (同glog方法)
 * @param int $flags
 */
function my_scan_dir($pattern, $flags = null) {
    $files = array_map('basename', glob($pattern, $flags));
    return $files;
}

/**
 * @title 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++)
        $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * @title 获取配置的类型
 * @param string $type 配置类型
 * @return string
 */
function get_config_type($type = 0) {
    $lists = config('CONFIG_TYPE_LIST');
    return $lists[$type];
}

/**
 * @title 获取配置的分组
 * @param string $group 配置分组
 * @return string
 */
function get_config_group($group = 0) {
    $lists = config('CONFIG_GROUP_LIST');
    return $group ? $lists[$group] : '';
}

/**
 * @title 分析枚举类型配置值 格式 a:名称1,b:名称2
 * @param type $string
 */
function parse_config_attr($string) {
    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
    if (strpos($string, ':')) {
        $value = array();
        foreach ($array as $val) {
            list($k, $v) = explode(':', $val);
            $value[$k] = $v;
        }
    } else {
        $value = $array;
    }
    return $value;
}

if (!function_exists('array_column')) {

    function array_column(&$array, $key) {
        $keyArr = [];
        foreach ($array as $value) {
            $keyArr[] = $value[$key];
        }
        return $keyArr;
    }

}
/**
 * @title 返回图像类型
 */
if (!function_exists('exif_imagetype')) {

    function exif_imagetype($filename) {
        if ((list($width, $height, $type, $attr) = getimagesize($filename) ) !== false) {
            return $type;
        }
        return false;
    }

}

/**
 * @title 下划线转驼峰
 */
function underline_to_hump($str) {
    $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function($matches) {
        return strtoupper($matches[2]);
    }, $str);
    return $str;
}

/**
 * @title 驼峰转下划线
 */
function hump_to_underline($str) {
    return strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $str));
}

/**
 * @title 一维数组转多维
 * @param type $items
 * @param type $id
 * @param type $pid
 * @param type $son
 * @return type
 */
function gen_tree($items, $id = 'id', $pid = 'pid', $son = 'son') {
    // print_r($items);exit;
    $tree = array();
    $tmpMap = array();
    foreach ($items as $item) {
        $tmpMap[$item[$id]] = $item;
    }
    foreach ($items as $item) {
        if (isset($tmpMap[$item[$pid]])) {
            $tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];
        } else {
            $tree[] = &$tmpMap[$item[$id]];
        }
    }
    unset($tmpMap);
    return $tree;
}

/**
 * @title 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type = 0, $adv = false) {
    $type = $type ? 1 : 0;
    static $ip = NULL;
    if ($ip !== NULL) {
        return $ip[$type];
    }
    if ($adv) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) {
                unset($arr[$pos]);
            }
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

/**
 * @title 动态生成下拉菜单
 * @param  array $arr 列表数组 int $selected_id当前被选中ID
 */
function html_select($arr, $selected_id = 0) {
    $str = '';
    foreach ((array) $arr as $key => $val) {
        if ($selected_id == $key) {
            $str = $str . '<option value="' . $key . '" selected="selected">' . $val . '</option>';
        } else {
            $str = $str . '<option value="' . $key . '">' . $val . '</option>';
        }
    }
    return $str;
}

/**
 * @title 动态生成单选框
 * @param  array $arr 列表数组 int $selected_id当前被选中ID
 */
function html_radio($name, $arr, $selected_id = 1) {
    ksort($arr);
    $str = '';
    foreach ($arr as $key => $val) {
        if ($selected_id == $key) {
            $str = $str . '<label class="radio-inline"><input type="radio" name="' . $name . '" id="' . $name . $key . '" value="' . $key . '" checked="checked" /><label for="' . $name . $key . '">' . $val . '</label></label>' . chr(10);
        } else {
            $str = $str . '<label class="radio-inline"><input type="radio" name="' . $name . '" id="' . $name . $key . '" value="' . $key . '" /><label for="' . $name . $key . '">' . $val . '</label></label>' . chr(10);
        }
    }
    return $str;
}

/**
 * @title 动态生成复选框
 * @param type $name
 * @param type $data
 * @param type $current 数组或者逗号分开的字符串
 */
function html_checkbox($name, $data, $current = '') {
    ksort($data);
    $str = "";
    $checked = "";
    foreach ($data as $key => $value) {
        $checked = '';
        if (is_array($current)) {
            if (in_array($key, $current)) {
                $checked = " checked";
            }
        } elseif (!empty($current)) {
            if (in_array($key, explode(',', $current))) {
                $checked = " checked";
            }
        }
        $str .= '<label class="checkbox-inline"><input type="checkbox" name="' . $name . '[]" value="' . $key . '" ' . $checked . '  > ' . $value . ' </label>';
    }
    return $str;
}

/**
 * @title 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function data_auth_sign($data) {
    //数据类型检测
    if (!is_array($data)) {
        $data = (array) $data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

/**
 * @title 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function is_login() {
    $user = session('user_auth');
    if (empty($user)) {
        return 0;
    } else {
        return session('user_auth_sign') == data_auth_sign($user) ? $user['id'] : 0;
    }
}

/**
 * @title 获取用户ID
 */
function get_uid() {
    $uid = UID;
    return $uid;
}
