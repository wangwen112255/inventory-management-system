<?php

namespace app\common\validate;

class FinanceAccounts extends Base {

    protected $rule = [
        ['c_id', 'require', '财务分类不能为空'],
        ['bank_id', 'require', '财务银行不能为空'],
        ['money', 'require|number', '金额不能为空|金额只能是数字']
    ];

}
