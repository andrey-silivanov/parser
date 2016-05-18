<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 10.05.2016
 * Time: 12:42
 */

namespace app\Controller;

use app\Models\People;


class ParserController extends Controller
{

    public function __construct()
    {

    }

    public function google($name, $surname, $user_id = null)
    {
        $url[1] = 'http://www.google.com/search?q=' . $name . '+' . $surname;
        $url[2] = 'http://www.google.com/search?q=' . $name . '+' . $surname . "&start=10";
        for ($k = 1; $k <= 2; $k++) {
            $content = $this->getContent($url[$k]);
            if (!$content) {
                echo "ERROR PROXY";
            }
            $pars_array = [];

            $pars_array['title'] = $this->getTitle($content);
            $pars_array['url'] = $this->getUrl($content);
            $pars_array['snippet'] = $this->getSnippet($content);
            $pars_array = $this->checkParsing($pars_array, $name);
            for ($i = 0; $i < count($pars_array); $i++) {
                $m = new People();
                $m->saveResult($pars_array[$i], $user_id);
            }
        }
    }


    public function getTitle($content)
    {
        $arr = [];
        $i = 0;
        $html = str_get_html($content);
        if (count($html->find('.r'))) {
            foreach ($html->find('.r > a') as $div) {
                $arr[$i] = strip_tags($div->innertext);
                $i++;
            }
        }
        return $arr;
    }


    public function getUrl($content)
    {
        $arr = [];
        $i = 0;
        $html = str_get_html($content);
        if (count($html->find('cite'))) {
            foreach ($html->find('cite') as $div) {
                $arr[$i] = $div->plaintext;
                $i++;
            }
        }
        return $arr;

    }

    public function getSnippet($content)
    {
        $arr = [];
        $i = 0;
        $html = str_get_html($content);
        if (count($html->find('.st'))) {

            foreach ($html->find('.st') as $div) {
                $arr[$i] = strip_tags($div->innertext);
                $i++;
            }
        }
        return $arr;
    }


    public function getContent($url)
    {
        $path = 'file/coolProxy.txt';
        $f_proxy = fopen($path, 'r');
        $proxy = fread($f_proxy, 650000);
        $proxies = explode("\n", $proxy);
        $steps = count($proxies);
        $step = 0;
        $try = true;

        while ($try) {
            $proxy = isset($proxies[$step]) ? $proxies[$step] : null;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвращает строку
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // редирект
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208');
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
            $out = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            echo $proxy . " - " . $http_code . "\n";
            $step++;
            $try = (($step < $steps) && $http_code != 200);
        }
        return $out;
    }

    public function checkParsing($arr, $name)
    {
        print_r($arr);
        $checkArray = [];
        $j = 0;
        for ($i = 0; $i < count($arr['title']) - 1; $i++) {
            if (strpos($arr['title'][$i], $name) !== false || strpos($arr['snippet'][$i], $name) !== false) {
                $checkArray[$j]['title'] = $arr['title'][$i];
                $checkArray[$j]['snippet'] = $arr['snippet'][$i];
                $checkArray[$j]['url'] = $arr['url'][$i];
                $j++;
            }
        }
        return $checkArray;
    }
}