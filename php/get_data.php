<?php

$conn = connectToDatabase();

$sql = "SELECT nome FROM tipi_immobili";

$tipiImmobili = $conn->query($sql);

foreach($tipiImmobili as $tipoImmobile){
    $html = file_get_contents("http://www.subito.it/annunci-italia/".$tipoImmobile["nome"]);

    $array = explode('<article class="item_list view_listing"',$html);

    for($i=1;$i<count($array);$i++){

        //RECUPERO IMMAGINE
        $array_image= explode('<div class="item_image_wrapper">',$array[$i]);
        $array_image_text = explode('<div class="item_extra_images">',$array_image[1]);
        $immagine = $array_image_text[0];
    }
}


function connectToDatabase(){
        $host = "localhost";
        $db = "esercizio4";
        $username="root";
        $password="root";

        try{
            $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8",$username,$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,"SET NAMES utf8");
        }
        catch(PDOException $e)
        {
        // notifica in caso di errore nel tentativo di connessione
        echo $e->getMessage();
        }

        return $conn;
    }
?>