<?php
    include_once 'PictureManagement.php';
    ini_set('session.cookie_secure', 1);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
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
    <?php
    include_once "header.php";
    ?>
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