<?php
    include_once 'CallApi.php';
    if(!session_id()) session_start();
    include_once 'globals.php';
    setcookie('testing', 'good', time()+3600);
    $cookiesGood = cookiesEnabled();

    function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

    if (!$cookiesGood){

        if (count($_SESSION) == 0){
            $_SESSION["gLoggedIn"] = false;
        }
    }

    if(isset($_GET["logout"])){
        $_SESSION["gLoggedIn"] = false;
    }

    if (!isset($_GET["login"])) {
        $response = "";
        $temp = "";
        $wind = "";
        $cloud = "";
        $sun = "";
        $cityn = "";
        if (isset($_GET['city'])){
            $weather = new CallApi($_GET['city']);
            $response = $weather->getForeCast();
            $temp = $weather->getTemp();
            $wind = $weather->getWind();
            $cloud = $weather->getCloud();
            $sun = $weather->getSun();
            $cityn = $weather->getCity();
        }
        ?>
        <!DOCTYPE html>

<html lang="hu">

    <head>
        <title>Kezdőlap</title>
        <meta charset="UTF-8">
        <link rel="icon" href="img/sun_icon.png">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
    </head>

    <body>
    <header>
        <div id="header">
            <div id="image">
                <img id="logo" src="img/animated_sun.gif" height="80" alt="">
                <h1 id="pName">WeatherPro</h1>
                <?php
                    if($_SESSION["gLoggedIn"]){
                        echo '<em id="userName">' .  $_SESSION["gUname"] . '</em>';
                        ?>
                        <form action="index.php">
                            <input type="hidden" name="logout" value="good">
                            <input type="submit" class="send" id="logout" value="Kijelentkezés">
                        </form>
                    <?php
                    }else{
                        ?>
                        <form action="index.php" method="get">
                            <input type="hidden" name="login" value="good">
                            <input type="submit" id="login2" class="send" value="Bejelentkezés">
                        </form>
                        <?php
                    }
                ?>

            </div>
            <nav>
                <div id="nav">
                    <ul class="no-bullets" id="menu">
                        <li><a href="index.php" class="active">Kezdőlap</a></li>
                        <li><a href="gallery.php">Galéria</a></li>
                        <li><a href="feedback.php">Visszajelzés</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <div id="content">
            <form action="index.php" method="get">
                <label for="city"></label><input type="text" id="city" class="texts" name="city" placeholder="Szeged">
                <input id="sbutton" type="submit" value="Keresés" class="send">
            </form>
            <?php
                if ($response != ""){
                    ?>
            <h3>Előrejelzés:
                <?php
                    echo $cityn;
                ?></h3>
            <table id="forecast-table">
                <tr>
                    <?php
                        for ($i = 0; $i < 7; $i++) {
                            echo '<th id="' . $temp[$i]["date"] . '">' . $temp[$i]["date"] . '</th>';
                        }
                    ?>
                </tr>
                <tr id="temp">
                    <?php
                        for ($i = 0; $i < 7; $i++) {
                            echo '<td headers="' . $temp[$i]["date"] . '">' . $temp[$i]["morning"] . '/' . $temp[$i]["night"] . '°C <i class="';
                                $var = "fa fa-thermometer-empty";
                                if ($temp[$i]["morning"] > 0 && $temp[$i]["morning"] < 10){
                                    $var = "fa fa-thermometer-quarter";
                                }else if($temp[$i]["morning"] > 9 && $temp[$i]["morning"] < 20){
                                    $var = "fa fa-thermometer-half";
                                }else if($temp[$i]["morning"] > 19 && $temp[$i]["morning"] < 30){
                                    $var = "fa fa-thermometer-three-quarters";
                                }else if($temp[$i]["morning"] > 29){
                                    $var = "fa fa-thermometer-full";
                                }
                                echo $var . '" aria-hidden="true"></i></th>';
                        }
                    ?>
                </tr>
                <tr id="wind">
                    <?php
                        for ($i = 0; $i < 7; $i++) {
                            echo '<td headers="' . $wind[$i]["date"] . '">' . $wind[$i]["speed"] . ' km/h</td>';
                        }
                    ?>
                </tr>
                <tr id="cloud">
                    <?php
                        for ($i = 0; $i < 7; $i++) {
                            echo '<td headers="' . $cloud[$i]["date"] . '">';
                            $var = "Derült";
                            if ($cloud[$i]["clouds"] > 0 && $cloud[$i]["clouds"] < 20){
                                $var = "Gyengén felhős";
                            }else if($cloud[$i]["clouds"] > 19 && $cloud[$i]["clouds"] < 50){
                                $var = "Borongós";
                            }else if($cloud[$i]["clouds"] > 49 && $cloud[$i]["clouds"] < 70){
                                $var = "Felhős";
                            }else if($cloud[$i]["clouds"] > 69 && $cloud[$i]["clouds"] < 90){
                                $var = "Gomoly felhős";
                            }else if($cloud[$i]["clouds"] > 89){
                                $var = "Világvége felhős";
                            }
                            echo $var . '</td>';
                        }
                    ?>
                </tr>
                <tr id="licon">
                    <?php
                        for ($i = 0; $i < 7; $i++) {
                            echo '<td headers="' . $sun[$i]['date'] . '"> <i class="';
                            $var = "";
                            if (strcmp($sun[$i]['sun'],"clouds") > 0){
                                $var = "fa fa-cloud";
                            }else if(strcmp($sun[$i]['sun'],"thunder") > 0){
                                $var = "fa fa-bolt";
                            }else if(strcmp($sun[$i]['sun'],"rain") > 0){
                                $var = "fa fa-tint";
                            }else if(strcmp($sun[$i]['sun'],"snow") > 0){
                                $var = "fa fa-snowflake-o";
                            }else if(strcmp($sun[$i]['sun'],"clear") > 0){
                                $var = "fa fa-sun-o";
                            }
                            echo $var . '" aria-hidden="true"></i></td>';
                        }
                    ?>
                </tr>
            </table>
                    <?php
                }
                    ?>
            <h3>Radarvideó</h3>
            <video id="radar" src="https://www.idokep.hu/radar/radar.mp4" width="900" controls autoplay loop></video>
            <aside>
                <h3 id="news">Meteorológia hírek</h3>
                <iframe src="https://www.met.hu/omsz/OMSZ_hirek/" ></iframe>
            </aside>
        </div>
    </main>
    <footer>
        <div id="footer">
            <div id="fcontent">
                <p>Alpha 1.0</p>
                <strong>Az előrejelzés hitelességéért felelősséget nem vállalunk!</strong>
            </div>
        </div>
    </footer>
    </body>

</html>
        <?php
    }else{
        header("Location: login.php");
    }