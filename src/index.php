<?php



require 'vendor/autoload.php';
use app\Controller\Controller;
use app\Controller\ParserController;

$n = new Controller();
$n->Start();

/*require 'vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$proxy = new \app\Controller\ProxyController();

$read = new \React\Stream\Stream(fopen('php://stdin', 'r+'), $loop);
$write = new \React\Stream\Stream(fopen('php://stdout', 'w+'), $loop);

$read->on('data', function ($data, $read) use ($write, $proxy) {
    if (trim($data) == 'start') {
        $write->close();
        $read->close();
    }

    $line = $proxy->searchProxy2();
    $line .= PHP_EOL;
    $write->write($line);
});

$loop->run();*/

/*E:\OpenServer\modules\php\PHP-5.6\php E:\OpenServer\domains\parser\src\index.php*/

