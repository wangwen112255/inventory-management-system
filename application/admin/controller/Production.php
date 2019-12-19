<?php

namespace app\admin\controller;

use app\admin\controller\Admin;


/**
 * @title 生产
 */
class Production extends Admin {

    /**
     * @title 生产撤销
     */
    public function product_build_undo($id) {

        empty($id) && $this->error('参数不能为空');


        // 从order_data表中把数据依次删除
        $message = model('product_build_order')->product_build_undo($id);

        if ($message) {
            model('operate')->failure('生产撤消', UID, $message);
            $this->error($message);
        } else {
            model('operate')->success('生产撤消成功');
            $this->success('生产撤消成功');
        }
    }

    /**
     * @title 加工记录
     */
    public function product_build_query() {


        if (!isset($_GET['timea']))
            $_GET['timea'] = date('Y-m-d', strtotime("-30 day"));
        if (!isset($_GET['timeb']))
            $_GET['timeb'] = date('Y-m-d');


        $count = model('product_build_order')->model_where()->count('distinct a.id');
        $lists = model('product_build_order')->model_where()->group('a.id')->paginate(config('base.page_size'), $count, ['query' => request()->get()]);


        //添加子
        foreach ($lists as $key => $val) {

            $lists2 = model('product_build_order_data')->model_where()->group('a.id')->where('a.o_id', $val['id'])->select();


            if ($lists) {
                $lists[$key]['child'] = $lists2;
            }
        }



        $this->assign('count', $count);
        $this->assign('lists', $lists);
        $this->assign('pages', $lists->render());

        return view();
    }

    /**
     * @title 产品加工提交   
     */
    public function product_build_submit() {

        if (request()->isPost()) {

            $post = request()->post();

            $product_ids = isset($post['product_ids']) ? $post['product_ids'] : [];   //包材ID
            $product_warehouse = isset($post['product_warehouse']) ? $post['product_warehouse'] : []; //包材所在的仓库 


            $product_ids = array_filter($product_ids);


            // 产品有效性验证
            foreach ($product_ids as $id) {

                if (is_numeric($id) && $var = db('product')->where('id', $id)->find()) {
                    // $var['warehouse'] = model('product_inventory')->model_where()->where('a.id', $value)->where('quantity', '>', 0)->select();
                    $products[$id] = $var;
                }
            }
            if (empty($products))
                $this->error('没选择包材？');


            if (empty($post['quantity']) || !is_numeric($post['quantity'])) {
                $this->error('请输入一个有效的生产数量');
            }


            // 库存数量验证
            foreach ($products as $key => $value) {


                $products[$key]['product_warehouse'] = $product_warehouse[$key];



                // 最终所需要的包材数量 
                $multiple = db('product_relation')->where('p_id', $post['product_id'])->where('p_id_bc', $value['id'])->value('multiple');

                $final_quantity = intval($post['quantity']) * $multiple;

                // 每个包材所需要的数量 
                $products[$key]['final_quantity'] = $final_quantity;



                if (!model('product_inventory')->check_product_sales($value['id'], $product_warehouse[$key], $final_quantity))
                    $this->error('包材：【' . $value['name'] . '】当前库存不足，不能出库，请更换仓库');
                //                
            }


            $message = model('product_build_order')->product_build_submit($post, $products);

            if ($message) {
                model('operate')->success($message);
                $this->error($message);
            } else {
                model('operate')->success('生产成功');
                $this->success('生产成功', 'product_build');
            }
        }
    }

    /**
     * @title 产品加工
     */
    public function product_build() {

        $products = [];


        if (request()->isPost()) {

            $post = request()->post();

            $product_id = isset($post['product_id']) ? $post['product_id'] : 0;


            if ($product_id && is_numeric($product_id)) {


                $lists = db('product_relation')
                        ->join('product p', 'p.id=pr.p_id_bc', 'LEFT')
                        ->where('pr.p_id', $product_id)
                        ->field('pr.multiple,pr.p_id_bc,p.id,p.name,p.code')
                        ->alias('pr')
                        ->select();


                $products = [];

                foreach ($lists as $key => $value) {

                    // 把所有包材及在各个仓库的数量 都找出来   
                    $warehouse_lists = db('product_inventory')
                            ->join('product_warehouse pw', 'pw.id=pi.w_id')
                            ->alias('pi')
                            ->where('pi.p_id', $value['p_id_bc'])
                            ->field('pi.w_id as id, pw.name, pi.quantity, pw.default')
                            ->select();


                    $products[$value['p_id_bc']] = $value;
                    $products[$value['p_id_bc']]['warehouse'] = $warehouse_lists;
                }
            }
        }


        // 加载仓库
        $this->assign('product_warehouse', model('product_warehouse')->model_where()->where('pwu.u_id', UID)->column('a.name', 'a.id'));

        $this->assign('products', $products);

        return view();
    }

    /**
     * @title 产品关系
     */
    public function product_relation() {


        $keyword = input('get.keyword', '');

        $lists = db('product')
                        ->where('name', 'like', '%' . $keyword . '%')
                        ->where('type', 1)->order('id desc')->select();

        foreach ($lists as $key => $value) {
            $lists[$key]['bc_count'] = db('product_relation')->where('p_id', $value['id'])->count();
        }

        $this->assign('lists', $lists);


        return view();
    }

    /**
     * @title 产品关系编辑
     */
    public function product_relation_edit($id) {


        $products = db('product_relation')->alias('a')
                ->join('product b', 'b.id=a.p_id_bc')
                ->where('a.p_id', $id)
                ->field('a.p_id_bc as id,b.name,b.code,a.multiple as multiple')
                ->select();


        if (request()->isPost()) {

            $post = request()->post();

            $product_ids = isset($post['product_ids']) ? $post['product_ids'] : [];


            $products = [];
            foreach ($product_ids as $value) {

                if (!empty($value) && is_numeric($value)) {

                    $one = db('product')->where('id', $value)->field('id,name,code')->find();
                    $one['multiple'] = 1;

                    $products[$value] = $one;
                }
            }
        }


        $this->assign('products', $products);



        return view();
    }

    /**
     * @title 产品关联提交
     */
    public function product_relation_edit_submit($id) {

        empty($id) && $this->error('参数不能为空');

        if (request()->isPost()) {

            $post = request()->post();

            $message = model('product_relation')->product_relation_edit_submit($post, $id);
            if ($message) {
                model('operate')->failure('产品关联提交');
                $this->error($message);
            } else {
                model('operate')->success('产品关联提交');
                $this->success('', url('product_relation'));
            }
        }
    }

}
