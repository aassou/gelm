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
	$idEmploye = htmlentities($_POST['idEmploye']);
    $employeManager = new EmployeManager($pdo);
    $employe = $employeManager->getEmployeById($idEmploye);
	$employeManager->delete($idEmploye);
    //add history data to db
    $historyManager = new HistoryManager($pdo);
    $createdBy = $_SESSION['userMerlaTrav']->login();
    $created = date('Y-m-d h:i:s');
    $history = new History(array(
        'action' => "Suppression",
        'target' => "Table des employés",
        'description' => "Suppression Employé : ".$employe->nom()." - CIN : ".$employe->cin(),
        'created' => $created,
        'createdBy' => $createdBy
    ));
    //add it to db
    $historyManager->add($history);
	$_SESSION['employe-delete-success'] = "<strong>Opération valide : </strong>L'employé est supprimé avec succès.";
	header('Location:../employes.php');
 