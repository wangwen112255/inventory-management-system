<?php

namespace app\common\model;

use app\common\model\Base;
use function request;

class Product extends Base {

    public function getTypeAttr($value) {
        return config_value('_dict_product_type', $value);
    }

    public function json($type = []) {

        if (request()->get('query')) {
            $this->where('py.py|code|name', 'like', '%' . request()->get('query') . '%');
        }

        if (!empty($type))
            $this->where('type', 'in', $type);

        $this->join('pinyin py', 'CONV(HEX(LEFT(CONVERT(name USING GBK),1)),16,10) BETWEEN py.begin AND py.end', 'LEFT');

        $array = $this->limit(10)->select();
        $json['query'] = request()->get('query');
        foreach ($array as $value) {
            $json['suggestions'][] = array('value' => $value['name'], 'code' => $value['code'], 'id' => $value['id']);
        }
        return json_encode($json);
    }

    public function model_where() {


        if (request()->get('c_id'))
            $this->where('a.c_id', request()->get('c_id'));
        if (request()->get('type'))
            $this->where('a.type', request()->get('type'));
        if (request()->get('keyword'))
            $this->where('a.code|a.name', 'like', '%' . request()->get('keyword') . '%');


        $this->join('product_inventory i', 'a.id=i.p_id', 'LEFT');
        $this->join('product_warehouse pw', 'pw.id=i.w_id', 'LEFT');
        $this->join('product_unit pu', 'pu.id=a.unit', 'LEFT');
        $this->join('product_category pc', 'a.c_id=pc.id', 'LEFT');
        $this->join('system_user b', 'a.u_id=b.id', 'LEFT');
        $this->join('system_user c', 'a.update_uid=c.id', 'LEFT');

        $this->field('a.*,'
                . 'pc.name as category,'
                . 'SUM(i.quantity) as quantity,group_concat(pw.name) as warehouse,'
                . 'b.nickname,'
                . 'pu.name as unit,'
                . 'c.nickname as replace_nickname');

        $this->order('a.id desc');
        $this->alias('a');

        return $this;
    }

}
