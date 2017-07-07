<?php
$hostname = "localhost";
    $dbname = "esercizio4";
    $user = "root";
   

    try
        {
            $db = new PDO ("mysql:host=$hostname;dbname=$dbname;", $user);
        
            $query="SELECT nome FROM tipi_immobili ORDER BY nome";
            $tipi_immobile=$db->query($query);
        }
    catch(PDOException $e) 
        {
            echo 'Attenzione: '.$e->getMessage();
        }
?>




<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="lib/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Esercizio 4</title>
</head>
<body>
  
<script src="lib/jquery-3.2.1.min.js"></script>
<script src="lib/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>