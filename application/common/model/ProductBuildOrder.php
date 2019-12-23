<?php
namespace app\common\model;

use app\common\model\Base;
use Exception;
use think\Db;


class ProductBuildOrder extends Base {

    public function getBuildTimeAttr($value) {
        return date('Y-m-d H:i', $value);
    }

    public function product_build_submit($post, $products) {
        // 启动事务
        Db::startTrans();
        try {
            $order['order_number'] = date('YmdtHis') . rand(100, 999) . UID;
            $order['u_id'] = UID;
            $order['p_id'] = $post['product_id'];
            $order['quantity'] = $post['quantity'];
            $order['build_time'] = strtotime($post['build_time']);
            $order['create_time'] = time();
            $order['remark'] = $post['remark'];
            $order['storage_order_id'] = 0;
            $insert_id = db('product_build_order')->insertGetId($order);
            if ($insert_id) {
                foreach ($products as $key => $value) {
                    $order_data['o_id'] = $insert_id;
                    $order_data['p_id_bc'] = $value['id'];
                    $order_data['w_id'] = $value['product_warehouse'];
                    $order_data['quantity'] = $value['final_quantity'];
                    $product_current = db('product')
                            ->alias('a')
                            ->join('product_category b', 'b.id=a.c_id')
                            ->where('a.id', $value['id'])
                            ->field('a.*,b.name as category')
                            ->find();
                    $types = config('_dict_product');
                    $product_current['type'] = isset($types[$product_current['type']]) ? $types[$product_current['type']] : '';
                    $order_data['product_data'] = serialize($product_current);
                    db('product_build_order_data')->insert($order_data);
                    //减去相应的库存
                    db('product_inventory')
                            ->where('w_id', $value['product_warehouse'])
                            ->where('p_id', $value['id'])
                            ->setDec('quantity', $value['final_quantity']);
                }
            } else {
                throw new Exception('订单生成失败');
            }
            // 2加入到仓库
            $warehouse_id = $post['warehouse_id'];
            if ($warehouse_id) {
                // 虚拟出所有需要的字段 
                $post2['product_build_id'] = $insert_id; //让入库 来反向更新 生产表，用于生产关联storage_order_id
                $post2['supplier'] = 0; //供应商
                $post2['quantity'] = $post['quantity']; //数量 
                $post2['amount'] = 0; //金额
                $post2['type'] = 3; //生产入库
                $post2['remark'] = '生产自动入库'; //生产入库
                // 只有一个产品入库
                $products2[] = [
                    'warehouse' => $warehouse_id,
                    'id' => $post['product_id'],
                    'product_quantity' => $post['quantity'],
                    'amount' => 0
                ];
                $message = model('product_storage_order')->storage_submit($post2, $products2);
                if ($message) {
                    throw new Exception($message);
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

    public function product_build_undo($id) {
        Db::startTrans();
        try {
            // 0关于库存的撤消
            $storage_order_id = db('product_build_order')->where('id', $id)->value('storage_order_id');
            if ($storage_order_id) {
                $message = model('product_storage_order')->storage_undo($storage_order_id);
                if ($message) {
                    throw new Exception($message);
                }
            }
            // 1依次把包材还给仓库
            $lists = db('product_build_order_data')->where('o_id', $id)->select();
            foreach ($lists as $key => $value) {
                model('product_inventory')->increase($value['p_id_bc'], $value['w_id'], $value['quantity']);
            }
            // 2依次删除order_data
            foreach ($lists as $key => $value) {
                db('product_build_order_data')->where('id', $value['id'])->delete();
            }
            // 3删除order
            db('product_build_order')->where('id', $id)->delete();
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
        if (request()->get('keyword'))
            $this->where('p.name|p.code', 'like', '%' . request()->get('keyword') . '%');        
        
        // $this->where('a.u_id', UID);
        
        $this->join('product p', 'p.id=a.p_id');
        
        $this->field('a.*,p.name as product_title');
        
        $this->order('a.id desc');
        $this->alias('a');        
        return $this;
    }

}
