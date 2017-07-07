<?php
    $conn = connectToDatabase();

    $tipo_immobile = $_POST["tipo_immobile"];

    $sql = "SELECT * FROM immobili WHERE tipo_immobile = '".$tipo_immobile."'";

    $lista_immobili = $conn->query($sql);

    $array = [];

    foreach($lista_immobili as $immobile){
        $obj = (object) array(
            "immagine" => $immobile["immagine"],
            "titolo" => $immobile["titolo"],
            "prezzo" => $immobile["prezzo"],
            "mq" => $immobile["mq"],
            "locali" => $immobile["locali"],
            "data" => $immobile["data"],
            "localita" => $immobile["localita"],
            "provincia" => $immobile["provincia"],
        );

        array_push($array,$obj);
    }

    echo json_encode($array);

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