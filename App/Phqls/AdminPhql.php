<?php

/**
 * Description of AdminPhql
 * Admin 模型,自定义查询语句
 * @author Gavin
 * @version 2018-01-10 09:57:32
 */
namespace App\Phqls;
class AdminPhql extends BasePhql {
    //put your code here
    public function initialize($table = ""){
        parent::initialize();
    }
    
    public function getAdminList( ){
        $phql = "SELECT ad.id as id, ad.username,ad.password,adi.name,adi.age,ad.create_time "
        . "FROM App\Modules\Admin ad " 
        . "LEFT JOIN App\Modules\AdminInfo adi ON adi.admin_id = ad.id";
        $result = $this->execute->modelsManager->executeQuery($phql);
        return $result;
    }
}
