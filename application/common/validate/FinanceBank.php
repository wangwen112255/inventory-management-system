<?php

namespace app\common\validate;

class FinanceBank extends Base {

    protected $rule = [
        ['name', 'require|max:25', '名称必须|名称最多不能超过25个字符'],
        ['money', 'number', '金额只能是数字'],
    ];
}
