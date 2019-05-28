<?php

namespace app\common\model;

use app\common\model\Base;
use const UID;
use function config_value;
use function request;

class ProductStorageOrderData extends Base {

    public function getTypeAttr($value) {
        return config_value('_dict_product_type', $value);
    }

    public function model_where() {
        
        if (request()->get('timea'))
            $this->where('a.create_time', '>=', strtotime(request()->get('timea') . ' 00:00:00'));
        if (request()->get('timeb'))
            $this->where('a.create_time', '<=', strtotime(request()->get('timeb') . ' 23:59:59'));

        $this->where('pwu.u_id', UID);

       
        if (request()->get('type'))
            $this->where('p.type', request()->get('type'));
        if (request()->get('warehouse'))
            $this->where('a.w_id', request()->get('warehouse'));       
        if (request()->get('supplier'))
            $this->where('a.s_id', request()->get('supplier'));
        if (request()->get('c_id'))
            $this->where('p.c_id', request()->get('c_id'));
        
        if (request()->get('keyword'))
            $this->where('p.code|p.name', 'like', '%' . request()->get('keyword') . '%');

        $this->join('product p', 'a.p_id=p.id', 'LEFT');
        $this->join('product_unit pu', 'pu.id=p.unit', 'LEFT');
        $this->join('product_warehouse pw', 'pw.id=a.w_id', 'LEFT');
        $this->join('product_warehouse_user pwu', 'a.w_id=pwu.w_id', 'LEFT');
        $this->join('product_supplier ps', 'a.s_id=ps.id', 'LEFT');
        $this->join('product_category pc', 'p.c_id=pc.id', 'LEFT');
        $this->join('product_inventory pi', 'a.p_id=pi.p_id and a.w_id=pi.w_id', 'LEFT');
        $this->join('system_user b', 'p.u_id=b.id', 'LEFT');
        $this->join('system_user c', 'p.update_uid=c.id', 'LEFT');
        $this->join('system_user e', 'a.u_id=e.id', 'LEFT');
        $this->order('a.id desc');


        $this->field('a.*,'
                . 'pi.quantity as inventory_quantity,'
                . 'pc.name as category,'
                . 'pw.name as warehouse,'
                . 'ps.id as com_id,ps.company,'
                . 'pu.name as unit_name,'
                . 'p.name,p.code,p.purchase,'
                . 'b.nickname,'
                . 'c.nickname as replace_nickname,'
                . 'e.nickname as storage_nickname');

        $this->alias('a');

        return $this;
    }

}
