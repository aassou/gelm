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
	$idCheque = $_POST['idCheque'];  
	$idSociete = htmlentities($_POST['idSociete']); 
    $chequeManager = new ChequeManager($pdo);
    $cheque = $chequeManager->getChequeById($idCheque);
	$chequeManager->delete($idCheque);
	$_SESSION['cheque-delete-success'] = "<strong>Opération valide : </strong>Chèque supprimé avec succès.";
    //add history data to db
    $historyManager = new HistoryManager($pdo);
    $projetManager = new ProjetManager($pdo);
    $projet = $projetManager->getProjetById($cheque->idProjet());
    $createdBy = $_SESSION['userMerlaTrav']->login();
    $created = date('Y-m-d h:i:s');
    $history = new History(array(
        'action' => "Suppression",
        'target' => "Table des chèques",
        'description' => "Suppression du chèque- N° : ".$cheque->numero()." - Montant : ".$cheque->montant()." - Compte : ".$cheque->compteBancaire()." - Designation : ".$cheque->designationSociete()."/".$cheque->designationPersonne()." - Projet : ".$projet->nom(),
        'created' => $created,
        'createdBy' => $createdBy
    ));
    //add it to db
    $historyManager->add($history);
	//do not forget p parameter and to send it in url
	header('Location:../company-cheques.php?idSociete='.$idSociete);
    
    