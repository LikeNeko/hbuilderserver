<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class User extends NotORM {
    /**
     * @desc 查询用户是否存在,有没有token
     *
     * @param $uuid
     *
     * @return mixed
     */
    public function getUserIsExist ($uuid)
    {
        $sql = "select u.id,r.token from api_user as u  left join api_user_rongyun as r on r.uid=u.id where u.uuid=:uuid";
        $data=  $this->getORM()->queryAll($sql,[':uuid'=>$uuid]);
        return $data?$data[0]:$data;
    }

    /**
     * @desc 获取用户信息 ，能获取到则登陆成功
     *
     * @param $account
     * @param $pwd
     *
     * @return mixed
     */
    public function getUserInfo ($account,$pwd)
    {
        $sql = "select u.id,r.token,u.email,u.headimg,u.crtime,u.lastip,u.lasttime from api_user as u  left join api_user_rongyun as r on r.uid=u.id where u.account=:account and u.passwd=:passwd";
        $data=  $this->getORM()->queryAll($sql,[':account'=>$account,":passwd"=>$pwd]);
        return $data?$data[0]:$data;
    }

    /**
     * @desc 更新最后登陆时间，ip地址
     *
     * @param $uid
     * @param $data
     *
     * @return TRUE
     */
    public function setLoginLast ($uid, $data)
    {
        return $this->update($uid,$data);
    }
}