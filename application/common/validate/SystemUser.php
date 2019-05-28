<?php

namespace app\common\validate;

class SystemUser extends Base {

    protected $rule = [
        ['username', 'require|max:25|unique:system_user', '名称必须|名称最多不能超过25个字符|用户名已经存在了'],
        ['nickname', 'require|max:25', '昵称必须|名称最多不能超过25个字符'],
    ];

}
