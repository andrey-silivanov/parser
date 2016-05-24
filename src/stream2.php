<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 24.05.2016
 * Time: 11:37
 */
require 'vendor/autoload.php';
$people_model = new \app\Models\People();
$proxy = new \app\Controller\ParserController();
$i = 0;
$people = $people_model->getPeopleLimit(264,264);
print_r($people);
echo "<hr />";

// block all the things!
//$proxy->google('Xara','Remd');
