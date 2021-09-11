<?php

namespace app\models\tables;

use app\models\ModelAbstract;

class UserModel extends ModelAbstract
{
    protected static string $table ='user_';
    public $name;
    public $Email;
    public $password;
    public $Age ;

    protected static $primaryKey = 'id';
    protected static $schema = [

        'name'          => self::STR_VAL,
        'Email'         => self::STR_VAL,
        'password'      => self::STR_VAL,
        'Age'           => self::INT_VAL,
    ];


    public static function getByAge()
    {
        return static::QueryGet(
            "SELECT * FROM `user_` WHERE  Age = :Age",
            [
                'Age' => array(static::INT_VAL,22)
            ]
        );
    }
}
