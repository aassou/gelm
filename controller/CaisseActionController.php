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
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $caisseManager = new CaisseManager($pdo);
    
    if($action == "add"){
        if( !empty($_POST['nom']) ){
            $nom = htmlentities($_POST['nom']);
            $dateCreation = htmlentities($_POST['dateCreation']);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $caisse = 
            new Caisse(array('nom' => $nom,
            'dateCreation' => $dateCreation, 'createdBy' => $createdBy,
            'created' => $created));
            //add it to db
            $caisseManager->add($caisse);
            $actionMessage = "Opération Valide : Caisse Ajoutée avec succès.";  
            $typeMessage = "success";
            //add history data to db
            $historyManager = new HistoryManager($pdo);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des caisses",
                'description' => "Ajout d'une nouvelle caisse - Nom : ".$nom,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
        }
        else{
            $actionMessage = "Erreur Ajout Caisse : Vous devez remplir le champ 'Nom de caisse'.";
            $typeMessage = "error";
        }
    }
    else if($action == "update"){
        $idCaisse = htmlentities($_POST['idCaisse']);
        if(!empty($_POST['nom'])){
            $nom = htmlentities($_POST['nom']);
            $dateCreation = htmlentities($_POST['dateCreation']);
            $caisse = 
            new Caisse(array('id' => $idCaisse, 'nom' => $nom, 'dateCreation' => $dateCreation));
            $caisseManager->update($caisse);
            $actionMessage = "Opération Valide : Caisse Modifiée avec succès.";
            $typeMessage = "success";
            //add history data to db
            $historyManager = new HistoryManager($pdo);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des caisses",
                'description' => "Modification de la caisse  - Nom : ".$nom,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
        }
        else{
            $actionMessage = "Erreur Modification Caisse : Vous devez remplir le champ 'Nom de caisse'.";
            $typeMessage = "error";
        }
    }
    else if($action == "delete"){
        $idCaisse = htmlentities($_POST['idCaisse']);
        $caisse = $caisseManager->getCaisseByid($idCaisse);
        $caisseManager->delete($idCaisse);
        $actionMessage = "Opération Valide : Caisse supprimée avec succès.";
        $typeMessage = "success";
        //add history data to db
        $historyManager = new HistoryManager($pdo);
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des caisses",
            'description' => "Suppression de la caisse - Nom : ".$caisse->nom(),
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
    }
    
    $_SESSION['caisse-action-message'] = $actionMessage;
    $_SESSION['caisse-type-message'] = $typeMessage;
    header('Location:../caisses.php');
    