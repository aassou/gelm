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
	//$codeClient = $_POST['codeClient'];
    if( !empty($_POST['idProjet']) and !empty($_POST['nomClient'])){	
    	if( !empty($_POST['typeBien']) ){
    		if( !empty($_POST['prixNegocie']) ){
    			$prixNegocie = htmlentities($_POST['prixNegocie'])-$mutation;
    		}
			else{
			$_SESSION['contrat-add-error'] = "<strong>Erreur Création Contrat : </strong>Vous devez remplir le 'Prix négocié'.";	
			header('Location:../contrats-add.php?idProjet='.$idProjet.'&codeClient='.$codeClient);
			exit;
			}
			$nomClient = openssl_encrypt(htmlentities($_POST['nomClient']), $method, $password, true, $iv);
			$cin = openssl_encrypt(htmlentities($_POST['cin']), $method, $password, true, $iv);
			$telephone = openssl_encrypt(htmlentities($_POST['telephone']), $method, $password, true, $iv);
			$adresse = openssl_encrypt(htmlentities($_POST['adresse']), $method, $password, true, $iv);
			$noteClient = openssl_encrypt(htmlentities($_POST['note']), $method, $password, true, $iv);
			$typeBien = htmlentities($_POST['typeBien']);
			$dateCreation = htmlentities($_POST['dateCreation']);
			$dateRetour = htmlentities($_POST['dateRetour']);
			$idBien = htmlentities($_POST['bien']);
			$avance = htmlentities($_POST['avance'])-$mutation;
            $taille = htmlentities($_POST['taille'])-$mutation;
			$modePaiement = openssl_encrypt(htmlentities($_POST['modePaiement']), $method, $password, true, $iv);
			$codeContrat = uniqid().date('YmdHis');
			$status = htmlentities($_POST['status']);
			$numeroCheque = 0;
			if( isset($_POST['numeroCheque']) ){
				$numeroCheque = openssl_encrypt(htmlentities($_POST['numeroCheque']), $method, $password, true, $iv);
			}
			$contratManager = new ContratManager($pdo);
			$contrat = new Contrat(array('nomClient' => $nomClient, 'cin' => $cin, 'adresse' => $adresse,
			'note' => $noteClient,'telephone' => $telephone, 'dateCreation' => $dateCreation, 'dateRetour' => $dateRetour, 
			'prixVente' => $prixNegocie, 'avance' => $avance, 'taille' => $taille, 'modePaiement' => $modePaiement, 
			'idProjet' => $idProjet, 'idBien' => $idBien, 'typeBien' => $typeBien, 'numeroCheque' => $numeroCheque));
			$contratManager->add($contrat);
			if($typeBien=="appartement"){
				$appartementManager = new AppartementManager($pdo);
				$appartementManager->updateStatus($status, $idBien);
			}
			else if($typeBien=="localCommercial"){
				$locauxManager = new LocauxManager($pdo);
				$locauxManager->updateStatus($status, $idBien);
			}
			else if($typeBien=="maison"){
				$maisonManager = new MaisonManager($pdo);
				$maisonManager->updateStatus($status, $idBien);
			}
			else if($typeBien=="terrain"){
				$terrainManager = new TerrainManager($pdo);
				$terrainManager->updateStatus($status, $idBien);
			}
            //add history data to db
            $projetManager = new ProjetManager($pdo);
            $historyManager = new HistoryManager($pdo);
            $projet = $projetManager->getProjetById($idProjet);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des contrats clients",
                'description' => "Ajout de contrat - Client :  ".$nomClient." - Bien : ".$typeBien." - ID Bien : ".$idBien." - Projet : ".$projet->nom(),
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
			header('Location:../contrats-list.php?idProjet='.$idProjet.'&idSociete='.$idSociete);
    	}
		else{
			$_SESSION['contrat-add-error'] = "<strong>Erreur Création Contrat : </strong>Vous devez choisir un 'Type de bien'.";	
			header('Location:../contrats-add.php?idProjet='.$idProjet.'&idSociete='.$idSociete);
			exit;
		}
    }
    else{
        $_SESSION['contrat-add-error'] = "<strong>Erreur Création Contrat : </strong>Vous devez remplir au moins le champ 'Nom'.";
		header('Location:../contrats-add.php?idProjet='.$idProjet.'&idSociete='.$idSociete);
    }
	
    