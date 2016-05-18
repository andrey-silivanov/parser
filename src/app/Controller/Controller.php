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
        echo "PROXY LOADING <br/>";

        $proxy->searchProxy();
        $proxy->searchProxy2();   // парсинг списков прокси
        $proxy->searchProxy3();
        $proxy->searchProxy4();


        $proxy->getProxy();  //проверка прокси

        $people = $people_m->getPeople();

        for ($i = 0; $i < count($people); $i++) {

            echo $people[$i]['first'] . " " . $people[$i]['last'] . "\n";
            $p = new ParserController();
            $p->google($people[$i]['first'], $people[$i]['last'], $people[$i]['id']);
            if ($i % 500 == 0 && $i != 0) {
                echo "PROXY Loading <br/>";
                $proxy->searchProxy();
                $proxy->searchProxy2();   // парсинг списков прокси
                $proxy->searchProxy3();
                $proxy->searchProxy4();
                $proxy->getProxy();
            }
            sleep(3);
        }

    }

}