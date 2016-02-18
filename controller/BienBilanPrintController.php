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
        $idProjet = $_GET['idProjet'];
        $idSociete = $_GET['idSociete'];
        $type = $_GET['type'];
        $projetManager = new ProjetManager($pdo);
        $societeManager = new SocieteManager($pdo);
        $contratManager = new ContratManager($pdo);
        $operationManager = new OperationManager($pdo);
        $appartementManager = new AppartementManager($pdo);
        $locauxManager = new LocauxManager($pdo);
        $terrainsManager = new TerrainManager($pdo);
        $maisonsManager = new MaisonManager($pdo);
        $contratNumber = $contratManager->getContratsNumberByIdProjet($idProjet);
        $contrats = $contratManager->getContratsByIdProjetOnly($idProjet);
ob_start();
?>
<style type="text/css">
    p, h1, h3{
        text-align: center;
        text-decoration: underline;
    }
    table, tr, td, th {
        border-collapse: collapse;
        width:auto;
        border: 1px solid black;
    }
    td, th{
        padding : 5px;
    }
    
    th{
        background-color: grey;
    }
    table, a{
        text-decoration: none;
    }
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <h3>Situation des <?= $type ?> - 
    Projet : <?= $projetManager->getProjetById($idProjet)->nom() ?> - 
    Societe : <?= $societeManager->getSocieteById($idSociete)->raisonSociale() ?>
    </h3>
    <p>Imprimé le <?= date('d-m-Y') ?> | <?= date('h:i') ?> </p>
    <!--**************************** TERRAIN BEGIN ****************************-->
    <?php 
    if( $type == "terrains" ) { 
        $terrains = $terrainsManager->getTerrainsByIdProjet($idProjet);
    ?>
    <h3>Liste des terrains</h3>
    <table>
        <thead>
            <tr>
                <th style="width:10%">Code</th>
                <th style="width:20%">Titre</th>
                <th style="width:15%">Superficie</th>
                <th style="width:15%">Surplan</th>
                <th style="width:30%">Emplacement</th>
                <th style="width:10%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($terrains as $terrain){
            ?>      
            <tr>
                <td style="width:10%"><?= $terrain->nom() ?></td>
                <td style="width:20%"><?= $terrain->numeroTitre() ?></td>
                <td style="width:15%"><?= $terrain->superficie() ?></td>
                <td style="width:10%"><?= $terrain->surplan() ?></td>
                <td style="width:30%"><?= $terrain->emplacement() ?></td>
                <td style="width:15%"><?= $terrain->status() ?></td>
            </tr>
            <?php
            }//end of loop
            ?>
        </tbody>
    </table>
    <?php } ?>
    <!--**************************** TERRAIN END ****************************-->
    <!--**************************** APPARTEMENT BEGIN ****************************-->
    <?php 
    if( $type == "appartements" ) { 
        $appartements = $appartementManager->getAppartementsByIdProjet($idProjet);
    ?>
    <h3>Liste des appartements</h3>
    <table>
        <thead>
            <tr>
                <th style="width:10%">Code</th>
                <th style="width:25%">Titre</th>
                <th style="width:10%">Niveau</th>
                <th style="width:15%">Superficie</th>
                <th style="width:15%">Surplan</th>
                <th style="width:10%">N.Pieces</th>
                <th style="width:15%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($appartements as $appartement){
            ?>      
            <tr>
                <td style="width:10%"><?= $appartement->nom() ?></td>
                <td style="width:25%"><?= $appartement->numeroTitre() ?></td>
                <td style="width:10%"><?= $appartement->niveau() ?></td>
                <td style="width:15%"><?= $appartement->superficie() ?></td>
                <td style="width:15%"><?= $appartement->surplan() ?></td>
                <td style="width:10%"><?= $appartement->nombrePiece() ?></td>
                <td style="width:15%"><?= $appartement->status() ?></td>
            </tr>
            <?php
            }//end of loop
            ?>
        </tbody>
    </table>
    <?php } ?>
    <!--**************************** APPARTEMENT END ****************************-->
    <!--**************************** LOCAUX BEGIN ****************************-->
    <?php 
    if( $type == "locaux" ) { 
        $locaux = $locauxManager->getLocauxByIdProjet($idProjet);
    ?>
    <h3>Liste des locaux commerciaux</h3>
    <table>
        <thead>
            <tr>
                <th style="width:15%">Code</th>
                <th style="width:30%">Titre</th>
                <th style="width:15%">Superficie</th>
                <th style="width:15%">Surplan</th>
                <th style="width:15%">Mezzanine</th>
                <th style="width:10%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($locaux as $local){
            ?>      
            <tr>
                <td style="width:15%"><?= $local->nom() ?></td>
                <td style="width:30%"><?= $local->numeroTitre() ?></td>
                <td style="width:15%"><?= $local->superficie() ?></td>
                <td style="width:15%"><?= $local->surplan() ?></td>
                <td style="width:15%"><?= $local->mezzanine() ?></td>
                <td style="width:10%"><?= $local->status() ?></td>
            </tr>
            <?php
            }//end of loop
            ?>
        </tbody>
    </table>
    <?php } ?>
    <!--**************************** LOCAUX END ****************************-->
    <!--**************************** MAISONS BEGIN ****************************-->
    <?php 
    if( $type == "maisons" ) { 
        $maisons = $maisonsManager->getMaisonsByIdProjet($idProjet);
    ?>
    <h3>Liste des maisons</h3>
    <table>
        <thead>
            <tr>
                <th style="width:10%">Code</th>
                <th style="width:20%">Titre</th>
                <th style="width:13%">Superficie</th>
                <th style="width:13%">Surplan</th>
                <th style="width:10%">Etage</th>
                <th style="width:20%">Emplacement</th>
                <th style="width:14%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($maisons as $maison){
            ?>      
            <tr>
                <td style="width:10%"><?= $maison->nom() ?></td>
                <td style="width:20%"><?= $maison->numeroTitre() ?></td>
                <td style="width:13%"><?= $maison->superficie() ?></td>
                <td style="width:13%"><?= $maison->surplan() ?></td>
                <td style="width:10%"><?= $maison->nombreEtage() ?></td>
                <td style="width:20%"><?= $maison->emplacement() ?></td>
                <td style="width:14%"><?= $maison->status() ?></td>
            </tr>
            <?php
            }//end of loop
            ?>
        </tbody>
    </table>
    <?php } ?>
    <!--**************************** MAISONS END ****************************-->
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;"></p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
        $fileName = "BienBilan-".date('Ymdhi').'.pdf';
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