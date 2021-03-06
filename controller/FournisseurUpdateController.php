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
    if( !empty($_POST['nom'])){
        $id = $_POST['idFournisseur'];
        $nom = htmlentities($_POST['nom']);
        $societe = htmlentities($_POST['societe']);        
        $adresse = htmlentities($_POST['adresse']);
        $telephone1 = htmlentities($_POST['telephone1']);
        $nature = htmlentities($_POST['nature']);
        $email = htmlentities($_POST['email']);
        $fax = htmlentities($_POST['fax']);
        //update a Founisseur object
        $fournisseur = 
        new Fournisseur(array('id' => $id, 'nom' => $nom, 'societe' => $societe, 'adresse' => $adresse, 
        'telephone1' => $telephone1, 'nature' => $nature, 'email' => $email, 'fax' => $fax));
        $fournisseurManager = new FournisseurManager($pdo);
        $fournisseurManager->update($fournisseur);
        //add history data to db
        $historyManager = new HistoryManager($pdo);
        $fournisseur = $fournisseurManager->getFournisseurById($id);
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Modification",
            'target' => "Table des fournisseurs",
            'description' => "Modification Fournisseur : ".$fournisseur->nom()." - Societe : ".$fournisseur->societe(),
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $_SESSION['fournisseur-update-success']='<strong>Opération valide</strong> : Les données du fournisseur '.$nom.' sont modifiées avec succès.';
        header('Location:../fournisseurs.php');
    }
    else{
        $_SESSION['fournisseur-update-error'] = "<strong>Erreur Modification Fournisseur</strong> : Vous devez remplir au moins le champs 'Nom du fournisseur'.";
        header('Location:../fournisseurs.php');
    }
    