<?php
namespace App;

function hello() {
    return 'Hey, man~';
}

/**
 * @desc 账号密码加密算法
 *
 * @param $pwd
 * @param $uuid
 */
function encode_pwd(&$pwd,$uuid){
    $key = \PhalApi\DI()->config->get('sys.rongyun.secret');
    $json_en_data = json_encode([$key,$pwd,$uuid]);
    $json_en_data = base64_encode($json_en_data);
    $pwd = md5($json_en_data);
}

/**
 * @desc 获取token
 *
 * @param $uid
 * @param string $name
 * @param string $headurl
 *
 * @return mixed
 */
function getToken ($uid,$name="小猫咪",$headurl="http://null")
{
    $key = \PhalApi\DI()->config->get('sys.rongyun.key');
    $secret = \PhalApi\DI()->config->get('sys.rongyun.secret');
    $ry = new Sdk\Rongyun\RongCloud($key,$secret);

    $token = $ry->User()->getToken($uid,$name, $headurl);

    return json_decode($token);
}