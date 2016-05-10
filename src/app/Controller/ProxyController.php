<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 10.05.2016
 * Time: 19:01
 */

namespace app\Controller;


class ProxyController
{
    public function checkProxy()
    {
        //полный путь ко второму скрипту
        $webpage = "detect.php";

//таймаут для коннекта к проксику
        $timeout = 2;

        $head="GET $webpage HTTP/1.1\r\n\r\n";
//proxy.txt - файл с проксиками
        $fcontents = file ('file/proxy.txt');
       // echo "Loading...";
       // print_r($fcontents);
        for($i=0; $i<count($fcontents); $i++) {
            $fp = fsockopen($fcontents[$i], 8080, $errno, $errstr, 3);
            if (!$fp) {
                echo "Error: \n";
            } else {
                /* fputs ($fp, "GET / HTTP/1.0\r\nHost: www.example.com\r\n\r\n");
                 while (!feof($fp)) {
                     echo fgets ($fp,128);
                 }
                 */
                echo "ok";
            }

        }
   /*     while (list ($line_num, $line) = each ($fcontents)) {
            echo $line_num.") test <b>$line</b>.......";
            $server = explode(":",trim($line));
            $fp = @fsockopen($server[0], $server[1], $errno, $errstr, $timeout);
            if($fp) {
                unset($result);
                fputs($fp,$head);
                while(!feof($fp)) {
                    $returndata.=fread($fp,1024);
                }
                $result = explode("|||",$returndata);
                echo "Proxy is life";
                if (trim($result[1])=="") {
                    echo "and anonim \n\n";
                } else {
                    echo "no anonim...\n\n";
                }
                fclose($fp);
            } else {
                echo "(".$errno.") ".$errstr."\n\n";
            }
        }*/
    }

}