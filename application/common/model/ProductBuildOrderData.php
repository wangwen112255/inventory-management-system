<?php

namespace app\common\model;

use app\common\model\Base;

class ProductBuildOrderData extends Base {
    
    public function model_where(){
        
        $this->join('product p', 'p.id=a.p_id_bc');
        $this->join('product_warehouse pw', 'pw.id=a.w_id');
        
        $this->field('a.*,'
                . 'p.name as product_title,'
                . 'pw.name as warehouse_title');
        
        $this->alias('a');        
        return $this;
    }
    
}