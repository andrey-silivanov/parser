<?php
require 'vendor/autoload.php';

$parser = new \app\Controller\ParserController();

require 'vendor/autoload.php';
$people_model = new \app\Models\People();
$proxy = new \app\Controller\ParserController();
$i = 0;
$people = $people_model->getPeopleLimit(0,264);

for($i=0; count($people); $i++ ){
    echo $people[$i]['first']."\n";
    sleep(1);
}



// block all the things!
//$proxy->google('Xara','Remd');
