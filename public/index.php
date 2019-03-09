<?php

use Applcon\Common\Application;

// 注册自动装载机
require __DIR__.'/../bootstrap/autoloader.php';

// 创建应用程序
$app = new Application();

// 运行应用程序
echo $app->run();
