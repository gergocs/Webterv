<?php


class CookieManager
{
    private $key = "";
    private $loggedin;
    private $uname;
    private $good;

    function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

    private static function replace_a_line($data, $key, $uname, $loggedin) {
        if (stristr($data, $key)) {
            $array = [
                "key" => $key,
                "uname" => $uname,
                "login" => $loggedin,
            ];
                $good = false;
                return serialize($array).'\n';
            }
        return $data;
    }

    private function readData(){
        $file = fopen("cookie.txt", "r");
        $counter = 0;
        while(!feof($file)) {
            $tmp = unserialize(fgets($file));
            $tkey = $tmp["key"];
            if (strcmp($tkey,$this->key) == 0){
                $this->uname = $tmp["uname"];
                $this->loggedin = $tmp["login"];
                $counter = 1;
                break;
            }
        }
        if ($counter == 0){
            $this->createKey();
        }
        fclose($file);
    }

    private function writeData(){
        $good = true;
        $data = file('cookie.txt');

        $data = array_map('replace_a_line',$data);
        file_put_contents('cookie.txt', implode('', $data));

        if (!$good){
            $file = fopen("cookie.txt", "a");
            $this->createKey();
            $this->loggedin = false;
            $array = [
                "key" => $this->key,
                "uname" => $this->uname,
                "login" => $this->loggedin,
            ];
            fwrite($file, serialize($array)."\n");
            fclose($file);
        }


    }

    public function createKey()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $key = "";

        for ($i = 0; $i < 30; $i++){
            $key[$i] = $characters[rand(0,strlen($characters)-1)];
        }
        $this->key = $key;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($uname): void
    {
        $this->uname = $uname;
        $this->writeData();
    }

    public function getLoggedin()
    {
        return $this->loggedin;
    }

    public function setLoggedin($loggedin): void
    {
        $this->loggedin = $loggedin;
    }



    public static function cookiesEnabled(): bool
    {
        if (isset($_COOKIE["testing"]) && $_COOKIE["testing"]=='good'){
            return true;
        }
        return false;
    }
}