<?php


class PictureManagement
{
    private $path;
    private $allowed_extensions = ["jpg", "jpeg", "png"];
    private $displayed_pictures = array();
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function save_pictures($name)
    {
        if (isset($_FILES[$name]) && $_FILES[$name]["size"] !== 0) {

            $extension = strtolower(pathinfo($_FILES[$name]["name"], PATHINFO_EXTENSION));

            try {
                if (in_array($extension, $this->allowed_extensions)) {
                    if ($_FILES[$name]["error"] === 0) {
                        $destination = $this->path . $_FILES[$name]["name"];

                        if (file_exists($destination)) {
                            throw new Error("<strong>Figyelem:</strong> Ilyen nevű fájl már létezik! <br/>");
                        }else{
                            if (move_uploaded_file($_FILES[$name]["tmp_name"], $destination)) {
                                echo "Sikeres fájlfeltöltés! <br/>";
                            } else {
                                throw new Error("<strong>Hiba:</strong> A fájl átmozgatása nem sikerült! <br/>");
                            }
                        }
                    } else {
                        throw new Error("<strong>Hiba:</strong> A fájlfeltöltés nem sikerült! <br/>");
                    }
                } else {
                    throw new Error("<strong>Hiba:</strong> A fájl kiterjesztése nem megfelelő! <br/>");
                }
            }catch (Error $err){
                echo $err->getMessage();
            }
        }
    }

    public function display_pictures(){
        $imgs_arr = array();
        // Get files from the directory
        $dir_arr = scandir($this->path);
        $arr_files = array_diff($dir_arr, array('.','..') );
        foreach ($arr_files as $file) {
            if (in_array($file, $this->displayed_pictures) === false){
                array_push($imgs_arr, $file);
            }
        }
        $count_img_index = count($imgs_arr) - 1;
        $random_img = $imgs_arr[rand( 0, $count_img_index )];
        array_push($this->displayed_pictures, $random_img);
        return $this->path."/".$random_img;
    }
}