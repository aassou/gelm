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
	$idContrat = $_POST['idContrat'];
	//old Contrat
	$contratManager = new ContratManager($pdo);
	$contrat = $contratManager->getContratById($idContrat);
	//form process
    if( !empty($_POST['prixNegocie']) and !empty($_POST['nomClient'])){
		$nomClient = htmlentities($_POST['nomClient']);
		$cin = htmlentities($_POST['cin']);
		$telephone = htmlentities($_POST['telephone']);
		$adresse = htmlentities($_POST['adresse']);
		$dateCreation = htmlentities($_POST['dateCreation']);
		$avance = htmlentities($_POST['avance']);
		$prixNegocie = htmlentities($_POST['prixNegocie']);
		$modePaiement = htmlentities($_POST['modePaiement']);
		$numeroCheque = $contrat->numeroCheque();
		if( isset($_POST['numeroCheque']) ){
			$numeroCheque = htmlentities($_POST['numeroCheque']);
		}
		//special treatment for bien of contrat object
		$idBien = $contrat->idBien();
		$typeBien = $contrat->typeBien();
		if(isset(htmlentities($_POST['typeBien']))){
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
		
		$newContrat = new Contrat(array('nomClient' => $nomClient, 'cin' => $cin, 'adresse' => $adresse,
		'telephone' => $telephone, 'dateCreation' => $dateCreation, 'prixVente' => $prixNegocie, 
		'avance' => $avance, 'modePaiement' => $modePaiement, 'id' => $contrat->id(),
		'idBien' => $idBien, 'typeBien' => $typeBien, 'numeroCheque' => $numeroCheque));
		$contratManager->update($newContrat);
		$_SESSION['contrat-update-success'] = "<strong>Opération Valide : </strong>Bien Modifié avec succès.";
		header('Location:../contrats-list.php?idProjet='.$idProjet);
    }
    else{
        $_SESSION['contrat-update-error'] = "<strong>Erreur Modification Contrat : </strong>Vous devez remplir au moins les champs 'Nom Client' et 'Prix Négocié'.";
		header('Location:../contrats-update.php?idContrat='.$idContrat.'&idProjet='.$idProjet);
    }