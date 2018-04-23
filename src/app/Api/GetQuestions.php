<?php
namespace App\Api;

use PhalApi\Api;
use PhalApi\Exception\BadRequestException;


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
        $tmp = $_POST;
		$model = new \App\Model\Userreply();

		$data = $tmp['reply'];
		$setdata = [];
		if($tmp['uuid'] && $tmp['reply']){
			foreach ($data as $key=>$v){
				array_push($setdata, [
					"uuid"=>$tmp['uuid'],
					'question_id'=>$v['id'],
					'reply'=>$v['key'],
					'crtime'=>time()
				]);

			}
			
			$info  = $model->setReply($setdata);
			switch($info){
				case 15:
					return array('status'=>'success');
				case 3:
					throw new BadRequestException('已经提交过了！',3);
			}
			throw  new BadRequestException('reply num is error',2);
		}else{
			throw new BadRequestException('uuid and reply error' ,1);
		}

    }
}