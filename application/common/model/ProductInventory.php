<?php

namespace app\common\model;

use think\Model;
use app\common\model\Base;

class ProductInventory extends Base {

    public function getTypeAttr($value) {
        return config_value('_dict_product_type', $value);
    }

    /**
     * 增加库存
     * @param int $product 产品
     * @param int $warehouse 仓库
     * @param int $quantity 数量
     */
    public function increase($product, $warehouse, $quantity) {

        $where['p_id'] = $product;
        $where['w_id'] = $warehouse;

        if ($this->where($where)->find()) {
            return $this->where($where)->inc('quantity', $quantity)->update();
        } else {
            return $this->data(['p_id' => $product, 'w_id' => $warehouse, 'quantity' => $quantity])->isUpdate(false)->save();
        }
    }

    /**
     * 减少库存
     * @param int $product 产品
     * @param int $warehouse 仓库
     * @param int $quantity 数量
     */
    public function reduce($product, $warehouse, $quantity) {

        $where['p_id'] = $product;
        $where['w_id'] = $warehouse;

        if ($this->where($where)->find()) {
            return $this->where($where)->dec('quantity', $quantity)->update();
        } else {
            return false;
        }
    }

    /**
     * 新增库存
     * @param int $product 产品
     * @param int $warehouse 仓库
     * @param int $quantity 数量
     */
    public function add($product, $warehouse, $quantity) {
        $data['p_id'] = $product;
        $data['w_id'] = $warehouse;
        $data['quantity'] = $quantity;
        return $this->insert($data);
    }

    public function model_where() {

        $this->where('pwu.u_id', UID);
        
        if (request()->get('keyword'))
            $this->where('p.code|p.name', 'like', '%' . request()->get('keyword') . '%');

        if (request()->get('warehouse'))
            $this->where('a.w_id', request()->get('warehouse'));
        if (request()->get('lowesta'))
            $this->where('a.quantity', '>=', request()->get('lowesta'));
        if (request()->get('lowestb'))
            $this->where('a.quantity', '<=', request()->get('lowestb'));
        if (request()->get('c_id'))
            $this->where('p.c_id', request()->get('c_id'));
        if (request()->get('type'))
            $this->where('p.type', request()->get('type'));
        


        $this->join('product p', 'p.id=a.p_id', 'LEFT');
        $this->join('product_unit pu', 'pu.id=p.unit', 'LEFT');
        $this->join('product_warehouse pw', 'pw.id=a.w_id', 'LEFT');
        $this->join('product_warehouse_user pwu', 'pwu.w_id=a.w_id', 'LEFT');
        $this->join('product_category pc', 'pc.id=p.c_id', 'LEFT');
        $this->join('system_user b', 'b.id=p.u_id', 'LEFT');
        $this->join('system_user c', 'c.id=p.update_uid', 'LEFT');

        $this->field('a.id as inventory_id,a.p_id,a.w_id,a.quantity,'
                . 'pc.name as category,'
                . 'pw.id,pw.name as warehouse,pw.default,'
                . 'p.name,p.lowest,p.code,p.type,p.image,'
                . 'b.nickname,'
                . 'c.nickname as replace_nickname,'
                . 'pu.name as unit_name');

        $this->order('a.w_id asc,a.p_id asc');
        $this->alias('a');
        return $this;
    }

    /**
     * @title 检查是否可以销售产器
     */
    public function check_product_sales($product, $warehouse, $quantity) {

        $lists = $this
                ->where('p_id', $product)
                ->where('w_id', $warehouse)
                ->find();
        if (!empty($lists) && $lists['quantity'] >= $quantity) {
            return TRUE;
        }
        return FALSE;
    }

}
