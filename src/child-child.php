<?php
require 'vendor/autoload.php';

$proxy = new \app\Controller\ParserController();
$i = 0;
// block all the things!
$proxy->google('Arena','Remd');

/*while (true) {
    echo ++$i . "\n";
    sleep(1);
}*/