<?php
require 'vendor/autoload.php';
$people_model = new \app\Models\People();
$proxy = new \app\Controller\ParserController();

$people = $people_model->getPeopleLimit(792,300);
for($i=0; count($people); $i++ ){
    echo $people[$i]['first']."\n";
    sleep(1);
}
echo "<hr />";

