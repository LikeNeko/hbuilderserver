<?php
namespace App\Api;

use PhalApi\Api;

class GetQuestions extends Api {

    /**
     * @desc 获取随机失调题目
     * @return array
     */
    public function Question() {
        $model = new \App\Model\Questions();
        $rows = $model->randTen();

        return array('rows'=>$rows);
    }

    /**
     * @desc 将用户的答案入库
     */
    public function SetReply()
    {
        $data = $_POST;
        $data = json_decode($data['data']);
		DI()->logger->error(json_encode($data));

        return array('info'=>(($data)));
    }
}