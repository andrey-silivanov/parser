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

    public function searchProxy()
    {
        $path = "http://webanetlabs.net/publ/9-1-0-15";

        $page = file_get_contents($path);
        $pattern = '|\n[\d.:]+|';
        preg_match_all($pattern, $page, $out);

        // удаляем старые записи из файла
        $fo = fopen("file/proxy.txt", "w");
        fclose($fo);

        // возвращаем массив
       // return $out[0];
        //записываем новые данные
        file_put_contents('file/proxy.txt', $out[0], FILE_APPEND);
    }

    public function  searchProxy2()
    {
        $url ="https://incloak.com/proxy-list/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвращает строку
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // редирект
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208');
        $out = curl_exec($ch);
        //$out = iconv('CP1251', 'UTF-8', curl_exec($ch));
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
            $i=0;
        $arr1=[];
        $html = str_get_html($out);
        if (count($html->find('tr'))) {

            foreach ($html->find('tr') as $div) {

               $arr1[$i] = $div->find('td',0).":".$div->find('td',1);
                $i++;

            }
        }
       // print_r($arr1);
       // unset($arr1[0]);
       return $arr1;
      //  for($i=1; $i<count($arr1); $i++){
      //  file_put_contents('file/proxy.txt', strip_tags($arr1[$i])."\n",FILE_APPEND);
   // }
    }

    public function getProxy()
    {
        //$host = "http://site.com";
        // $this->searchProxy();
       /* $path = "file/copyCoolProxy.txt";

        $f_proxy = fopen($path, 'r');
        $proxy = fread($f_proxy, 65000);
        $proxy_server = explode("\n", $proxy);
       // $proxy_server = $this->searchProxy2();
       // $url = 'https://www.google.com.ua/';
        $url = "http://www.gibdd.ru/";
        $user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0";
        $timeout = "10";
        $arr = [];
        $error_arr=[];
        $j=0;

       print_r($proxy_server);
        for ($i = 1; $i < count($proxy_server); $i++) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_PROXY, $proxy_server[$i]);

            //$data = curl_exec($ch);

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            //  if ($http_code == 200 && strpos($data, $_SERVER['SERVER_ADDR']) === false)
            //    echo "<font color='green'>Анонимен</font>";
            if ($http_code == 200){
                file_put_contents('file/coolProxy.txt', $proxy_server[$i]."\n",FILE_APPEND);
                $arr[$j] = $proxy_server[$i];
                $j++;
            }

            else

                $error_arr[$i] = 'error - ' . $proxy_server[$i] . "<br>";

            curl_close($ch);
        }
        print_r($arr);
        echo "<hr>";
        print_r($error_arr);*/
        /////
       // return $arr;
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
        $path = "file/proxy.txt";
        $f = fopen('file/coolProxy.txt','w');
        fclose($f);

        $f_proxy = fopen($path, 'r');
        $proxy = fread($f_proxy, 650000);
        $proxy_server = explode("\n", $proxy);
        $url = 'https://www.google.com.ua/';
       // $url = "http://www.gibdd.ru/";
        $user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0";
        $timeout = 3;
        $arr = [];
        $error_arr=[];
        $j=0;

        //print_r($proxy_server);
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

            if ($http_code == 200){
                file_put_contents('file/coolProxy.txt', $proxy_server[$i]."\n",FILE_APPEND);
            }
            curl_close($ch);
        }
        //print_r($arr);
        //echo "<hr>";
        //print_r($error_arr);

    }


}