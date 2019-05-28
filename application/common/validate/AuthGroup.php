<?php

namespace app\common\validate;

class AuthGroup extends Base {

    protected $rule = [
        ['title', 'require|max:25', '标题必须|标题最多不能超过25个字符']
    ];

}
