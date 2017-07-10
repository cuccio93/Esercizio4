<?php
    switch($_POST["action"]){
        case "add": echo addToWishlist();
            break;
        case "delete": echo deleteToWishlist();
            break;
        case "view": echo viewWishList();
            break;
    }


function addToWishlist(){
    $id = $_POST["id"];

    $conn = connectToDatabase();

    $sql = "INSERT INTO wishlist (idimmobili) VALUES (?)";

    try{
        $statement = $conn->prepare($sql);
        $statement->execute(array($id));
    }catch(PDOException $e){
        return $e->getMessage();
    }

    return "1";
}  

function deleteToWishlist(){
    $id = $_POST["id"];

    $conn = connectToDatabase();

    $sql = "DELETE FROM wishlist WHERE idimmobili=".$id;

    try{
        $statement = $conn->prepare($sql);
        $statement->execute();
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    echo "1";
}

function viewWishList(){

    $conn = connectToDatabase();

    $sql = "SELECT * FROM wishlist INNER JOIN immobili ON wishlist.idimmobili = immobili.idimmobili";

    $statement = $conn->prepare($sql);
    $statement->execute();
    $immobili = $statement->fetchAll();

    $array = [];

    foreach($immobili as $immobile){
        $obj = (object) array(
            "immagine" => $immobile["immagine"],
            "titolo" => $immobile["titolo"],
            "prezzo" => $immobile["prezzo"],
            "mq" => $immobile["mq"],
            "locali" => $immobile["locali"],
            "data" => $immobile["data"],
            "localita" => $immobile["localita"],
            "provincia" => $immobile["provincia"],
            "id" => $immobile["idimmobili"]
        );

        array_push($array,$obj);
    }

    return json_encode($array);
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