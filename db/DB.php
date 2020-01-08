<?php
namespace db;

use PDO;

class DB
{
    private static $pdo = null;

    static function getDB() {
       if (DB::$pdo == null) {
            try{
                DB::$pdo = new \PDO("sqlite:../databases/sti.db");
            }catch (\PDOException $e) {
                echo "wtf";
             }
        }
        return DB::$pdo;
        
    }

    static function find($table,$id) {
        $response = DB::getDB()->query("SELECT * FROM ".$table." WHERE id=".$id);
        return $response->fetch();
    }

    static function findByPseudo($table,$pseudo) {
        $preparedStatement = DB::getDB()->prepare("SELECT * FROM ".$table." WHERE pseudo = :pseudo ");
        $preparedStatement->bindValue(':pseudo',$pseudo);
        $preparedStatement->execute();
        $response = $preparedStatement->fetchAll();
        return $response;
    }

    static function all($table) {
        return DB::getDB()->query("SELECT * FROM ".$table." ORDER BY id DESC");
    }

    static function allBydate($table) {
        return DB::getDB()->query("SELECT * FROM ".$table." ORDER BY date DESC");
    }

    static function lastId($table) {
        $result = (DB::getDB()->query("SELECT max(id) as ID FROM ".$table )->fetch());
        return  $result? ((int)$result['ID']) :0;
    }

}
