<?php
require 'vendor/autoload.php';

$parser = new \app\Controller\ParserController();

require 'vendor/autoload.php';
$people_model = new \app\Models\People();
$proxy = new \app\Controller\ParserController();
$i = 0;
$people = $people_model->getPeopleLimit(0,264);
print_r($people);



// block all the things!
//$proxy->google('Xara','Remd');
