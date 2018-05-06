<?php

namespace App\Api;

use PhalApi\Api;
use PhalApi\Exception\BadRequestException;

/**
 * 用户处理模块
 * Class User
 * @author Neko
 */
class User extends Api
{

    public function getRules ()
    {
        return [
            "SetUser" => [
                "account"  => ['name' => "account", 'require' => true, 'source' => "post", "min" => 6, "max" => 10],
                "password" => ["name" => "password", 'require' => true, 'source' => "post", "min" => 8, "max" => 16],
                "uuid"     => ["name" => "uuid", 'require' => true, 'source' => "post", "min" => 1],
                "email"    => [
                    "name"    => "email",
                    'regex'   => "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",
                    'require' => true,
                    'source'  => "post",
                ],
                // 获取HTTP请求方法，判断是POST还是GET
                'method'   => ['name' => 'REQUEST_METHOD', 'source' => 'server'],
            ],
            "Login" => [
                "account"  => ['name' => "account", 'require' => true, 'source' => "post", "min" => 6, "max" => 10],
                "password" => ["name" => "password", 'require' => true, 'source' => "post", "min" => 8, "max" => 16],
                "uuid"     => ["name" => "uuid", 'require' => true, 'source' => "post", "min" => 1],
                // 获取HTTP请求方法，判断是POST还是GET
                'method'   => ['name' => 'REQUEST_METHOD', 'source' => 'server'],
            ],
        ];
    }


    /**
     * @desc 设置一个用户
     * @return array
     */
    public function SetUser ()
    {
        $userDomain = new \App\Domain\UserDomain();

        $data = $userDomain->setUser($this->account, $this->password, $this->email, $this->uuid);

        return ['uid' => $data['uid'],"token"=>$data['token']];
    }

    /**
     * @desc 登陆操作
     */
    public function Login ()
    {
        $userDomain = new \App\Domain\UserDomain();
        return $userDomain->Login($this->account,$this->password,$this->uuid);
    }

}