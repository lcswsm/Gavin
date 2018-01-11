<?php

/**
 * IndexController ，默认控制器
 *
 * @author Gavin
 * @version 2018-01-08 14：21：30
 */
use App\Entity\Request;
use App\Entity\Response;
use App\Logics\AdminLogic;
class IndexController extends App\Common\BaseController {
    //put your code here
    private $adminParams;
    
    public function initialize() {
        parent::initialize();
        $this->logic = new AdminLogic();
        $this->assets->addJs("Js/Admin/Admin.js");
    }
    
    /**
     * indexAction 默认方法，自动显示View视图文件
     */
    public function indexAction () {
        $this->tag->setDocType(Phalcon\Tag::HTML5);
    }
    
    /**
     * 保存用户信息
     * 使用 AdminRequest 请求参数模版
     */
    public function saveAdminAction(){
        $this->adminParams = new Request\AdminRequest();
        $this->setParameter( $this->adminParams );
        $this->response = $this->logic->save( $this->adminParams );
        if($this->response["respCode"] == true){
            echo $this->response["respBody"];
            echo $this->tag->linkTo("index/getAdmin","去列表页");
        }else{
            echo $this->response["respBody"];
            echo $this->tag->linkTo("index/index","返回");
        }
        
    }
    /**
     * 返回用户信息
     */
    public function getAdminAction(){
        $this->adminParams = new Response\AdminResponse();
        $this->setParameter( $this->adminParams );
        $this->adminParams->page = $this->__GET__(0);
        $list = $this->logic->getAdmin( $this->adminParams );
        if($this->request->isAjax()){
            $this->ajaxReturn($list);
            $this->response->setJsonContent(array('Response' => 'ok'));
        }
        $this->view->pick("index/adminList");
        $this->view->setVar("list", $list);
    }
    
    /**
     * 删除数据
     */
    public function deleteAdminAction(){
        $this->adminParams = new Request\AdminRequest();
        $this->adminParams->id = $this->__GET__(1);
        $this->logic->deleteAdmin( $this->adminParams );
        echo $this->tag->linkTo("index/getAdmin/{$this->__GET__(0)}","删除完成，返回");
    }
    
    /**
     * 根据ID 获取一条admin的具体信息
     */
    
    public function getAdminByIdAction () {
        $this->adminParams = new Response\AdminResponse();
        $this->adminParams->id = $this->__GET__(1);
        $list = $this->logic->getAdminById( $this->adminParams );
        foreach($list as $key => $value){
            $this->tag->setDefault($key, $value);  
        }
        $this->view->pick("index/adminInfo");
        $this->view->setVar("list", $list);
        $this->view->setVar("page", $this->__GET__(0));
    }
    
    /**
     * 修改数据
     */
    public function updateAdminAction(){
        $this->adminParams = new Request\AdminRequest();
        $this->setParameter( $this->adminParams );
        $this->response = $this->logic->update( $this->adminParams );
        if($this->response["respCode"] == true){
            echo $this->response["respBody"];
            echo $this->tag->linkTo("index/getAdmin/{$this->__GET__(0)}","去列表页");
        }else{
            echo $this->response["respBody"];
            echo $this->tag->linkTo("index/index","返回");
        }
    }
          
}
