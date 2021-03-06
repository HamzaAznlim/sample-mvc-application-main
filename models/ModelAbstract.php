<?php

namespace app\models;

use app\Database\Database;

 abstract class ModelAbstract
 {
     const BOOL_VAL = \PDO::PARAM_BOOL;
     const STR_VAL      =  \PDO::PARAM_STR;
     const INT_VAL =  \PDO::PARAM_INT;
     const DECIMAL_VAL = 4;

 
     public function __construct()
     {
     }


     private static function buildParamSql() :string
     {
         $buildParam = '';
         foreach (static::$schema as $key => $value) {
             $buildParam .= $key ." = :".$key . " , " ;
         };

         return trim($buildParam, ", ");
     }


     private function prepareValues(\PDOStatement &$statement) : \PDOStatement
     {
         foreach (static::$schema as $column => $type) {
             if ($type === 4) {
                 $sanitizedVAl=\filter_var($this->$column, FILTER_SANITIZE_FLOAT, FILTER_ALLOW_FRACTION);
                 $statement->bindValue(':'.$column, $this->$column, $sanitizedVAl);
             } else {
                 $statement->bindValue(':'.$column, $this->$column, $type);
             }
         };

         return $statement;
     }

     private function prepareValuesArr(\PDOStatement &$statement, array $arr) : \PDOStatement
     {
         $index = 0;
         foreach (static::$schema as $column => $type) {
             if ($type === 4) {
                 $sanitizedVAl=\filter_var($arr[$index], FILTER_SANITIZE_FLOAT, FILTER_ALLOW_FRACTION);
                 $statement->bindValue(':'.$column, $sanitizedVAl);
             } else {
                 $statement->bindValue(':'.$column, $arr[$index], $type);
             }

             $index++;
         };

         return $statement;
     }


     public function create(array $arr = []):bool
     {
         $sql  = "INSERT INTO " . static::$table . " SET " . self::buildParamSql();
          
         $statement = Database::GetInstance()->prepare($sql);
         if (count($arr) > 0  && !empty($arr)) {
             $this->prepareValuesArr($statement, $arr);
         } else {
             $this->prepareValues($statement);
         }
        
         return $statement->execute();
     }


   


     public function update()
     {
         $sql  = "UPDATE " . static::$table . " SET " . self::buildParamSql(). " WHERE " . static::$primaryKey." = " .$this->{static::$primaryKey};

         $statement = Database::GetInstance()->prepare($sql);
         $this->prepareValues($statement);
         return $statement->execute();
     }


     public function save()
     {
         return ($this->{static::$primaryKey} === null) ? $this->create() : $this->update();
     }

     public function delete():bool
     {
         $sql  = "DELETE FROM " . static::$table . " WHERE " . static::$primaryKey." = " .$this->{static::$primaryKey};

         $statement = Database::GetInstance()->prepare($sql);
         return $statement->execute();
     }

     public function find(int $id)
     {
         $sql  = "SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey." = " .$id." ";
         $statement = Database::GetInstance()->prepare($sql);
         
         if ($statement->execute() === true) {
             $obj = $statement->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, \get_called_class(), array_keys(static::$schema));
             return array_shift($obj);
         }
         return false;
     }

     public static function Get()
     {
         $sql  = "SELECT * FROM " . static::$table;

         $statement = Database::GetInstance()->prepare($sql);
         
         return $statement->execute() === true ? $statement->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, \get_called_class(), array_keys(static::$schema)) : false;
     }


     public static function QueryGet($sql, $options = array())
     {
         $stmt = Database::GetInstance()->prepare($sql);
         if (!empty($options)) {
             foreach ($options as $columnName => $type) {
                 if ($type[0] == 4) {
                     $sanitizedValue = filter_var($type[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                     $stmt->bindValue(":{$columnName}", $sanitizedValue);
                 } elseif ($type[0] == 5) {
                     if (!preg_match(self::VALIDATE_DATE_STRING, $type[1]) || !preg_match(self::VALIDATE_DATE_NUMERIC, $type[1])) {
                         $stmt->bindValue(":{$columnName}", self::DEFAULT_MYSQL_DATE);
                         continue;
                     }
                     $stmt->bindValue(":{$columnName}", $type[1]);
                 } else {
                     $stmt->bindValue(":{$columnName}", $type[1], $type[0]);
                 }
             }
         }
         $stmt->execute();
         if (method_exists(get_called_class(), '__construct')) {
             $results = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$schema));
         } else {
             $results = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
         }
         if ((is_array($results) && !empty($results))) {
             return new \ArrayIterator($results);
         };
         return false;
     }


     public static function getTable()
     {
         return static::$table;
     }
 }
