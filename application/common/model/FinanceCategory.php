<?php

namespace app\common\model;

use think\Model;
use app\common\model\Base;

class FinanceCategory extends Base {
    

    public function json() {
        $json = array();
        $array = array(array('v' => '0', 'n' => '支出'), array('v' => '1', 'n' => '收入'));
        foreach ($array as $value) {
            foreach ($this->lists_tree() as $var) {
                if ($var['type'] == $value['v'])
                    $value['s'][] = array('v' => $var['id'], 'n' => $var['name']);
            }
            $json[] = $value;
        }
        return json_encode($json);
    }

    

    public function model_where() {

        if (is_numeric(request()->get('type')))
            $this->where('a.type', request()->get('type'));
        if (request()->get('keyword'))
            $this->where('a.name', 'like', '%' . request()->get('keyword') . '%');

        $this->order('sort asc,id desc');
        $this->field('a.*');
        $this->alias('a');
        return $this;
    }

}
