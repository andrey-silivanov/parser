<?php



require 'vendor/autoload.php';
use app\Controller\Controller;
use app\Controller\ParserController;

//$n = new Controller();
//$n->Start();

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


$loop = React\EventLoop\Factory::create();
// Stream 1
$process = new React\ChildProcess\Process('php stream1.php');
$process->on('exit', function($exitCode, $termSignal) {
    echo "Child exit\n";
});
$loop->addTimer(0.001, function($timer) use ($process) {
    $process->start($timer->getLoop());
    $process->stdout->on('data', function($output) {
        echo "Child script says: {$output}";
    });
});
// Stream 2
$process2 = new React\ChildProcess\Process('php stream2.php');
$process2->on('exit', function($exitCode, $termSignal) {
    echo "Child exit\n";
});
$loop->addTimer(0.001, function($timer) use ($process2) {
    $process2->start($timer->getLoop());
    $process2->stdout->on('data', function($output) {
        echo "Child 2 script says: {$output}";
    });
});
// Stream 3
$process3 = new React\ChildProcess\Process('php stream3.php');
$process3->on('exit', function($exitCode, $termSignal) {
    echo "Child exit\n";
});
$loop->addTimer(0.001, function($timer) use ($process3) {
    $process3->start($timer->getLoop());
    $process3->stdout->on('data', function($output) {
        echo "Child 3 script says: {$output}";
    });
});
// Stream 4
$process4 = new React\ChildProcess\Process('php stream4.php');
$process4->on('exit', function($exitCode, $termSignal) {
    echo "Child exit\n";
});
$loop->addTimer(0.001, function($timer) use ($process4) {
    $process4->start($timer->getLoop());
    $process4->stdout->on('data', function($output) {
        echo "Child 4 script says: {$output}";
    });
});

$loop->addPeriodicTimer(5, function($timer) {
    echo "Parent cannot be blocked by child\n";
});
$loop->run();

/*E:\OpenServer\modules\php\PHP-5.6\php E:\OpenServer\domains\parser\src\index.php*/

