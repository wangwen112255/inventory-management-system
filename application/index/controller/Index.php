<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

/**
 * @title 引导
 */
class Index extends Controller {

    /**
     * @title 跳转后台
     */
    public function index() {
        //
        $this->redirect('admin/index/index');
    }

}
