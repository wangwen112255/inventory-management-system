<?php

namespace app\common\model;

use app\common\model\Base;

class MemberGroup extends Base {

    public function model_where() {

        $this->join('member m', 'a.id = m.g_id', 'LEFT');

        $this->field('a.*,COUNT(DISTINCT m.id) as member_count');

        $this->group('a.id');
        $this->alias('a');
        return $this;
    }

}
