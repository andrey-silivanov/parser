<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 10.05.2016
 * Time: 12:42
 */

namespace app\Controller;

use app\Libs\Curl;
use app\Models\People;
use app\Models\Proxy;


class ParserController extends Controller
{

    public function __construct()
    {

    }

    public function google($name, $surname, $userId = null, $stream = null)
    {

        $url = 'http://www.google.com/search?num=20&q=' . $name . '+' . $surname;
        $content = $this->getContent($url, $stream);
        $m = new People();
        if (empty($content)) {
            echo "<<<<====== END PROXY ======>>>>";
        } elseif ($content == 404) {
            $parsArray['title'] = " ";
            $parsArray['url'] = " ";
            $parsArray['snippet'] = " ";
            $m->saveResult($parsArray, $userId);
            $m->checkName($userId);

        } else {
            $parsArray = [];
            $parsArray['title'] = $this->getTitle($content);
            $parsArray['url'] = $this->getUrl($content);
            $parsArray['snippet'] = $this->getSnippet($content);

            $parsArray = $this->checkParsing($parsArray, $name);
            for ($i = 0; $i < count($parsArray); $i++) {
                $m->saveResult($parsArray[$i], $userId);
                $m->checkName($userId);
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


    public function getContent($url, $stream = null)
    {
        $proxyModel = new Proxy();
        $proxies = $proxyModel->getGoodProxy();
        if (empty($proxies)) {
            echo "<<<<======= PROXY NOT FOUND =======>>>>>>\n";
            $peopleM = new People();
            exit();
        }
        shuffle($proxies);
        $steps = count($proxies);
        $step = 0;
        $try = true;

        while ($try) {
            $proxy = isset($proxies[$step]) ? $proxies[$step] : null;

            $curl = Curl::curlProxy($url, $proxy['ip']);

            echo "Stream " . $stream . " - " . trim($proxy['ip']) . " - " . $curl['httpCode'] . "\n";
            $step++;
            if ($curl['httpCode'] == 404) {
                echo "<<<<<<<<<<<====== PAGE NOT FOUND =======>>>>>>>>>\n";
                return $out = 404;
            }
            $try = (($step < $steps) && $curl['httpCode'] != 200 && $curl['httpCode'] != 404);
            sleep(3);
        }
        return $curl['data'];
    }


    public function checkParsing($arr, $name)
    {
        $checkArray = [];
        $j = 0;
        for ($i = 0; $i < count($arr['title']); $i++) {
            if (isset($arr['title'][$i]) && isset($arr['snippet'][$i])) {
                if (strpos($arr['title'][$i], $name) !== false || strpos($arr['snippet'][$i], $name) !== false) {
                    $checkArray[$j]['title'] = $arr['title'][$i];
                    $checkArray[$j]['snippet'] = $arr['snippet'][$i];
                    $checkArray[$j]['url'] = $arr['url'][$i];
                    $j++;
                }
            }
        }
        print_r($checkArray);
        return $checkArray;
    }
}