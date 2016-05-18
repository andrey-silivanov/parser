<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 10.05.2016
 * Time: 19:01
 */

namespace app\Controller;


use app\Models\People;


class ProxyController extends Controller
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

        //записываем новые данные
        file_put_contents('file/proxy.txt', $out[0], FILE_APPEND);
    }

    public function searchProxy2()
    {
        $url = "https://incloak.com/proxy-list/";
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
        $i = 0;
        $arr1 = [];
        $html = str_get_html($out);
        if (count($html->find('tr'))) {

            foreach ($html->find('tr') as $div) {
                $arr1[$i] = $div->find('td', 0) . ":" . $div->find('td', 1);
                $i++;
            }
        }
        for ($i = 1; $i < count($arr1); $i++) {
            file_put_contents('file/proxy.txt', $arr1[$i], FILE_APPEND);
        }
    }

    public function getProxy()
    {
        $path = "file/proxy.txt";
        // очищаем
        $f = fopen('file/coolProxy.txt', 'w');
        fclose($f);

        $f_proxy = fopen($path, 'r');
        $proxy = fread($f_proxy, 650000);
        $proxy_server = explode("\n", $proxy);
        $url = 'https://www.google.com.ua/';
        $user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:33.0) Gecko/20100101 Firefox/33.0";
        $timeout = 3;
        $arr = [];
        $error_arr = [];
        $j = 0;

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
            echo $proxy_server[$i] . " - " . $http_code . "\n";
            if ($http_code == 200) {
                file_put_contents('file/coolProxy.txt', $proxy_server[$i] . "\n", FILE_APPEND);
            }
            curl_close($ch);
        }
    }

    public function searchProxy3()
    {
        $url = "http://ab57.ru/downloads/proxylist.txt";
        $page = file_get_contents($url);
        $arr = preg_split('/\s/', $page);
        for ($i = 0; $i < count($arr); $i++) {
            if (!empty($arr[$i])) {
                file_put_contents('file/proxy.txt', $arr[$i] . "\n", FILE_APPEND);
            }
        }
    }

    public function searchProxy4()
    {

        $url = "http://fineproxy.org/freshproxy/#more-6";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвращает строку
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // редирект
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208');
        $out = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        $i = 0;
        $arr1 = [];
        $html = str_get_html($out);

        if (count($html->find('.storycontent > p'))) {
            foreach ($html->find('.storycontent > p') as $div) {

                $arr1[$i] = $div->innertext;
                $i++;
            }
            preg_match_all('/[\d*\.:]*/', $arr1[0], $out);
        }

        $fo = fopen("file/proxy.txt", "w");
        fclose($fo);

        for ($i = 110; $i < count($out[0]); $i++) {
            if (!empty($out[0][$i]) && strlen($out[0][$i] >= 15)) {
                file_put_contents('file/proxy.txt', $out[0][$i] . "\n", FILE_APPEND);

            }
        }

    }


}