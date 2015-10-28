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
    if( !empty($_POST['nom']) ){
    	$nom = htmlentities($_POST['nom']);
    	$projetManager = new ProjetManager($pdo);
    	if($projetManager->exists($nomProjet)>0){
    		$_SESSION['projet-add-error'] = "<strong>Erreur Ajout Projet : </strong>Un projet existe déjà avec ce nom : ".$nomProjet.".";
			header('Location:../projets.php');
			exit;			
    	}
		else{
			$numeroTitre = htmlentities($_POST['numeroTitre']);    
	        $emplacement = htmlentities($_POST['emplacement']);
	        $superficie = htmlentities($_POST['superficie']);
	        $description = htmlentities($_POST['description']);
			$dateCreation = htmlentities($_POST['dateCreation']);
			$status = "En cours";
			$createdBy = $_SESSION['userMerlaTrav']->login();
			$created = date('Y-m-d');
			$idSociete = htmlentities($_POST['idSociete']);
			//create object
	        $projet = 
	        new Projet(array('nom' => $nom, 'numeroTitre' => $numeroTitre, 'emplacement' => $emplacement,
	        'superficie' => $superficie, 'description' =>$description, 'dateCreation' => $dateCreation, 
	        'status' => $status, 'createdBy' => $createdBy, 'created' => $created, 'idSociete' => $idSociete));
			//add it to db
	        $projetManager->add($projet);
	        $_SESSION['projet-add-success']="<strong>Opération valide : </strong>Le projet '".strtoupper($nom)."' est ajouté avec succès !";	
		}  
    }
    else{
        $_SESSION['projet-add-error'] = "<strong>Erreur Ajout Projet : </strong>Le champ 'Nom du projet' est obligatoire.";
    }
	header('Location:../projects-by-company.php?idSociete='.$idSociete);
    