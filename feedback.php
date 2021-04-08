<?php
    include_once 'PictureManagement.php';
    if(!session_id()) session_start();

    function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

    if(isset($_GET["review"])){
        $review = [];
        $review["review"] = $_GET["review"];
        $var = true;
        switch ($_GET["radio"]){
            case "good": $var = true; break;
            case "bad":
            case "ok": $var = false; break;
        }
        $review["god"] = $var;
        $var = $_SESSION["reviewC"];
        $_SESSION["review"][$var] = $review;
        $_SESSION['reviewC'] = $var + 1;
    }

?>
<!DOCTYPE html>

<html lang="hu">

<head>
    <title>Visszajelzés</title>
    <meta charset="UTF-8">
    <link rel="icon" href="img/sun_icon.png">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<header>
    <div id="header">
        <div id="image">
            <img id="logo" src="img/animated_sun.gif" height="80" alt="">
            <h1 id="pName">WheaterPro</h1>
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
                header("Location: login.php");
            }
            ?>
        </div>
        <nav>
            <div id="nav">
                <ul class="no-bullets" id="menu">
                    <li><a href="index.php">Kezdőlap</a></li>
                    <li><a href="gallery.php">Galéria</a></li>
                    <li><a href="feedback.php" class="active">Visszajelzés</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<main>
    <div id="content">
        <form action="feedback.php" method="post" enctype="multipart/form-data">
            <label for="review" id="form-label">Rövid vélemény:</label><br>
            <div id="feedb">
                <div id="radiobc">
                    <label class="radioc">Jó
                        <input type="radio" checked="checked" name="radio"  value="good">
                        <span class="checkmark"></span>
                    </label>
                    <label class="radioc">Elmegy
                        <input type="radio" name="radio" value="ok">
                        <span class="checkmark"></span>
                    </label>
                    <label class="radioc">Rossz
                        <input type="radio" name="radio" value="bad">
                        <span class="checkmark"></span>
                    </label><br>
                </div>
                <textarea id="review" class="texta" name="review" rows="10" cols="50" placeholder="Egy menci vélemény az oldalrol"></textarea><br>
                <label for="review" id="form-label">Kép feltöltése:</label><br>
                <div>
                    <input type="file" name="weather-pic" accept="image/*" class="file-send">
                </div>
            </div>
            <input type="submit" value="Küldés" class="send">
            <input type="reset" id="reset" class="send" value="Visszaállítás">
        </form>

        <?php
        $p1 = new PictureManagement("img/uploaded/");
        $p1->save_pictures("weather-pic");

        $feedback =[
            "uname" => "Brendon",
            "opinion" => "Elmegy",
            "text" => "Mi ez te?"
        ];

        $file = fopen("feedbacks.txt", "a");
        //fwrite($file, serialize($feedback)."\n");
        fclose($file);
        ?>

        <p class="pinned-feedback">Mások ezt írták rólunk:</p>
        <table class="pinned-feedback">
            <tr>
                <td>Józsi bácsi: </td>
                <td> (Jó) </td>
                <td>Nagyon menci</td>
            </tr>
            <?php
            $file = fopen("feedbacks.txt", "r");
            while ( ($line = fgets($file)) !== false ){
                $feedback = unserialize($line);
                echo "<tr>";
                    echo "<td>".$feedback["uname"].": "."</td>";
                    echo "<td>"." (".$feedback["opinion"].") "."</td>";
                    echo "<td>".$feedback["text"]."</td>";
                echo "</tr>";
            }
            fclose($file);
            ?>
        </table>
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
