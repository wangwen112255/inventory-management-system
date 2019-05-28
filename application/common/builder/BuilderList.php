<?php

namespace app\common\builder;

/**
 * @title 列表构建器
 */
class BuilderList extends Builder {

    private $listItems = [];  // 列表项目
    private $actionItems = [
//       'edit'=> [
//            'title' => '编辑',
//            'href' => 'edit',
//            'icon' => '',
//            'class' => '',
//            'attr' => '',
//           
//        ],
//        'delete'=>[
//            'title' => '删除',
//            'href' => 'delete',
//            'icon' => '',
//            'class' => 'ajax-get confirm layui-btn-danger',
//            'attr' => '',
//        ]
    ];  // 列表操作项目

    /**
     * 加入一个表单项
     * @param $name 名称
     * @param $title 表单标题
     * @param $type 表单显示的类型，默认一般都是p，有时候可能是image
     * @return $this
     */

    public function addItem($name, $title, $type = 'p') {
        $item = [
            'name' => $name,
            'title' => $title,
            'type' => $type,
        ];
        $this->listItems[$name] = $item;

        return $this;
    }
    
    
    /**
     * 加入一个表单项
     * @param $name 名称
     * @param $title 表单标题
     * @param $type 表单显示的类型，默认一般都是p，有时候可能是image
     * @return $this
     */
    public function addSortItem($name, $title, $table) {
        $item = [
            'name' => $name,
            'title' => $title,
            'type' => 'input',
            'table' => $table,
        ];
        $this->listItems[$name] = $item;

        return $this;
    }

    /**
     * @title 表格的操作
     * @param $title 标题     
     * @param $href 链接
     * @param $icon 图标
     * @param $class 类
     * @param $attr 额外属性
     * @return $this
     */
    public function addAction($title, $href = '', $icon = '', $class = '', $attr = '') {

        $item = [
            'title' => $title,
            'href' => $href,
            'icon' => $icon,
            'class' => $class,
            'attr' => $attr,
        ];

        $this->actionItems[$href] = $item;

        return $this;
    }

    /**
     * @title 数据替换
     */
    public function build() {

        $template_val = [
            'table_datas' => $this->listItems,
            'table_actions' => $this->actionItems,
        ];

        $this->assign($template_val);

        $field_template = '../application/common/view/list.' . config('template.view_suffix');

        $this->assign('tpl_list', parent::fetch($field_template));
    }

}
