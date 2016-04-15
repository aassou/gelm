<?php
    //classes loading begin
    function classLoad ($myClass) {
        if(file_exists('../model/'.$myClass.'.php')){
            include('../model/'.$myClass.'.php');
        }
        elseif(file_exists('../controller/'.$myClass.'.php')){
            include('../controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('../config.php');  
    //classes loading end
    session_start();
    if( isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil()=="admin" ){
        //classes managers  
        $projetManager = new ProjetManager($pdo);
        $caisseManager = new CaisseManager($pdo);
        $caisseDetailsManager = new CaisseDetailsManager($pdo);
        $projets = $projetManager->getProjets();
        $idCaisse = htmlentities($_POST['idCaisse']);
        $caisse = $caisseManager->getCaisseById($idCaisse);
        $caisseDetails = "";
        if($_POST['duree']=="all"){
            $caisseDetails = $caisseDetailsManager->getCaisseDetailsByIdCaisse($idCaisse);
        }
        else{
            $from = htmlentities($_POST['dateFrom']);
            $to = htmlentities($_POST['dateTo']);
            $caisseDetails = $caisseDetailsManager->getCaisseDetailsByIdCaisseByDate($idCaisse, $from, $to);
        }

ob_start();
?>
<style type="text/css">
    p, h1{
        text-align: center;
        text-decoration: underline;
    }
    table {
            border-collapse: collapse;
            width:100%;
        }
        
        table, th, td {
            border: 1px solid black;
			font-size: 10px;
        }
        td, th{
            padding : 5px;
        }
        
        th{
            background-color: grey;
        }
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <img src="../assets/img/logo_company.png" style="width: 110px" />
    <br><br><br>
    <h1>Bilan Détaillé Caisse <?= $caisse->nom() ?></h1>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <br><br><br>
    <table>
        <tr>
            <th style="width:10%">Date</th>
            <th style="width:15%">Personne</th>
            <th style="width:20%">Désignation</th>
            <th style="width:10%">Projet</th>
            <th style="width:15%">Entrée</th>
            <th style="width:15%">Sortie</th>
            <th style="width:15%">Reste</th>
            <!--th style="width:10%">Comment</th-->
        </tr>
        <?php
        foreach($caisseDetails as $detail){
            $montantEntree = 0;
            $montantSortie = 0;
            
            if($detail->type()=="Sortie"){
                $montantEntree = 0;
                $montantSortie = $detail->montant();    
            }
            else{
                $montantEntree = $detail->montant();
                $montantSortie = 0;
            }
        ?>      
        <tr>
            <td style="width:10%"><?= date('d/m/Y', strtotime($detail->dateOperation())) ?></td>
            <td style="width:15%"><?= $detail->personne() ?></td>
            <td style="width:20%"><?= $detail->designation() ?></td>
            <td style="width:10%"><?= $detail->projet() ?></td>
            <td style="width:15%"><?= number_format($montantEntree, 2, ',', ' ') ?></td>
            <td style="width:15%"><?= number_format($montantSortie, 2, ',', ' ') ?></td>
            <td style="width:15%"><?= number_format(0, 2, ',', ' ') ?></td>
            <!--td style="width:10%"><?php //$detail->commentaire() ?></td-->
        </tr>   
        <?php
        }//end of loop
        ?>
    </table> 
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;">STE GELM SARL : Au capital de 100 000,00 DH – siège social QT 313 Old Brahim Mezanine B1, Nador. 
        <br>Tèl 0536601818 / 0661668860 IF : 40451179   RC : 10999  Patente 56126681</p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
        $fileName = "BilanCaisseDetails-".date('Ymdhi').'.pdf';
        $pdf->Output($fileName);
    }
    catch(HTML2PDF_exception $e){
        die($e->getMessage());
    }
}
else{
    header("Location:index.php");
}
?>
