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
    $idSociete = htmlentities($_POST['idSociete']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";

    //Component Class Manager

    $chargesCommunsManager = new ChargesCommunsManager($pdo);
	//Action Add Processing Begin
    if($action == "add"){
        if( !empty($_POST['dateOperation']) ){
			$dateOperation = htmlentities($_POST['dateOperation']);
			$designation = htmlentities($_POST['designation']);
			$beneficiaire = htmlentities($_POST['beneficiaire']);
			$numeroCheque = htmlentities($_POST['numeroCheque']);
			$montant = htmlentities($_POST['montant']);
			$idSociete = htmlentities($_POST['idSociete']);
			$idProjet = htmlentities($_POST['idProjet']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $chargesCommuns = new ChargesCommuns(array(
				'dateOperation' => $dateOperation,
				'designation' => $designation,
				'beneficiaire' => $beneficiaire,
				'numeroCheque' => $numeroCheque,
				'montant' => $montant,
				'idSociete' => $idSociete,
				'idProjet' => $idProjet,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $chargesCommunsManager->add($chargesCommuns);
            $actionMessage = "Opération Valide : ChargesCommuns Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout chargesCommuns : Vous devez remplir le champ 'dateOperation'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idChargesCommuns = htmlentities($_POST['idChargesCommuns']);
        if(!empty($_POST['dateOperation'])){
			$dateOperation = htmlentities($_POST['dateOperation']);
			$designation = htmlentities($_POST['designation']);
			$beneficiaire = htmlentities($_POST['beneficiaire']);
			$numeroCheque = htmlentities($_POST['numeroCheque']);
			$montant = htmlentities($_POST['montant']);
			$idProjet = htmlentities($_POST['idProjet']);
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            $chargesCommuns = new ChargesCommuns(array(
				'id' => $idChargesCommuns,
				'dateOperation' => $dateOperation,
				'designation' => $designation,
				'beneficiaire' => $beneficiaire,
				'numeroCheque' => $numeroCheque,
				'montant' => $montant,
				'idProjet' => $idProjet,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $chargesCommunsManager->update($chargesCommuns);
            $actionMessage = "Opération Valide : ChargesCommuns Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification ChargesCommuns : Vous devez remplir le champ 'dateOperation'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idChargesCommuns = htmlentities($_POST['idChargesCommuns']);
        $chargesCommunsManager->delete($idChargesCommuns);
        $actionMessage = "Opération Valide : ChargesCommuns supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['chargescommuns-action-message'] = $actionMessage;
    $_SESSION['chargescommuns-type-message'] = $typeMessage;
    header('Location:../charges-communs.php?idSociete='.$idSociete);

