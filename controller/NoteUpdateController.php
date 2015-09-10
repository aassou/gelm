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
    $idContrat = htmlentities($_POST['idContrat']);
    $note = htmlentities($_POST['note']);
    $contratManager = new ContratManager($pdo);
    $contratManager->updateNote($idContrat, $note);
    $_SESSION['note-update-success']="<strong>Opération valide : </strong>La note a été modifiée avec succès.";
    header('Location:../dashboard.php');
    