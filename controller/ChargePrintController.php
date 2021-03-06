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
        //classes managers	
        $projetManager = new ProjetManager($pdo);
		$projets = $projetManager->getProjets();
		$idProjet = htmlentities($_POST['idProjet']);
        $idSociete = htmlentities($_POST['idSociete']);
        $type = htmlentities($_POST['type']);
		$dateFrom = htmlentities($_POST['dateFrom']);
		$dateTo = htmlentities($_POST['dateTo']);
		
		if(isset($_POST['terrain'])){
			$chargesTerrainManager = new ChargesTerrainManager($pdo);
			$totalChargesTerrain = number_format($chargesTerrainManager->getTotalByIdProjet($idProjet), 2, ',', ' ');
			$chargesTerrainLastWeek = $chargesTerrainManager->getChargesTerrainsByDatesByIdProjet($idProjet, $dateFrom, $dateTo);	
		}
		if(isset($_POST['construction'])){
			$chargesConstructionManager = new ChargesConstructionManager($pdo);
			$totalChargesConstruction = number_format($chargesConstructionManager->getTotalByIdProjet($idProjet), 2, ',', ' ');
			$chargesConstructionLastWeek = $chargesConstructionManager->getChargesConstructionsByDatesByIdProjet($idProjet, $dateFrom, $dateTo);		
		}
		if(isset($_POST['finition'])){
			$chargesFinitionManager = new ChargesFinitionManager($pdo);
			$totalChargesFinition = number_format($chargesFinitionManager->getTotalByIdProjet($idProjet), 2, ',', ' ');
			$chargesFinitionLastWeek = $chargesFinitionManager->getChargesFinitionsByDatesByIdProjet($idProjet, $dateFrom, $dateTo);		
		}

ob_start();
?>
<style type="text/css">
	p, h1, h2{
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
    <br><br><br><br>
    <h2>Liste des Charges du <?= date('d/m/Y', strtotime($dateFrom)).' au '.date('d/m/Y', strtotime($dateTo)) ?> </h2>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <br><br>
    <table>
		<tr>
			<?php
		    if(isset($_POST['terrain'])){
		    ?>
			<th style="width: 10%"><strong>Terrain</strong></th>
			<td style="width: 20%"><strong><?= $totalChargesTerrain ?>&nbsp;DH</strong></td>
			<?php
		    }
		    ?>
		    <?php
		    if(isset($_POST['construction'])){
		    ?>
			<th style="width: 15%"><strong>Construction</strong></th>
			<td style="width: 20%"><strong><?= $totalChargesConstruction ?>&nbsp;DH</strong></td>
			<?php
		    }
		    ?>
		    <?php
		    if(isset($_POST['finition'])){
		    ?>
			<th style="width: 15%"><strong>Finition</strong></th>
			<td style="width: 20%"><strong><?= $totalChargesFinition ?>&nbsp;DH</strong></td>
			<?php
		    }
		    ?>
		</tr>
		<tr>
		    <?php
		    if(isset($_POST['terrain']) and isset($_POST['construction']) and isset($_POST['finition']) ){
		    	$grandTotal =
		    				$chargesTerrainManager->getTotalByIdProjet($idProjet)+ 
		    				$chargesConstructionManager->getTotalByIdProjet($idProjet)+
		    				$chargesFinitionManager->getTotalByIdProjet($idProjet);
		    ?>
			<th><strong>Grand Total</strong></th>
			<td><a><strong><?= number_format($grandTotal, 2, ',', ' ') ?>&nbsp;DH</strong></a></td>
			<?php
		    }
		    ?>
		</tr>
	</table>
    <?php
    if(isset($_POST['terrain'])){
    ?>
    <h3>Les Charges du Terrain</h3>
    <table>
		<tr>
			<th style="width:15%">Date</th>
			<th style="width:30%">Désignation</th>
			<th style="width:20%">Bénéficiaire</th>
			<th style="width:15%">Numéro Chèque</th>
			<th style="width:20%">Montant</th>
		</tr>
		<?php
		foreach($chargesTerrainLastWeek as $terrain){
		?>		
		<tr>
			<td style="width:15%"><?= date('d/m/Y', strtotime($terrain->dateOperation())) ?></td>
			<td style="width:30%"><?= $terrain->designation() ?></td>
			<td style="width:20%"><?= $terrain->beneficiaire() ?></td>
			<td style="width:15%"><?= $terrain->numeroCheque() ?></td>
			<td style="width:20%"><?= number_format($terrain->montant(), 2, ' ', ',') ?>&nbsp;DH</td>
		</tr>	
		<?php
		}//end of loop
		?>
	</table> 
	<?php
    }//end of terrain
    ?>
    <br>
    <?php
    if(isset($_POST['construction'])){
    ?>
    <h3>Les Charges de Construction</h3>
    <table>
		<tr>
			<th style="width:20%">Date Opération</th>
			<th style="width:20%">Désignation</th>
			<th style="width:20%">Bénéficiaire</th>
			<th style="width:20%">Numéro Chèque</th>
			<th style="width:20%">Montant</th>
		</tr>
		<?php
		foreach($chargesConstructionLastWeek as $construction){
		?>		
		<tr>
			<td style="width:20%"><?= date('d/m/Y', strtotime($construction->dateOperation())) ?></td>
			<td style="width:20%"><?= $construction->designation() ?></td>
			<td style="width:20%"><?= $construction->beneficiaire() ?></td>
			<td style="width:20%"><?= $construction->numeroCheque() ?></td>
			<td style="width:20%"><?= number_format($construction->montant(), 2, ' ', ',') ?>&nbsp;DH</td>
		</tr>	
		<?php
		}//end of loop
		?>
	</table> 
	<?php
    }//end of construction
    ?>
    <br>
    <?php
    if(isset($_POST['finition'])){
    ?>
    <h3>Les Charges de Finition</h3>
    <table>
		<tr>
			<th style="width:20%">Date Opération</th>
			<th style="width:20%">Désignation</th>
			<th style="width:20%">Bénéficiaire</th>
			<th style="width:20%">Numéro Chèque</th>
			<th style="width:20%">Montant</th>
		</tr>
		<?php
		foreach($chargesFinitionLastWeek as $finition){
		?>		
		<tr>
			<td style="width:20%"><?= date('d/m/Y', strtotime($finition->dateOperation())) ?></td>
			<td style="width:20%"><?= $finition->designation() ?></td>
			<td style="width:20%"><?= $finition->beneficiaire() ?></td>
			<td style="width:20%"><?= $finition->numeroCheque() ?></td>
			<td style="width:20%"><?= number_format($finition->montant(), 2, ' ', ',') ?>&nbsp;DH</td>
		</tr>	
		<?php
		}//end of loop
		?>
	</table> 
	<?php
    }//end of finition
    ?>
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
		$fileName = "ListeCharges-".date('Ymdhi').'.pdf';
       	$pdf->Output($fileName);
    }
    catch(HTML2PDF_exception $e){
        die($e->getMessage());
    }
}
else{
    header("Location:index.php");
}
?>
