<?php

namespace app\admin\controller;

use app\admin\controller\Admin;
use FilesystemIterator;
use org\util\Database as DbTool;
use think\Db;
/**
 * @title 数据库
 */
class Database extends Admin {

    /**
     * @title 备份数据库
     */
    public function export($tables = null, $id = null, $start = null) {


        if (request()->isPost() && !empty($tables) && is_array($tables)) { //初始化
            // 
            //读取备份配置
            $config = [
                'path' => realpath(config('backup.DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR,
                'part' => config('backup.DATA_BACKUP_PART_SIZE'),
                'compress' => config('backup.DATA_BACKUP_COMPRESS'),
                'level' => config('backup.DATA_BACKUP_COMPRESS_LEVEL'),
            ];

            //检查是否有正在执行的任务
            $lock = "{$config['path']}backup.lock";
            if (is_file($lock)) {
                // $this->error('检测到有一个备份任务正在执行，请稍后再试！');
            } else {
                // 创建锁文件
                file_put_contents($lock, time());
            }

            //检查备份目录是否可写
            is_writeable($config['path']) || $this->error('备份目录不存在或不可写，请检查后重试！');

            session('backup_config', $config);

            //生成备份文件信息
            $file = [
                'name' => date('Ymd-His', time()),
                'part' => 1,
            ];
            session('backup_file', $file);

            //缓存要备份的表
            session('backup_tables', $tables);

            //创建备份文件
            $Database = new DbTool($file, $config);
            if (false !== $Database->create()) {
                $tab = ['id' => 0, 'start' => 0];
                $this->success('初始化成功！', '', ['tables' => $tables, 'tab' => $tab]);
            } else {
                $this->error('初始化失败，备份文件创建失败！');
            }
        } elseif (request()->isGet() && is_numeric($id) && is_numeric($start)) { //备份数据
            $tables = session('backup_tables');
            
            //备份指定表
            $Database = new DbTool(session('backup_file'), session('backup_config'));
            $start = $Database->backup($tables[$id], $start);
            if (false === $start) { //出错
                $this->error('备份出错！');
            } elseif (0 === $start) { //下一表
                if (isset($tables[++$id])) {
                    $tab = ['id' => $id, 'start' => 0];
                    $this->success('备份完成！', '', ['tab' => $tab]);
                } else { //备份完成，清空缓存
                    unlink(session('backup_config.path') . 'backup.lock');
                    session('backup_tables', null);
                    session('backup_file', null);
                    session('backup_config', null);
                    $this->success('备份完成！');
                }
            } else {
                $tab = ['id' => $id, 'start' => $start[0]];
                $rate = floor(100 * ($start[0] / $start[1]));
                $this->success("正在备份...({$rate}%)", '', ['tab' => $tab]);
            }
        } else { //出错
            $this->error('ERROR');
        }
    }

    /**
     * @title 还原列表
     */
    function import_list() {

        //列出备份文件列表
        $path = realpath(config('backup.DATA_BACKUP_PATH'));
        $flag = FilesystemIterator::KEY_AS_FILENAME;
        $glob = new FilesystemIterator($path, $flag);

        $lists = [];
        foreach ($glob as $name => $file) {
            if (preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)) {
                $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');

                $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                $part = $name[6];

                if (isset($lists["{$date} {$time}"])) {
                    $info = $lists["{$date} {$time}"];
                    $info['part'] = max($info['part'], $part);
                    $info['size'] = $info['size'] + $file->getSize();
                } else {
                    $info['part'] = $part;
                    $info['size'] = $file->getSize();
                }
                $extension = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                $info['compress'] = ($extension === 'SQL') ? '-' : $extension;
                $info['time'] = strtotime("{$date} {$time}");

                $lists["{$date} {$time}"] = $info;
            }
        }


        ksort($lists);

        $this->assign('lists', $lists);

        return view();
    }

    /**
     * @title 备份列表
     */
    public function export_list() {

        //$Db    = Db::getInstance();
        $lists = Db::query('SHOW TABLE STATUS');
        $lists = array_map('array_change_key_case', $lists);

        $this->assign('lists', $lists);
        return view();
    }

    /**
     * @title 优化表
     * @param  String $tables 表名

     */
    public function optimize($tables = null) {
        if ($tables) {
            //$Db   = Db::getInstance();			
            if (is_array($tables)) {
                $tables = implode('`,`', $tables);
                $lists = Db::query("OPTIMIZE TABLE `{$tables}`");

                if ($lists) {
                    $this->success("数据表优化完成！");
                } else {
                    $this->error("数据表优化出错请重试！");
                }
            } else {
                $lists = Db::query("OPTIMIZE TABLE `{$tables}`");
                if ($lists) {
                    $this->success("数据表'{$tables}'优化完成！");
                } else {
                    $this->error("数据表'{$tables}'优化出错请重试！");
                }
            }
        } else {
            $this->error("请指定要优化的表！");
        }
    }

    /**
     * @title 修复表
     * @param  String $tables 表名

     */
    public function repair($tables = null) {
        if ($tables) {
            // $Db   = Db::getInstance();
            if (is_array($tables)) {
                $tables = implode('`,`', $tables);
                $lists = Db::query("REPAIR TABLE `{$tables}`");

                if ($lists) {
                    $this->success("数据表修复完成！");
                } else {
                    $this->error("数据表修复出错请重试！");
                }
            } else {
                $lists = Db::query("REPAIR TABLE `{$tables}`");
                if ($lists) {
                    $this->success("数据表'{$tables}'修复完成！");
                } else {
                    $this->error("数据表'{$tables}'修复出错请重试！");
                }
            }
        } else {
            $this->error("请指定要修复的表！");
        }
    }

    /**
     * @title 删除备份文件
     */
    public function del($time = 0) {
        if ($time) {
            $name = date('Ymd-His', $time) . '-*.sql*';
            $path = realpath(config('backup.DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR . $name;
            array_map("unlink", glob($path));
            if (count(glob($path))) {
                $this->success('备份文件删除失败，请检查权限！');
            } else {
                $this->success('');
            }
        } else {
            $this->error('ERROR');
        }
    }

    /**
     * @title 还原数据库

     */
    public function import($time = 0, $part = null, $start = null) {

        //还原数据库的开始标志
        if (is_numeric($time) && is_null($part) && is_null($start)) { //初始化
            //获取备份文件信息
            $name = date('Ymd-His', $time) . '-*.sql*';
            $path = realpath(config('backup.DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR . $name;
            $files = glob($path);
            $lists = [];
            foreach ($files as $name) {
                $basename = basename($name);
                $match = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
                $gz = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
                $lists[$match[6]] = [$match[6], $name, $gz];
            }
            ksort($lists);

            //检测文件正确性
            $last = end($lists);
            if (count($lists) === $last[0]) {
                session('backup_list', $lists); //缓存备份列表
                $this->success('初始化完成！', '', ['part' => 1, 'start' => 0]);
            } else {
                $this->error('备份文件可能已经损坏，请检查！');
            }
        } elseif (is_numeric($part) && is_numeric($start)) {

            //用于对备份的数据进行恢复

            $lists = session('backup_list');

            $Db = new DbTool($lists[$part], [
                        'path' => realpath(config('backup.DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR,
                        'compress' => $lists[$part][2]
                    ]);

            $start = $Db->import($start);

            if (false === $start) {
                $this->error('还原数据出错！');
            } elseif (0 === $start) { //下一卷
                if (isset($lists[++$part])) {
                    $data = ['part' => $part, 'start' => 0];
                    $this->success("正在还原...#{$part}", '', $data);
                } else {
                    session('backup_list', null);
                    $this->success('还原完成！');
                }
            } else {
                $data = ['part' => $part, 'start' => $start[0]];
                if ($start[1]) {
                    $rate = floor(100 * ($start[0] / $start[1]));
                    $this->success("正在还原...#{$part} ({$rate}%)", '', $data);
                } else {
                    $data['gz'] = 1;
                    $this->success("正在还原...#{$part}", '', $data);
                }
            }
        } else {
            $this->error('ERROR');
        }
    }

}
