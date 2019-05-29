<?php

namespace app\common\model;

use app\common\model\Base;

class Operate extends Base {

    private $rule;

    public function __construct($data = array()) {
        parent::__construct($data);
        $this->rule = [
            'type' => 'mod', // 分表方式
            'num' => 10     // 分表数量
        ];
    }

    public function clear() {
        $this->partition(['u_id' => UID], "u_id", $this->rule);
        return $this->where('u_id', UID)->delete();
    }

    public function add($title, $status, $uid = NULL, $message = '') {
        if (empty($uid)) {
            $uid = UID;
        }
        $data['log'] = $message;
        $data['u_id'] = $uid;
        $data['create_time'] = time();
        $data['title'] = $title;
        $data['status'] = (int) $status;
        $data['ip'] = request()->ip();
        $data['country'] = '';
        $data['client'] = request()->isMobile() ? 'mobile' : 'pc';
        $data['area'] = '';
        $data['url'] = request()->url();
        $data['data'] = serialize($_POST);
        $this->partition(['u_id' => $data['u_id']], "u_id", $this->rule);
        $this->allowField(true)->save($data);
    }

    public function success($title, $uid = NULL) {
        $this->add($title, 1, $uid);
    }

    public function failure($title, $uid = NULL, $message='') {
        $this->add($title, 0, $uid, $message);
    }

    public function model_where($uid = NULL) {

        if (request()->get('timea'))
            $this->where('a.create_time', '>=', strtotime(request()->get('timea') . ' 00:00:00'));
        if (request()->get('timeb'))
            $this->where('a.create_time', '<=', strtotime(request()->get('timeb') . ' 23:59:59'));

        if (empty($uid)) {
            if (!empty($_GET['staff_uid']) && is_numeric($_GET['staff_uid']))
                $uid = $_GET['staff_uid'];
            else
                $uid = UID;
        }

        $this->where('a.u_id', $uid);

        if (is_numeric(request()->get('status')))
            $this->where('a.status', request()->get('status'));
        if (request()->get('keyword'))
            $this->where('title|ip|country', 'like', '%' . request()->get('keyword') . '%');


        $this->field('a.*,su.nickname')->join('system_user su', 'a.u_id=su.id', 'LEFT');

        $this->partition(['u_id' => $uid], "u_id", $this->rule);

        $this->order('a.id desc');
        $this->alias('a');
        return $this;
    }

}
