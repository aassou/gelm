<?php
function classLoad ($myClass) {
    if(file_exists('model/'.$myClass.'.php')){
        include('model/'.$myClass.'.php');
    }
    elseif(file_exists('controller/'.$myClass.'.php')){
        include('controller/'.$myClass.'.php');
    }
}
spl_autoload_register("classLoad"); 
include("config.php");

$contratManager = new ContratManager($pdo);
$contrats = $contratManager->getContrats();

foreach ($contrats as $contrat){
    $contratManager->update(new Contrat(
        array( 'id' => $contrat->id(),
               'nomClient' => openssl_encrypt($contrat->nomClient(), $method, $password, true, $iv),
               'cin' => openssl_encrypt($contrat->cin(), $method, $password, true, $iv),
               'adresse' => openssl_encrypt($contrat->adresse(), $method, $password, true, $iv),
               'telephone' => openssl_encrypt($contrat->telephone(), $method, $password, true, $iv),
               'prixVente' => ($contrat->prixVente()-$mutation),
               'avance' => ($contrat->avance()-$mutation),
               'taille' => ($contrat->taille()-$mutation),
               'idBien' => $contrat->idBien(),
               'typeBien' => $contrat->typeBien(),
               'modePaiement' => openssl_encrypt($contrat->modePaiement(), $method, $password, true, $iv),
               'numeroCheque' => openssl_encrypt($contrat->numeroCheque(), $method, $password, true, $iv),
               'note' => openssl_encrypt($contrat->note(), $method, $password, true, $iv),
               'dateRetour' => $contrat->dateRetour(),
               'dateCreation' => $contrat->dateCreation(),
               )
    ));
}


/*
$chequeManager = new ChequeManager($pdo);
$cheques = $chequeManager->getCheques();

//$selectQuery = "SELECT * FROM t_cheque";
//$pdo1 = new PDO('mysql:host=localhost;dbname=gelm', 'root', '');
//$pdo2 = new PDO('mysql:host=localhost;dbname=gelm', 'root', '');
//$result = $pdo->query($selectQuery);

foreach ($cheques as $cheque){
    $chequeManager->update(new Cheque(
                    array('id' => $cheque->id(),
                          'dateCheque' => $cheque->dateCheque(),
                          'idProjet' => $cheque->idProjet(),
                          'statut' => $cheque->statut(),
                          'numero' => openssl_encrypt($cheque->numero(), $method, $password, true, $iv),
                          'designationSociete' => openssl_encrypt($cheque->designationSociete(), $method, $password, true, $iv),
                          'designationPersonne' => openssl_encrypt($cheque->designationPersonne(), $method, $password, true, $iv),
                          'compteBancaire' => openssl_encrypt($cheque->compteBancaire(), $method, $password, true, $iv),
                          'montant' => ($cheque->montant()-$mutation)
                          )
                    )
                );
    $id = $data['id'];
    $numero = openssl_encrypt($data['numero'], $method, $password, true, $iv);
    $designationSociete = openssl_encrypt($data['designationSociete'], $method, $password, true, $iv);
    $designationPersonne = openssl_encrypt($data['designationPersonne'], $method, $password, true, $iv);
    $compteBancaire = openssl_encrypt($data['compteBancaire'], $method, $password, true, $iv);
    $montant = $data['montant']-$mutation;
    //update the whole table
    $updateQuery = "UPDATE t_cheque SET numero='".$numero."', designationSociete='".$designationSociete."', 
    designationPersonne='".$designationPersonne."', compteBancaire='".$compteBancaire."', 
    montant=".$montant." WHERE id=".$id;
    $pdo->query($updateQuery);
    echo $updateQuery;
    echo "<br>";
    echo "----------------------------------------------------------------------------------";
    echo "<br>";
}*/

