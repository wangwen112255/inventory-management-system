<?php

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class ProductRelation extends Base {

    public function product_relation_edit_submit($post, $id) {

        Db::startTrans();
        try {



            $product_ids = isset($post['product_ids']) ? $post['product_ids'] : [];
            $multiple = isset($post['multiple']) ? $post['multiple'] : [];


            db('product_relation')->where('p_id', $id)->delete();

            foreach ($product_ids as $value) {

                if (!empty($value) && is_numeric($value)) {

                    // 依次往relation表中添加数据 
                    db('product_relation')->insert([
                        'p_id' => $id,
                        'p_id_bc' => $value,
                        'multiple' => $multiple[$value]
                    ]);
                }
            }




            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

}
