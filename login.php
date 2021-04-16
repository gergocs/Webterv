<?php
    ini_set('session.cookie_secure', 1);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    if(!session_id()){
        session_start();
    }
    $good = true;
    $goodUname = -1;
    $goodPw = -1;
    $Users = [];

    try {
        $file = fopen("data/users.txt", "r");
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

    if(isset($_POST["uname"])){
        foreach ($Users as $user){
            if (strcmp($user["uname"],$_POST["uname"]) == 0){
                $goodUname = 2;
                if (strcmp($user["pword"],$_POST["password"]) == 0){
                    $good = false;
                    $_SESSION["gLoggedIn"] = true;
                    $_SESSION["gUname"] = $_POST["uname"];
                }else{
                    $goodPw = 1;
                }
            }else{
                $goodUname = 1;
            }
        }
    }
    if($good){
        ?><!DOCTYPE html>

<html lang="hu">

<head>
    <title>Bejelentkezés</title>
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
    <form action="login.php" method="post">
        <label for="uname"><input type="text" id="uname" name="uname" placeholder="MintaGabor84"></label>
        <?php
            try {
                if ($goodUname == 1){
                    throw new TypeError("Hibás felhasználónév!");
                }
            }catch (TypeError $te){
                echo $te->getMessage();
            }
        ?>
        <br>
        <label>
            <input type="password" class="password" name="password" placeholder="********">
        </label>
        <?php
            try {
                if ($goodPw == 1){
                    throw new TypeError("Hibás jelszó!");
                }
            }catch (TypeError $te){
                echo $te->getMessage();
            }

        ?>
        <br>
        <input type="submit" id="login" class="send" value="Bejelentkezés">
        <input type="reset" id="reset" class="send" value="Visszaállítás">
    </form>
    <form action="register.php" method="get">
        <input type="submit" id="register" class="send" value="Regisztráció">
    </form>
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

</html>'
<?php
}else{
    header("Location: index.php");
}