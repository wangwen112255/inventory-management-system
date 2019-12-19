<?php

namespace app\admin\controller;

use app\admin\controller\Admin;


/**
 * @title JSON
 */
class Json extends Admin {

    /**
     * @title 财务分类
     */
    public function finance_category() {
        echo model('finance_category')->json();
    }

    /**
     * @title 菜单
     */
    public function menu($id = null) {
        echo model('menu')->json($id);
    }

    /**
     * @title 城市
     */
    public function city() {
        echo model('city')->json();
    }

    /**
     * @title 产品
     */
    public function product() {


        $type = input('get.type/a', []);

        echo model('product')->json($type);
    }

    /**
     * @title 会员
     */
    public function member() {
        echo model('member')->json();
    }

}
