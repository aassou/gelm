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
        //les sources
        $mois = $_GET['mois'];
        $annee = $_GET['annee'];
        $idProjet = 0;
        $projetManager = new ProjetManager($pdo);
        $societeManager = new SocieteManager($pdo);
        $contratManager = new ContratManager($pdo);
        $locauxManager = new LocauxManager($pdo);
        $maisonManager = new MaisonManager($pdo);
        $terrainManager = new TerrainManager($pdo);
        $appartementManager = new AppartementManager($pdo);
        $contrats = $contratManager->getContratByMonthYear($mois, $annee);

ob_start();
?>
<style type="text/css">
    p, h1, h2{
        text-align: center;
        text-decoration: underline;
    }
    p, table{
        font-size : 12px;
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
    <h2>Archive des clients <?= $mois.'/'.$annee ?> </h2>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <br><br>
    <table>
        <tr>
            <th style="width:10%">Client</th>
            <th style="width:10%">Dates</th>
            <th style="width:10%">Type</th>
            <th style="width:10%">Prix</th>
            <th style="width:10%">Taille</th>
            <th style="width:10%">Payé</th>
            <th style="width:10%">Reste</th>
            <th style="width:15%">Note</th>
        </tr>
        <?php
        foreach($contrats as $contrat){
            $bien = "";
            $typeBien = "";
            if($contrat->typeBien()=="appartement"){
                $bien = $appartementManager->getAppartementById($contrat->idBien());
                $typeBien = "Appartement";
            }
            else if($contrat->typeBien()=="localCommercial"){
                $bien = $locauxManager->getLocauxById($contrat->idBien());
                $typeBien = "Local Commercial";
            }
            else if($contrat->typeBien()=="terrain"){
                $bien = $terrainManager->getTerrainById($contrat->idBien());
                $typeBien = "Terrain";
            }
            else if($contrat->typeBien()=="maison"){
                $bien = $maisonManager->getMaisonById($contrat->idBien());
                $typeBien = "Maison";
            }
        ?>      
        <tr>
            <td><?= $contrat->nomClient() ?></td>
            <td><?= date('d/m/Y', strtotime($contrat->dateCreation())) ?>-<br/><?= date('d/m/Y', strtotime($contrat->dateRetour())) ?></td>
            <td><?= $typeBien."-".$bien->nom() ?></td>
            <td><?= number_format($contrat->prixVente(), 2, ',', ' ') ?></td>
            <td><?= number_format($contrat->taille(), 2, ',', ' ') ?></td>
            <td><?= number_format($contrat->avance(), 2, ',', ' ') ?></td>
            <td><?= number_format($contrat->prixVente()-$contrat->avance(), 2, ',', ' ') ?></td>
            <td><?= $contrat->note() ?></td>
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
        $fileName = "ClientsArchive-".date('Ymdhi').'.pdf';
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
