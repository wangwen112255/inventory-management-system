<?php

namespace app\common\model;

use think\Model;
use think\Request;
use think\Loader;
use think\Cookie;

class Base extends Model {

    private $formats = [];
    private $category;

    public function get_formats($pid = 0, $len = 0) {
        $this->category = $this->model_where()->select();
        $this->formats($len, $pid);
        $category = $this->formats;
        $this->formats = array();
        return $category;
    }

    function formats($len, $pid) {
        $n = str_pad('', $len, '-', STR_PAD_RIGHT);
        $n = str_replace("-", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $n);
        foreach ($this->category as $var) {
            if ($var['pid'] == $pid) {
                $var['name'] = $n . "|--" . $var['name'];
                $this->formats[] = $var;
                $this->formats($len + 1, $var['id']);
            }
        }
    }

    public function model_where() {
        return $this;
    }

    /**
     * @title 树型的列表，不分页
     * @param type $firstRow
     * @return type
     */
    public function lists_tree($map = NULL, $sort = 'sort asc,id asc', $pid = 0) {        
        $this->category = $this->where($map)->order($sort)->select();
        $this->formats(0, $pid);
        $category = $this->formats;
        $this->formats = array();
        return $category;
    }

    /**
     * @title 用于select赋值
     * @param type $firstRow
     * @return type
     */
    public function lists_select($fields = 'id,name') {
        return $this->column($fields);
    }

    /**
     * @title 用于树型select赋值
     * @return type
     */
    public function lists_select_tree($map = NULL, $sort = 'sort asc,id asc', $pid = 0) {

        $this->category = $this->where($map)->select();
        $this->formats(0, $pid);
        $category = $this->formats;
        $this->formats = array();

        $options = [];
        if ($category)
            foreach ($category as $key => $value) {
                $options[$value['id']] = $value['name'];
            }
        return $options;
    }

    ///////////////////////////
    static $configbase, $base;

    public function get_base($key = null) {
        if (empty(self::$base))
            self::$base = is_file($this->get_base_file()) ? include $this->get_base_file() : array();
        return is_null($key) ? self::$base : (isset(self::$base[$key]) ? self::$base[$key] : NULL);
    }

    public function get_base_file() {
        return self::$configbase ?: self::$configbase = rtrim(dirname(__DIR__), '\\/') . DS . 'config' . DS . 'base.php';
    }

    public function lists($count) {
        $page = isset($_GET['pagination']) ? $_GET['pagination'] : 1;
        $numPerPage = $this->get_base('queqry');
        $offset = $numPerPage * ((int) $page - 1);
        return $this->limit($numPerPage, $offset)->select();
    }

}
