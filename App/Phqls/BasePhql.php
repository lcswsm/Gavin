<?php

/**
 * Description of AdminPhql
 * PHQL 通用层,自定义查询语句
 * @author Gavin
 * @version 2018-01-10 09:57:32
 */
namespace App\Phqls;
use App\Modules\BaseModule;
use App\Modules\Execute;
class BasePhql extends BaseModule {
    //put your code here
    public $tablePrefix;
    protected $execute;


    public function initialize ( $table = "" ){
        $this->execute = new Execute();
    }
}
