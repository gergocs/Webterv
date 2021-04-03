<?php
    if(!session_id()) session_start();
    include("globals.php");
    $good = true;

$gUsers = [ //Ide lehetne egy file beolvasás
    "NagyLajosAJampi" => "lajcsivagyok",
    "LakatosPS5" => "sadlife",
];
$_SESSION['gUsers'] = $gUsers;

    function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

    if(isset($_POST["uname"])){
        $gUserInfo["uName"] = $_POST["uname"];
        $gUserInfo["pWord"] = $_POST["password"];
        if (isset($_SESSION['gUsers'])) {
            $tmp = $_SESSION['gUsers'];
            if (isset($tmp[$gUserInfo["uName"]])) {
                console_log(strcmp($tmp[$gUserInfo["uName"]], $gUserInfo["pWord"]));
                if (strcmp($tmp[$gUserInfo["uName"]], $gUserInfo["pWord"]) == 0) {
                    $good = false;
                }
            }
        }

        $_SESSION['gUserInfo'] = $gUserInfo;

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
            <h1 id="pName">WheaterPro</h1>
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
        <label for="uname"></label><input type="text" id="uname" name="uname" placeholder="janosvagyok123"><br>
        <label>
            <input type="password" class="password" name="password" placeholder="******">
        </label><br>
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
    $_SESSION["gLoggedIn"] = true;
    $_SESSION["gUname"] = $gUserInfo["uName"];
    header("Location: index.php");
}