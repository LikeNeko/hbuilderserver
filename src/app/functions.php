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
    $key = "nekomiao";
    $json_en_data = json_encode([$key,$pwd,$uuid]);
    $json_en_data = base64_encode($json_en_data);
    $pwd = md5($json_en_data);
}