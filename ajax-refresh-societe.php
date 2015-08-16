<?php
include('config.php');
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT * FROM t_societe WHERE raisonSociale LIKE (:keyword) ORDER BY id ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$nom = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['raisonSociale']);
	// add new option
	echo '<li onclick="setItemSociete(\''.str_replace("'", "\'", $rs['raisonSociale']).'\', \''.$rs['id'].'\')">'.$nom.'</li>';
}
?>
