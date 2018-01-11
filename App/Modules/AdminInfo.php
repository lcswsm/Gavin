<?php

/**
 * Description of Admin
 * 管理员表模型
 * @author Admin
 */
namespace App\Modules;

class AdminInfo extends BaseModule {
    //初始化模型 admin表
    /**
     * 定义表结构
     */
    protected $id;
    protected $admin_id;
    protected $name;
    protected $age;
    
    public function initialize($table = ""){
        parent::initialize("admin_info");
    }
}
