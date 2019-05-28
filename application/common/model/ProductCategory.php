<?php

namespace app\common\model;

use think\Model;
use app\common\model\Base;

class ProductCategory extends Base {

    public function model_where() {
        $this->order('sort asc');
        return $this;
    }

}
