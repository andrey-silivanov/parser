<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 10.05.2016
 * Time: 19:01
 */

namespace app\Controller;


use app\Models\People;

class ProxyController
{
    public function test()
    {
        $model = new People();
        $m = $model->getPeople();
        echo($m[29]['first']);
    }

    public function searchProxy()
    {
        $path = "http://webanetlabs.net/publ/9-1-0-15";

        $page = file_get_contents($path);
        $pattern = '|\n[\d.:]+|';
        preg_match_all($pattern, $page, $out);

        // удаляем старые записи из файла
        $fo = fopen("file/proxy.txt", "w");
        fclose($fo);

        //записываем новые данные
        file_put_contents('file/proxy.txt', $out[0], FILE_APPEND);

    }


    public function checkProxy()
    {
        //$host = "http://site.com";
        // $this->searchProxy();
        $path = "file/proxy.txt";
        $fo = fopen("file/coolProxy.txt", "w");
        fclose($fo);

        $f_proxy = fopen($path, 'r');
        $proxy = fread($f_proxy, 65000);
        $proxy_server = explode("\n", $proxy);

        $url = 'https://www.google.com.ua/';
        $user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0";
        $timeout = "10";
        $arr = [];
        //  print_r($proxy_server[1]);
        // echo count($proxy_server);
        for ($i = 1; $i < count($proxy_server); $i++) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_PROXY, $proxy_server[$i]);

            $data = curl_exec($ch);

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            //  if ($http_code == 200 && strpos($data, $_SERVER['SERVER_ADDR']) === false)
            //    echo "<font color='green'>Анонимен</font>";
            if ($http_code == 200)
                file_put_contents('file/coolProxy.txt', $proxy_server[$i] . "\n", FILE_APPEND);
            else
                $arr[$i] = 'error - ' . $proxy_server[$i] . "<br>";

            curl_close($ch);
        }
        print_r($arr);
        /*  for ($i = 0; $i < count($proxy_serv); $i++) {
              //echo $proxy_serv[$i][0];
              $fp = @fsockopen($proxy_serv[$i][0], $proxy_serv[$i][1], $errno, $errstr, 0.5);
              if (!$fp)
              {
               echo $i." Error <br />";
              }
              else{
                  file_put_contents('file/coolProxy.txt', $proxy_serv[$i][0].":".$proxy_serv[$i][1]."\n",FILE_APPEND);
                  echo $i." ok <br />";
              }
          }*/

    }


}