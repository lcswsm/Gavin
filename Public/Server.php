<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Server {
    public function add($a, $b){
        return $a+$b;
    }
}

$server = new Yar_Server(new Server());
$server->handle();