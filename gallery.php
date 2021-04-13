<?php
    include_once 'PictureManagement.php';
    if(!session_id()) session_start();
    $p1 = new PictureManagement("img/uploaded/");
?>
<!DOCTYPE html>

<html lang="hu">

<head>
    <title>Galéria</title>
    <meta charset="UTF-8">
    <link rel="icon" href="img/sun_icon.png">
    <link rel="stylesheet" href="css/style.css">
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
                        <li><a href="index.php">Kezdőlap</a></li>
                        <li><a href="gallery.php" class="active">Galéria</a></li>
                        <li><a href="feedback.php">Visszajelzés</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <div id="content" class="noselect">
            <table id="images-table">
                <caption><h3>Felhasználók által küldött képek</h3></caption>
                <tr>
                    <td class="user-images"><img src="<?php echo $p1->display_pictures(); ?>" height="200" alt="Felhasználói kép"></td>
                    <td class="user-images"><img src="<?php echo $p1->display_pictures(); ?>" height="200" alt="Felhasználói kép"></td>
                    <td class="user-images"><img src="<?php echo $p1->display_pictures(); ?>" height="200" alt="Felhasználói kép"></td>
                </tr>
                <tr>
                    <td class="user-images"><img src="<?php echo $p1->display_pictures(); ?>" height="200" alt="Felhasználói kép"></td>
                    <td class="user-images"><img src="<?php echo $p1->display_pictures(); ?>" height="200" alt="Felhasználói kép"></td>
                    <td class="user-images"><img src="<?php echo $p1->display_pictures(); ?>" height="200" alt="Felhasználói kép"></td>
                </tr>
                <tr>
                    <td class="user-images"><img src="<?php echo $p1->display_pictures(); ?>" height="200" alt="Felhasználói kép"></td>
                    <td class="user-images"><img src="<?php echo $p1->display_pictures(); ?>" height="200" alt="Felhasználói kép"></td>
                    <td class="user-images"><img src="<?php echo $p1->display_pictures(); ?>" height="200" alt="Felhasználói kép"></td>
                </tr>
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