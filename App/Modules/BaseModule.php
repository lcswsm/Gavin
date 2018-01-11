<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
/**
 * Description of BaseModule
 *
 * @author Admin
 */
class BaseModule extends Model {
    //put your code here
    
    protected $transection;
    protected $manager;
    protected $exception;
    public $tablePrefix;


    public function initialize ( $table = "" ){
        $this->manager = new TxManager();
        $this->tablePrefix = $this->getDI()->get('config')->database->prefix;
        if(!empty($table)){
            $this->setDbSource( $table );
        }
    }
    
    //开启事务
    public function trans_start (){
        $this->transection = $this->manager->get();
    }
    
    //提交事务
    public function trans_commit(){
        $this->transection->commit();
    }
    
    //回滚事务
    public function trans_rollback(){
        $this->transection->rollback();
    }
    
    public function setDbSource( $table ) {
       $this->setSource( $this->tablePrefix . $table );
    }
}
