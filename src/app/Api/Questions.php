<?php
namespace App\Api;

use PhalApi\Api;
use PhalApi\Exception\BadRequestException;


/**
 * 注册问题模块
 * Class Questions
 * @author Neko
 */
class Questions extends Api {

    /**
     * @desc 获取随机失调题目
     * @return array
     */
    public function GetQuestion() {
        $model = new \App\Domain\QuestionsCURD();
        $rows = $model->randTen();

        return array('rows'=>$rows);
    }

    /**
     * @desc 将用户的答案入库
     */
    public function SetReply()
    {
        $tmp = $_POST;
		$model = new \App\Domain\QuestionsCURD();

		$data = $tmp['reply'];

		if($tmp['uuid'] && $tmp['reply']){
			return $model->setReply($data,$tmp);
		}else{
			throw new BadRequestException('uuid and reply error' ,1);
		}

    }
}