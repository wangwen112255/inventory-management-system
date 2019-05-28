<?php

namespace app\common\model;

use app\common\model\Base;
use Exception;
use think\Db;

class ProductScrapped extends Base {
    
    public function getTypeAttr($value) {
        return config_value('_dict_product_type', $value);
    }

    public function scrapped_add($post, $product_inventory) {

        Db::startTrans();
        try {


            $post['u_id'] = UID;
            $post['p_id'] = $product_inventory['p_id'];
            $post['w_id'] = $product_inventory['w_id'];
            $post['quantity'] = (int) $post['quantity'];
            $post['remark'] = $post['remark'];
            $post['create_time'] = time();

            db('product_scrapped')->insert($post);

            model('product_inventory')->reduce($post['p_id'], $post['w_id'], $post['quantity']);



            // 提交事务
            Db::commit();
        } catch (Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    public function model_where() {
        
         $this->where('pwu.u_id', UID);

        if (request()->get('timea'))
            $this->where('a.create_time', '>=', strtotime(request()->get('timea') . ' 00:00:00'));
        if (request()->get('timeb'))
            $this->where('a.create_time', '<=', strtotime(request()->get('timeb') . ' 23:59:59'));
        
        if (request()->get('keyword'))
            $this->where('p.code|p.name', 'like', '%' . request()->get('keyword') . '%');
        
        
        
        if (request()->get('type'))
            $this->where('p.type', request()->get('type'));
        if (request()->get('warehouse'))
            $this->where('a.w_id', request()->get('warehouse'));
        if (request()->get('c_id'))
            $this->where('p.c_id', request()->get('c_id'));       

        $this->join('product_warehouse_user pwu', 'a.w_id=pwu.w_id', 'LEFT');
        $this->join('product_warehouse pw', 'pw.id=a.w_id', 'LEFT');
        $this->join('product p', 'a.p_id=p.id', 'LEFT');
        $this->join('product_category pc', 'p.c_id=pc.id', 'LEFT');
        $this->join('system_user s', 'a.u_id=s.id', 'LEFT');

        $this->field('a.*,'
                . 's.nickname,'
                . 'p.name,p.code,p.type,p.id as product_id,'
                . 'pw.name as warehouse,'
                . 'pc.name as category');

        $this->order('a.id desc');
        $this->alias('a');
        return $this;
    }

}
