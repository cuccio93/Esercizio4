<?php

//SETTO IL TEMPO LIMITE
set_time_limit(99999999999999999999);

//CONNESSIONE AL DATABASE
$conn = connectToDatabase();

//RICAVO TUTTI  I TIPI DI IMMOBILI
$sql = "SELECT url,nome FROM tipi_immobili";
$tipiImmobili = $conn->query($sql);

//CICLO SUI TIPI DI IMMOBILI
foreach($tipiImmobili as $tipoImmobile){

    //RECUPERO LA PAGINA
    $html = file_get_contents("http://www.subito.it/annunci-italia/".$tipoImmobile["url"]);

    $array = explode('<article class="item_list view_listing"',$html);

    for($i=1;$i<count($array);$i++){

        //RECUPERO IMMAGINE
        $array_image= explode('<div class="item_image_wrapper">',$array[$i]);
        $array_image_text = explode('<div class="item_extra_images">',$array_image[1]);
        $immagine = $array_image_text[0];

        //RECUPERO TITOLO CON LINK
        $array_title = explode('<div class="item_list_section item_description"> <h2>',$array[$i]);
        $array_title_text = explode('</h2>',$array_title[1]);
        $titolo = $array_title_text[0];

        //RECUPERO PREZZO
        $array_prezzo = explode('<span class="item_price">',$array[$i]);
        $array_prezzo_text = explode('</span>',$array_prezzo[1]);
        $prezzo = $array_prezzo_text[0];

        //RECUPERO MQ E LOCALI
        $array_mq_locali = explode('<span class="item_specs">',$array[$i]);
        $array_mq_locali_text = explode('</span>',$array_mq_locali[1]);
        $array_mq_locali_divisi = explode(',',$array_mq_locali_text[0]);

        $mq = $array_mq_locali_divisi[0];
        $locali = $array_mq_locali_divisi[1];

        //RECUPERO LA DATA DI IMMISSIONE ANNUNCIO
        $array_data = explode('<span class="item_info">  <time datetime="',$array[$i]);
        $array_data_text = explode('">',$array_data[1]);
        $data = $array_data_text[0];

        //RECUPERO LOCALITA'
        $array_localita = explode('<span class="item_location">',$array[$i]);
        $array_localita_text = explode('<em class="item_city">',$array_localita[1]);
        $localita = $array_localita_text[0];

        $array_provincia = explode('</em>',$array_localita_text[1]);
        $provincia = $array_provincia[0];

        //INSERISCO I DATI NELLA TABELLA
        $sql = "INSERT INTO immobili (immagine,titolo,prezzo,mq,locali,data,localita,provincia,tipo_immobile) VALUES (?,?,?,?,?,?,?,?,?)";

        try{
        $statement = $conn->prepare($sql);
        $statement->execute(array($immagine,$titolo,$prezzo,$mq,$locali,$data,$localita,$provincia,$tipoImmobile["nome"]));
        }catch(PDOException $e){
            echo $e->getMessage();
        }
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