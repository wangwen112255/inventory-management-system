<?php

namespace app\common\model;

use think\Model;
use app\common\model\Base;

class ProductReturnSupplier extends Base {

    public function getTypeAttr($value) {
        $status = [1 => '正常', 2 => '赠品'];
        return $status[$value];
    }

   
    public function add_submit($id, $post) {
        $data = 0;
        $post['u_id'] = UID;
        $post['w_id'] = $id;
        $lists = $this->m_product_storage_order_data->model_where()->group('a.id')->where('a.id', $id)->find();
        
        $inventory = $this->m_product_inventory
                ->where('p_id', $lists['id'])
                ->where('w_id', $lists['wid'])
                ->find();
        
        if (empty($lists) || empty($inventory))
            return '退回传递参数不正确';
        $returns = $lists['number'] - $lists['returns'];
        if ($returns > 0) {
            if ($inventory['quantity'] <= $returns) {
                $returns = $inventory['quantity'];
            }
        } else {
            $returns = 0;
        }
        if (empty($returns) || $returns < $post['quantity'])
            return '仓库库存不足 无法退回';
        if ($this->save($post)) {
            $this->m_product_storage_order_data->where('id', $id)->setInc('returns', $post['quantity']);
            $this->m_product_inventory->reduce($lists['id'], $lists['wid'], (int) $post['quantity']);
            $this->m_operate->success('退回产品');
            return 0;
        } else {
            $this->m_operate->failure('退回产品');
            return '删除失败';
        }
  
    }

    public function model_where() {
        if (request()->get('timea'))
            $this->where('a.create_time', '>=', strtotime(request()->get('timea') . ' 00:00:00'));
        if (request()->get('timeb'))
            $this->where('a.create_time', '<=', strtotime(request()->get('timeb') . ' 23:59:59'));
        $this->where('pwu.u_id', UID);
        if (request()->get('type'))
            $this->where('p.type', request()->get('type'));
        if (request()->get('c_id'))
            $this->where('p.c_id', request()->get('c_id'));
        if (request()->get('supplier'))
            $this->where('psod.s_id', request()->get('supplier'));
        if (request()->get('warehouse'))
            $this->where('psod.w_id', request()->get('warehouse'));
        if (request()->get('staff_uid'))
            $this->where('a.u_id', request()->get('staff_uid'));
        if (request()->get('keyword'))
            $this->where('p.code|p.name', 'like', '%' . request()->get('keyword') . '%');

        $this->join('system_user su', 'a.u_id=su.id', 'LEFT');
        $this->join('product_storage_order_data psod', 'a.w_id=psod.id', 'LEFT');
        $this->join('product_warehouse pw', 'pw.id=psod.w_id', 'LEFT');
        $this->join('product p', 'psod.p_id=p.id', 'LEFT');
        $this->join('product_category pc', 'p.c_id=pc.id', 'LEFT');
        $this->join('product_supplier psu', 'psod.s_id=psu.id', 'LEFT');
        $this->join('product_warehouse_user pwu', 'psod.w_id=pwu.w_id', 'LEFT');
        
        $this->field('a.*,'
                . 'pw.name,'
                . 'su.nickname,'
                . 'p.code,p.name,p.type,'
                . 'pc.name as category,'
                . 'psu.company');
        
        $this->order('a.id desc');
        $this->alias('a');
        return $this;
    }

   
}
