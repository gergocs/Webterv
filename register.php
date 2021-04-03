<?php
    include "globals.php";
    $goodUname = -1;
    $goodPw = -1;
    $goodPwA = -1;
    $goodMail = -1;

    $gUsers = [ //Ide lehetne egy file beolvasás
        "NagyLajosAJampi" => "lajcsivagyok",
        "LakatosPS5" => "sadlife",
    ];

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
        if (preg_match($regexUname,$_POST['uname'])>=1){
            $array_keys = array_keys($gUsers);
            foreach ($array_keys as $array_key){
                if(strcmp($gUsers[$array_key], $_POST['uname']) != 0){
                    $goodUname = 1;
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
        if (isset($_POST['email'])){
            $regUser['mail'] = $_POST['email'];
            $goodMail = 2;
        }else{
            $goodMail = 1;
        }
        console_log($regUser);
        //Mentés fileba majd a regUsert
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
            <form action="register.php" method="post">
                <label for="uname"><input type="text" id="uname" name="uname" placeholder="janosvagyok123"
                <?php
                    if ($goodUname == 1){
                        echo '><p>Lol de béna felhasználónév</p>';
                    }else if ($goodUname == 2){
                        echo 'value=" ' . $regUser['uname']  . ' ">';
                    }else{
                        echo ">";
                    }

                ?>
                </label><br>
                <label>
                    <input type="password" class="password" name="password" placeholder="******"

                <?php
                    if ($goodPw == 1){
                        echo '<p>Ezt csukott szemmel is kitalalom</p>';
                    }else if ($goodPw == 2){
                        echo 'value=" ' . $tmp  . ' ">';
                    }else{
                        echo ">";
                    }
                ?>
                </label><br>
                <label>
                    <input type="password" class="password" name="pwagain" placeholder="******"
                <?php
                    if ($goodPwA == 1){
                        echo '<p>Mi van nem megy a gépelés?</p>';
                    }else if ($goodPwA == 2){
                        echo 'value=" ' . $regUser['pword']  . ' ">';
                    }else{
                        echo ">";
                    }

                ?>
                </label><br>
                <label for="email"><input type="email" id="email" class="texts" name="email" placeholder="janika@gmail.com"
                <?php
                    if ($goodPw == 1){
                        echo '<p>Azért nem olyan nehéz egy emailt beírni</p>';
                    }else if ($goodPwA == 2){
                        echo 'value=" ' . $regUser['mail']  . ' ">';
                    }else{
                        echo ">";
                    }
                ?>
                </label><br>
                <input type="submit" id="register" class="send" value="Regisztráció">
                <input type="reset" id="reset" class="send" value="Visszaállítás">
            </form>
            <form action="login.php" method="get">
                <input type="submit" id="login" class="send" value="Bejelentkezés">
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

    </html>

<?php
    }else{
        header("Location: login.php");
    }
