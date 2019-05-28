<?php

namespace app\common\validate;

class Express extends Base {

    protected $rule = [
        ['name', 'require|max:25', '名称必须|名称最多不能超过25个字符']
    ];
    protected $scene = [
        'add' => ['title'],
        'edit' => ['title'],
    ];

}
