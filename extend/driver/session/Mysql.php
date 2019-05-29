<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: ziiber <ziiber@foxmail.com>	2016.09.24
// +----------------------------------------------------------------------

namespace driver\session;

use SessionHandler;
use think\Config;
use think\Db;
use think\Exception;

/**
 * 数据库方式Session驱动
 *    CREATE TABLE think_session (
 *      session_id varchar(255) NOT NULL,
 *      session_expire int(11) UNSIGNED NOT NULL,
 *      session_data blob,
 *      UNIQUE KEY `session_id` (`session_id`)
 *    );
 */
class Mysql extends SessionHandler {

    protected $handler = null;
    protected $table_name = null;
    protected $config = [
        'session_expire' => 3600, // Session有效期 单位：秒
        'session_prefix' => 'think_', // Session前缀
        'table_name' => 'session', // 表名（不包含表前缀）
    ];
    protected $database = [
        'type' => 'mysql', // 数据库类型
        'hostname' => '127.0.0.1', // 服务器地址
        'database' => 'db_pss', // 数据库名
        'username' => 'root', // 用户名
        'password' => 'nariims', // 密码
        'hostport' => '3306', // 端口
        'prefix' => 'tb_', // 表前缀
        'charset' => 'utf8', // 数据库编码
        'debug' => true, // 数据库调试模式
    ];

    public function __construct($config = []) {
        // 获取数据库配置
        if (isset($config['database']) && !empty($config['database'])) {
            if (is_array($config['database'])) {
                $database = $config['database'];
            } elseif (is_string($config['database'])) {
                $database = Config::get($config['database']);
            } else {
                throw new Exception('session error:database');
            }
            unset($config['database']);
        } else {
            // 使用默认的数据库配置
            $database = Config::get('database');
        }

        $this->config = array_merge($this->config, $config);
        $this->database = array_merge($this->database, $database);
    }

    /**
     * 打开Session
     * @access public
     * @param string $save_path
     * @param mixed  $session_name
     * @return bool
     * @throws Exception
     */
    public function open($save_path, $session_name) {
        // 判断数据库配置是否可用
        if (empty($this->database)) {
            throw new Exception('session error:database empty');
        }
        $this->handler = Db::connect($this->database);
        $this->table_name = $this->database['prefix'] . $this->config['table_name'];
        return true;
    }

    /**
     * 关闭Session
     * @access public
     */
    public function close() {
        $this->gc(ini_get('session.gc_maxlifetime'));
        $this->handler = null;
        return true;
    }

    /**
     * 读取Session
     * @access public
     * @param string $session_id
     * @return bool|string
     */
    public function read($session_id) {
        $where = [
            'session_id' => $this->config['session_prefix'] . $session_id,
            'session_expire' => time()
        ];
        $sql = 'SELECT session_data FROM ' . $this->table_name . ' WHERE session_id = :session_id AND session_expire > :session_expire';
        $result = $this->handler->query($sql, $where);
        if (!empty($result)) {
            return $result[0]['session_data'];
        }
        return '';
    }

    /**
     * 写入Session
     * @access public
     * @param string $session_id
     * @param String $session_data
     * @return bool
     */
    public function write($session_id, $session_data) {
        $params = [
            'session_id' => $this->config['session_prefix'] . $session_id,
            'session_expire' => $this->config['session_expire'] + time(),
            'session_data' => $session_data
        ];
        $sql = 'REPLACE INTO ' . $this->table_name . ' (session_id, session_expire, session_data) VALUES (:session_id, :session_expire, :session_data)';
        $result = $this->handler->execute($sql, $params);
        return $result ? true : false;
    }

    /**
     * 删除Session
     * @access public
     * @param string $session_id
     * @return bool|void
     */
    public function destroy($session_id) {
        $where = [
            'session_id' => $this->config['session_prefix'] . $session_id
        ];
        $sql = 'DELETE FROM ' . $this->table_name . ' WHERE session_id = :session_id';
        $result = $this->handler->execute($sql, $where);
        return $result ? true : false;
    }

    /**
     * Session 垃圾回收
     * @access public
     * @param string $sessMaxLifeTime
     * @return bool
     */
    public function gc($sessMaxLifeTime) {
        $where = [
            'session_expire' => time()
        ];
        $sql = 'DELETE FROM ' . $this->table_name . ' WHERE session_expire < :session_expire';
        return $this->handler->execute($sql, $where);
    }

}
