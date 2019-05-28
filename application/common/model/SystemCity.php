<?php
namespace app\common\model;

use app\common\model\Base;

class SystemCity extends Base {

    public function json() {
        $json = $this->cache->file->get('cityjson');
        if (empty($json)) {
            $items = $this->model_where()->select();
            $json = json_encode(gen_tree($items, 'v'));
            $this->cache->file->set('cityjson', $json);
        }
        return $json;
    }

    public function model_where() {
        $this->select('a.id as v,a.name as n,a.pid');
        $this->from('city as a');
        return $this;
    }

}
