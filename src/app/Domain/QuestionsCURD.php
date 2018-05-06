<?php

namespace App\Domain;

use  App\Model\Questions as QuestionCURD;
use  App\Model\UserReply as UserReplyCURD;

class QuestionsCURD
{

    /**
     * 获取随机的十条数据
     * @return mixed
     */
    public function randTen ()
    {
        $curd = new QuestionCURD();

        return $curd->randTen();
    }

    public function setReply ($data, $tmp)
    {
        $curd = new UserReplyCURD();
        if(is_array($data)){
            $setdata = [];
            foreach ( $data as $key => $v ) {
                array_push($setdata, [
                    "uuid"        => $tmp[ 'uuid' ],
                    'question_id' => $v[ 'id' ],
                    'reply'       => $v[ 'key' ],
                    'crtime'      => time(),
                ]);

            }

            $info = $curd->setReply($setdata);
            switch ( $info ) {
                case 15:
                    return ['status' => 'success'];
                case 3:
                    throw new BadRequestException('已经提交过了！', 3);
            }
        }else{
            throw  new BadRequestException('reply num is error', 2);
        }


    }

}