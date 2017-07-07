<?php
require_once('lib/tcpdf/config/lang/ita.php');
require_once('lib/tcpdf/tcpdf.php');
$hostname = "localhost";
    $dbname = "esercizio4";
    $user = "root";
    
  
    $ val=$_GET;


        try
        {
            $db = new PDO ("mysql:host=$hostname;dbname=$dbname;", $user);
        
            $query="SELECT nome,titolo,prezzo,mq,locali,data,località,provincia,immagine FROM immobili where idimmobili='$val'";
            $tipi_immobile=$db->query($query);
            $pdf= new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf=AddPage();
            $pdf=SetFont('', 'B');
            $html= <<<EOD
                        <h1>Caratterisiche</h1>
                        .$tipi_immobile['immagine'].<br>
                        
                        <h4>titolo</h4>
                        EOD;
            $pdf->writeHTMLCell(0, 0, 10, 10, $html);

             
               
            
        }
    catch(PDOException $e) 
        {
            echo 'Attenzione: '.$e->getMessage();
        }
?>
