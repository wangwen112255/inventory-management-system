<?php

namespace app\common\model;

use think\Model;
use app\common\model\Base;

class ProductSalesReturn extends Base {

    public function model_where() {

        if (request()->get('timea'))
            $this->where('a.create_time', '>=', strtotime(request()->get('timea') . ' 00:00:00'));
        if (request()->get('timeb'))
            $this->where('a.create_time', '<=', strtotime(request()->get('timeb') . ' 23:59:59'));

        $this->where('ws.u_id|ws2.u_id', '=', UID);


        if (request()->get('keyword'))
            $this->where('p.code|p.name', 'like', '%' . request()->get('keyword') . '%');
        if (request()->get('order_number'))
            $this->where('c.order_number', 'like', '%' . request()->get('order_number') . '%');


        $this->join('product_sales_order_data b', 'a.o_id=b.id', 'LEFT');
        $this->join('product_sales_order c', 'b.o_id=c.id', 'LEFT');
        $this->join('member m', 'm.id=c.m_id', 'LEFT');
        $this->join('product_warehouse_user ws', 'b.w_id=ws.w_id', 'LEFT');
        $this->join('product_warehouse_user ws2', 'a.w_id=ws2.w_id', 'LEFT');
        $this->join('product_warehouse pw', 'pw.id=a.w_id', 'LEFT');
        $this->join('product_warehouse pw2', 'pw2.id=b.w_id', 'LEFT');
        $this->join('product p', 'b.p_id=p.id', 'LEFT');
        $this->join('system_user s', 'a.u_id=s.id', 'LEFT');

        $this->field('a.*,'
                . 'c.id as order_id,'
                . 'pw.name,'
                . 'pw2.name as name2,'
                . 's.nickname,'
                . 'm.nickname as member_nickname,'
                . 'b.product_data');

        $this->order('a.id desc');
        $this->alias('a');
        return $this;
    }

}
