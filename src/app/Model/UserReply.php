<?php
namespace App\Model;

use PhalApi\Exception\BadRequestException;
use PhalApi\Model\NotORMModel as NotORM;

class UserReply extends NotORM {

	/**
	 * 回复表
	 * @param $data
	 */
	public function setReply($data)
	{
	    return 1;
		$check = $this->getORM()->where(['uuid'=>$data[0]['uuid']])->fetchOne();
		if(!$check){
			$data = $this->getORM()->insert_multi($data);
			return $data;
		}else{
			return 3;//已经存在
		}

	}
}