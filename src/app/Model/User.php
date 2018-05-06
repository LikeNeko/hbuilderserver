<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class User extends NotORM {
    public function getUserIsExist ($uuid)
    {
        return $this->getORM()
            ->select('id')
            ->where('uuid', $uuid)
            ->order('id DESC')
            ->fetchOne();
    }
}