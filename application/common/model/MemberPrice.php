<?php

namespace app\common\model;

use app\common\model\Base;

class MemberPrice extends Base {

    public function model_where() {
        $this->join('member_group group', 'group.id = a.g_id', 'LEFT');
        $this->join('member m', 'm.g_id = group.id', 'LEFT');
        $this->field('a.*');
        $this->alias('a');
        return $this;
    }

}
