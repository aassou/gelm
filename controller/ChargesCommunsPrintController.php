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
        $societeManager = new SocieteManager($pdo);
        $projets = $projetManager->getProjets();
        $idSociete = htmlentities($_POST['idSociete']);
        $societe = $societeManager->getSocieteById($idSociete);
        $dateFrom = htmlentities($_POST['dateFrom']);
        $dateTo = htmlentities($_POST['dateTo']);
        
        $chargesCommunsManager = new ChargesCommunsManager($pdo);
        $totalChargesCommuns = number_format($chargesCommunsManager->getTotalByIdSociete($idSociete), 2, ',', ' ');
        $chargesCommuns = $chargesCommunsManager->getChargesCommunsByDatesByIdSociete($idSociete, $dateFrom, $dateTo);   

ob_start();
?>
<style type="text/css">
    p, h1, h2{
        text-align: center;
        text-decoration: underline;
    }
    table {
            border-collapse: collapse;
            width:100%;
        }
        
        table, th, td {
            border: 1px solid black;
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
    <br><br><br><br>
    <h2>Charges Communs Societe <?= $societe->raisonSociale() ?> du <?= date('d/m/Y', strtotime($dateFrom)).' au '.date('d/m/Y', strtotime($dateTo)) ?> </h2>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <br><br>
    <table>
        <tr>
            <th style="width: 85%"><strong>Total des charges communs</strong></th>
            <td style="width: 15%"><strong><?= $totalChargesCommuns ?>&nbsp;DH</strong></td>
        </tr>
    </table>
    <h3>Les Charges communs</h3>
    <table>
        <tr>
            <th style="width:15%">Date</th>
            <th style="width:20%">Projet</th>
            <th style="width:20%">Désignation</th>
            <th style="width:15%">Bénéficiaire</th>
            <th style="width:15%">Numéro Chèque</th>
            <th style="width:15%">Montant</th>
        </tr>
        <?php
        foreach($chargesCommuns as $charges){
        ?>      
        <tr>
            <td style="width:15%"><?= date('d/m/Y', strtotime($charges->dateOperation())) ?></td>
            <td style="width:20%"><?= $projetManager->getProjetById($charges->idProjet())->nom() ?></td>
            <td style="width:20%"><?= $charges->designation() ?></td>
            <td style="width:15%"><?= $charges->beneficiaire() ?></td>
            <td style="width:15%"><?= $charges->numeroCheque() ?></td>
            <td style="width:15%"><?= number_format($charges->montant(), 2, ' ', ',') ?>&nbsp;DH</td>
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
        $fileName = "ListeCharges-".date('Ymdhi').'.pdf';
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
