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
    //post input processing
    $idProjet = $_POST['idProjet'];
    $idSociete = $_POST['idSociete'];
    $idContrat  = $_POST['idContrat'];
    $status = $_POST['status'];
    $typeBien = $_POST['typeBien'];
    $idBien = $_POST['idBien'];
    //create classes managers
    $contratManager = new ContratManager($pdo);
    //create classes
    $redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet.'&idSociete='.$idSociete;
    
    if( $typeBien == "appartement" ) {
        $appartementManager = new AppartementManager($pdo);
        $appartementManager->updateStatus($status, $idBien );
    }
    else if( $typeBien == "localCommercial" ) {
        $locauxManager = new LocauxManager($pdo);
        $locauxManager->updateStatus($status, $idBien);
    }
    else if( $typeBien == "maison" ) {
        $maisonManager = new MaisonManager($pdo);
        $maisonManager->updateStatus($status, $idBien);
    }
    else if( $typeBien == "terrain" ) {
        $terrainManager = new TerrainManager($pdo);
        $terrainManager->updateStatus($status, $idBien);
    }
    $_SESSION['bien-change-status-success'] = "<strong>Opération valide : </strong>Le status du bien est changé avec succès.";
    header($redirectLink);
    