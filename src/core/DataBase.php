<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 06.11.2015
 * Time: 16:07
 */

namespace core;

use PDO;
use PDOException;


class DataBase
{
    private static $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        set_time_limit(12000);
        $settings = self::settings();
        $host = $settings->host;
        $db_name = $settings->dbName;
        $user = $settings->user;
        $pass = $settings->password;

        if (is_null(self::$instance)) {
            try {
                self::$instance = new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $user, $pass);
            } catch (PDOException $e) {
                print "Error DataBase!: " . $e->getMessage() . "<br/>";
                die();
            }

        }
        return self::$instance;
    }

    private static function settings()
    {
        $f = file_get_contents('config/settings.json');
        $settings = json_decode($f);
        return $settings;
    }


    /* private $userName = "silivanov-aa";
     private $password = "1q2w3e4r";
    mysql:host=192.168.10.251*/


}