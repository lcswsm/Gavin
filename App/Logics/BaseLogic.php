<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Logics;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
/**
 * Description of BaseLogic
 *
 * @author Admin
 */
class BaseLogic {
    //put your code here
    public $tablePrefix;    
    protected $module;
    protected $phql;
    protected $offsite = 2;
    protected $currentPage;

    protected $response = array("respCode","respBody");
    
    
    /**
     * 返回符合response 结构的数据
     * @param object $stucture 响应实体数据结构
     * @param array $data 查询得到的结果集（二维数组）
     */
    protected function getResponseArray( $stucture, $data ){
        $resData = array();
        $index = 0;
        foreach ( $data as $row ) {
            
            foreach( $row as $key => $value  ){
                if(property_exists($stucture, $key)){
                    $resData[$index][$key] = $value;
                }
            }
            $index++;
        }
        return $resData;
    }
    
    
    /**
     * 设置响应参数
     */
    
    protected function setResponseBody( $code, $message ){
        $this->response["respCode"] = $code;
        $this->response["respBody"] = $message;
    }
    
    /**
     * 获取分页页码
     */
    
    protected function getPaginator( $dataObject ){
        return new PaginatorModel(
            array(
                "data"  => $dataObject,
                "limit" => $this->offsite,
                "page"  => $this->currentPage
            )
        );
    }
}
