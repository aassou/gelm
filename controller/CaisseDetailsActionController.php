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
    include('../lib/image-processing.php');
    //classes loading end
    session_start();
    
    //post input processing
    $idCaisse = htmlentities($_POST['idCaisse']);
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $caisseDetailsManager = new CaisseDetailsManager($pdo);
    $caisseManager = new CaisseManager($pdo);
    
    if($action == "add"){
        if( !empty($_POST['montant']) ){
            $dateOperation = htmlentities($_POST['dateOperation']);
            $personne = htmlentities($_POST['personne']);
            $designation = htmlentities($_POST['designation']);
            $projet = htmlentities($_POST['projet']);
            $typeOperation = htmlentities($_POST['typeOperation']);
            $montant = htmlentities($_POST['montant']);
            $commentaire = htmlentities($_POST['commentaire']);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d');
            //create object
            $caisseDetails = 
            new CaisseDetails(array('dateOperation' => $dateOperation, 'personne' => $personne, 
            'designation' => $designation, 'projet' => $projet, 'type' => $typeOperation,
            'montant' => $montant, 'commentaire' => $commentaire, 'idCaisse' => $idCaisse, 
            'createdBy' => $createdBy, 'created' => $created));
            //add it to db
            $caisseDetailsManager->add($caisseDetails);
            $actionMessage = "Opération Valide : Caisse Détails Ajoutée avec succès.";  
            $typeMessage = "success";
            //add history data to db
            $historyManager = new HistoryManager($pdo);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des détails de caisse",
                'description' => "Ajout d'une opération - Caisse : ".$caisseManager->getCaisseById($idCaisse)->nom()." - Type : ".$typeOperation." - Montant : ".$montant." - Projet : ".$projet,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
        }
        else{
            $actionMessage = "Erreur Ajout Caisse Détails: Vous devez remplir le champ 'Montant'.";
            $typeMessage = "error";
        }
    }
    else if($action == "update"){
        $idCaisseDetails = htmlentities($_POST['idCaisseDetails']);
        $caisseDetails = $caisseDetailsManager->getCaisseDetailsById($idCaisseDetails);
        $caisse = $caisseManager->getCaisseById($caisseDetails->idCaisse());
        if(!empty($_POST['montant'])){
            $dateOperation = htmlentities($_POST['dateOperation']);
            $personne = htmlentities($_POST['personne']);
            $designation = htmlentities($_POST['designation']);
            $projet = htmlentities($_POST['projet']);
            $typeOperation = htmlentities($_POST['typeOperation']);
            $montant = htmlentities($_POST['montant']);
            $commentaire = htmlentities($_POST['commentaire']);
            //create object
            $caisseDetails = 
            new CaisseDetails(array('id' => $idCaisseDetails,'dateOperation' => $dateOperation, 
            'personne' => $personne, 'designation' => $designation, 'projet' => $projet, 
            'type' => $typeOperation, 'montant' => $montant, 'commentaire' => $commentaire));
            $caisseDetailsManager->update($caisseDetails);
            $actionMessage = "Opération Valide : Caisse Détails Modifiée avec succès.";
            $typeMessage = "success";
            //add history data to db
            $historyManager = new HistoryManager($pdo);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des détails de caisse",
                'description' => "Modification d'une opération - Caisse : ".$caisse->nom()." - Type : ".$typeOperation." - Montant : ".$montant." - Projet : ".$projet,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
        }
        else{
            $actionMessage = "Erreur Modification Caisse Détails : Vous devez remplir le champ 'Montant'.";
            $typeMessage = "error";
        }
    }
    else if($action == "delete"){
        $idCaisseDetails = htmlentities($_POST['idCaisseDetails']);
        $caisseDetails = $caisseDetailsManager->getCaisseDetailsById($idCaisseDetails);
        $caisse = $caisseManager->getCaisseById($caisseDetails->idCaisse());
        $caisseDetailsManager->delete($idCaisseDetails);
        $actionMessage = "Opération Valide : Caisse Détail supprimé avec succès.";
        $typeMessage = "success";
        //add history data to db
        $historyManager = new HistoryManager($pdo);
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des détails de caisse",
            'description' => "Suppression d'une opération - Caisse : ".$caisse->nom()." - Type : ".$caisseDetails->type()." - Montant : ".$caisseDetails->montant()." - Projet : ".$caisseDetails->projet(),
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
    }
    
    $_SESSION['caisse-details-action-message'] = $actionMessage;
    $_SESSION['caisse-details-type-message'] = $typeMessage;
    header('Location:../caisse-details.php?idCaisse='.$idCaisse);
    