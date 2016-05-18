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
use PDOException;

class People
{
    protected $db;


    public function __construct()
    {

    }

    public function getPeople()
    {
        $db = DataBase::getInstance();
        $arr = [];
        $sql = "SELECT * FROM names ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $key => $value) {
            $arr[$key] = $value;

        }
        return $arr;
    }

    public function saveResult($arr = [], $user_id)
    {
        $db = DataBase::getInstance();
        $title = $arr['title'];
        $snippet = $arr['snippet'];
        $url = $arr['url'];

        $sql = "INSERT INTO result (user_id, title, url, snippet) VALUES (:user_id, :title, :url, :snippet)";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(':user_id' => $user_id,
            ':title' => $title,
            ':url' => $url,
            ':snippet' => $snippet,
        ));
        echo "SAVE \n";

    }

}