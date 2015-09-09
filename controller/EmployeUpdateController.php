<<<<<<< HEAD
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
	
	if( !empty($_POST['nom'])){
		$id = htmlentities($_POST['idEmploye']);
		$nom = htmlentities($_POST['nom']);
		$cin = htmlentities($_POST['cin']);
		$adresse = htmlentities($_POST['adresse']);
		$telephone = htmlentities($_POST['telephone']);
		$employe = new Employe(array('id' => $id, 'nom' => $nom, 'cin' => $cin, 'adresse' => $adresse, 'telephone' => $telephone) );
		$_SESSION['employe-update-success'] = "<strong>Opération Valide : </strong>Employé modifié avec succès.";
		$employeManager->update($employe);	
	}
	else{
		$_SESSION['employe-update-error'] = "<strong>Erreur Modification Employé : </strong>Vous devez remplir au moins le champ 'Nom'.";
		header('Location:../employes.php');
		exit;
	}	
	header('Location:../employes.php');
=======
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
	
	if( !empty($_POST['nom'])){
		$id = htmlentities($_POST['idEmploye']);
		$nom = htmlentities($_POST['nom']);
		$cin = htmlentities($_POST['cin']);
		$adresse = htmlentities($_POST['adresse']);
		$telephone = htmlentities($_POST['telephone']);
		$employe = new Employe(array('id' => $id, 'nom' => $nom, 'cin' => $cin, 'adresse' => $adresse, 'telephone' => $telephone) );
		$_SESSION['employe-update-success'] = "<strong>Opération Valide : </strong>Employé modifié avec succès.";
		$employeManager->update($employe);	
	}
	else{
		$_SESSION['employe-update-error'] = "<strong>Erreur Modification Employé : </strong>Vous devez remplir au moins le champ 'Nom'.";
		header('Location:../employes.php');
		exit;
	}	
	header('Location:../employes.php');
>>>>>>> 32d8c2d0dbce6a6ed5c3ce01d84e1dca4c37cc04
	