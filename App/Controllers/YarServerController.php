<?php

/**
 * IndexController ，默认控制器
 *
 * @author Gavin
 * @version 2018-01-08 14：21：30
 */

use App\Logics\YarLogic;
class YarServerController extends App\Common\BaseController {

    public function initialize() {
        parent::initialize();
        $this->logic = new YarLogic();
    }

    
    public function serverAction(){
        $server = new Yar_Server($this->logic);
        $server->handle();
//        var_export($this->logic->getAdmin());
        die();
    }
}
