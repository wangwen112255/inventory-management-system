<?php

namespace app\common\validate;

class ProductSupplier extends Base {

    protected $rule = [
        ['company', 'require|max:25', '名称必须|名称最多不能超过25个字符']
    ];
    protected $scene = [
        'add' => ['company'],
        'edit' => ['company'],
    ];

}
