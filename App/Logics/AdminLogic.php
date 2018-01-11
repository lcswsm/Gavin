<?php
/**
 * Description of AdminLogic
 * 业务逻辑层， admin 模块相关操作
 * @author Admin
 */
namespace App\Logics;
use App\Modules\Admin;
class AdminLogic extends BaseLogic {
    //put your code here

    public function __construct( ) {
        $this->module = new Admin();
        $this->phql   = new \App\Phqls\AdminPhql;
    }
    
    /**
     * 添加
     */
    public function save ( $params ) {
        $this->module->username = $params->username;
        $this->module->password = $params->password;
        $this->module->create_time = date("Y-m-d H:i;s");
        try{
            $this->module->trans_start();
            $result = $this->module->save();
            if($result){
                $this->module->trans_commit();
                $this->response["respCode"] = true;
                $this->response["respCode"] = true;
                $this->setResponseBody(true, SUCCESS_INSERT);
                return $this->response;
            }else{
                
                $this->module->trans_rollback();
                foreach ($this->module->getMessages() as $message) {
                    echo $message->getMessage(), "<br/>";
                }
                $this->setResponseBody(false, ERROR_INSERT);
                return $this->response;
            }
        } catch (\Exception $e){
            $this->setResponseBody(false, ERROR_INSERT ." 错误原因：". $e->getMessage());
            return $this->response;
        }
    }
    
    /**
     * 获取admin list
     * @param object $structure 数据结构，返回数据的结构规则
     * @return object
     */
    
    public function getAdmin( $structure ){
        $result   = $this->phql->getAdminList();
        $this->currentPage = $structure->page;
        $page     = $this->getPaginator($result);
        $responseData = $page->getPaginate();
        $responseData->items = $this->getResponseArray($structure, $responseData->items);
        return $responseData;
    }
    
    /**
     * 删除admin
     */
    
    public function deleteAdmin ( $params ) {
        $data = $this->module->findFirst("id={$params->id}");
        if($data){
            $data->delete();
        }
        return true;
    }
    
    
    /**
     * 获取单个admin 信息
     * @param object $structure 数据结构，返回数据的结构规则
     * @return object
     */
    
    public function getAdminById( $structure ){
        $result[0] = $this->module->findFirst(
                array(
                    "conditions" => "id=?1",
                    "bind"       => array(1 => $structure->id )
                )
        )->toArray();
        $responseData = $this->getResponseArray($structure, $result);
        return $responseData[0];
    }
    /**
     * 修改
     */
    public function update ( $params ) {
        $data = $this->module->findFirst("id={$params->id}");
        if(empty($data)){
            $this->setResponseBody(true, ERROR_UPDATE . " 失败原因：要修改的数据不存在！");
            return $this->response;
        }
        $data->username = $params->username;
        $data->password = $params->password;
        $data->create_time = date("Y-m-d H:i;s");
        try{
            $this->module->trans_start();
            $result = $data->save();
            if($result){
                $this->module->trans_commit();
                $this->response["respCode"] = true;
                $this->response["respCode"] = true;
                $this->setResponseBody(true, SUCCESS_UPDATE);
                return $this->response;
            }else{
                
                $this->module->trans_rollback();
                foreach ($this->module->getMessages() as $message) {
                    echo $message->getMessage(), "<br/>";
                }
                $this->setResponseBody(false, ERROR_UPDATE);
                return $this->response;
            }
        } catch (\Exception $e){
            $this->setResponseBody(false, ERROR_UPDATE ." 错误原因：". $e->getMessage());
            return $this->response;
        }
    }
}
