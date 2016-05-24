<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 24.05.2016
 * Time: 13:22
 */
require 'vendor/autoload.php';
$people_model = new \app\Models\People();
$proxy = new \app\Controller\ParserController();
$i = 0;
$people = $people_model->getPeopleLimit(528,264);

for($i=0; count($people); $i++ ){
    echo $people[$i]['first']."\n";
    sleep(1);
}
echo "<hr />";

