<?php

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class ProductSalesOrderData extends Base {

    public function getShipTimeAttr($value) {
        return date('Y-m-d H:i', $value);
    }

    public function getStatusTextAttr($value, $data) {
        $status = [-1 => '<span class="label label-warning">有退货</span>', 1 => '<span class="label label-success">已完成</span>', -2 => '<span class="label label-important">已退货</span>'];
        return $status[$data['status']];
    }

    public function sales_returns_add($post, $one) {
        $id = $one['id'];
        Db::startTrans();
        try {
            $inventory_flag = model('product_inventory')->increase((int) $one['product_data']['id'], (int) $post['warehouse'], (int) $post['quantity']);
            if (!$inventory_flag)
                throw new Exception('库存更新失败');
            db('product_sales_order_data')->where('id', $id)->setInc('returns', $post['quantity']);
            db('product_sales_return')->insert([
                'u_id' => UID,
                'create_time' => time(),
                'o_id' => $id,
                'quantity' => $post['quantity'],
                'w_id' => $post['warehouse'],
                'remark' => $post['remark'],
            ]);
            db('product_sales_order')->where('id', $one['o_id'])->setField(['status' => -1]);
            db('product_sales_order_data')->where('id', $id)->setField(['status' => -1]);
            $one2 = db('product_sales_order_data')->where('id', $id)->find();
            if ($one2['returns'] >= $one2['quantity']) {
                db('product_sales_order_data')->where('id', $id)->setField(['status' => -2]);
            }
            if (!db('product_sales_order_data')->where('o_id', $one['o_id'])->where('status', '>=', -1)->find()) {
                db('product_sales_order')->where('id', $one['o_id'])->setField(['status' => -2]);
            }
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    public function get_order_data($id) {
        $one = $this->alias('psod')
                ->field('psod.*,pso.m_id')
                ->join('product_sales_order pso', 'psod.o_id=pso.id', 'LEFT')
                ->where('psod.id', $id)
                ->find();
        if (empty($one['product_data']))
            return FALSE;
        $one['product_data'] = unserialize($one['product_data']);
        return $one;
    }

    public function get_order_data_lists($id) {
        $lists = $this->alias('psod')
                ->join('product_warehouse pw', 'pw.id=psod.w_id', 'LEFT')
                ->where('psod.o_id', $id)
                ->field('psod.*,pw.name as warehouse')
                ->select();
        return $lists;
    }

    public function model_where() {
        if (request()->get('timea'))
            $this->where('pso.create_time', '>=', strtotime(request()->get('timea') . ' 00:00:00'));
        if (request()->get('timeb'))
            $this->where('pso.create_time', '<=', strtotime(request()->get('timeb') . ' 23:59:59'));


        $this->where('pwu.u_id', UID);



        if (request()->get('keyword'))
            $this->where('pso.order_number|p.code|p.name', '=', request()->get('keyword'));

        if (request()->get('nickname'))
            $this->where('m.nickname', 'like', '%' . request()->get('nickname') . '%');

        if (request()->get('tel'))
            $this->where('m.tel', 'like', '%' . request()->get('tel') . '%');

        if (request()->get('warehouse'))
            $this->where('a.w_id', request()->get('warehouse'));

        if (request()->get('c_id'))
            $this->where('p.c_id', request()->get('c_id'));

        if (request()->get('type'))
            $this->where('p.type', request()->get('type'));

        if (request()->get('status'))
            $this->where('a.status', request()->get('status'));
        
        
        if(request()->get('sales_type'))
            $this->where('pso.type', request()->get('sales_type'));



        $this->join('product_sales_order pso', 'a.o_id=pso.id', 'LEFT');
        $this->join('member m', 'm.id=pso.m_id', 'LEFT');
        $this->join('system_user s', 'pso.u_id=s.id', 'LEFT');
        $this->join('product p', 'a.p_id=p.id', 'LEFT');
        $this->join('product_warehouse_user pwu', 'a.w_id=pwu.w_id', 'LEFT');
        $this->join('product_warehouse pw', 'pw.id=a.w_id', 'LEFT');


        $this->field('a.*,'
                . 'pso.create_time,pso.ship_time,'
                . 'pw.name as warehouse,'
                . 'm.nickname,'
                . 's.nickname as staff_nickname');

        $this->order('pso.id desc');
        $this->alias('a');
        return $this;
    }

}
