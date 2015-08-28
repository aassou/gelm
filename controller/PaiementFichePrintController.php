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
        $employeManager = new EmployeManager($pdo);
        $paiementManager = new PaiementEmployeManager($pdo);
		//classes and attributes
		$idEmploye = $_GET['idEmploye'];
		$idProjet = $_GET['idProjet'];
        $employe = $employeManager->getEmployeById($idEmploye);
        $projet = $projetManager->getProjetById($idProjet);
		$paiements = $paiementManager->getPaiementsByIdProjetByIdEmploye($idProjet, $idEmploye);
		$totalPaiements = $paiementManager->getTotalPaiementsByIdProjetByIdEmployegetTotalPaiementsByIdProjetByIdEmploye($idProjet, $idEmploye);
//property data
$programme  = $projet->nom();

ob_start();
?>
<style type="text/css">
	h1{
		text-align: center;
		text-decoration: underline;
	}
	table
	{
		width: 100%;	
	}
	.contratSection, .observationSection
	{
		width: 100%;
		border: solid 1px black;
		
	}
	.clienSection
	{
		width: 100%;
		border: solid 1px black;
	}
	.clientHeader
	{
		width: 100%;
		text-align: center;
		font-size: 20pt;
		color: black;
	}
	.head1
	{
		width: 45%;
		font-weight: bold;
	}
	.body1
	{
		width: 55%;
	}
	.head2
	{
		width: 100%;		
	}
	.head3
	{
		width: 45%;
		font-weight: bold;
		
	}
	.body3
	{
		width: 55%;
	}
</style>
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <img src="../assets/img/logo_company.png" style="width: 110px" />
    <br><br><br><br>
    <h1>Fiche Paiement de <?= $employe->nom() ?> - Projet : <?= $programme ?></h1>
    <br><br><br><br>
	<table>
		<thead>
			<tr>
				<th style="width:30%">Date Paiement</th>
				<th style="width:35%">Montant Payé</th>
				<th style="width:35%">Numéro chèque</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if($paiementNumber != 0){
			foreach($paiements as $paiement){
			?>		
			<tr>
				<td><?= $paiement->dateOperation() ?></td>
				<td><?= number_format($paiement->montant(), 2, ',', ' ') ?></td>
				<td><?= $paiement->numeroCheque() ?></td>
			</tr>		
			<?php
			}//end of loop
			}//end of if
			?>
		</tbody>
	</table>
	<table>
		<thead>
			<tr>
				<th style="width:30%"></th>
				<th style="width:35%">Total</th>
				<th style="width:35%">Signature</th>
			</tr>
		</thead>
		<tbody>	
			<tr>
				<td></td>
				<td><?= number_format($totalPaiements, 2, ',', ' ') ?></td>
				<td></td>
			</tr>
		</tbody>
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
		$fileName = "FicheClient-".$nomClient.'-'.$dateContrat.'.pdf';
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
