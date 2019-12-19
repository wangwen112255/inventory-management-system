<?php

namespace app\admin\controller;

use app\admin\controller\Admin;

/**
 * @title 库存管理
 */
class Inventory extends Admin {

    /**
     * @title 入库
     */
    public function storage() {

        if (request()->isPost()) {
            $post = request()->post();

            //仓库列表 
            $warehouse = $this->m_product_warehouse->model_where()->where('pwu.u_id', UID)->column('a.name', 'a.id');
            $this->assign('warehouse', $warehouse);


            $product_ids = isset($post['product_ids']) ? $post['product_ids'] : [];
            $product_ids[] = input('post.product_id', 0); // 把当前选择的加进来            

            $products = NULL;
            foreach ($product_ids as $id) {
                if (!empty($id) && is_numeric($id) && $one = db('product')->where('id', $id)->find())
                    if (!empty($one))
                        $products[$id] = $one;
            }
            $this->assign('products', $products);
        }

        return view();
    }

    /**
     * @title 入库提交  
     */
    public function storage_submit() {

        if (request()->isPost()) {
            $post = request()->post();

            //产品
            $product_ids = isset($post['product_ids']) ? $post['product_ids'] : [];
            $product_ids = array_filter($product_ids);
            //数量
            $product_quantity = isset($post['product_quantity']) ? $post['product_quantity'] : [];
            //仓库
            $warehouse = isset($post['warehouse']) ? $post['warehouse'] : [];
            //价格
            $group_price = isset($post['group_price']) ? $post['group_price'] : [];

            $quantity = 0;
            $amount = 0;
            $products = [];
            foreach ($product_ids as $id) {

                if (empty($warehouse[$id]))
                    $this->error('请选择仓库');

                if (empty($product_quantity[$id]) || !preg_match("/^[1-9][0-9]*$/", $product_quantity[$id]))
                    $this->error('数量有误');

                if (!is_numeric($group_price[$id]))
                    $this->error('金额有误');

                if (!empty($id) && is_numeric($id) && ($one = db('product')->where('id', $id)->find())) {

                    // 放到哪个仓库
                    $one['warehouse'] = $warehouse[$id];
                    // 放了多少数量 
                    $one['product_quantity'] = $product_quantity[$id];
                    // 放入的金额是多少
                    $one['amount'] = $group_price[$id];

                    // 数据总计
                    $quantity += $product_quantity[$id];
                    // 金额总计
                    $amount += $product_quantity[$id] * $group_price[$id];

                    $products[] = $one;
                }
            }

            if (empty($products))
                $this->error('请选择入库产品');


            $post['quantity'] = $quantity;
            $post['amount'] = $amount;

            $message = $this->m_product_storage_order->storage_submit($post, $products);
            if ($message) {
                $this->m_operate->success($message);
                $this->error($message);
            } else {
                $this->m_operate->success('入库成功');
                $this->success('入库成功', 'storage');
            }
        }
    }

    /**
     * @title 入库撤消
     */
    public function storage_undo($id) {

        empty($id) && $this->error('参数不能为空');

        $message = $this->m_product_storage_order->storage_undo($id);
        if ($message) {
            $this->m_operate->failure('入库撤消', UID, $message);
            $this->error($message);
        } else {
            $this->m_operate->success('入库撤消');
            $this->success('入库撤消成功');
        }
    }

    /**
     * @title 入库查询
     */
    public function storage_query() {

        if (!isset($_GET['timea']))
            $_GET['timea'] = date('Y-m-d', strtotime("-30 day"));
        if (!isset($_GET['timeb']))
            $_GET['timeb'] = date('Y-m-d');

        $this->assign('warehouse', $this->m_product_warehouse->model_where()->where('pwu.u_id', UID)->column('a.id,a.name'));
        $this->assign('category', $this->m_product_category->lists_select_tree());

        $chart = request()->get('chart');
        $this->assign('chart', $chart);

        //如果export这个参数=1，则直接进行数据导出
        $export = input('get.export', 0);
        if ($export) {
            $lists = $this->m_product_storage_order->model_where()->group('a.id')->select();
            $this->m_excel->product_storage_query_export($lists);
            exit();
        }

        if (empty($chart)) {

            $count = $this->m_product_storage_order->model_where()->count('distinct a.id');
            $lists = $this->m_product_storage_order->model_where()->group('a.id')->paginate(config('base.page_size'), $count, ['query' => request()->get()]);

            foreach ($lists as $key => $val) {
                $lists2 = $this->m_product_storage_order_data->model_where()->where('a.o_id', $val['id'])->select();
                if ($lists2) {
                    $lists[$key]['child'] = $lists2;
                }
            }

            $this->assign('count', $count);
            $this->assign('lists', $lists);
            $this->assign('pages', $lists->render());
        } else {

            $count_sum = $this->m_product_storage_order_data->model_where()->sum('a.quantity');
            $this->assign('count_sum', $count_sum);


            $count = $this->m_product_storage_order_data->model_where()->count();
            $lists = $this->m_product_storage_order_data->model_where()->paginate(config('base.page_size'), $count, ['query' => request()->get()]);

            $this->assign('count', $count);
            $this->assign('lists', $lists);
            $this->assign('pages', $lists->render());
        }


        return view();
    }

    /**
     * @title 出库
     * 
     */
    public function sales() {



        if (request()->isPost()) {


            $post = request()->post();

            if ($member_id = request()->post('member_id')) {

                $member = db('member')->alias('a')->join('member_group c', 'a.g_id=c.id', 'LEFT')
                        ->where('a.id', $member_id)
                        ->find();

                $this->assign('member', $member);
            }



            $product_ids = isset($post['product_ids']) ? $post['product_ids'] : [];
            $product_ids[] = input('post.product_id', 0);

            $products = [];
            foreach ($product_ids as $id) {

                if (!empty($id) && is_numeric($id) && $var = db('product')->where('id', $id)->find()) {

                    // 库存大于0的仓库属于自己的找出来
                    $var['warehouse'] = db('product_inventory a')
                            ->join('product_warehouse pw', 'pw.id=a.w_id', 'LEFT')
                            ->join('product_warehouse_user pws', 'pws.w_id=a.w_id', 'LEFT')
                            ->where('pws.u_id', UID)
                            ->where('a.p_id', $id)
                            ->where('a.quantity', '>', 0)
                            ->field('a.w_id as id,pw.name,a.quantity,pw.default')
                            ->select();

                    //如果存在这个值的话，把会员所相关联的分级价格(group_price)找出来 
                    if (is_numeric($member_id) && !empty($member_id)) {
                        $group_price = db('member_price')->where('p_id', $id)->where('g_id', $member['g_id'])->find();
                        if ($group_price)
                            $var['group_price'] = $group_price['price'];
                    }

                    $products[$id] = $var;
                }
            }


            if (!empty($products))
                $this->assign('products', $products);
        }


        $this->assign('express', db('express')->order('sort')->select());

        return view();
    }

    /**
     * @title 出库提交
     *     
     */
    public function sales_submit() {

        if (request()->isPost()) {
            $post = request()->post();

            // 产品
            $product_ids = isset($post['product_ids']) ? $post['product_ids'] : [];
            $product_ids = array_filter($product_ids);
            // 数量 
            $product_quantity = isset($post['product_quantity']) ? $post['product_quantity'] : [];
            // 仓库
            $product_warehouse = isset($post['product_warehouse']) ? $post['product_warehouse'] : [];
            // 价格
            $group_price = isset($post['group_price']) ? $post['group_price'] : [];


            $amount = 0; // 销售价合计
            $cost = 0; // 成本价合计
            $products = [];
            foreach ($product_ids as $id) {

                if (!is_numeric($group_price[$id]) && $group_price[$id] > 0)
                    $this->error('价格有误');

                if (empty($product_quantity[$id]) || !preg_match("/^[1-9][0-9]*$/", $product_quantity[$id]))
                    $this->error('数量有误');

                if (!empty($id) && is_numeric($id) && ($var = db('product')->where('id', $id)->find())) {

                    //上面的三个参数都检查过了，仓库有没有库存也要检查一下。
                    if (!$this->m_product_inventory->check_product_sales($var['id'], $product_warehouse[$id], $product_quantity[$id]))
                        $this->error('产品：【' . $var['name'] . '】当前库存不足，不能出库，请更换仓库');

                    $var['product_quantity'] = $product_quantity[$id];
                    $var['product_warehouse'] = $product_warehouse[$id];
                    $var['group_price'] = $group_price[$id];

                    // 销售总价
                    $amount += sprintf("%.2f", ($var['group_price'] * $var['product_quantity']));

                    // 成本总价
                    $cost += sprintf("%.2f", ($var['purchase'] * $var['product_quantity']));

                    $products[$id] = $var;
                }
            }
            if (empty($products))
                $this->error('至少提供一个产品');

            $post['amount'] = $amount;
            $post['cost'] = $cost;
            $message = $this->m_product_sales_order->sales_submit($post, $products);

            if ($message) {
                $this->m_operate->failure('产品销售', UID, $message);
                $this->error($message);
            } else {
                $this->m_operate->success('销售产品');
                $this->success('出库成功');
            }
        }
    }

    /**
     * @title 出库查询
     */
    public function sales_query() {

        if (!isset($_GET['timea']))
            $_GET['timea'] = date('Y-m-d', strtotime("-30 day"));
        if (!isset($_GET['timeb']))
            $_GET['timeb'] = date('Y-m-d');

        $this->assign('warehouse', $this->m_product_warehouse->model_where()->where('pwu.u_id', UID)->column('a.id,a.name'));
        $this->assign('category', $this->m_product_category->lists_select_tree());


        $chart = request()->get('chart');
        $this->assign('chart', $chart);


        //如果export这个参数=1，则直接进行数据导出
        $export = input('get.export', 0);
        if ($export) {
            $lists = $this->m_product_sales_order->model_where()->group('a.id')->select();
            $this->m_excel->product_sales_query_export($lists);
            exit();
        }

        if (empty($chart)) {

            $count = $this->m_product_sales_order->model_where()->count('distinct a.id');
            $lists = $this->m_product_sales_order->model_where()->group('a.id')->paginate(config('base.page_size'), $count, ['query' => request()->get()]);


            foreach ($lists as $key => $val) {
                $lists[$key]['child'] = $this->m_product_sales_order_data->get_order_data_lists($val['id']);
            }

            $this->assign('count', $count);
            $this->assign('lists', $lists);
            $this->assign('pages', $lists->render());
        } else {


            $this->assign('count_sum', $count_sum = $this->m_product_sales_order_data->model_where()->sum('a.quantity'));

            $this->assign('count', $count = $this->m_product_sales_order_data->model_where()->count());
            $this->assign('lists', $lists = $this->m_product_sales_order_data->model_where()->paginate(config('base.page_size'), $count, ['query' => request()->get()]));
            $this->assign('pages', $lists->render());
        }


        return view();
    }

    /**
     * @title 产品出库撤消
     */
    public function sales_undo($id) {

        empty($id) && $this->error('参数不能为空');

        $message = $this->m_product_sales_order->sales_undo($id);

        if ($message) {
            $this->m_operate->failure('出库撤消', UID, $message);
            $this->error($message);
        } else {
            $this->m_operate->success('出库撤消成功');
            $this->success('出库撤消成功');
        }
    }

    /**
     * @title 退货查询
     */
    public function sales_returns_query() {


        if (!isset($_GET['timea']))
            $_GET['timea'] = date('Y-m-d', strtotime("-30 day"));
        if (!isset($_GET['timeb']))
            $_GET['timeb'] = date('Y-m-d');


        $count = $this->m_product_sales_return->model_where()->group('a.id')->count();
        $lists = $this->m_product_sales_return->model_where()->group('a.id')->paginate(config('base.page_size'), $count, ['query' => request()->get()]);

        $this->assign('count', $count);
        $this->assign('lists', $lists);
        $this->assign('pages', $lists->render());


        return view();
    }

    /**
     * @title 出库退货提交
     */
    public function sales_returns_add($id) {

        empty($id) && $this->error('参数不能为空');

        if (request()->isPost()) {

            $post = request()->post();


            if (empty($post['warehouse']))
                $this->error('请选择仓库');
            if (empty($post['quantity']) || !is_numeric($post['quantity']))
                $this->error('请确定退货数量');


            $one = $this->m_product_sales_order_data->get_order_data($id);


            $quantity = $one['quantity'] - $one['returns'];

            if ($one['returns'] >= $one['quantity'])
                $this->error('该产品已经完全退货');


            if (empty($one['quantity']) || $quantity < $post['quantity'])
                $this->error('退货数量不能大与' . $quantity);


            $message = $this->m_product_sales_order_data->sales_returns_add($post, $one);
            $message ? $this->error($message) : $this->success('');
        }


        $this->assign('one', $one = $this->m_product_sales_order_data->get_order_data($id));

        $this->assign('warehouse', $this->m_product_warehouse->model_where()->where('pwu.u_id', UID)->select());

        return view();
    }

    /**
     * @title 产品出库查询
     */
    public function sales_look($id) {

        empty($id) && $this->error('参数不能为空');

        $one = $this->m_product_sales_order->model_where()->where('a.id', $id)->group('a.id')->find();
        $this->assign('one', $one);

        if (empty($one['id']))
            return $this->m_common->failure('查询到产品出库记录不存在');


        $this->assign('orders', $this->m_product_sales_order_data->get_order_data_lists($id));


        // 快递公司下拉
        $this->assign('express_lists', db('express')->order('sort')->select());

        return view();
    }

    /**
     * @title 补充快递信息
     */
    public function sales_look_info_update($id) {

        empty($id) && $this->error('参数不能为空');

        $post = request()->post();

        $affect_rows = $this->m_product_sales_order->where('id', $id)->update($post);

        $affect_rows ? $this->success('更新成功') : $this->error('无更新');
    }

    /**
     * @title 库存记录删除
     * 
     */
    public function stock_delete($id) {

        empty($id) && $this->error('参数不能为空');

        $quantity = db('product_inventory')->where('id', $id)->value('quantity');
        if ($quantity) {
            $this->error('还有库存，没法删');
        }

        $affect_rows = db('product_inventory')->where('id', $id)->delete();

        if ($affect_rows) {
            $this->success('');
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * @title 库存查询
     */
    public function stock_query() {

        $this->assign('warehouse', $this->m_product_warehouse->model_where()->where('pwu.u_id', UID)->column('a.id,a.name'));
        $this->assign('category', $this->m_product_category->lists_select_tree());        
        
        //如果export这个参数=1，则直接进行数据导出
        $export = input('get.export', 0);
        if ($export) {
            $lists = $this->m_product_inventory->model_where()->group('a.id')->select();
            $this->m_excel->product_stock_query_export($lists);
            exit();
        }

        $this->assign('count', $count = $this->m_product_inventory->model_where()->count('distinct a.id'));
        $this->assign('lists', $lists = $this->m_product_inventory->model_where()->group('a.id')->paginate(config('base.page_size'), $count, ['query' => request()->get()]));
        $this->assign('pages', $lists->render());

        return view();
    }

    /**
     * @title 库存调拨窗口
     */
    public function transfer_add($id) {

        empty($id) && $this->error('参数不能为空');


        if (request()->isPost()) {

            $post = request()->post();




            if (empty($post['warehouse']) || !is_numeric($post['warehouse']))
                $this->error('请选择拨出仓库');
            if (empty($post['number']) || !is_numeric($post['number']))
                $this->error('请输入拨出数目');


            // 当前库存表
            $one = $this->m_product_inventory->where('id', $id)->find();
            if (empty($one) || $one['quantity'] < $post['number']) {
                $this->error('没这么多货');
            }


            $message = $this->m_product_warehouse_transfer->transfer_add($post, $one);
            if ($message) {
                $this->m_operate->failure('库存调拨');
                $this->error($message);
            } else {
                $this->m_operate->success('库存调拨');
                $this->success('库存调拨');
            }
        } else {


            $this->assign('lists', $this->m_product_inventory->model_where()->where('a.id', $id)->find());
            $this->assign('warehouse', $this->m_product_warehouse->model_where()->where('pwu.u_id', UID)->select());


            return view();
        }
    }

    /**
     * @title 调拨查询
     */
    public function transfer_query() {


        if (!isset($_GET['timea']))
            $_GET['timea'] = date('Y-m-d', strtotime("-30 day"));
        if (!isset($_GET['timeb']))
            $_GET['timeb'] = date('Y-m-d');

        $this->assign('warehouse', $this->m_product_warehouse->model_where()->where('pwu.u_id', UID)->column('a.id,a.name'));
        $this->assign('category', $this->m_product_category->lists_select_tree());


        $count = $this->m_product_warehouse_transfer->model_where()->count('distinct a.id');
        $lists = $this->m_product_warehouse_transfer->model_where()->group('a.id')->paginate(config('base.page_size'), $count, ['query' => request()->get()]);

        $this->assign('count', $count);
        $this->assign('lists', $lists);
        $this->assign('pages', $lists->render());


        return view();
    }

    /**
     * @title 报废窗口
     */
    public function scrapped_add($id) {


        empty($id) && $this->error('参数不能为空');


        if (request()->isPost()) {

            $post = request()->post();


            $one = $this->m_product_inventory->where('id', $id)->find();

            if (empty($one))
                $this->error('产品不存在');

            if (!isset($post['quantity']) || !is_numeric($post['quantity']) || $one['quantity'] < $post['quantity']) {
                $this->error('没那么货报废');
            }


            $message = $this->m_product_scrapped->scrapped_add($post, $one);
            if ($message) {
                $this->m_operate->failure('报废产品');
                $this->error($message);
            } else {
                $this->m_operate->success('报废产品');
                $this->success('报废成功', 'stock_query');
            }
        } else {
            $this->assign('var', $this->m_product_inventory->model_where()->where('a.id', $id)->find());
            return view();
        }
    }

    /**
     * @title 报废查询
     */
    public function scrapped_query() {


        if (!isset($_GET['timea']))
            $_GET['timea'] = date('Y-m-d', strtotime("-30 day"));
        if (!isset($_GET['timeb']))
            $_GET['timeb'] = date('Y-m-d');

        $this->assign('warehouse', $this->m_product_warehouse->model_where()->where('pwu.u_id', UID)->column('a.id,a.name'));
        $this->assign('category', $this->m_product_category->lists_select_tree());

        $count = $this->m_product_scrapped->model_where()->count('distinct a.id');
        $lists = $this->m_product_scrapped->model_where()->group('a.id')->paginate(config('base.page_size'), $count, ['query' => request()->get()]);

        $this->assign('count', $count);
        $this->assign('lists', $lists);
        $this->assign('pages', $lists->render());


        return view();
    }

}
