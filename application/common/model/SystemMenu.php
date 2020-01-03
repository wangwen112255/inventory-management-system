<?php

namespace app\common\model;

use app\common\model\Base;
use org\util\Auth;

class SystemMenu extends Base {

    /**
     * @title 返回主菜单
     * 用于BUI框架的列表展示
     */
    public function get_menu_list() {
        $menu_obj = db('system_menu')->where('status', '>', 0)->order('sort asc')->select();
        $menu_result = NULL;
        foreach ($menu_obj as $key => $val) {
            $menu_result[] = $val;
        }
        $gen_tree_result = gen_tree($menu_result, 'id', 'pid');
        foreach ($gen_tree_result as $key => $val) {
            $id_arr = explode('/', $val['url']);
            $menu[$key]['id'] = $id_arr[1] ?? md5($val['id']);
            $menu[$key]['homePage'] = substr(strrchr($val['url'], '/'), 1);
            if (isset($val['son'])) {
                foreach ($val['son'] as $key2 => $val2) {
                    $menu[$key]['menu'][$key2]['text'] = $val2['name'];
                    if (isset($val2['son'])) {
                        foreach ($val2['son'] as $key3 => $val3) {
                            //如果是超级管理员，显示所有
                            if (IS_SUPER_ADMIN) {
                                $menu[$key]['menu'][$key2]['items'][$key3] = [
                                    'id' => substr(strrchr($val3['url'], '/'), 1),
                                    'text' => $val3['name'],
                                    'href' => url($val3['url']),
                                    'closeable' => true,
                                ];
                            } else {
                                $Auth = new Auth();
                                $authList = $Auth->getAuthList(UID, 1);
                                //将没有权限的菜单隐藏
                                foreach ($authList as $key4 => $val4) {
                                    if ($val3['url'] === $val4) {
                                        $menu[$key]['menu'][$key2]['items'][$key3] = [
                                            'id' => substr(strrchr($val3['url'], '/'), 1),
                                            'text' => $val3['name'],
                                            'href' => url($val3['url']),
                                            'closeable' => true,
                                        ];
                                    }
                                }//end foreach
                            }
                        }//end foreach
                        if (empty($menu[$key]['menu'][$key2]['items']))
                            unset($menu[$key]['menu'][$key2]);
                    }
                }
                if (empty($menu[$key]['menu'][$key2]))
                    unset($menu[$key]['menu'][$key2]);
                if (empty($menu[$key]['menu']))
                    unset($menu[$key]);
                else
                    $m[] = $val['id'];
            }else {
                //如果没有子类，把父类本身就删除
                unset($menu[$key]);
            }
        }
        foreach ($menu as $val2) {
            $e[] = $val2;
        }
        return array($m, $e);
    }

}
