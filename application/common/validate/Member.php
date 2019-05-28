<?php

namespace app\common\validate;

class Member extends Base {

    protected $rule = [
        ['username', 'require|max:25', '用户名必须|用户名最多不能超过25个字符'],
        ['email', 'email', '邮箱格式错误']
    ];

}
