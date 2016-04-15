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
	$codeClient = "";
	//classModel
	$client = "";
	//classManager
	$clientManager = new ClientManager($pdo);
    if( !empty($_POST['idClient']) ){
    	$idClient = htmlentities($_POST['idClient']);
    	$client = $clientManager->getClientById($idClient);
		$codeClient = $client->code();
    }
	else if( empty($_POST['idClient']) ){
		if( !empty($_POST['nom'])){
			$nom = htmlentities($_POST['nom']);
			if( $clientManager->exists($nom) ){
				$_SESSION['client-add-error'] = "<strong>Erreur Création Client : </strong>Un client existe déjà avec ce nom : ".$nom." .";
				header('Location:../clients-add.php?idProjet='.$idProjet);
				exit;	
			}   
			else{
				$cin = htmlentities($_POST['cin']);
				$adresse = htmlentities($_POST['adresse']);
				$telephone1 = htmlentities($_POST['telephone1']);
				$telephone2 = htmlentities($_POST['telephone2']);
				$email = htmlentities($_POST['email']);
				$codeClient = uniqid().date('YmdHis');
				$created = date('Y-m-d');
				$client = new Client(array('nom' => $nom, 'cin' => $cin, 'adresse' => $adresse,'telephone1' => $telephone1, 
		        'telephone2' =>$telephone2, 'email' => $email, 'code' => $codeClient, 'created' => $created));
		        $clientManager->add($client);	
                //add history data to db
                $historyManager = new HistoryManager($pdo);
                $createdBy = $_SESSION['userMerlaTrav']->login();
                $created = date('Y-m-d h:i:s');
                $history = new History(array(
                    'action' => "Ajout",
                    'target' => "Table des clients",
                    'description' => "Ajout du client - Nom : ".$nom." - CIN : ".$cin,
                    'created' => $created,
                    'createdBy' => $createdBy
                ));
                //add it to db
                $historyManager->add($history);
			}
		}
		else{
	        $_SESSION['client-add-error'] = "<strong>Erreur Création Client : </strong>Vous devez remplir au moins le champ 'Nom'.";
			header('Location:../clients-add.php?idProjet='.$idProjet);
			exit;
	    }	
	}
	header('Location:../contrats-add.php?idProjet='.$idProjet.'&codeClient='.$codeClient);
	