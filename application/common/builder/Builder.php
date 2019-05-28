<?php

namespace app\common\builder;

use app\common\controller\Base;

/**
 * @title 表单或表格构建
 */
class Builder extends Base {

    /**
     * @title 开启Builder
     * @param  string $type 构建器名称
     * @return [type]       [description]
     */
    public static function run($type = '') {
        if ($type == '') {
            throw new \Exception('未指定构建器', 100001);
        } else {
            $type = ucfirst(strtolower($type));
        }

        // 构造器类路径
        $class = '\\app\\common\\builder\\Builder' . $type;
        if (!class_exists($class)) {
            throw new \Exception($type . '构建器不存在', 100002);
        }

        return new $class;
    }

}
