<?php

namespace app\admin\controller;

use app\common\controller\Base;
use think\Cookie;
use think\Session;

/**
 * @title 公共
 */
class Everyone extends Base {

    /**
     * @title 用户登录
     */
    public function login() {

        if (request()->isPost()) {

            $post = request()->post();

            $username = $post['username'];
            $password = $post['password'];

            // 前台验证
            if (empty($username) || empty($password)) {
                return $this->error('用户名或密码不能为空');
            }

            //在用户名通过的前提下，再验证密码
            $user_arr = db('system_user')->where('username', $username)->find();
            if (!empty($user_arr) && $user_arr['status']) {

                //TODO 后期需要加上盐值
                if (md5($password) === $user_arr['password']) {

                    //cookie是否保存7天
                    if (input('?post.rember_password')) {
                        $this->_save_session_cookie_($user_arr, true);
                    } else {
                        $this->_save_session_cookie_($user_arr);
                    }
                    model('operate')->success('成功登录系统', $user_arr['id']);
                    $this->success('', 'admin/index/index');
                } else {
                    model('operate')->failure('用户密码错误', $user_arr['id']);
                    $this->error('用户密码错误');
                }
            } else {
                $this->error('用户不存在或被禁用');
            }
        } else {
            return view();
        }
    }

    public function _save_session_cookie_($user, $rember = false) {

        // 基本信息     
        $user_auth = [
            'id' => $user['id'],
            'username' => $user['username'],
            'nickname' => $user['nickname'],
        ];
        Session::set('user_auth', $user_auth);


        Cookie::set('user_id', $user_auth['id']);

        if ($rember)
            Cookie::set('user_auth_sign', data_auth_sign($user_auth));
        else
            Cookie::set('user_auth_sign', data_auth_sign($user_auth), 86400 * 7);
    }

    /**
     * @title 用户登出
     */
    public function logout() {

        Session::delete('user_auth');
        Cookie::delete('user_auth_sign');

        $this->redirect('login');
    }

}
