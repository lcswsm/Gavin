<?php

/**
 * Description of Admin
 * 管理员表模型
 * @author Admin
 */
namespace App\Modules;

class Admin extends BaseModule {
    //初始化模型 admin表
    /**
     * 定义表结构
     */
    protected $id;
    protected $username;
    protected $password;
    protected $create_time;
    
    public function initialize($table = ""){
        parent::initialize("admin");
    }
}
