<?php

/**
 * 账务管理
 */

namespace app\common\model;

use think\Model;
use app\common\model\Base;
use think\Db;

class FinanceAccounts extends Base {

    public function query_delete($id) {


        Db::startTrans();
        try {


            // 是支出还是收入
            $one = db('finance_accounts')->where('id', $id)->find();

            //支出，把银行查出来，然后把钱还回银行+，然后把记录删除
            if ($one['type'] == 0) {
                db('finance_bank')->where('id', $one['bank_id'])->setInc('money', $one['money']);
            }
            //收入，把收入到银行的钱 给减去-，然后把记录删除
            if ($one['type'] == 1) {
                db('finance_bank')->where('id', $one['bank_id'])->setDec('money', $one['money']);
            }

            db('finance_accounts')->where('id', $id)->delete();


            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return $e->getMessage();
        }
    }

    public function model_where() {
        // 初始化查询条件
        $this->where('a.u_id', UID);
        // 通用查询条件
        // $this->base_where($map);
        // 特殊查询条件
        if (request()->get('timea'))
            $this->where('a.create_time', '>=', strtotime(request()->get('timea') . ' 00:00:00'));
        if (request()->get('timeb'))
            $this->where('a.create_time', '<=', strtotime(request()->get('timeb') . ' 23:59:59'));
        if (request()->get('datetimea'))
            $this->where('a.datetime', '>=', strtotime(request()->get('datetimea') . ' 00:00:00'));
        if (request()->get('datetimeb'))
            $this->where('a.datetime', '<=', strtotime(request()->get('datetimeb') . ' 23:59:59'));
        
        
        $this->join('system_user m', 'a.u_id=m.id', 'LEFT');
        $this->join('system_user t', 'a.attn_id=t.id', 'LEFT');
        $this->join('finance_bank b', 'a.bank_id=b.id', 'LEFT');
        $this->join('finance_category c', 'a.c_id=c.id', 'LEFT');
        
        $this->field('a.*,'
                . 'b.name,'
                . 'c.name as c_name,'
                . 'm.nickname,'
                . 't.nickname as nickname_attn');
        
        $this->order('a.id desc');
        $this->alias('a');
        return $this;
    }

    

}
