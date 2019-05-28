<?php

namespace app\common\model;

use app\common\model\Base;
use Exception;
use think\Db;

class ProductWarehouse extends Base {

    public function warehouse_edit($post) {
        Db::startTrans();
        try {
            // 更新主信息
            db('product_warehouse')->strict(false)->where('id', $post['id'])->update($post);
            // 删除关联
            db('product_warehouse_user')->where('w_id', $post['id'])->delete();
            // 添加关联
            $users = isset($post['uids']) ? $post['uids'] : [];
            foreach ($users as $value) {
                if (is_numeric($value))
                    db('product_warehouse_user')->insert([
                        'u_id' => $value,
                        'w_id' => $post['id'],
                    ]);
            }
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    public function warehouse_add($post) {
        Db::startTrans();
        try {
            $insert_id = db('product_warehouse')->strict(false)->insertGetId($post);
            if ($insert_id) {
                $users = isset($post['uids']) ? $post['uids'] : [];
                foreach ($users as $value)
                    db('product_warehouse_user')->insert([
                        'u_id' => $value,
                        'w_id' => $insert_id
                    ]);
            }
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    public function warehouse_delete($id) {
        Db::startTrans();
        try {
            $one = model('product_warehouse')->model_where(true)->where('a.id', $id)->find();
            if (!empty($one['number'])) {
                throw new Exception('当前仓库有库存,无法删除');
            }
            db('product_warehouse')->where('id', $id)->delete();
            db('product_warehouse_user')->where('w_id', $id)->delete();
            // 提交事务
            Db::commit();
        } catch (Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    public function model_where($count = false) {        
        

        $this->join('product_warehouse_user pwu', 'pwu.w_id = a.id ', 'LEFT');
        $this->join('system_user su', 'su.id = pwu.u_id', 'LEFT');
        $this->join('product_inventory pi', 'pi.w_id = a.id', 'LEFT');

        $this->group('a.id');

        $this->field('a.*' . ($count ? ',group_concat(DISTINCT su.nickname) as nickname,group_concat(DISTINCT su.id) as uids,SUM(pi.quantity) as number' : ''));

        $this->order('a.sort asc,a.id desc');
        $this->alias('a');
        return $this;
    }

}
