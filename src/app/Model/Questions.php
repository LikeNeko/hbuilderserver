<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class Questions extends NotORM {
    public function randTen ()
    {
        $quest = $this->getORM();
        $data = $quest->select('id,title,`key`')->order("rand(),id")->limit(15);

        $dataInfo = $data->fetchAll();
        foreach ( $dataInfo as $key=>$datum ) {
            $dataInfo[$key]['title_num'] = $key + 1;
        }
        return $dataInfo;
    }
}