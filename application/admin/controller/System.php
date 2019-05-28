<?php
namespace app\admin\controller;
use app\admin\controller\Admin;
use org\util\ClassReader;
use org\util\Document;
use think\Cache;
use think\Db;
use think\Response;
/**
 * @title 系统
 */
class System extends Admin {
    /**
     * @title 信息列表
     *
     * @return Response
     */
    public function auth_group() {
        $lists = db('auth_group')->paginate(10, false, ['query' => request()->get()]);
        $this->assign('lists', $lists);
        $this->assign('pages', $lists->render());
        builder('list')
                ->addItem('id', '#')
                ->addItem('title', '名称')
                ->addItem('description', '描述')
                ->addAction('编辑', 'auth_group_edit', '<i class="fa fa-edit"></i>')
                ->addAction('删除', 'auth_group_delete', '<i class="fa fa-remove"></i>', 'ajax-get confirm')
                ->build();
        return view();
    }
    /**
     * @title 添加角色
     */
    public function auth_group_add() {
        if (request()->isPost()) {
            $post = request()->post();
            if (!$this->v_auth_group->check($post))
                $this->error($this->v_auth_group->getError());
            if (isset($post['access']))
                $data['rules'] = implode(',', $post['access']);
            $data['title'] = $post['title'];
            $data['remark'] = $post['remark'];
            if (db('auth_group')->strict(true)->insert($data)) {
                $this->success('', 'auth_group');
            } else {
                $this->error('添加失败');
            }
        } else {
            $this->assign('auth_rule_list', $this->_get_auth_rule());
            builder('form')
                    ->addItem('title', 'input', '名称<font color="red">*</font>')
                    ->addItem('remark', 'textarea', '描述')
                    ->build();
            return view();
        }
    }
    /**
     * @title 编辑角色
     */
    public function auth_group_edit($id) {
        empty($id) && $this->error('参数不能为空');
        if (request()->isPost()) {
            $post = request()->post();
            if (!$this->v_auth_group->check($post))
                $this->error($this->v_auth_group->getError());
            if (isset($post['access']))
                $data['rules'] = implode(',', $post['access']);
            $data['title'] = $post['title'];
            $data['remark'] = $post['remark'];
            if (db('auth_group')->strict(true)->where('id', $post['id'])->update($data) !== false) {
                $this->success('', 'auth_group');
            } else {
                $this->error('更新失败');
            }
        } else {
            $one = db('auth_group')->where('id', $id)->find();
            $this->assign('auth_rule_list', $this->_get_auth_rule($one['rules']));
            builder('form')
                    ->addItem('title', 'input', '名称<font color="red">*</font>')
                    ->addItem('remark', 'textarea', '备注')
                    ->build($one);
            return view();
        }
    }
    /**
     * @title 删除资源
     *
     * @param  int  $id
     * @return Response
     */
    public function auth_group_delete($id) {        
        empty($id) && $this->error('参数不能为空');
        $affect_rows = db('auth_group')->where('id', $id)->delete();
        if ($affect_rows > 0) {
            $this->success('');
        } else {
            $this->error('删除失败！');
        }
    }
    /**
     * @title 显示资源列表
     */
    public function auth_rule() {
        $result = $this->_get_auth_rule();
        $this->assign('auth_rule_list', $result);
        return view();
    }
    /**
     * @title 节点解析
     */
    public function node_parse($dir = 'admin') {
        $dir_all = APP_PATH . $dir . DIRECTORY_SEPARATOR . 'controller';
        $service_annotation = $this->_get_service_annotation($dir_all);
        //print_r($service_annotation);
        $this->assign('service_annotation', $service_annotation);
        $this->assign('dir', $dir);
        // 
        //把application目录下的各个目录名加载出来。
        $folder = glob(APP_PATH . '*', GLOB_ONLYDIR);
        foreach ($folder as $key => $value) {
            $folder[$key] = str_replace(APP_PATH, '', $value);
        }
        $this->assign('folder', array_diff($folder, ['extra', 'runtime']));
        //$this->assign('folder', $folder);
        return view();
    }
    /**
     * @title 刷新节点
     */
    public function node_refresh($dir = 'admin') {
        $dir = APP_PATH . $dir . DIRECTORY_SEPARATOR . 'controller';
        $service_annotation = $this->_get_service_annotation($dir);
        $result = Db::execute('TRUNCATE table ' . config('database.prefix') . 'auth_rule ; ');
        $flag = 0;
//        print_r($service_annotation);
//        exit;
        foreach ($service_annotation as $k => $v) {
            if (isset($v['child']))
                foreach ($v['child'] as $k2 => $v2) {
                    //$data2['pid'] = $insertId;
                    $data2['name'] = 'admin/' . hump_to_underline($k) . '/' . $k2;
                    $data2['title'] = $v2['title'];
                    $data2['status'] = '1';
                    $data2['group'] = $v['title'];
                    db('auth_rule')->insert($data2);
                    //   $flag++;  
                    //  $node->add($data2);
                }
        }
        if ($flag) {
            $this->error("导入失败");
        } else {
            $this->success("导入成功", null);
        }
    }
    /**
     * @title 获取各个类的各个方法的注释字段，返回二维+数组
     */
    private function _get_service_annotation($dir) {
        $module_list = [];
        //类名&方法名解析类
        $class_reader = new ClassReader($dir);
        $class_tree = $class_reader->get_service_tree();
        //print_r($class_tree);exit;
        foreach ($class_tree as $classes => $methods) {
            $class_file = $dir . '/' . $classes . '.php';
            $class_name = $classes;
            //注释解析类
            $my_doc = new Document($class_file);
            $class_annotation = $my_doc->getAnnotation($class_name);
            $module_list[$classes] = $class_annotation;
            //依次循环输出方法名 
            foreach ($methods as $k2 => $method_name) {
                $method_annotation = $my_doc->getAnnotation($class_name, $method_name);
                if ($method_annotation) {
                    $module_list[$classes]['child'][$method_name] = $method_annotation;
                }
            }
        }
        return $module_list;
    }
    /**
     * @title 列表
     *
     * @return Response
     */
    public function user() {
        $lists = $this->m_system_user->paginate(10, false, ['query' => request()->get()]);
        foreach ($lists as $key => $value) {
            $lists[$key]['group_name'] = db('auth_group_access')
                    ->alias('a')
                    ->join('auth_group b', 'b.id=a.group_id', 'LEFT')
                    ->where('a.uid', $value['id'])
                    ->value('b.title');
        }
        //  print_r($list_obj);exit;
        $this->assign('lists', $lists);
        $this->assign('pages', $lists->render());
        builder('list')
                ->addItem('id', '#')
                ->addItem('group_name', '分组')
                ->addItem('username', '账号')
                ->addItem('nickname', '姓名')
                ->addItem('create_time', '创建日期')
                ->addAction('编辑', 'user_edit', '<i class="fa fa-edit"></i>')
                ->addAction('删除', 'user_delete', '<i class="fa fa-remove"></i>', 'ajax-get confirm')
                ->build();
        return view();
    }
    /**
     * @title 添加用户
     */
    function user_add() {
        if (request()->isPost()) {
            $post = request()->post();
            $data['username'] = request()->post('username') ?: '';
            $data['nickname'] = request()->post('nickname') ?: '';
            $data['password'] = md5('123456');
            $data['create_time'] = time();
            $data['status'] = 1;
            if (!$this->v_system_user->check($post))
                $this->error($this->v_system_user->getError());
            $message = $this->m_system_user->user_add($data);
            if ($message) {
                $this->error($message);
            } else {
                $this->success('', 'user');
            }
        } else {
            builder('form')
                    ->addItem('username', 'input', '账号<font color="red">*</font>')
                    ->addItem('nickname', 'input', '姓名<font color="red">*</font>')
                    ->addItem('auth_group_id', 'radio', '分组', db('auth_group')->column('title', 'id'))
                    ->addItem('password', 'p', '密码', '', '', '', '初始密码123456')
                    ->build();
            return view();
        }
    }
    /**
     * @title 编辑用户
     */
    function user_edit($id) {
        empty($id) && $this->error('参数不能为空');
        if (request()->isPost()) {
            $post = request()->post();
            $data['username'] = request()->post('username') ?: '';
            $data['nickname'] = request()->post('nickname') ?: '';
            if (!$this->v_system_user->check($post))
                $this->error($this->v_system_user->getError());
            $message = $this->m_system_user->user_edit($data, $post['id']);
            if ($message) {
                $this->error($message);
            } else {
                $this->success('', 'user');
            }
        } else {
            //获取基本信息
            $one = db('system_user')->where('id', '=', $id)->find();
            $one['auth_group_id'] = db('auth_group_access')->where('uid', $id)->value('group_id');
            $this->assign($one);
            builder('form')
                    ->addItem('username', 'input', '账号<font color="red">*</font>', '', 'readonly')
                    ->addItem('nickname', 'input', '姓名<font color="red">*</font>')
                    ->addItem('auth_group_id', 'radio', '分组', db('auth_group')->column('title', 'id'))
                    ->build($one);
            return view();
        }
    }
    /**
     * @title 用户删除
     */
    public function user_delete($id) {
        empty($id) && $this->error('参数不能为空');
        $message = $this->m_system_user->user_delete($id);
        if ($message) {
            $this->error($message);
        } else {
            $this->success('', 'user');
        }
    }
    /**
     * @title 菜单列表
     */
    public function menu() {
        $lists = $this->m_system_menu->lists_tree();
        foreach ($lists as $key => $value) {
            $lists[$key]['name'] = '<i class="fa ' . $value['icon'] . '"></i>' . $value['name'];
            $lists[$key]['status'] = $value['status'] == 0 ? '隐藏' : '';
        }
        $this->assign('lists', $lists);
        builder('list')
                ->addItem('id', '#')
                ->addItem('name', '名称')
                ->addItem('url', 'URL')
                ->addSortItem('sort', '排序', 'system_menu')
                ->addItem('status', '状态')
                ->addAction('编辑', 'menu_edit', '<i class="fa fa-edit"></i>')
                ->addAction('删除', 'menu_delete', '<i class="fa fa-remove"></i>', 'ajax-get confirm')
                ->build();
        return view();
    }
    /**
     * @title 获取菜单深度
     * @param $id
     * @param $array
     * @param $i
     */
    protected function _get_level($id, $array = [], $i = 0) {
        if ($array[$id]['pid'] == 0 || empty($array[$array[$id]['pid']]) || $array[$id]['pid'] == $id) {
            return $i;
        } else {
            $i++;
            return $this->_get_level($array[$id]['pid'], $array, $i);
        }
    }
    /**
     * @title 添加
     */
    public function menu_add($pid = 0) {
        if (request()->isPost()) {
            $post = request()->post();
            if (empty($post['name'])) {
                $this->error('标题不能为空');
            }
            $insert_id = $this->m_system_menu->allowField(true)->save($post);
            if (false !== $insert_id) {
                $this->success("", url('menu'));
            } else {
                $this->error($this->m_system_menu->getError());
            }
        } else {
            builder('form')
                    ->addItem('pid', 'select', '上级', $this->m_system_menu->lists_select_tree())
                    ->addItem('name', 'input', '名称<font color="red">*</font>', '', '')
                    ->addItem('url', 'input', 'URL')
                    ->addItem('icon', 'input', '图标', '', '', '', '<a href="http://www.thinkcmf.com/font/icons#new" target="_blank">参照网址</a>')
                    ->addItem('status', 'radio', '状态', [0 => '隐藏', 1 => '显示'])
                    ->addItem('sort', 'input', '排序')
                    ->build();
            return view();
        }
    }
    /**
     * @title 编辑菜单
     */
    public function menu_edit($id) {
        empty($id) && $this->error('参数不能为空');
        if (request()->isPost()) {
            $post = request()->post();
            if (empty($post['name'])) {
                $this->error('标题不能为空');
            }
            $affect_rows = $this->m_system_menu->allowField(true)->save($post, ['id' => $post['id']]);
            if (0 == $affect_rows) {
                $this->error('你没有做任何更改');
            } elseif (false !== $affect_rows) {
                $this->success("", url('menu'));
            } else {
                $this->error($this->m_system_menu->getError());
            }
        } else {
            $one = db('system_menu')->where('id', $id)->find();
            builder('form')
                    ->addItem('pid', 'select', '上级', $this->m_system_menu->lists_select_tree())
                    ->addItem('name', 'input', '名称<font color="red">*</font>', '', '')
                    ->addItem('url', 'input', 'URL')
                    ->addItem('icon', 'input', '图标', '', '', '', '<a href="http://www.thinkcmf.com/font/icons#new" target="_blank">参照网址</a>')
                    ->addItem('status', 'radio', '状态', [0 => '隐藏', 1 => '显示'])
                    ->addItem('sort', 'input', '排序')
                    ->build($one);
            return view();
        }
    }
    /**
     * @title 删除菜单
     */
    public function menu_delete($id) {
        empty($id) && $this->error('参数不能为空');
        $count = db('system_menu')->where('pid', '=', $id)->count();
        if ($count > 0) {
            $this->error("该菜单下还有子菜单，无法删除！");
        }
        if (db('system_menu')->delete($id) !== false) {
            $this->success("");
        } else {
            $this->error("删除失败！");
        }
    }
    /**
     * @title 配置列表
     */
    public function config() {
        $base_dir = APP_DIR . '/../application/extra/';
        if (request()->isPost()) {
            $cfg_name = input('post.cfg_name');
            $cfg_name_root = $base_dir . $cfg_name;
            if (is_file($cfg_name_root)) {
                $cfg_cnt = input('post.cfg_cnt');
                $cfg_cnt = htmlspecialchars_decode($cfg_cnt);
                /*  【直接保存到文件】  */
                $check = file_put_contents($cfg_name_root, $cfg_cnt);
                if ($check > 0) {
                    Cache::rm('CACHE_CONFIG_DATA');
                    $this->success("保存成功，共写入字节数：" . $check);
                } else {
                    $this->error("内容为空");
                }
            } else {
                $this->error("请选择一个有效模板文件");
            }
        } else {
            $file_list = my_scan_dir($base_dir . "*.php");
            $navs = [];
            /*  【通过文件名，依次解析title】  */
            foreach ($file_list as $key => $value) {
                $content = file_get_contents($base_dir . $value);
                $array = parse_config_tit($content);
                if ($array) {
                    $navs[$value] = $array;
                } else {
                    $navs[$value] = str_replace('.php', '', $value);
                }
            }
            $this->assign('navs', $navs);
            /*  【当前的配置文件名称】  */
            $cfg_name = input('get.cfg_name', 'base.php');
            $this->assign('cfg_name', $cfg_name);
            /*  【通过当前name获取配置文件的内容】  */
            $file_cnt = file_get_contents($base_dir . $cfg_name);
            $this->assign('file_cnt', $file_cnt);
            return view();
        }
    }
}
