<?php

namespace app\common\model;

use app\common\model\Base;
use Exception;
use think\Db;

class ProductStorageOrder extends Base {

    public function getTypeAttr($value) {
        return config_value('_dict_storage', $value);
    }

    public function storage_undo($id) {

        Db::startTrans();
        try {

            $lists = db("product_storage_order_data")->where('o_id', $id)->select();
            $i = 0;
            foreach ($lists as $key => $value) {
                $affect_rows = db('product_inventory')
                        ->where('p_id', $value['p_id'])
                        ->where('w_id', $value['w_id'])
                        ->setDec('quantity', $value['quantity']);
                $i = $i + $affect_rows;
            }
            if ($i != count($lists) || $i == 0) {
                throw new Exception("库存数量增减存在问题");
            }
            //删除w_order_data的所有数据
            db('product_storage_order_data')->where('o_id', '=', $id)->delete();
            //删除w_order下面的数据，单条
            db('product_storage_order')->where('id', '=', $id)->delete();
            foreach ($lists as $key => $value) {
                // 检查库存是否为0，如果是0删除这条记录
                $count = db('product_inventory')
                        ->where('p_id', $value['p_id'])
                        ->where('w_id', $value['w_id'])
                        ->value('quantity');
                if ($count < 0) {
                    throw new Exception("库存出现负数");
                }
                //
                if ($count == 0) {
                    db('product_inventory')
                            ->where('p_id', $value['p_id'])
                            ->where('w_id', $value['w_id'])
                            ->delete();
                }
            }
            // 提交事务
            Db::commit();
        } catch (Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    public function storage_submit($post, $products) {
        // 启动事务
        Db::startTrans();
        try {
            //很长很长 $amount
            $data['order_number'] = date('YmdtHis') . rand(100, 999) . UID;
            $data['u_id'] = UID;
            $data['s_id'] = $post['supplier'];
            $data['quantity'] = $post['quantity'];
            $data['amount'] = $post['amount'];
            $data['type'] = $post['type'];
            $data['remark'] = $post['remark'];
            $data['create_time'] = time();
            $insert_id = db('product_storage_order')->strict(true)->insertGetId($data);
            //让入库 来反向更新 生产表，用于生产关联storage_order_id
            if (isset($post['product_build_id'])) {
                db('product_build_order')->where('id', $post['product_build_id'])->setField('storage_order_id', $insert_id);
            }
            if ($insert_id) {
                foreach ($products as $value) {
                    $order_data['o_id'] = $insert_id;
                    $order_data['w_id'] = $value['warehouse'];
                    $order_data['p_id'] = $value['id'];
                    $order_data['s_id'] = $data['s_id'];
                    $order_data['quantity'] = $value['product_quantity'];
                    $order_data['amount'] = $value['amount'] * $value['product_quantity'];
                    $order_data['u_id'] = UID;
                    $order_data['create_time'] = time();
                    
                    // 产品快照
                    // 产品快照
                    $product_data = db('product')
                            ->alias('p')
                            ->join('product_category pc', 'pc.id=p.c_id', 'LEFT')
                            ->where('p.id', $value['id'])
                            ->field('p.*,pc.name as category')
                            ->find();
                    $product_data['product_type'] = config_value('_dict_product_type', $product_data['type']);
                    $order_data['product_data'] = serialize($product_data);                 
                    db("product_storage_order_data")->insert($order_data);
                    
                    //增加库存数量    
                    model('product_inventory')->increase($value['id'], $value['warehouse'], $value['product_quantity']);
                    //print_r($order_data);exit;
                }
            } else {
                throw new Exception('入库单生成失败');
            }
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
            $this->where('a.create_time', '>=', strtotime(input('get.timea') . ' 00:00:00'));
        if (request()->get('timeb'))
            $this->where('a.create_time', '<=', strtotime(input('get.timeb') . ' 23:59:59'));
        
        $this->where('pwu.u_id', UID);
        
        if (request()->get('supplier'))
            $this->where('a.s_id', request()->get('supplier'));      
        if (request()->get('type'))
            $this->where('p.type', request()->get('type'));
        if (request()->get('warehouse'))
            $this->where('psod.w_id', request()->get('warehouse'));        
        if (request()->get('c_id'))
            $this->where('p.c_id', request()->get('c_id'));
        
        if (request()->get('keyword'))
            $this->where('a.order_number|p.code|p.name', 'like', '%' . request()->get('keyword') . '%');

        $this->join('system_user su', 'a.u_id=su.id', 'LEFT');
        $this->join('product_supplier ps', 'a.s_id=ps.id', 'LEFT');
        $this->join('product_storage_order_data psod', 'psod.o_id=a.id', 'LEFT');
        $this->join('product_warehouse_user pwu', 'pwu.w_id=psod.w_id', 'LEFT');
        $this->join('product p', 'p.id=psod.p_id', 'LEFT');

        $this->field('a.*,su.nickname,ps.company');

        $this->order('a.id desc');
        $this->alias('a');
        return $this;
    }

}
