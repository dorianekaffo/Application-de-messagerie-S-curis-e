<?php
    namespace model;

    class Util{
        static $specialchars = ['@','/','+','-','*','!','?','%','"','$','(',')','.',';'
        ,'<','>','[',']','\\','_','|','{','}','\'',' ','&',',','=','~','^'];
        static $digits = ['0','1','2','3','4','5','6','7','8','9'];
        public static function checkPassword($password){
            if(strlen($password)<8){
                return false;
            }else{
                foreach (static::$digits as $digit) {
                    if(strpos($password,$digit) !== false){
                        foreach (static::$specialchars as $char) {
                            if(strpos($password,$char) !== false)
                            return true;
                        }
                    }
                }
                return false;
            }
        }
    }