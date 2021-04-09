<?php


class CallApi
{
    private const apiKey = 'e2bd18f9d168bcad59428813e6ce1732';
    private $city;
    private $lat;
    private $lon;
    private $wheather;
    function __construct($city)
    {
        $datas = json_decode(file_get_contents("city.list.json"), true);

        $counter = 0;
        foreach ($datas as $data) {
            if ($data["name"] === $city) {
                $this->lon = $data["coord"]["lon"];
                $this->lat = $data["coord"]["lat"];
                break;
            }else{
                $counter++;
            }
        }
        if ($counter == count($datas)){
            $rnum = rand(0, count($datas));
            $city = $datas[$rnum]["name"];
            $this->lon = $datas[$rnum]["coord"]["lon"];
            $this->lat = $datas[$rnum]["coord"]["lat"];
        }
        $this->city = $city;
    }

    function getCity(){
        return $this->city;
    }

    function getForeCast(){
        $apiUrl = "https://api.openweathermap.org/data/2.5/onecall?lat=" . $this->lat . "&lon=" . $this->lon . "&lang=hu&exclude=minutely,hourly" . "&appid=" . self::apiKey;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        $this->wheather=json_decode($response, true);
        return $data;
    }

    function hungarialo($day): string
    {
        switch ($day){
            case "Monday": return "Hétfő";
            case "Tuesday": return "Kedd";
            case "Wednesday": return "Szerda";
            case "Thursday": return "Csütörtök";
            case "Friday": return "Péntek";
            case "Saturday": return "Szombat";
            case "Sunday": return "Vasárnap";
        }
        return "Hetfo";
    }

    function getTemp(): array
    {
        $temp = [
            "date" => "",
            "morning" => "",
            "night" => "",
        ];
        $retVal = [];
        for ($i = 0; $i < 8; $i++){
            $temp["date"] = $this->hungarialo(date("l",$this->wheather["daily"][$i]["dt"]));
            $temp["morning"] = round($this->wheather["daily"][$i]["temp"]["day"] - 273.15);
            $temp["night"] = round($this->wheather["daily"][$i]["temp"]["night"] - 273.15);
            $retVal[$i] = $temp;
        }
        return $retVal;
    }
    function getWind(): array
    {
        $temp = [
            "speed" => "",
            "date" => "",
        ];
        $retVal = [];
        for ($i = 0; $i < 8; $i++){
            $temp["date"] = date("l",$this->wheather["daily"][$i]["dt"]);
            $temp["speed"] = round($this->wheather["daily"][$i]["wind_speed"] * 3.6);
            $retVal[$i] = $temp;
        }
        return $retVal;
    }
    function getCloud(): array
    {
        $temp = [
            "clouds" => "",
            "date" => "",
        ];
        $retVal = [];
        for ($i = 0; $i < 8; $i++){
            $temp["date"] = date("l",$this->wheather["daily"][$i]["dt"]);
            $temp["clouds"] = $this->wheather["daily"][$i]["clouds"];
            $retVal[$i] = $temp;
        }
        return $retVal;
    }
    function getSun(): array
    {
        $temp = [
            "sun" => "",
            "date" => "",
        ];
        $retVal = [];
        for ($i = 0; $i < 8; $i++) {
            $temp["date"] = date("l", $this->wheather["daily"][$i]["dt"]);
            $var = "fog";
            if (strcmp($this->wheather["daily"][$i]["weather"][0]["main"], "Clouds") > 0) {
                $var = "clouds";
            } else if (strcmp($this->wheather["daily"][$i]["weather"][0]["main"], "Thunderstorm") > 0){
                $temp["sun"] = "thunder";
            }else if (strcmp($this->wheather["daily"][$i]["weather"][0]["main"], "Drizzle") > 0){
                $temp["sun"] = "rain";
            }else if (strcmp($this->wheather["daily"][$i]["weather"][0]["main"], "Rain") > 0){
                $temp["sun"] = "rain";
            }else if (strcmp($this->wheather["daily"][$i]["weather"][0]["main"], "Snow") > 0){
                $temp["sun"] = "snow";
            }else if (strcmp($this->wheather["daily"][$i]["weather"][0]["main"], "Clear") > 0){
                $temp["sun"] = "clear";
            }
            $temp["sun"] = $var;
            $retVal[$i] = $temp;
        }
        return $retVal;

    }
}