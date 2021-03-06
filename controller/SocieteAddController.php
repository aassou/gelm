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
    if( !empty($_POST['raisonSociale'])){
        $raisonSociale = htmlentities($_POST['raisonSociale']);    
        $dateCreation = htmlentities($_POST['dateCreation']);
		$createdBy = $_SESSION['userMerlaTrav']->login();
		$created = date('d/m/y');
        
        $societe = new Societe(array('raisonSociale' => $raisonSociale, 'dateCreation' => $dateCreation,
        'createdBy' => $createdBy, 'created' =>$created));
        $societeManager = new SocieteManager($pdo);
        $societeManager->add($societe);
        //add history data to db
        $historyManager = new HistoryManager($pdo);
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Ajout",
            'target' => "Table des sociétés",
            'description' => "Ajout Société : Raison Sociale ".$raisonSociale,
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $_SESSION['company-add-success']="<strong>Opération valide : </strong>La société est ajoutée avec succès.";
    }
    else{
        $_SESSION['company-add-error'] = "<strong>Erreur Ajout Entrées : </strong>Vous devez remplir au moins le champ <Raison Sociale>.";
    }
	header('Location:../companies-group.php');
    