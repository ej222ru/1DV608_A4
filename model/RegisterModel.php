<?php

namespace model;

class RegisterModel {
    
    private static $file = "data/users.txt";
    
    public function saveUser($userName, $password) {
         
        $fileHandle = fopen(self::$file, 'a');
        $userData = $userName . "::" .$password .PHP_EOL;
        fwrite($fileHandle, $userData);
        fclose($fileHandle);
    }
    public function getUser($userName) {
        $fileHandle = fopen(self::$file, 'r');
        do{
            $userData = fgets($fileHandle);
            $userDataSep = explode("::", $userData);
            if (strcmp($userName, $userDataSep[0]) == 0){
                fclose($fileHandle);
                return $userData;
            }
        }while(strlen($userData) > 0);
        fclose($fileHandle);
    }    
    
}
