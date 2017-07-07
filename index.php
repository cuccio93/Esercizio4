<?php
$hostname = "localhost";
    $dbname = "esercizio4";
    $user = "root";
    $password = "root";
   

    try
        {
            $db = new PDO ("mysql:host=$hostname;dbname=$dbname;", $user,$password);
        
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
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img src="img\logo.ico"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Lista offerte <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php
            foreach($tipi_immobile as $tipi_immobile)
            {
                echo '<li><a href="#" onclick="getImmobili(\''.$tipi_immobile['nome'].'\')">'.$tipi_immobile['nome'].'</a></li>';            }
                ?>
          </ul>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
    <h1 id="titolo"></h1>
    <table  class="table">
        <thead>
            <tr>
                <th></th>
                <th>Titolo</th>
                <th>Prezzo</th>
                <th>Mq</th>
                <th>Locali</th>
                <th>Data annuncio</th>
                <th>Località</th>
                <th>Provincia</th>
            </tr>
        </thead>
        <tbody id="immobili">
        </tobody>
        </tbody>
    </table>

  
<script src="lib/jquery-3.2.1.min.js"></script>
<script src="lib/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>