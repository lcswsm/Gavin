<?php
/**
 * Description of AdminLogic
 * 业务逻辑层， admin 模块相关操作
 * @author Admin
 */
namespace App\Logics;
use App\Modules\Admin;
use App\Entity\Response;
class YarLogic extends BaseLogic {
    //put your code here

    public function __construct( ) {
        $this->module = new Admin();
        $this->phql   = new \App\Phqls\AdminPhql;
    }
    
    public function add ( $a, $b ) {
        return $a + $b;
    }
    
    public function getAdmin ( $id = "" ) {
        $structure = new Response\AdminResponse();
        if($id > 0){
            $result   = $this->module->find( "id=" . $id );  
        }else{
            $result   = $this->module->find();
        }
        if(empty($result->toArray())){
            return "没有查询到对应的数据";
        }
        return $this->getResponseArray($structure, $result->toArray());
    }
}
