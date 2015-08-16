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
    if( !empty($_POST['numeroCompte']) ){
		$numeroCompte = htmlentities($_POST['numeroCompte']);
		$dateCreation = htmlentities($_POST['dateCreation']);
		$createdBy = $_SESSION['userMerlaTrav']->login();
		$created = date('Y-m-d h:i:s');
		$idSociete = htmlentities($_POST['idSociete']);
		//create object
        $compteBancaire = new CompteBancaire(array('numero' => $numeroCompte,
        'dateCreation' => $dateCreation, 'createdBy' => $createdBy,
		'created' => $created, 'idSociete' => $idSociete));
		//add it to db
		$compteManager = new CompteBancaireManager($pdo);
        $compteManager->add($compteBancaire);
        $_SESSION['compte-add-success']="<strong>Opération valide : </strong>Le compte est ajouté avec succès !";	
	}
    else{
        $_SESSION['compte-add-error'] = "<strong>Erreur Ajout Compte Bancaire : </strong>Le champ 'Numéro Compte' est obligatoire.";
    }
	header('Location:../companies.php');
    