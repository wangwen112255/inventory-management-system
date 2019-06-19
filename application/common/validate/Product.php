<?php

namespace app\common\validate;

class Product extends Base {

    protected $rule = [
        ['c_id', 'require', '分类不能为空'],
        ['name', 'require|max:25', '名称必须|名称最多不能超过25个字符'],
        ['code', 'require|unique:product', '货号不能为空|货号已经被使用了'],
        ['sales', 'require|number', '销售价不能为空|销售价必须是数字'],
        ['purchase', 'require|number', '进价不能为空|进价必须是数字'],
    ];

}
