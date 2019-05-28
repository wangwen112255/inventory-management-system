<?php

namespace app\common\model;

use app\common\model\Base;
use think\Db;

class SystemUser extends Base {

    public function user_delete($id) {


        Db::startTrans();
        try {

            //删除员工
            db('system_user')->where('id', $id)->delete();
            //删除相应角色
            db('auth_group_access')->where('uid', $id)->delete();

            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    public function user_edit($data, $id) {


        Db::startTrans();
        try {



            db('system_user')->where('id', $id)->update($data);

            if (request()->post('auth_group_id')) {

                $data_auth['uid'] = $id;
                $data_auth['group_id'] = request()->post('auth_group_id');

                if (db('auth_group_access')->where('uid', $id)->count()) {
                    db('auth_group_access')->where('uid', $id)->update($data_auth);
                } else {
                    db('auth_group_access')->insert($data_auth);
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

    public function user_add($data) {


        Db::startTrans();
        try {



            $insert_id = db('system_user')->strict(true)->insertGetId($data);

            if (!$insert_id) {
                throw new Exception('用户生成失败');
            }

            if (request()->post('auth_group_id')) {

                $data_auth['uid'] = $insert_id;
                $data_auth['group_id'] = request()->post('auth_group_id');

                db('auth_group_access')->insert($data_auth);
            }


            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    public function model_where() {

        if (request()->get('status'))
            $this->where('a.status', request()->get('status'));
        if (request()->get('c_id'))
            $this->where('a.cid', request()->get('cid'));

        $this->order('a.id asc');
        $this->field('a.*');
        $this->alias('a');
        return $this;
    }

}
