<?php

namespace app\common\controller;

use think\Config;
use think\Controller;
use think\Loader;

/**
 * @title 基类
 */
class Base extends Controller {

    //当前请求的URL
    protected $url;
    //错误代码 
    //protected $message;
    //

    protected function _initialize() {

        parent::_initialize();
        //获取request信息
        $this->requestInfo();
        
        //load config
        $this->load_config();
    }

    public function __set($var, $value) {
        $this->assign($var, $value);
    }

    public function __get($name) {

        $substr = substr($name, 0, 2);

        switch (strtolower($substr)) {
            case 'm_':
                return Loader::model(substr($name, 2));
            case 'v_':
                return Loader::validate(substr($name, 2));
            //other
        }
    }
    
    
    /**
     * @title 加载配置
     */
    protected function load_config() {
        
            
        
        
        Config::has('base.page_size')?:Config::set('base.page_size', 10);
        
        
        //$base = Config::get('base');          
        //$this->assign('base', $base);      
       
        
        //$m_staff_arr = model('system_user')->where('status','1')->column('nickname', 'id');       
        //$this->assign('m_staff_arr', $m_staff_arr);        
        
        $this->assign('pinyin', array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z'));
        
    }



    /**
     * @title 定义一些系统需要用到的常量
     */
    protected function requestInfo() {


        defined('MODULE_NAME') or define('MODULE_NAME', $this->request->module());
        defined('CONTROLLER_NAME') or define('CONTROLLER_NAME', $this->request->controller());
        defined('ACTION_NAME') or define('ACTION_NAME', $this->request->action());


        //驼峰转小写
        $this->url = hump_to_underline(MODULE_NAME) . '/' . hump_to_underline(CONTROLLER_NAME) . '/' . hump_to_underline(ACTION_NAME);           
        
        
        
    }

}
