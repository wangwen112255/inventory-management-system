<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\controller\Admin;
use org\util\Date;

/**
 * @title 统计报表
 */
class Statistics extends Admin {

    /**
     * @title 销售报表
     */
    public function sales() {
        //
        if (empty($_REQUEST['timea']))
            $_REQUEST['timea'] = date('Y-m-d', time() - 86400 * 30);
        if (empty($_REQUEST['timeb']))
            $_REQUEST['timeb'] = date('Y-m-d');

        $my_date = new Date();

        $list = model('product_sales_order')->model_where()->chart(($my_date->date_diff('d', $_REQUEST['timea'], $_REQUEST['timeb']) + 1));

        $this->assign('list', $list);

        return view();
    }

}
