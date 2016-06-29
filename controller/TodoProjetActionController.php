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
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $idProjet = htmlentities($_POST['idProjet']);
    $idSociete = "";
    //$idSociete = htmlentities($_POST['idSociete']);
    //Component Class Manager

    $todoManager = new TodoProjetManager($pdo);
    $projetManager = new ProjetManager($pdo);
    $projet = $projetManager->getProjetById($idProjet);
	//Action Add Processing Begin
    if($action == "add"){
        if( !empty($_POST['todo']) ){
			$todo = htmlentities($_POST['todo']);
            $priority = htmlentities($_POST['priority']);
            $responsable = htmlentities($_POST['responsable']);
            $description = htmlentities($_POST['description']);
			$status = 0;
			$createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            if ( $idProjet == 0 ) {
                $idSociete = htmlentities($_POST['idSociete']);
            } 
            else {
                $idSociete = $projet->idSociete();
            }
            //create object
            $todo = new TodoProjet(array(
				'todo' => $todo,
				'priority' => $priority,
				'status' => $status,
				'responsable' => $responsable,
				'description' => $description,
				'idProjet' => $idProjet,
				'idSociete' => $idSociete,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $todoManager->add($todo);
            $actionMessage = "Opération Valide : Todo Ajouté(e) avec succès.";  
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Ajout todo : Vous devez remplir le champ 'todo'.";
            $typeMessage = "error";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if($action == "update"){
        $idTodo = htmlentities($_POST['idTodo']);
        if(!empty($_POST['todo'])){
			$todo = htmlentities($_POST['todo']);
            $priority = htmlentities($_POST['priority']);
            $responsable = htmlentities($_POST['responsable']);
            $description = htmlentities($_POST['description']);
			$status = 0;
			$updatedBy = $_SESSION['userMerlaTrav']->login();
            $updated = date('Y-m-d h:i:s');
            if ( $idProjet == "x" ) {
                $idSociete = htmlentities($_POST['idSocieteNew']);
            } 
            else if ( $idProjet == 0 ) {
                $idSociete = htmlentities($_POST['idSociete']);
            }
            else {
                $idSociete = $projet->idSociete();
            }
            $todo = new TodoProjet(array(
				'id' => $idTodo,
				'todo' => $todo,
				'priority' => $priority,
				'status' => $status,
				'responsable' => $responsable,
                'description' => $description,
                'idProjet' => $idProjet,
                'idSociete' => $idSociete,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $todoManager->update($todo);
            $actionMessage = "Opération Valide : Todo Modifié(e) avec succès.";
            $typeMessage = "success";
        }
        else{
            $actionMessage = "Erreur Modification Todo : Vous devez remplir le champ 'todo'.";
            $typeMessage = "error";
        }
    }
    //Action Update Processing End
    //Action UpdatePriority Processing Begin
    else if($action == "update-priority"){
        $idTodo = htmlentities($_POST['idTodo']);
        $priority = htmlentities($_POST['priority']);
        $todoManager->updatePriority($idTodo, $priority);
        $actionMessage = "Opération Valide : Todo Modifié avec succès.";
        $typeMessage = "success";
    }
    //Action UpdatePriority Processing End
    //Action Delete Processing Begin
    else if($action == "delete"){
        $idTodo = htmlentities($_POST['idTodo']);
        $todoManager->delete($idTodo);
        $actionMessage = "Opération Valide : Todo supprimé(e) avec succès.";
        $typeMessage = "success";
    }
    //Action Delete Processing End
    $_SESSION['todo-action-message'] = $actionMessage;
    $_SESSION['todo-type-message'] = $typeMessage;
    //header('Location:../todo-projet.php?idProjet='.$idProjet.'&idSociete='.$idSociete);
    $redirektLink = "Location:../todos.php";
    if ( isset($_POST['idSociete']) ) {
        $idSociete = htmlentities($_POST['idSociete']);
        $redirektLink = "Location:../todos.php?idSociete=".$idSociete;    
    }
    if ( isset($_POST['source']) and $_POST['source'] == "todos-archive" ) {
        $idSociete = htmlentities($_POST['idSociete']);
        $mois = htmlentities($_POST['mois']);
        $annee = htmlentities($_POST['annee']);
        $redirektLink = "Location:../todos-archive.php?idSociete=".$idSociete."&mois=".$mois."&annee=".$annee;    
    }
    header($redirektLink);

