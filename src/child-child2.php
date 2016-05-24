<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 24.05.2016
 * Time: 11:37
 */
require 'vendor/autoload.php';
$proxy = new \app\Controller\ParserController();
$i = 0;
// block all the things!
$proxy->google('Xara','Remd');
