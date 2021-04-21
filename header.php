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
                    <?php
                        if ($_SESSION["page"] == 1){
                            ?>
                                <li><a href="index.php" class="active">Kezdőlap</a></li>
                                <li><a href="gallery.php">Galéria</a></li>
                                <li><a href="feedback.php">Visszajelzés</a></li>
                            <?php

                        }else if($_SESSION["page"] == 2){
                            ?>
                                <li><a href="index.php">Kezdőlap</a></li>
                                <li><a href="gallery.php" class="active">Galéria</a></li>
                                <li><a href="feedback.php">Visszajelzés</a></li>
                            <?php
                        }else{
                            ?>
                                <li><a href="index.php">Kezdőlap</a></li>
                                <li><a href="gallery.php">Galéria</a></li>
                                <li><a href="feedback.php" class="active">Visszajelzés</a></li>
                            <?php
                        }
                    ?>
                </ul>
            </div>
        </nav>
    </div>
</header>