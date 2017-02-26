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
    $userManager = new UserManager($pdo);
	
	if ( !empty($_POST['oldPassword']) 
	and password_verify( $_POST['oldPassword'], $userManager->getPasswordByLogin($_SESSION['userMerlaTrav']->login()) ) ){
		if($_POST['newPassword1']==$_POST['newPassword2']){
			$newPassword = htmlentities($_POST['newPassword1']);
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
			$idUser = $_SESSION['userMerlaTrav']->id();
			$userManager->changePassword($newPassword, $idUser);
			$_SESSION['password-update-success']="<strong>Opération valide</strong> : Le mot de passe a été changé avec succès.";
		}
		else{
			$_SESSION['password-update-error']="<strong>Erreur Mot de passe</strong> : Les 2 nouveaux mots de passe ne sont pas identiques.";
		}
	}
	else{
		$_SESSION['password-update-error']="<strong>Erreur Mot de passe</strong> : Vous devez saisir votre ancien mot de passe pour créer un nouveau.";
	}
	header('Location:../user-profil.php');
