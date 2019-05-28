<?php

namespace app\admin\controller;

use app\common\controller\Base;
use org\util\Auth;
use think\Cookie;
use think\Session;

/**
 * @title 后台
 */
class Admin extends Base {

    protected function _initialize() {
        parent::_initialize();


        if (Cookie::has('user_auth_sign') && Session::has('user_auth')) {

            $user_auth = Session::get('user_auth');
            $user_auth_sign = Cookie::get('user_auth_sign');

            if (data_auth_sign($user_auth) != $user_auth_sign) {
                $this->error('auth error', url('admin/everyone/login'));
            } else {
                define('UID', $user_auth['id']);
            }
        } else {
            $this->error('cookie or session missing', url('admin/everyone/login'));
        }


        //是否是超级管理员
        $is_super_admin = $user_auth['id'] == 1 ? true : false;
        define('IS_SUPER_ADMIN', $is_super_admin);

        //如果不是超级管理员
        if (!IS_SUPER_ADMIN) {
            //检测访问权限
            if (strpos($this->url, 'listorders') === false && !$this->_rule_check($this->url)) {
                $this->error('未授权访问!');
            }
        }
    }

    public function _get_auth_rule($selected_str = '') {


        //加载菜单的所有URL
        $menu_url_arr = $this->m_system_menu->where('url', '<>', '')->column('url');
        $menu_url_arr = array_unique($menu_url_arr);

        //print_r($menu_url_arr);exit;

        $selected_arr = [];
        if ('' != $selected_str) {
            $selected_arr = explode(',', $selected_str);
        }
        $group_array = db('auth_rule')->distinct(true)->field('group')->select();
        $auth_rule_result = db('auth_rule')->select();

        $auth_rule_result_new = [];
        foreach ($group_array as $k => $v) {
            $v_name = $v['group'];
            $check_flag = 0;
            foreach ($auth_rule_result as $key => $val) {
                if ($val['group'] == $v_name) {

                    //如果存在菜单中
                    if (in_array($val['name'], $menu_url_arr)) {
                        $val['remark'] = '<br><span style="color:red">已绑定菜单</span>';
                    } else {
                        $val['remark'] = '';
                    }

                    //无需验证的节点
                    if (in_array($val['name'], ['admin/everyone/login', 'admin/everyone/logout'])) {
                        $val['remark'] = '<br><span style="color:blue">无需验证</span>';
                    }

                    //如果被选中
                    if (in_array($val['id'], $selected_arr)) {
                        $val['checked'] = 'checked';
                        $check_flag = 1;
                    } else {
                        $val['checked'] = '';
                    }

                    //组合结果
                    $auth_rule_result_new[$k]['child'][] = $val;
                }
            }
            $auth_rule_result_new[$k]['title'] = $v_name;
            if ($check_flag) {
                $auth_rule_result_new[$k]['checked'] = 'checked';
            } else {
                $auth_rule_result_new[$k]['checked'] = '';
            }
        }

        return $auth_rule_result_new;
    }

    /**
     * @title 权限检测
     * @param string  $rule    检测的规则
     * @param string  $mode    check模式
     * @return boolean
     * @author 朱亚杰  <xcoolcc@gmail.com>
     */
    public function _rule_check($rule, $type = 1, $mode = 'url') {

        static $Auth = null;
        if (!$Auth) {
            $Auth = new Auth();
        }
        //return true;

        if (!$Auth->check($rule, UID, $type, $mode)) {
            return false;
        }
        return true;
    }

    /**
     * @title 排序 
     */
    public function listorders($table = '') {

        if ($table) {
            $ids = input('post.sort/a');
            foreach ($ids as $key => $r) {
                $data['sort'] = $r;
                db($table)->where('id', $key)->update($data);
            }
            $this->success('排序完成');
        }
    }

}
