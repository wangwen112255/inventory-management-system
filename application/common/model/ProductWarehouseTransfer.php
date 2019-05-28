<?php

namespace app\common\model;

use Exception;
use think\Db;

class ProductWarehouseTransfer extends Base {
    
    
    public function getTypeAttr($value) {
        return config_value('_dict_product_type', $value);
    }

    public function transfer_add($post, $product_inventory) {


        Db::startTrans();
        try {




            $data['u_id'] = UID;
            $data['jin_id'] = (int) $post['warehouse'];
            $data['out_id'] = (int) $product_inventory['w_id'];
            $data['number'] = (int) $post['number'];
            $data['p_id'] = (int) $product_inventory['p_id'];
            $data['remark'] = $post['remark'];
            $data['create_time'] = time();

            db('product_warehouse_transfer')->insert($data);


            // 一加一减
            model('product_inventory')->increase($product_inventory['p_id'], $post['warehouse'], $post['number']);
            // 一加一减
            model('product_inventory')->reduce($product_inventory['p_id'], $product_inventory['w_id'], $post['number']);



            // 提交事务
            Db::commit();
        } catch (Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    public function model_where() {
        
        if (request()->get('timea'))
            $this->where('a.create_time', '>=', strtotime(request()->get('timea') . ' 00:00:00'));
        if (request()->get('timeb'))
            $this->where('a.create_time', '<=', strtotime(request()->get('timeb') . ' 23:59:59'));
        
        $this->where('a.u_id|pwu1.u_id|pwu2.u_id', '=', UID);
        
        
        if (request()->get('keyword'))
            $this->where('p.code|p.name', 'like', '%' . request()->get('keyword') . '%');
        
        if (request()->get('lowesta'))
            $this->where('a.number', '>=', request()->get('lowesta'));
        if (request()->get('lowestb'))
            $this->where('a.number', '<=', request()->get('lowestb'));
        
        
        if (request()->get('jin_id'))
            $this->where('a.jin_id', request()->get('jin_id'));
        if (request()->get('out_id'))
            $this->where('a.out_id', request()->get('out_id'));
        
        if (request()->get('c_id'))
            $this->where('pc.id', request()->get('c_id'));
        
        if (request()->get('type'))
            $this->where('p.type', request()->get('type'));
        
        

        
        $this->join('product_warehouse_user pwu1', 'pwu1.w_id=a.jin_id', 'LEFT');
        $this->join('product_warehouse_user pwu2', 'pwu2.w_id=a.out_id', 'LEFT');
        $this->join('product_warehouse w', 'w.id=a.jin_id', 'LEFT');
        $this->join('product_warehouse w2', 'w2.id=a.out_id', 'LEFT');
        $this->join('product p', 'p.id=a.p_id', 'LEFT');
        $this->join('product_category pc', 'pc.id=p.c_id', 'LEFT');
        $this->join('system_user su', 'a.u_id = su.id', 'LEFT');

        $this->field('a.*,'
                . 'p.code,p.name,p.format,p.type,' 
                . 'pc.name as category,'
                . 'su.nickname,'
                . 'w.name as jin_title,'
                . 'w2.name as out_title'
        );

        $this->order('a.id desc');
        $this->alias('a');
        return $this;
    }

}
