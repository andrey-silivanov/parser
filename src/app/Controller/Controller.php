<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 01.04.2016
 * Time: 12:57
 */

namespace app\Controller;

use app\Controller\ProxyController;
use app\Controller\ParserController;
use app\Models\People;

include 'app/Libs/simple_html_dom.php';

class Controller
{

    public function start()
    {
        $people_m = new People();
        $proxy = new ProxyController();
       // $proxy->searchProxy();
       // $proxy->getProxy();
        $people = $people_m -> getPeople();

        for($i=0; $i<count($people); $i++){
            $p = new ParserController($people[$i]['first'],$people[$i]['last'],$people['id']);
            $p->google();
        }


       // $proxy->searchProxy();
     // $proxy->getProxy();
        //$proxy_array = $proxy->getProxy();
       // print_r($proxy_array);
      //
      //  $p->google();

    }

}