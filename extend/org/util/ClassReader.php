<?php

namespace org\util;

/**
 * @title 类解析
 */
class ClassReader {

    var $class_path = '';

    function __construct($class_path) {

        $this->class_path = $class_path;
        return is_dir($class_path);
    }

    public function echo_test() {

        echo 'only test';
    }

    public function get_dir() {

        $file_array = array();

        $handler = opendir($this->class_path);


        while (($filename = readdir($handler)) !== false) {

            //3、目录下都会有两个文件，名字为'.'和‘..’，不要对他们进行操作
            if ($filename != "." && $filename != ".." && $filename != "DebugController.class.php" && $filename != "CommonController.class.php") {
                //4、进行处理		
                //这里简单的用echo来输出文件名
                $file_array[] = $filename;
            }
        }
        closedir($handler);

        return $file_array;

        //$file_array = scandir($this->class_path, "*.php");
    }

    public function get_service_tree() {

        $class_array = array();
        $function_array = array();

        $file_array = $this->get_dir();

        foreach ($file_array as $k => $v) {

            $class_name = str_replace('.php', '', $v);

            $content = file_get_contents($this->class_path . '/' . $v);

            //print_r($this->class_path.'/'.$v);exit;

            preg_match_all("/function\s{1}([^_].*?)\(/is", $content, $matchs);
            $function_array = $matchs[1];

            $class_array[$class_name] = $function_array;
        }
        return $class_array;
    }

}
