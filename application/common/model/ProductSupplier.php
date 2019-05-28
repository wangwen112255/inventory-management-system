<?php

namespace app\common\model;

use think\Model;
use app\common\model\Base;

class ProductSupplier extends Base {

    public function model_where() {

        if (request()->get('keyword'))
            $this->where('a.company|a.name', 'like', '%' . request()->get('keyword') . '%');

        $this->join('system_user su', 'a.u_id=su.id', 'LEFT');
        $this->join('system_user su2', 'a.replace_uid=su2.id', 'LEFT');

        $this->field('a.*,su.nickname,su2.nickname as nickname_replace');

        $this->order('a.id desc');
        $this->alias('a');
        return $this;
    }

}
