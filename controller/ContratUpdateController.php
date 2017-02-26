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
	$idContrat = $_POST['idContrat'];
	//old Contrat
	$contratManager = new ContratManager($pdo);
	$contrat = $contratManager->getContratById($idContrat);
	//form process
    if( !empty($_POST['prixNegocie']) and !empty($_POST['nomClient'])){
		$nomClient = openssl_encrypt(htmlentities($_POST['nomClient']), $method, $password, true, $iv);
		$cin = openssl_encrypt(htmlentities($_POST['cin']), $method, $password, true, $iv);
		$telephone = openssl_encrypt(htmlentities($_POST['telephone']), $method, $password, true, $iv);
		$adresse = openssl_encrypt(htmlentities($_POST['adresse']), $method, $password, true, $iv);
		$dateCreation = htmlentities($_POST['dateCreation']);
		$dateRetour = htmlentities($_POST['dateRetour']);
		$avance = htmlentities($_POST['avance'])-$mutation;
		$note = openssl_encrypt(htmlentities($_POST['note']), $method, $password, true, $iv);
        $taille = htmlentities($_POST['taille'])-$mutation;
		$prixNegocie = htmlentities($_POST['prixNegocie'])-$mutation;
		$modePaiement = openssl_encrypt(htmlentities($_POST['modePaiement']), $method, $password, true, $iv);
		$numeroCheque = $contrat->numeroCheque();
		if( isset($_POST['numeroCheque']) ){
			$numeroCheque = openssl_encrypt(htmlentities($_POST['numeroCheque']), $method, $password, true, $iv);
		}
		//special treatment for bien of contrat object
		$idBien = $contrat->idBien();
		$typeBien = $contrat->typeBien();
		if(isset($_POST['typeBien'])){
			//get bien form elements	
			$idBien = htmlentities($_POST['bien']);
			$typeBien = htmlentities($_POST['typeBien']);
			//bien treatment
			if($typeBien=="appartement"){
				$appartementManager = new AppartementManager($pdo);
				$appartementManager->updateStatus("Vendu", $idBien);
				$appartementManager->updateStatus("Disponible", $contrat->idBien());
			}
			else if($typeBien=="localCommercial"){
				$locauxManager = new LocauxManager($pdo);
				$locauxManager->updateStatus("Vendu", $idBien);
				$locauxManager->updateStatus("Disponible", $contrat->idBien());
			}
			else if($typeBien=="maison"){
				$maisonManager = new MaisonManager($pdo);
				$maisonManager->updateStatus("Vendu", $idBien);
				$maisonManager->updateStatus("Disponible", $contrat->idBien());
			}
			else if($typeBien=="terrain"){
				$terrainManager = new TerrainManager($pdo);
				$terrainManager->updateStatus("Vendu", $idBien);
				$terrainManager->updateStatus("Disponible", $contrat->idBien());
			}
		}
		$newContrat = new Contrat(array(
			'nomClient' => $nomClient, 
			'cin' => $cin, 
			'adresse' => $adresse,
			'telephone' => $telephone,
			'dateCreation' => $dateCreation,
			'dateRetour' => $dateRetour,
			'prixVente' => $prixNegocie, 
			'avance' => $avance,
			'note' => $note,
			'taille' => $taille,
			'modePaiement' => $modePaiement,
			'id' => $idContrat,
			'idBien' => $idBien,
			'typeBien' => $typeBien,
			'numeroCheque' => $numeroCheque));
		$contratManager->update($newContrat);
        //add history data to db
        $projetManager = new ProjetManager($pdo);
        $historyManager = new HistoryManager($pdo);
        $projet = $projetManager->getProjetById($idProjet);
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Modification",
            'target' => "Table des contrats clients",
            'description' => "Modification contrat - Client :  ".$nomClient." - CIN : ".$cin." - ID Contrat : ".$idContrat." - Type bien : ".$typeBien." - ID Bien : ".$idBien." - Projet : ".$projet->nom(),
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
		$_SESSION['contrat-update-success'] = "<strong>Opération Valide : </strong>Contrat Modifié avec succès.";
		//print_r($newContrat);
		header('Location:../contrats-list.php?idProjet='.$idProjet.'&idSociete='.$idSociete);
    }
    else{
        $_SESSION['contrat-update-error'] = "<strong>Erreur Modification Contrat : </strong>Vous devez remplir au moins les champs 'Nom Client' et 'Prix Négocié'.";
		header('Location:../contrats-update.php?idContrat='.$idContrat.'&idProjet='.$idProjet.'&idSociete='.$idSociete);
    }