<?php

namespace app\admin\controller;

use app\common\controller\Base;
use think\Request;


/**
 * @title 打印
 */
class Prints extends Base {

    public function __construct(Request $request = null) {
        parent::__construct($request);

        $session_id = input('get.session_id', '');
        $session_data = db('session')->where('session_id', config('session.prefix') . '_' . $session_id)->value('session_data');

        if (empty($session_data))
            exit('会话无效');

        $user_json = explode('|', $session_data);

        if (empty($user_json[1]))
            exit('用户无效');

        $user = unserialize($user_json[1]);

        $this->assign('user_info', $user['user_auth']);

        define('UID', $user['user_auth']['id']);
    }

    /**
     * @title 出库订单详情
     */
    public function orders_view($id) {
        
        empty($id) && $this->error('参数不能为空');


        $this->assign('info', $var = model('product_sales_order')->model_where(NULL)->where('a.id', $id)->group('a.id')->find());

        // print_r($var);exit;

        if (!empty($var)) {
            model('product_sales_order')->save(['print' => 1], ['id' => $id]);
            model('operate')->success('打印出货单=>' . $var['order_number']);
        }

        $this->assign('orders', model('product_sales_order_data')->get_order_data_lists($id));
        return view();
    }

    /**
     * @title 出库订单列表
     */
    public function orders_list() {

        if (!isset($_GET['timea']))
            $_GET['timea'] = date('Y-m-d', time() - 86400 * 30);
        if (!isset($_GET['timeb']))
            $_GET['timeb'] = date('Y-m-d');

        $this->assign('lists', model('product_sales_order_data')->model_where()->group('a.id')->select());
        model('operate')->success('打印出货单');
        return view();
    }
    

    /**
     * @title 入库查询
     */
    public function storage_list() {

        if (!isset($_GET['timea']))
            $_GET['timea'] = date('Y-m-d', time() - 86400 * 30);
        if (!isset($_GET['timeb']))
            $_GET['timeb'] = date('Y-m-d');

        $this->assign('lists', model('product_storage_order_data')->model_where(true)->group('a.id')->select());
        model('operate')->success('打印入库单');
        return view();
    }

    /**
     * @title 入库查询
     */
    public function storage_view($id) {
        
        empty($id) && $this->error('参数不能为空');


        if (!isset($_GET['timea']))
            $_GET['timea'] = date('Y-m-d', time() - 86400 * 30);
        if (!isset($_GET['timeb']))
            $_GET['timeb'] = date('Y-m-d');


        $var = model('product_storage_order')->model_where()->group('a.id')->where('a.id', $id)->find();

        $sub_list = model('product_storage_order_data')->model_where()->group('a.id')->where('a.o_id', $var['id'])->select();
        $this->assign('sub_list', $sub_list);

        $this->assign('var', $var);

        model('operate')->success('打印入库单');

        return view();
    }

    /**
     * @title 打印账务
     */
    public function finance_list() {
        
        if (!isset($_GET['timea']))
            $_GET['timea'] = date('Y-m-d', time() - 86400 * 30);
        if (!isset($_GET['timeb']))
            $_GET['timeb'] = date('Y-m-d');
        
        $this->assign('lists', model('finance_accounts')->model_where()->group('a.id')->select());
        model('operate')->success('打印账务单');
        return view();
    }

}
