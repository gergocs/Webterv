<?php
    include_once 'class/PictureManagement.php';
    ini_set('session.cookie_secure', 1);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    if(!session_id()){
        session_start();
    }

    if(isset($_POST["review"])){
        $review = [];
        $review["review"] = $_POST["review"];
        $var = true;
        switch ($_POST["radio"]){
            case "ok":
            case "good": $var = true; break;
            case "bad": $var = false; break;
        }
        $review["god"] = $var;
        $var = $_SESSION["reviewC"];
        $_SESSION["review"][$var] = $review;
        $_SESSION['reviewC'] = $var + 1;
        $feedback =[
            "uname" => $_SESSION['gUname'],
            "opinion" => $review["god"],
            "text" => $review["review"]
        ];
        $file = "";
        try {
            $file = fopen("data/feedbacks.txt", "a");
            if ($file === false){
                throw new Error("HIBA: A fájl megnyitása nem sikerült!");
            }
        }catch (Error $err){
            echo $err->getMessage()."<br>";
        }
        fwrite($file, serialize($feedback)."\n");
        fclose($file);
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
<?php
    if ($_SESSION["gLoggedIn"]){

        include_once "header.php";

    }else{
        header("Location: login.php");
    }
?>
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
                <textarea id="review" class="texta" name="review" rows="10" cols="50" placeholder="Egy menci vélemény az oldalról"></textarea><br>
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
        ?>

        <p class="pinned-feedback">Mások ezt írták rólunk:</p>
        <table class="pinned-feedback">
            <?php
            try {
                $file = fopen("data/feedbacks.txt", "r");
                if ($file === false){
                    throw new Error("HIBA: A fájl megnyitása nem sikerült!");
                }
            }catch (Error $err){
                echo $err->getMessage()."<br>";
            }
            while ( ($line = fgets($file)) !== false ){
                $feedback = unserialize($line);
                if ($feedback["opinion"]) {
                    echo "<tr>";
                    echo "<td>" . $feedback["uname"] . ": " . "</td>";
                    echo "<td>" . " (jó) " . "</td>";
                    echo "<td>" . $feedback["text"] . "</td>";
                    echo "</tr>";
                }
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
