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
    $idProjet = htmlentities($_POST['idProjet']);
    $idSociete = htmlentities($_POST['idSociete']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    //Comonent Manager
    $contratEmployeManager = new ContratEmployeManager($pdo);
	//Action Add Processing Begin
    if($action == "add"){
        if( !empty($_POST['employe']) ){
			$dateContrat = htmlentities($_POST['dateContrat']);
            $nombreUnites = htmlentities($_POST['nombreUnites']);
            $prixUnitaire = htmlentities($_POST['prixUnitaire']);
			$total = htmlentities($_POST['total']);
			$employe = htmlentities($_POST['employe']);
			$idProjet = htmlentities($_POST['idProjet']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $contratEmploye = new ContratEmploye(array(
				'dateContrat' => $dateContrat,
				'nombreUnites' => $nombreUnites,
				'prixUnitaire' => $prixUnitaire,
				'total' => $total,
				'employe' => $employe,
				'idProjet' => $idProjet,
				'created' => $created,
				'createdBy' => $createdBy
			));
            //add it to db
            $contratEmployeManager->add($contratEmploye);
            $actionMessage = "Opération Valide : ContratEmploye Ajouté(e) avec succès.";  
            $typeMessage = "success";
            //add history data to db
            $projetManager = new ProjetManager($pdo);
            $historyManager = new HistoryManager($pdo);
            $projet = $projetManager->getProjetById($idProjet);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des contrats employés",
                'description' => "Ajout contrat - Employé :  ".$employe." - Projet : ".$projet->nom(),
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
        }
        else{
            $actionMessage = "Erreur Ajout contratEmploye : Vous devez remplir le champ 'Employé'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idContratEmploye = htmlentities($_POST['idContratEmploye']);
        if(!empty($_POST['employe'])){
            $dateContrat = htmlentities($_POST['dateContrat']);
            $nombreUnites = htmlentities($_POST['nombreUnites']);
            $prixUnitaire = htmlentities($_POST['prixUnitaire']);
            $total = htmlentities($_POST['total']);
            $employe = htmlentities($_POST['employe']);
            $contratEmploye = new ContratEmploye(array(
				'id' => $idContratEmploye,
				'dateContrat' => $dateContrat,
				'nombreUnites' => $nombreUnites,
                'prixUnitaire' => $prixUnitaire,
				'total' => $total,
				'employe' => $employe,
				'idProjet' => $idProjet,
			));
            $contratEmployeManager->update($contratEmploye);
            $actionMessage = "Opération Valide : ContratEmploye Modifié(e) avec succès.";
            $typeMessage = "success";
            //add history data to db
            $projetManager = new ProjetManager($pdo);
            $historyManager = new HistoryManager($pdo);
            $projet = $projetManager->getProjetById($idProjet);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des contrats employés",
                'description' => "Modification contrat - Employé :  ".$employe." - Projet : ".$projet->nom(),
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
        }
        else{
            $actionMessage = "Erreur Modification ContratEmploye : Vous devez remplir le champ 'Employé'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idContratEmploye = htmlentities($_POST['idContratEmploye']);
        $contrat = $contratEmployeManager->getContratEmployeById($idContratEmploye);
        $contratEmployeManager->delete($idContratEmploye);
        $actionMessage = "Opération Valide : ContratEmploye supprimée avec succès.";
        $typeMessage = "success";
        //add history data to db
        $projetManager = new ProjetManager($pdo);
        $historyManager = new HistoryManager($pdo);
        $projet = $projetManager->getProjetById($idProjet);
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des contrats employés",
            'description' => "Suppression contrat - Employé :  ".$contrat->employe()." - Projet : ".$projet->nom(),
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
    }
    //Action Delete Processing End
    $_SESSION['contratEmploye-action-message'] = $actionMessage;
    $_SESSION['contratEmploye-type-message'] = $typeMessage;
    header('Location:../projet-contrat-employe.php?idProjet='.$idProjet.'&idSociete='.$idSociete);

