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
include("../config.php");
//classes loading end
session_start();

$redirectLink='../index.php';

if(empty($_POST['login']) || empty($_POST['password'])){
    $_SESSION['signin-error'] = "<strong>Erreur Connexion</strong> Tous les champs sont obligatoires.";
}
else{
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);
    $userManager = new UserManager($pdo);
    if($userManager->exists2($login)){
		if($userManager->getStatus($login)!=0){
		    if ( password_verify($password, $userManager->getPasswordByLogin($login)) ) {
			    $_SESSION['userMerlaTrav'] = $userManager->getUserByLogin($login);
			    $redirectLink='../dashboard.php';
            }	
            else {
                $_SESSION['signin-error']="<strong>Erreur Connexion</strong> : Mot de passe incorrecte.";    
            }
		}
		else{
			$_SESSION['signin-error']="<strong>Erreur Connexion</strong> : Votre compte est inactif.";	
		}
    }
    else{
        $_SESSION['signin-error']="<strong>Erreur Connexion</strong> : Login ou Mot de passe invalide.";
    }
}
header('Location:'.$redirectLink);
exit;
?>