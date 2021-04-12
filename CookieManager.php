<?php


class CookieManager
{
    private $datas = [];

    private $readFromFile = [];

    function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

    public function __construct(){
        $this->readFromFile = [
            "datas" => $this->datas,
            "key" => "randomstringvagyok",
            "uname" => "LakatosPS",
        ];
        $this->createKey();
    }

    private function readData($key){
        //A fileból ki kellene olvasni az adatokat
        try {
            $file = fopen("cookie.txt", "r");
            if ($file === false){
                throw new Error("HIBA: A fájl megnyitása nem sikerült!");
            }
        }catch (Error $err){
            echo $err->getMessage()."<br>";
        }

        $this->readFromFile = unserialize(fgets($file));
        fclose($file);
    }

    private function writeData($key){
        //a file ba kellene írni a kulcsot üres adatokkal
        $this->readFromFile = [
            "datas" => "",
            "key" => $key,
            "uname" => "",
        ];

        try {
            $file = fopen("cookie.txt", "w");
            if ($file === false){
                throw new Error("HIBA: A fájl megnyitása nem sikerült!");
            }
        }catch (Error $err){
            echo $err->getMessage()."<br>";
        }

        fwrite($file, serialize($this->readFromFile)."\n");
        fclose($file);
    }

    private function createKey(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $key = "";

        for ($i = 0; $i < 30; $i++){
            $key[$i] = $characters[rand(0,strlen($characters)-1)];
        }
        $this->writeData($key);
    }

    public function getDatas($key): array
    {
        $this->readData($key);
        return $this->datas;
    }

    public function setDatas(array $datas): void
    {
        $this->datas = $datas;
    }

    public static function cookiesEnabled(): bool
    {
        if (isset($_COOKIE["testing"]) && $_COOKIE["testing"]=='good'){
            return true;
        }
        return false;
    }
}