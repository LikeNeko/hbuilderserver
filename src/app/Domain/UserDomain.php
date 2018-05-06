<?php

namespace App\Domain;

use function App\encode_pwd;

use App\Model\User as UserCURD;
use PhalApi\Exception\BadRequestException;

class UserDomain
{

    /**
     * @desc 设置一个用户
     *
     * @param $account 用户名
     * @param $pwd     密码
     * @param $email   邮件
     * @param $uuid    设备唯一id
     *
     * @return bool
     */
    public function setUser ($account, $pwd, $email, $uuid)
    {
        $curd = new UserCURD();
        $user_status = $curd->getUserIsExist($uuid);

        if ( $user_status[ 'id' ] ) {
            throw new BadRequestException("该手机已经注册过账号了！", 1);
        }
        encode_pwd($pwd,$uuid);
        $ret = $curd->insert([
            "account" => $account,
            "passwd"  => $pwd,
            "email"   => $email,
            'uuid'    => $uuid,
            "crtime"  => date(DATE_W3C),
        ]);

        if ( $ret ) {
            return $ret;
        } else {
            throw new BadRequestException("注册失败请重试！", 2);;
        }
    }
}