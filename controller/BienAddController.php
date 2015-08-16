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
    $idProjet = htmlentities($_POST['idProjet']);
	if( !empty($_POST['idProjet']) ){
		if( !empty($_POST['numeroTitre']) ){
	        $numeroTitre = htmlentities($_POST['numeroTitre']);
			$nom = htmlentities($_POST['nom']);
			$superficie = htmlentities($_POST['superficie']);
			$niveau = htmlentities($_POST['niveau']);
			$facade = htmlentities($_POST['facade']);
			$mezzanine = htmlentities($_POST['mezzanine']);
			$nombrePiece = htmlentities($_POST['nombrePiece']);
			$nombreEtage = htmlentities($_POST['nombreEtage']);
			$emplacement = htmlentities($_POST['emplacement']);
			$status = "Disponible";
			$cave = htmlentities($_POST['cave']);
			$prix = htmlentities($_POST['prix']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
			$created = date('d/m/Y h:m');
	        
			if(htmlentities($_POST['typeImmobiliere'])=="appartement"){
				$appartement = new Appartement(array('numeroTitre' => $numeroTitre, 'prix' => $prix,
				'nom' => $nom, 'niveau' => $niveau, 'facade' => $facade, 'nombrePiece' => $nombrePiece,
				'status' => $status, 'superficie' => $superficie, 'cave' => $cave, 
				'idProjet' => $idProjet, 'created' => $created, 'createdBy' => $createdBy));
				$appartementManager = new AppartementManager($pdo);
				$appartementManager->add($appartement);
			}
			else if(htmlentities($_POST['typeImmobiliere'])=="local"){
				$local = new Locaux(array('numeroTitre' => $numeroTitre, 'prix' => $prix,
				'nom' => $nom, 'mezzanine' => $mezzanine, 'facade' => $facade, 
				'status' => $status, 'superficie' => $superficie,  
				'idProjet' => $idProjet, 'created' => $created, 'createdBy' => $createdBy));
				$locauxManager = new LocauxManager($pdo);
				$locauxManager->add($local);
			}
			else if(htmlentities($_POST['typeImmobiliere'])=="maison"){
				$maison = new Maison(array('numeroTitre' => $numeroTitre, 'prix' => $prix,
				'nom' => $nom, 'nombreEtage' => $nombreEtage, 'emplacement' => $emplacement, 
				'status' => $status, 'superficie' => $superficie,  
				'idProjet' => $idProjet, 'created' => $created, 'createdBy' => $createdBy));
				$maisonManager = new MaisonManager($pdo);
				$maisonManager->add($maison);
			}
			else if(htmlentities($_POST['typeImmobiliere'])=="terrain"){
				$terrain = new Terrain(array('numeroTitre' => $numeroTitre, 'prix' => $prix,
				'nom' => $nom, 'emplacement' => $emplacement, 
				'status' => $status, 'superficie' => $superficie,  
				'idProjet' => $idProjet, 'created' => $created, 'createdBy' => $createdBy));
				$terrainManager = new TerrainManager($pdo);
				$terrainManager->add($terrain);
			}
	        
	        $_SESSION['bien-add-success']='<strong>Opération valide</strong> : Le Bien Immobilière est ajouté avec succès !';
	        $redirectLink = 'Location:../projet-biens.php?idProjet='.$idProjet;
	        header($redirectLink);
    	}
	    else{
	    	$_SESSION['bien-add-error'] = "<strong>Erreur Ajout Bien Immobilière</strong> : Vous devez remplir au moins le champ 'Numéro Titre'.";
	        $redirectLink = 'Location:../projet-biens.php?idProjet='.$idProjet;
	        header($redirectLink);
			exit;
    	}	
	}
	else{
		header('Location:../projet-biens.php?idProjet='.$idProjet);
	}
    
    