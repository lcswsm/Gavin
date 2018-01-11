<?php

/* 
 * 项目主入口文件
 */

//加载配置文件
use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\Config\Adapter\Json as ConfigJson;
use Phalcon\Config\Adapter\Php as ConfigPhp;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

$ConfigIni  = new ConfigIni('../Config/Ini.ini');
$ConfigJson = new ConfigJson('../Config/Json.json');
$ConfigPhp  = new ConfigPhp('../Config/Php.php');
$config     = new ConfigPhp('../Config/System.php');

//加载如果类文件
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;

try{
    //创建自动加载的实例
    $loader = new Loader();
    //加载命名空间
    $loader->registerNamespaces(
        array(
            'App'    => "../App",
            'Config'    => "../ Config"
        )
    )->register(); 
    
    //注册MVC组件
    $loader->registerDirs(array(
        '../App/Controllers/', // 控制器所在目录
        '../App/Views/',       // 视图所在目录
        '../App/Modules/',     // 模型所在目录
    ))->register();

    // 创建一个DI实例
    $di = new FactoryDefault();
    
    // 实例化View 赋值给DI的view
    $di->set('view', function () {
        $view = new View();
        $view->setViewsDir('../app/views/');
        $view->setLayoutsDir('layouts/');     // 定义布局文件目录
        $view->setTemplateAfter('header');     // 定义布局文件名，header.phtml 将被视作模板文件
        return $view;
    });
    // 
    $di->set('config', function () use($ConfigIni) {
        return $ConfigIni;
    });
    //实例化session并且开始 赋值给DI实例 方便在控制器中调用
    $di->setShared('session', function () {
        $session = new Session();
        $session->start();
        return $session;
    });
    
    
    // 初始化数据库连接 从配置项读取配置信息
    include_once "../Config/Service.php";
    include_once "../Config/ErrorMessage.php";
//    $di->set('db', function () use ($ConfigIni) {
//        return new DbAdapter(array(
//            "host"     => $ConfigIni->database->host,
//            "username" => $ConfigIni->database->username,
//            "password" => $ConfigIni->database->password,
//            "dbname"   => $ConfigIni->database->dbname
//        ));
//    });
    
    // 处理请求
    $application = new Application($di);
    // 输出请求类容
    echo $application->handle()->getContent();
} catch ( \Exception $e){
    // 异常处理
    echo "PhalconException: ", $e->getMessage();
}