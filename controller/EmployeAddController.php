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
	//classModel
	$employe = "";
	//classManager
	$employeManager = new EmployeManager($pdo);
	$redirectLink = 'Location:../projet-employes.php?idProjet='.$idProjet;
	if(isset($_GET['source']) and $_GET['source']==100){
		$redirectLink = 'Location:../employes.php';
	}
	if( !empty($_POST['nom'])){
		$nom = htmlentities($_POST['nom']);
		if( $employeManager->exists($nom) ){
			$_SESSION['employe-add-error'] = "<strong>Erreur Création Employe : </strong>Un employe existe déjà avec ce nom : ".$nom." .";
			header('Location:../projet-employes.php?idProjet='.$idProjet);
			exit;	
		}   
		else{
			$cin = htmlentities($_POST['cin']);
			$adresse = htmlentities($_POST['adresse']);
			$telephone = htmlentities($_POST['telephone']);
			$created = date('Y-m-d');
			$createdBy = $_SESSION['userMerlaTrav']->login();
			$employe = new Employe(array('nom' => $nom, 'cin' => $cin, 'adresse' => $adresse,
			'telephone' => $telephone, 'createdBy' => $createdBy, 'created' => $created));
			$_SESSION['employe-add-success'] = "<strong>Opération Valide : </strong>Employé ajouté avec succès.";
			$employeManager->add($employe);	
            //add history data to db
            $historyManager = new HistoryManager($pdo);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des employés",
                'description' => "Ajout Employé : ".$nom." - CIN : ".$cin,
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
		}
	}
	else{
		$_SESSION['employe-add-error'] = "<strong>Erreur Création Employé : </strong>Vous devez remplir au moins le champ 'Nom'.";
		header($redirectLink);
		exit;
	}	
	header($redirectLink);
	