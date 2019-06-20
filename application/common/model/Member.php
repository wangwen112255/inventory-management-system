<?php

namespace app\common\model;

use app\common\model\Base;

class Member extends Base {

    public function getSexAttr($value) {
        $sexs = [1 => '男', 2 => '女'];
        return isset($sexs[$value]) ? $sexs[$value] : '';
    }

    /**
     * 增加积分
     */
    public function increase($member_id, $points, $title, $m_id) {
        $this->where('id', $member_id);
        $this->inc('points', $points);
        if ($this->update()) {
            $data['u_id'] = UID;
            $data['member'] = $member_id;
            $data['type'] = 1;
            $data['title'] = $title;
            $data['value'] = $points;
            $data['create_time'] = time();
            return db('member_points')->insert($data);
        } else {
            return false;
        }
    }

    /**
     * 减少积分
     */
    public function reduce($member_id, $points, $title, $m_id) {
        $this->where('id', $member_id);
        $this->dec('points', $points);
        if ($this->update()) {
            $data['u_id'] = UID;
            $data['member'] = $member_id;
            $data['type'] = 0;
            $data['title'] = $title;
            $data['value'] = $points;
            $data['create_time'] = time();
            return db('member_points')->insert($data);
        } else {
            return false;
        }
    }

    public function json() {

        if (request()->get('keyword')) {
            $this->where('py.py|card|nickname', 'like', '%' . request()->get('keyword') . '%');
        }

        $this->join('pinyin py', 'CONV(HEX(LEFT(CONVERT(nickname USING GBK),1)),16,10) BETWEEN py.begin AND py.end', 'LEFT');

        $lists = $this->alias('a')->field('a.id,a.nickname as label')->join('member_group c', 'a.g_id=c.id', 'LEFT')->limit(10)->select();

        return json_encode($lists);
    }

    public function model_where() {


        if (request()->get('g_id'))
            $this->where('a.g_id', request()->get('g_id'));
        if (request()->get('keyword'))
            $this->where('a.nickname', 'like', '%' . request()->get('keyword') . '%');


        $this->order('a.id desc');

        $this->join('member_group c', 'a.g_id=c.id', 'LEFT');
        $this->join('system_user s', 'a.u_id=s.id', 'LEFT');
        $this->join('system_user s2', 'a.update=s2.id', 'LEFT');

        $this->field('a.*,'
                . 's.nickname as s_nickname,'
                . 's2.nickname as u_nickname,'
                . 'c.name as group_name');
        $this->alias('a');
        return $this;
    }

}
