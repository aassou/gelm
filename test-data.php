<?php
include("config.php");
include("include/params.php");

$contrats = array();

$selectQuery = "SELECT * FROM t_contrat";

$result = $pdo->query($selectQuery);

while($data = $result->fetch(PDO::FETCH_ASSOC)){
    $id = $data['id'];
    $nomClient = $data['nomClient'];
    $cin = $data['cin'];
    $adresse = $data['adresse'];
    $telephone = $data['telephone'];
    $numeroCheque = $data['numeroCheque'];
    $note = $data['note'];
    $modePaiement = $data['modePaiement'];
    $taille = $data['taille'];
    $avance = $data['avance'];
    $prixVente = $data['prixVente'];
    echo "<br>".$id;
    echo "<br>".openssl_decrypt($nomClient, $method, $password, true, $iv);
    echo "<br>".openssl_decrypt($cin, $method, $password, true, $iv);
    echo "<br>".openssl_decrypt($adresse, $method, $password, true, $iv);
    echo "<br>".openssl_decrypt($telephone, $method, $password, true, $iv);
    echo "<br>".openssl_decrypt($numeroCheque, $method, $password, true, $iv);
    echo "<br>".openssl_decrypt($note, $method, $password, true, $iv);
    echo "<br>".openssl_decrypt($modePaiement, $method, $password, true, $iv);
    echo "<br>".$taille+$mutation;
    echo "<br>".$avance+$mutation;
    echo "<br>".$prixVente+$mutation;
    echo "<br>-------------------------------------------------<br>";
}