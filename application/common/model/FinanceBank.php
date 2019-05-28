<?php
/**
 * 银行管理
 */
namespace app\common\model;
use think\Model;
use app\common\model\Base;
class FinanceBank extends Base {
    /**
     * 支出
     */
    public function expenditure($money, $id) {
        $this->where('id', $id)->setDec('money', abs($money)) ? model('operate')->success('银行支出变更') : model('operate')->failure('银行支出变更');
    }
    /**
     * 收入
     */
    public function income($money, $id) {
        $this->where('id', $id)->setInc('money', abs($money)) ? model('operate')->success('银行收入变更') : model('operate')->failure('银行收入变更');
    }

    public function model_where() {
        if (request()->get('start')) {
            $this->where('a.money', '>=', request()->get('start'));
        }
        if (request()->get('end')) {
            $this->where('a.money', '<=', request()->get('end'));
        }
        if (request()->get('keyword')) {
            $this->where('a.name', 'like', '%' . request()->get('keyword') . '%');
        }
        $this->alias('a');
        $this->order('a.id desc');
        $this->select('a.*');
        return $this;
    }
}
