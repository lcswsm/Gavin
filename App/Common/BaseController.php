<?php

/**
 * BaseController
 * 公共控制器，用来控制权限、登录拦截等
 * @author Gacin
 * @version 2018-01-08 14：23：30
 */

namespace App\Common;
use Phalcon\Mvc\Controller;

class BaseController extends Controller {
    //put your code here
    protected $response = array("respCode","respBody");
    protected $logic;
   

    
    public function initialize() {
        $this->assets->addJs("Js/Common/vue.min.js");
    }
    
    
    /**
     * 设置访问请求，响应 实体结构
     */
    public function setParameter ( &$entity ) {
        $params = $this->request->get();
        foreach( $params as $key => $value ){
            if(property_exists($entity, $key) && $value !== null){
                $entity->$key = $value;
            }
        }
    }
    
    
    protected function __GET__( $index = false ){
        if(false === $index){
           return  $this->dispatcher->getParams();
        }
        return $this->dispatcher->getParam($index);
    }
}
