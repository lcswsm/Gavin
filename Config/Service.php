<?php

/* 
 * 注册数据库DI对象，开启log记录
 */

$di -> setShared('db', function () use($config) {
    $dbconfig = $config -> database->db;
    $dbconfig = $dbconfig -> toArray();
    if (!is_array($dbconfig) || count($dbconfig)==0) {
        throw new \Exception("the database config is error");
    }
    $eventsManager = new \Phalcon\Events\Manager();
    // 分析底层sql性能，并记录日志
    $profiler = new Phalcon\Db\Profiler();
    $eventsManager -> attach('db', function ($event, $connection) use ($profiler) {
        if($event -> getType() == 'beforeQuery'){
            //在sql发送到数据库前启动分析
            $profiler -> startProfile($connection -> getSQLStatement());
        }
        if($event -> getType() == 'afterQuery'){
            //在sql执行完毕后停止分析
            $profiler -> stopProfile();
            //获取分析结果
            $profile = $profiler -> getLastProfile();
            $sql = $profile->getSQLStatement();
            $params = $connection->getSqlVariables();
            (is_array($params) && count($params)) && $params = json_encode($params);
            $executeTime = $profile->getTotalElapsedSeconds();
            //日志记录
            $currentDay = date('Ymd');
            $logger = new \Phalcon\Logger\Adapter\File("../App/Cache/Logs/{$currentDay}.log");
            $logger -> debug("{$sql} {$params} {$executeTime}");
        }
    });

    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => $dbconfig['host'], 
        "port" => $dbconfig['port'],
        "username" => $dbconfig['username'],
        "password" => $dbconfig['password'],
        "dbname" => $dbconfig['dbname'],
        "charset" => $dbconfig['charset']
        )
        
    );

    /* 注册监听事件 */
    $connection->setEventsManager($eventsManager);

    return $connection;
});