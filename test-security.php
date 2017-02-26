<?php
include("config.php");
/*
$contrats = array();

$selectQuery = "SELECT * FROM t_contrat";
$pdo1 = new PDO('mysql:host=localhost;dbname=gelm', 'root', '');
$pdo2 = new PDO('mysql:host=localhost;dbname=gelm', 'root', '');
$result = $pdo1->query($selectQuery);

while($data = $result->fetch(PDO::FETCH_ASSOC)){
    $id = $data['id'];
    $nomClient = openssl_encrypt($data['nomClient'], $method, $password, true, $iv);
    $cin = openssl_encrypt($data['cin'], $method, $password, true, $iv);
    $adresse = openssl_encrypt($data['adresse'], $method, $password, true, $iv);
    $telephone = openssl_encrypt($data['telephone'], $method, $password, true, $iv);
    $numeroCheque = openssl_encrypt($data['numeroCheque'], $method, $password, true, $iv);
    $note = openssl_encrypt($data['note'], $method, $password, true, $iv);
    $modePaiement = openssl_encrypt($data['modePaiement'], $method, $password, true, $iv);
    $taille = $data['taille']-$mutation;
    $avance = $data['avance']-$mutation;
    $prixVente = $data['prixVente']-$mutation;
    //update the whole table
    $updateQuery = "UPDATE t_contrat SET nomClient='".$nomClient."', cin='".$cin."', adresse='".$adresse."', 
    telephone='".$telephone."', numeroCheque='".$numeroCheque."', note='".$note."', modePaiement='".$modePaiement."', 
    taille=".$taille.", avance=".$avance.", prixVente=".$prixVente." WHERE id=".$id;
    $pdo2->query($updateQuery) or die(print_r($pdo2->errorInfo()));
    echo $updateQuery;
    echo "<br>";
    echo "----------------------------------------------------------------------------------";
    echo "<br>";
}
*/
$cheque = array();

$selectQuery = "SELECT * FROM t_cheque";
$pdo1 = new PDO('mysql:host=localhost;dbname=gelm', 'root', '');
$pdo2 = new PDO('mysql:host=localhost;dbname=gelm', 'root', '');
$result = $pdo1->query($selectQuery);

while($data = $result->fetch(PDO::FETCH_ASSOC)){
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
    $pdo2->query($updateQuery) or die(print_r($pdo2->errorInfo()));
    echo $updateQuery;
    echo "<br>";
    echo "----------------------------------------------------------------------------------";
    echo "<br>";
}

