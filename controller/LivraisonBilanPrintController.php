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
    if( isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil()=="admin" ){
        $projetManager = new ProjetManager($pdo);
		$fournisseurManager = new FournisseurManager($pdo);
		$livraisonManager = new LivraisonManager($pdo);
		$livraisonDetailManager = new LivraisonDetailManager($pdo);
		$reglementsFournisseurManager = new ReglementFournisseurManager($pdo);
		//classes and vars
		$livraisonNumber = 0;
		$totalReglement = 0;
		$totalLivraison = 0;
		$titreLivraison ="Liste de toutes les livraisons";
		$hrefLivraisonBilanPrintController = "controller/LivraisonBilanPrintController.php";
		if(isset($_POST['idProjet']) and 
    	($_POST['idProjet'] >=1 and $_POST['idProjet'] <= $projetManager->getLastId()) ){
    		$idProjet = htmlentities($_POST['idProjet']);
			$idFournisseur = htmlentities($_POST['idFournisseur']);
            $dateFrom = htmlentities($_POST['dateFrom']);
            $dateTo = htmlentities($_POST['dateTo']);
			$livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseur($idFournisseur);
			//if($livraisonNumber != 0){
			$livraisons = $livraisonManager->getLivraisonsNonPayesByIdFournisseurByProjet($idFournisseur, $idProjet);
            
			$titreLivraison ="Liste des Livraisons du Fournisseur "
			.strtoupper($fournisseurManager->getFournisseurById($idFournisseur)->nom())
			."<br>Projet: ".$projetManager->getProjetById($idProjet)->nom();
			//get the sum of livraisons details using livraisons ids (idFournisseur)
			$livraisonsIds = 
			$livraisonManager->getLivraisonNonPayesIdsByIdFournisseurByIdProjet($idFournisseur, $idProjet);
			if ( isset($_POST['chooseDate']) and !empty($_POST['chooseDate']) ){
                if ( isset($_POST['printAll']) and !empty($_POST['printAll']) ) {
                    $livraisons = $livraisonManager->getLivraisonsByIdFournisseurByProjetByDates($idFournisseur, $idProjet, $dateFrom, $dateTo);
                    $livraisonsIds = $livraisonManager->getLivraisonIdsByIdFournisseurIdProjetByDates($idFournisseur, $idProjet, $dateFrom, $dateTo);    
                }
                else {
                    $livraisons = $livraisonManager->getLivraisonsNonPayesByIdFournisseurByProjetByDates($idFournisseur, $idProjet, $dateFrom, $dateTo);
                    $livraisonsIds = $livraisonManager->getLivraisonNonPayesIdsByIdFournisseurByIdProjetByDates($idFournisseur, $idProjet, $dateFrom, $dateTo);   
                }
            }
            else {
                if ( isset($_POST['printAll']) and !empty($_POST['printAll']) ) {
                    $livraisons = $livraisonManager->getLivraisonsByIdFournisseurByProjet($idFournisseur, $idProjet);
                    $livraisonsIds = $livraisonManager->getLivraisonIdsByIdFournisseurIdProjet($idFournisseur, $idProjet);    
                }
            }
			$sommeDetailsLivraisons = 0;
			foreach($livraisonsIds as $idl){
				$sommeDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($idl);
			}	
			$totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseur($idFournisseur);
			$totalLivraison = 
			$livraisonManager->getSommeLivraisonsByIdProjetAndIdFournisseur($idProjet, $idFournisseur)+
			$sommeDetailsLivraisons;
			//$hrefLivraisonBilanPrintController = "controller/LivraisonBilanPrintController.php?idFournisseur=".$fournisseur;
			//}

ob_start();
?>
<style type="text/css">
	p, h1, h2, h3{
		text-align: center;
		text-decoration: underline;
	}
	table {
		    border-collapse: collapse;
		    width:100%;
		}
		
		table, th, td {
		    border: 1px solid black;
		}
		td, th{
			padding : 5px;
		}
		
		th{
			background-color: grey;
		}
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <img src="../assets/img/logo_company.png" style="width: 110px" />
    <h3><?= $titreLivraison ?></h3>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <table>
		<tr>
			<th style="width: 15%">Date</th>
			<th style="width: 15%">Libelle</th>
			<th style="width: 45%">Designation</th>
			<th style="width: 10%">Status</th>
			<th style="width: 15%">Total</th>
		</tr>
		<?php
		foreach($livraisons as $livraison){
		    $detailsLivraison = $livraisonDetailManager->getLivraisonsDetailByIdLivraison($livraison->id());
		?>		
		<tr>
			<td style="width: 15%"><?= date('d/m/Y', strtotime($livraison->dateLivraison())) ?></td>
			<td style="width: 15%"><?= $livraison->libelle() ?></td>
			<td style="width: 45%">
			    <?php
			    //$livraisonDetailManager->getNombreArticleLivraisonByIdLivraison($livraison->id())
			    foreach ($detailsLivraison as $detail) {
			         echo $detail->designation()." - ";   
			    } 
			    ?>
			</td>
			<td style="width: 10%"><?= $livraison->status() ?></td>
			<td style="width: 15%"><?= number_format($livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id()), 2, ',', ' ') ?>&nbsp;DH</td>
		</tr>	
		<?php
		}//end of loop
		?>
	</table>
	<br />
	<table>
		<tr>
			<th style="width: 80%"><strong>Grand Total Livraisons</strong></th>
			<td style="width: 20%">
				<strong><?= number_format($totalLivraison, 2, ',', ' ') ?>&nbsp;DH
				</strong>
			</td>
		</tr>
	</table> 
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;">STE GELM SARL : Au capital de 100 000,00 DH – siège social QT 313 Old Brahim Mezanine B1, Nador. 
    	<br>Tèl 0536601818 / 0661668860 IF : 40451179   RC : 10999  Patente 56126681</p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
		$fileName = "BilanLivraison-".date('Ymdhi').'.pdf';
       	$pdf->Output($fileName);
    }
    catch(HTML2PDF_exception $e){
        die($e->getMessage());
    }
}//end if isset idProjet
else{
    header("Location:../projets.php");
}
}
else{
    header("Location:../index.php");
}
?>
