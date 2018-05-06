<?php

namespace App\Domain;

use function App\encode_pwd;

use function App\getToken;
use App\Model\User as UserCURD;

use App\Model\UserReply;
use App\Model\UserRongyun as RongyunCURD;
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
        $rydb = new RongyunCURD();


        $user_status = $curd->getUserIsExist($uuid);
        if ( $user_status ) {
            if ( empty($user_status[ 'token' ]) ) {

                $t = getToken($user_status[ 'id' ]);
                $rydb->insert([
                    'uid'    => $user_status[ 'id' ],
                    "token"  => $t->token,
                    "crtime" => date(DATE_W3C),
                    'status' => "true",
                ]);
                throw new BadRequestException("该手机已经注册过账号了！但token绑定成功！", 1);
            } else if ( $user_status[ 'id' ] ) {
                throw new BadRequestException("该手机已经注册过账号了！", 2);
            }
        }

        // 加密密码
        encode_pwd($pwd, $uuid);


        $ret = $curd->insert([
            "account" => $account,
            "passwd"  => $pwd,
            "email"   => $email,
            'uuid'    => $uuid,
            "crtime"  => date(DATE_W3C),
            "status"  => "true",
        ]);

        if ( $ret ) {
            $t = getToken($ret);
            if ( $t->token ) {

                $rydb->insert([
                    'uid'    => $ret,
                    "token"  => $t->token,
                    "crtime" => date(DATE_W3C),
                    'status' => "true",
                ]);

                return ["uid" => $ret, 'token' => $t->token];
            } else {
                throw new BadRequestException("融云token获取失败请重试！", 3);;
            }


        } else {
            throw new BadRequestException("注册失败请重试！", 2);;
        }
    }

    /**
     * @desc 登陆
     *
     * @param $account
     * @param $pwd
     * @param $uuid
     *
     * @return mixed
     */
    public function Login ($account, $pwd, $uuid)
    {
        $curd = new UserCURD();

        encode_pwd($pwd, $uuid);

        $data = $curd->getUserInfo($account, $pwd);

        if ( $data ) {
            $lastdata = [
                'lasttime' => date(DATE_W3C),
                'lastip' => $_SERVER[ 'REMOTE_ADDR' ]
            ];
            $curd->setLoginLast($data['id'],$lastdata);

            $data['uid'] = $data['id'];
            unset($data['id']);
            return $data;
        } else {
            throw  new BadRequestException('登陆失败！账号或密码错误！', 1);
        }
    }

}