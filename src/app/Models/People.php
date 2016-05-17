<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 11.05.2016
 * Time: 13:02
 */

namespace app\Models;

use core\DataBase;
use PDO;

class People
{
    protected $db;


    public function __construct()
    {
        $this->db = DataBase::getInstance();

    }

    public function getPeople()
    {
        $arr = [];
        $sql = "SELECT * FROM names Limit 10";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $key => $value) {
            $arr[$key] = $value;
            /* foreach ($value as $k => $v) {
                 $arr[$k] = $v;
             }*/

        }
        return $arr;
    }

    public function saveResult($arr=[],$user_id)
    {
       // print_r($arr);

        $title = $arr['title'];
        $snippet = $arr['snippet'];
        $url = $arr['url'];


        $sql = "INSERT INTO result (user_id, title, url, snippet) VALUES (:user_id, :title, :url, :snippet)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(':user_id' => $user_id,
                             ':title' => $title,
                             ':url' => $url,
                             ':snippet' => $snippet,
        ));

    }

}