<?php
require 'vendor/autoload.php';

$stream = $argv[1];
$i = $argv[2];
$proxy = new \app\Controller\ProxyController();

$proxy_model = new \app\Models\Proxy();

$server = $proxy_model->getProxy();
$count = round(count($server) / $stream);
$end = $count;
if ($i == 0) {
    echo "Error";
} elseif ($i == 1) {
    $start = 0;

} elseif ($i >= 2 && $i <= 10) {
    $start = $count * ($i - 1);
} else {
    echo "Error more 10 stream";
}

$server = $proxy_model->getProxyLimit($start, $end);
echo "Stream " . $i . " -- ";
$proxy->getMultiProxy($server, $i);


