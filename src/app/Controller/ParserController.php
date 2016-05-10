<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 10.05.2016
 * Time: 12:42
 */

namespace app\Controller;


class ParserController
{
    public $name;
    public $surname;

    public function __construct()
    {
        $this->name = $_POST['name'];
        $this->surname = $_POST['surname'];
    }

    public function postIndex()
    {

        $arrUrl = $this->googleParse();

       // $t = $this->siteParse($arrUrl[0]);


    }

    public function googleParse()
    {
       // $path = 'http://www.google.com/search?q=' . $this->name . '+' . $this->surname;
       //echo $path;
        $page = file_get_contents($path);
        $page = iconv('windows-1251', 'utf-8', $page);
       // echo $page;
        $pattern = '|<h3 class="r"><a[^>]+>(.+?)</a><\/h3>|iu';
        preg_match_all($pattern, $page, $out);
        for($i=0; $i<count($out[0]); $i++){
            echo $out[0][$i];
        }
        //echo $out[0][4];
     /*   $page = iconv('windows-1251', 'utf-8', $page);
        $pattern = '/q=htt\w{1,2}:\/\/.+?&/';
        preg_match_all($pattern, $page, $out);
        $arr = [];
        for ($i = 0; $i < count($out[0]); $i++) {
            $arr[$i] = $out[0][$i];
            $arr[$i] = $this->mySub($arr[$i]);
        }
        return $arr;*/
    }

   /* public function siteParse($url, $i=0)
    {
        $arr=[];
       // echo $url."<br>";
        $page = file_get_contents($url);

       // echo $page;
        $pattern = '/<title>(.+)<\/title>/';
        preg_match($pattern, $page, $out);
     // print_r($out);
        $title = $out[1];
        $pattern = $this->name;
       // echo $title."<br />".$this->name;
        $pos  = strripos($title, $pattern);
        if ($pos === false){
            return false;
        }
        else {
            $arr[$i]['title'] = $title;
        }
        $pattern2 ='/description.+content="(.+)?">/';
        preg_match($pattern2, $page, $res);
        print_r($res);

    }*/

    public function checkTitle($title)
    {

    }

    public function mySub($string)
    {
        $string = substr($string, 2);
        $string = substr($string, 0, -1);
        return $string;
    }
}