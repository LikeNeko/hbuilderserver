<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class UserRongyun extends NotORM {
    protected function getTableName($id) {
        return 'user_rongyun';
    }
}