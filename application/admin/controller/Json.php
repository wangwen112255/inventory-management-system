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
        echo $this->m_finance_category->json();
    }

    /**
     * @title 菜单
     */
    public function menu($id = null) {
        echo $this->m_menu->json($id);
    }

    /**
     * @title 城市
     */
    public function city() {
        echo $this->m_city->json();
    }

    /**
     * @title 产品
     */
    public function product() {


        $type = input('get.type/a', []);

        echo $this->m_product->json($type);
    }

    /**
     * @title 会员
     */
    public function member() {
        echo $this->m_member->json();
    }

}
