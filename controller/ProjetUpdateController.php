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
    if( !empty($_POST['nom'])){
        $nom = htmlentities($_POST['nom']);    
		$numeroTitre = htmlentities($_POST['numeroTitre']);
        $emplacement = htmlentities($_POST['emplacement']);
        $superficie = htmlentities($_POST['superficie']);
        $description = htmlentities($_POST['description']);
        $dateCreation = htmlentities($_POST['dateCreation']);
		$idSociete = htmlentities($_POST['idSociete']);
        
        $projet = new Projet(array('id' => $idProjet, 'nom' => $nom, 'numeroTitre' => $numeroTitre, 
        'emplacement' => $emplacement, 'superficie' => $superficie, 'description' => $description, 
        'dateCreation' => $dateCreation, 'idSociete' => $idSociete));
        $projetManager = new ProjetManager($pdo);
        $projetManager->update($projet);
        $_SESSION['projet-update-success']="<strong>Opération valide : </strong>Votre projet '".$nom."' est modifié avec succès.";
		$redirectLink = "Location:../projets.php";
		if( isset($_GET['source']) and $_GET['source']==2 ){
			$redirectLink = "Location:../company-projets.php?idSociete=".$idSociete;	
		}
        header($redirectLink);
    }
    else{
        $_SESSION['projet-update-error'] = "<strong>Erreur Modification Projet : </strong>Vous devez remplir au moins le champ 'Nom'.";
        $redirectLink = "Location:../projets.php";
		if( isset($_GET['source']) and $_GET['source']==2 ){
			$redirectLink = "Location:../company-projets.php?idSociete=".$idSociete;	
		}
        header($redirectLink);
    }
    