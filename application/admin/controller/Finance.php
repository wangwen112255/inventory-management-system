<?php

namespace app\admin\controller;

use app\admin\controller\Admin;

/**
 * @title 财务
 */
class Finance extends Admin {

    /**
     * @title 银行管理
     */
    public function bank() {


        $lists = $this->m_finance_bank->model_where()->select();


        $sum = 0;
        foreach ($lists as $key => $value) {
            $sum += $value['money'];
        }

        $this->assign('lists', $lists);
        $this->assign('sum', $sum);



        builder('list')
                ->addItem('id', '#')
                ->addItem('name', '名称')
                ->addItem('money', '金额')
                ->addItem('remark', '备注')
                ->addItem('default', '默认')
                ->addSortItem('sort', '排序', 'finance_bank')
                ->addAction('编辑', 'bank_edit', '<i class="fa fa-edit"></i>')
                ->addAction('删除', 'bank_delete', '<i class="fa fa-remove"></i>', 'ajax-get confirm')
                ->build();


        return view();
    }

    /**
     * @title 新增银行
     */
    public function bank_add() {
        if (request()->isPost()) {
            $post = request()->post();


            $data['name'] = request()->post('name');
            $data['money'] = request()->post('money') ?: 0;
            $data['remark'] = request()->post('remark');
            $data['default'] = request()->post('default') ? 1 : 0;


            if (!$this->v_finance_bank->check($post))
                $this->error($this->v_finance_bank->getError());

            if (!empty($data['default']))
                db('finance_bank')->where('1=1')->update(['default' => 0]);

            if (db('finance_bank')->insert($data)) {
                $this->m_operate->success('新增银行');
                $this->success('', url('bank'));
            } else {
                $this->m_operate->failure('新增银行');
                $this->error('新增失败');
            }
        } else {


            builder('form')
                    ->addItem('name', 'input', '名称<font color="red">*</font>', '', '')
                    ->addItem('money', 'input', '金额')
                    ->addItem('remark', 'textarea', '备注')
                    ->addItem('default', 'checkbox', '', [1 => '默认'])
                    ->build();

            return view();
        }
    }

    /**
     * @title 删除银行
     */
    public function bank_delete($id) {

        empty($id) && $this->error('参数不能为空');


        if (db('finance_bank')->where('id', $id)->delete()) {
            $this->m_operate->success('删除银行');
            $this->success('', url('bank'));
        } else {
            $this->m_operate->failure('删除银行');
            $this->error('删除失败', url('bank'));
        }
    }

    /**
     * @title 修改银行
     */
    public function bank_edit($id) {


        empty($id) && $this->error('参数不能为空');

        if (request()->isPost()) {
            $post = request()->post();

            if (!$this->v_finance_bank->check($post))
                $this->error($this->v_finance_bank->getError());


            $data['name'] = $post['name'];
            $data['remark'] = $post['remark'];
            $data['money'] = $post['money'];
            $data['default'] = request()->post('default') ? 1 : 0;
            $money = request()->post('money') ?: 0;


            if (!empty($data['default']))
                db('finance_bank')->where('1=1')->update(['default' => 0]);

            if (db('finance_bank')->where('id', request()->post('id'))->update($data) !== FALSE) {

                $this->m_operate->success('修改银行');
                $this->success('', url('bank'));
            } else {
                $this->m_operate->failure('修改银行');
                $this->error('没有任何修改');
            }
        } else {



            $one = db('finance_bank')->where('id', $id)->find();

            builder('form')
                    ->addItem('name', 'input', '名称<font color="red">*</font>', '', '')
                    ->addItem('money', 'input', '金额', '', '', '')
                    ->addItem('remark', 'textarea', '备注')
                    ->addItem('default', 'checkbox', '', [1 => '默认'])
                    ->build($one);


            return view();
        }
    }

    /**
     * @title 财务分类
     */
    public function category() {


        $lists = $this->m_finance_category->lists_tree();


        foreach ($lists as $key => $value) {
            $lists[$key]['type'] = $value['type'] ? '收入' : '支出';
        }

        $this->assign('lists', $lists);


        builder('list')
                ->addItem('id', '#')
                ->addItem('name', '名称')
                ->addItem('type', '类型')
                ->addSortItem('sort', '排序', 'finance_category')
                ->addAction('编辑', 'category_edit', '<i class="fa fa-edit"></i>')
                ->addAction('删除', 'category_delete', '<i class="fa fa-remove"></i>', 'ajax-get confirm')
                ->build();

        return view();
    }

    /**
     * @title 新增财务分类
     */
    public function category_add() {


        if (request()->isPost()) {
            $post = request()->post();

            if (!$this->v_finance_category->check($post))
                $this->error($this->v_finance_category->getError());


            $data['pid'] = request()->post('pid') ?: 0;
            $data['type'] = request()->post('type') ? 1 : 0;
            $data['name'] = request()->post('name');


            if (db('finance_category')->insert($data)) {
                $this->m_operate->success('新增财务分类');
                $this->success('', url('category'));
            } else {
                $this->m_operate->failure('新增财务分类');
                $this->error('新增失败');
            }
        } else {


            $type = input('get.type', 0);

            builder('form')
                    ->addItem('pid', 'select', '目录', $this->m_finance_category->lists_select_tree(), '')
                    ->addItem('name', 'input', '分类名称<font color="red">*</font>')
                    ->addItem('type', 'hidden', '类别', $type)
                    ->build();


            return view();
        }
    }

    /**
     * @title 财务银行分类
     */
    public function category_delete($id) {

        empty($id) && $this->error('参数不能为空');

        if (db('finance_category')->where('id', $id)->delete()) {
            $this->m_operate->success('删除账务分类');
            $this->success('', url('category'));
        } else {
            $this->m_operate->failure('删除账务分类');
            $this->error('删除失败', url('category'));
        }
    }

    /**
     * @title 修改财务分类
     */
    public function category_edit($id) {
        empty($id) && $this->error('参数不能为空');

        if (request()->isPost()) {
            $post = request()->post();

            if (!$this->v_finance_category->check($post))
                $this->error($this->v_finance_category->getError());

            $data['pid'] = request()->post('pid') ?: 0;
            $data['type'] = request()->post('type') ? 1 : 0;
            $data['name'] = request()->post('name');



            if (db('finance_category')->where('id', request()->post('id'))->update($data) !== FALSE) {
                $this->m_operate->success('修改银行分类');
                $this->success('', url('category'));
            } else {
                $this->m_operate->failure('修改银行分类');
                $this->error('没有任何修改');
            }
        } else {


            $one = db('finance_category')->where('id', $id)->find();

            builder('form')
                    ->addItem('pid', 'select', '目录', $this->m_finance_category->lists_select_tree(), '')
                    ->addItem('name', 'input', '分类名称<font color="red">*</font>')
                    ->build($one);

            return view();
        }
    }

    /**
     * @title 新增财务
     */
    public function add() {


        if (request()->isPost()) {

            if (!$this->v_finance_accounts->check(request()->post()))
                $this->error($this->v_finance_accounts->getError());

            $data['u_id'] = UID;
            $data['type'] = (int) request()->post('type');
            $data['c_id'] = request()->post('c_id');
            $data['bank_id'] = request()->post('bank_id');
            $data['money'] = abs(request()->post('money'));
            $data['datetime'] = request()->post('datetime') ? strtotime(request()->post('datetime')) : time();
            $data['attn_id'] = request()->post('attn_id') ?: UID;
            $data['remark'] = request()->post('remark');
            $data['create_time'] = time();

            if (empty($data['type'])) {
                $var = $this->m_finance_bank->find($data['bank_id']);
                if (!empty($var['id']) && $var['money'] < $data['money'])
                    $this->error('当前银行金额不足:' . $data['money'] . ' 无法支出');
            }


            if (db('finance_accounts')->insert($data)) {

                empty($data['type']) ? $this->m_finance_bank->expenditure($data['money'], $data['bank_id']) : $this->m_finance_bank->income($data['money'], $data['bank_id']);


                $this->m_operate->success('新增账务');
                $this->success('', url('query'));
            } else {
                $this->m_operate->failure('新增账务');
                $this->error('新增失败');
            }
        } else {





            builder('form')
                    ->addItem('bank_id', 'select', '银行', $this->m_finance_bank->model_where()->lists_select('id,name'))
                    ->addItem('money', 'input', '金额')
                    ->addItem('datetime', 'datetime', '日期')
                    ->addItem('attn_id', 'select', '经办人', $this->m_system_user->model_where()->lists_select('id,nickname'))
                    ->addItem('remark', 'textarea', '备注')
                    ->build();


            return view();
        }
    }

    /**
     * @title 账务查询
     */
    public function query() {

        if (!isset($_GET['timea']))
            $_GET['timea'] = date("Y-m-d", strtotime("-30 day"));
        if (!isset($_GET['timeb']))
            $_GET['timeb'] = date('Y-m-d');

        $this->assign('revenue', $this->m_finance_accounts->model_where()->where('a.type', 1)->sum('a.money'));
        $this->assign('expenditure', $this->m_finance_accounts->model_where()->where('a.type', 0)->sum('a.money'));


        //如果export这个参数=1，则直接进行数据导出
        $export = input('get.export', 0);
        if ($export) {
            $lists = $this->m_finance_accounts->model_where()->group('a.id')->select();
            $this->m_excel->finance_export($lists);
            exit();
        }


        $this->assign('count', $count = $this->m_finance_accounts->model_where()->count('distinct a.id'));
        $lists = $this->m_finance_accounts->model_where()->group('a.id')->paginate(config('base.page_size'), $count, ['query' => request()->get()])->each(function($item, $key) {
            $item->datetime = date('Y-m-d H:i', $item['datetime']);
            if ($item['type'])
                $item->type_inc = '+' . $item['money'];
            else
                $item->type_dec = '<span style="color:#f18130"> - ' . $item['money'] . '</span>';
        });
        $this->assign('lists', $lists);
        $this->assign('pages', $lists->render());


        builder('list')
                ->addItem('c_name', '分类')
                ->addItem('type_inc', '收入')
                ->addItem('type_dec', '支出')
                ->addItem('bank', '银行')
                ->addItem('nickname_attn', '经办人')
                ->addItem('datetime', '经办日期')
                ->addItem('nickname', '创建人')
                ->addItem('create_time', '创建日期')
                ->addItem('remark', '备注')
                ->addAction('撤消', 'finance/query_delete', '<i class="fa fa-reply-all"></i>', 'ajax-get confirm')
                ->build();

        return view();
    }

    /**
     * @title 撤销账单
     */
    public function query_delete($id) {

        empty($id) && $this->error('参数不能为空');

        $message = $this->m_finance_accounts->query_delete($id);
        if ($message) {
            $this->m_operate->failure('撤销账单');
            $this->error($message);
        } else {
            $this->m_operate->success('撤销账单');
            $this->success('撤销账单');
        }
    }

}
