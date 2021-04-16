<?php
    include "globals.php";
    $goodUname = -1;
    $goodPw = -1;
    $goodPwA = -1;
    $goodMail = -1;

    $Users = [];
    $Users = [];


    $file = "";
    try {
        $file = fopen("users.txt", "r");
        if ($file === false){
            throw new Error("HIBA: A fájl megnyitása nem sikerült!");
        }
    }catch (Error $err){
        echo $err->getMessage()."<br>";
    }

    while ( ($line = fgets($file)) !== false ){
        $User = unserialize($line);
        $Users[] = $User;
    }
    fclose($file);

    function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }
    $regUser =[
        "uname" => "",
        "pword" => "",
        "mail" => "",
    ];
    $tmp = "";
    if(isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['email'])){

        $regexUname = "/^(?=[a-zA-Z0-9._]{8,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/";
        $regexPword = "/^(?=[a-zA-Z0-9._]{8,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/";
        $regexEmail = "/^[0-9a-z\.-]+@([0-9a-z-]+\.)+[a-z]{2,4}$/";
        if (preg_match($regexUname,$_POST['uname'])==1){
            foreach ($Users as $user) {
                if (strcmp($user["uname"], $_POST['uname']) == 0) {
                    $goodUname = 0;
                    goto SKIP;
                }
            }
            $regUser['uname'] = $_POST['uname'];
            $goodUname = 2;
        }else{
            $goodUname = 1;
        }
        SKIP:
        if (preg_match($regexPword,$_POST['password'])>=1){
            $goodPw = 2;
            $tmp = $_POST['password'];
            if(strcmp($_POST['password'],$_POST['pwagain']) == 0){
                $regUser['pword'] = $_POST['password'];
                $goodPwA = 2;
            }else{
                $goodPwA = 1;
            }
        }else{
            $goodPw = 1;
        }
        if (preg_match($regexEmail,$_POST['email'])>=1){
            foreach ($Users as $user) {
                if (strcmp($user["mail"], $_POST['email']) == 0){
                    $goodMail = 1;
                    goto SKIP2;
                }
            }
            $regUser['mail'] = $_POST['email'];
            $goodMail = 2;
        }else{
            $goodMail = 1;
        }
        SKIP2:
    }
    if ($goodUname < 2 || $goodPw < 2 || $goodPwA < 2 || $goodMail < 2){
?>
    <!DOCTYPE html>

    <html lang="hu">

    <head>
        <title>Regisztráció</title>
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
            <form action="register.php" method="post">
                <label for="uname"><input type="text" id="uname" name="uname" placeholder="MintaGabor84"></label>
                <?php
                    try {
                        if ($goodUname == 0){
                            throw new TypeError("Ilyen felhasználónév már létezik!");
                        }
                        else if ($goodUname == 1){
                            throw new TypeError("Kis- és nagybetűket és számokat tartalmazhat és 8-20 karakter hosszúságú lehet!");
                        }
                    }catch (TypeError $te){
                        echo $te->getMessage();
                    }

                ?>
                <br>
                <label>
                    <input type="password" class="password" name="password" placeholder="********"></label>

                <?php
                    try {
                        if ($goodPw == 1){
                            throw new TypeError("Kis- és nagybetűket és számokat tartalmazhat és 8-20 karakter hosszúságú lehet!");
                        }
                    }catch (TypeError $te){
                        echo $te->getMessage();
                    }
                ?>
                <br>
                <label>
                    <input type="password" class="password" name="pwagain" placeholder="******"></label>
                <?php
                    try {
                        if ($goodPwA == 1){
                            throw new TypeError("A beírt jelszó nem egyezik!");
                        }
                    }catch (TypeError $te){
                        echo $te->getMessage();
                    }
                ?>
                <br>
                <label for="email"><input type="email" id="email" class="texts" name="email" placeholder="minta@gmail.com"></label>
                <?php
                    try {
                        if ($goodMail == 1){
                            throw new TypeError("Hibás vagy már regisztrált email!");
                        }
                    }catch (TypeError $te){
                        echo $te->getMessage();
                    }
                ?>
                <br>
                <input type="submit" id="register" class="send" value="Regisztráció">
                <input type="reset" id="reset" class="send" value="Visszaállítás">
            </form>
            <form action="login.php" method="get">
                <input type="submit" id="login" class="send" value="Bejelentkezés">
            </form>
        </div>
        <?php

        ?>
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
        try {
            $file = fopen("users.txt", "a");
            if ($file === false){
                throw new Error("HIBA: A fájl megnyitása nem sikerült!");
            }
        }catch (Error $err){
            echo $err->getMessage()."<br>";
        }
        fwrite($file, serialize($regUser)."\n");
        fclose($file);
        header("Location: login.php");
    }
