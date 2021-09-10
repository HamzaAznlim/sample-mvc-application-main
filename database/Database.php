<?php

namespace app\Database;

class Database
{
    private static $instance=null;

    private function __construct()
    {
        try {
            self::$instance= new \PDO(DATABASE_HOST_NAME.DATABASE_DB_NAME, DATABASE_USER_NAME, DATABASE_PASSWORD, array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ));
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error". $e->getMessage();
        }
    }


    public static function GetInstance()
    {
        if (self::$instance===null) {
            new Database();
        }
        return self::$instance;
    }

    public function __clone()
    {
        throw new Exception("Can't clone this Database Class");
    }
}
