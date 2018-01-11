<?php

/**
 * IndexController ，默认控制器
 *
 * @author Gavin
 * @version 2018-01-08 14：21：30
 */

class YarClientController extends App\Common\BaseController {
    //put your code here

    protected $client;
    protected $yarServer = "http://192.168.200.101/Index/rpc_server";



    public function initialize() {
        parent::initialize();
        $this->client = new yar_client($this->yarServer);
    }

    
    public function getServerDataAction(){
        echo 11111;
        echo $this->client->add(1,2);
        $className = get_class($this->client);
        print_r("<pre>");
        print_r($this->client);
        print_r(get_class_methods($className));
        die();
    }
}
