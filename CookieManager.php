<?php


class CookieManager
{
    private $datas = [];

    function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

    public function __construct(){
        $this->createKey();
    }

    private function readData($key){
        //A fileból ki kellene olvasni az adatokat
    }

    private function writeData($key){
        //a file ba kellene írni a kulcsot üres adatokkal
    }

    private function createKey(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $key = "";

        for ($i = 0; $i < 30; $i++){
            $key[$i] = $characters[rand(0,strlen($characters)-1)];
        }
        $this->writeData($key);
    }

    public function getDatas(): array
    {
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