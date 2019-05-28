<?php

namespace app\admin\controller;

use app\admin\controller\Admin;
use think\Db;
use think\Session;

/**
 * @title 控制台
 */
class Index extends Admin {

    /**
     * @title 日志删除
     */
    public function log_clear() {


        if ($affect_rows = $this->m_operate->clear()) {

            $this->success('清理了' . $affect_rows . '条数据 ', 'log');
        } else {
            $this->error('没有清理任何数据');
        }
    }

    /**
     * @title 修改自己的密码
     */
    public function password() {

        if (request()->isPost()) {

            $password = input('post.password');

            if (trim($password) == '') {

                $this->error('密码不能为空');
            } else {

                if (db('system_user')->where('id', UID)->update(['password' => md5($password)]) !== false) {
                    $this->success('更新成功');
                } else {
                    $this->error('密码没有更新');
                }
            }
        } else {

            return view();
        }
    }

    /**
     * @title 框架页面
     */
    public function index() {

        //菜单列表
        $menu_list = $this->m_system_menu->get_menu_list();
        $this->assign('menu_list', json_encode($menu_list[1]));


        //菜单分组
        $menu_list_group = $this->m_system_menu->where('id', 'in', $menu_list[0])->order('sort asc')->select();
        $this->assign('menu_list_group', $menu_list_group);


        //用户的基本信息
        $this->assign('user_auth', Session::get('user_auth'));

        return view();
    }

    /**
     * @title 首页
     */
    public function main() {


        // 系统信息
        $version = Db::query('SELECT VERSION() AS ver');
        $config = [
            'thinkphp_ver' => THINK_VERSION,
            'url' => $_SERVER['HTTP_HOST'],
            'document_root' => $_SERVER['DOCUMENT_ROOT'],
            'server_os' => PHP_OS,
            'server_port' => $_SERVER['SERVER_PORT'],
            'server_ip' => $_SERVER['SERVER_ADDR'],
            'server_soft' => $_SERVER['SERVER_SOFTWARE'],
            'php_version' => PHP_VERSION,
            'mysql_version' => $version[0]['ver'],
            'max_upload_size' => ini_get('upload_max_filesize')
        ];
        $this->assign('config', $config);

        return view();
    }

    /**
     * @title 我的日志
     */
    public function log() {

        if (!isset($_GET['timea']))
            $_GET['timea'] = date('Y-m-d', strtotime("-30 day"));
        if (!isset($_GET['timeb']))
            $_GET['timeb'] = date('Y-m-d');



        $count = $this->m_operate->model_where(UID)->count();
        $lists = $this->m_operate->model_where(UID)->paginate(20, $count);

        $this->assign('count', $count);
        $this->assign('lists', $lists);
        $this->assign('pages', $lists->render());



        return view();
    }

}
