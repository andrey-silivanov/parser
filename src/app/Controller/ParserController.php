<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 10.05.2016
 * Time: 12:42
 */

namespace app\Controller;

use app\Models\People;



class ParserController
{
    public $name;
    public $surname;
    protected $url;
    protected $content;
    protected $user_id;

    public function __construct($name, $surname, $user_id)
    {
        //  $this->name = $_POST['name'];
        //  $this->surname = $_POST['surname'];
        $this->name = $name;
        $this->surname = $surname;
        $this->user_id = $user_id;

    }

    public function google()
    {

        $user_id = $this->user_id;
        $this->content = $this->getContent();
        // echo $this->content;
        $pars_array = [];

       $pars_array['title'] = $this->getTitle();
        $pars_array['url'] = $this->getUrl();
        $pars_array['snippet'] = $this->getSnippet();
        $pars_array = $this->checkParsing($pars_array);

       // print_r($pars_array);
       // echo count($pars_array);
       // $m->saveResult($pars_array[0],$user_id);
        for($i=0; $i<count($pars_array); $i++){
           // print_r($pars_array[$i]);
            $m = new People();
            $m->saveResult($pars_array[$i],$user_id);
           // echo $i;
        }


        /*  for($i=0; $i<10; $i++){
             echo $title[$i]." - <b>"
                 .$url[$i]." - </b>"
                 .$snippet[$i]." - <hr>";
          }*/
        /// print_r($title);
        //  print_r($url);
        // print_r($snippet);

    }

    public function getTitle()
    {

        $arr = [];
        $i = 0;
      /*  $f = fopen('file/page.txt', 'r');
        $file = fread($f, 650000);*/
        $html = str_get_html($this->content);
        if (count($html->find('.r'))) {
            foreach ($html->find('.r > a') as $div) {
                $arr[$i] = strip_tags($div->innertext);
                $i++;
            }
        }
        /*

          $pattern = '|<h3 class="r">.*<a[^>]+>(.+?)</a><\/h3>|iu';
          preg_match_all($pattern, $file, $out);
          for($i=0; $i<count($out[1]); $i++){
              $arr[$i] = strip_tags($out[1][$i]);
          }*/
        return $arr;
    }


    public function getUrl()
    {

        $arr = [];
        /*
                $f = fopen('file/page.txt', 'r');
                $file = fread($f, 650000);*/
        $i = 0;
       $html = str_get_html($this->content);
        if (count($html->find('.r'))) {

            foreach ($html->find('.r a') as $div) {
                $arr[$i] = $div->attr['href'];
                $i++;
            }
        }
        return $arr;

    }

    public function getSnippet()
    {
        /*$f = fopen('file/page.txt', 'r');
        $file = fread($f, 650000);*/
        $arr = [];
        $i = 0;
        $html = str_get_html($this->content);
        if (count($html->find('.st'))) {

            foreach ($html->find('.st') as $div) {

                $arr[$i] = strip_tags($div->innertext);
                $i++;

            }
        }
        return $arr;
        /* $pattern = '/<span class="st">[\S\s]*?<\/span>/';*/
    }


    public function getContent()
    {
        //$url = "http://www.gibdd.ru/";
         $url = 'http://www.google.com/search?q=' . $this->name . '+' . $this->surname;
        //$this->url = 'http://www.google.com/';
        //  $this->url = 'http://socksproxylist24.blogspot.com/2016/05/13-05-16-socks-proxy-list_85.html#more';

        $path = 'file/coolProxy.txt';
        $f_proxy = fopen($path, 'r');
        $proxy = fread($f_proxy, 65000);
        $proxies = explode("\n", $proxy);
        $steps = count($proxies);
        $step = 0;
        $try = true;
        //$arr =[];
       // print_r($proxies);
         while ($try) {
          $proxy = isset($proxies[$step]) ? $proxies[$step] : null;

       // $proxy = "198.2.202.52:8090";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвращает строку
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // редирект
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208');
         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
          curl_setopt($ch, CURLOPT_PROXY, $proxy);
         curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        $out = curl_exec($ch);
        // $out = iconv('CP1251', 'UTF-8', curl_exec($ch));
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        //echo $error;
        curl_close($ch);
        //$arr[$step]=$http_code;
        // echo $http_code;
        $step++;
        $try = (($step < $steps) && $http_code != 200);
         }
        return $out;
    }

    public function checkParsing($arr)
    {
        $checkArray = [];
        $j = 0;
        print_r($arr);
        for ($i = 0; $i < count($arr['title']); $i++) {

            if (strpos($arr['title'][$i], $this->name) !== false || strpos($arr['snippet'][$i], $this->name) !== false) {
                $checkArray[$j]['title'] = $arr['title'][$i];
                $checkArray[$j]['snippet'] = $arr['snippet'][$i];
                $checkArray[$j]['url'] = $arr['url'][$i];
                $j++;
            }
        }
        return $checkArray;
    }
}