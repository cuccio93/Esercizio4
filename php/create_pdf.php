<?php
require_once('../lib/tcpdf/config/lang/ita.php');
require_once('../lib/tcpdf/tcpdf.php');
    $hostname = "localhost";
    $dbname = "esercizio4";
    $user = "root";
    $password = "root";
    
    $val=$_GET["id"];


    try
    {
        $db = new PDO ("mysql:host=$hostname;dbname=$dbname;", $user,$password);
    
        $query="SELECT * FROM immobili WHERE idimmobili=$val";
        $statement=$db->prepare($query);
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
                "id" => $immobile["idimmobili"],
            );

            array_push($array,$obj);
        }

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->SetFont('', 'B');

        $immobile = $array[0];
        
        //errore prossima riga
        $array2 = explode('src="',$immobile->immagine);
        
        $array_image = explode('"',$array2[1]);
        $data = file_get_contents($array_image[0]);

        //$pdf->Image('@'.$data);
        $html= "<h1>".$immobile->titolo."</h1>
                        <table>
                            <tr>
                                <td>".$immobile->immagine."
                                    <h4>".$immobile->prezzo."</h4>
                                </td>
                                <td>
                                    <p>Data : ".$immobile->data."</p>
                                    <p>Mq : ".$immobile->mq."</p>
                                    <p>Locali : ".$immobile->locali."</p>
                                    <p>Località : ".$immobile->localita ." ".$immobile->provincia."</p>
                                </td>
                            </tr>
                        </table>";

        $pdf->writeHTMLCell(0, 0, 10, 10, $html);

        // Invia PDF inline
        $pdf->Output('esempio_html.pdf', 'I');

            
            
        
    }catch(PDOException $e) {
        echo 'Attenzione: '.$e->getMessage();
    }

?>
