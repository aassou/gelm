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
        $contratManager = new ContratManager($pdo);
        $projetManager = new ProjetManager($pdo);
		//classes and attributes
		$idContrat = $_GET['idContrat'];
        $contrat = $contratManager->getContratById($idContrat);
        $projet = $projetManager->getProjetById($contrat->idProjet());
//property data
$programme  = $projet->nom();
$nomClient = $contrat->nomClient();
$adresse = $contrat->adresse();
$cin = $contrat->cin();
$telephone = $contrat->telephone();
$dateContrat = date('d-m-Y', strtotime($contrat->dateCreation()));
$email = "";
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
    <br><br><br><br><br><br><br>
    <h1>Fiche - Client</h1>
    <br><br><br><br><br><br><br>
	<table class="clientHeader">
		<tr>
			<td class="head2">Informations du Contrat</td>
		</tr>
	</table>
	<br>
    <table class="contratSection">
		<tr>
			<td class="head1">Numéro dossier</td>
			<td class="body1">: <?= $contrat->id(); ?></td>
		</tr>
		<tr>
			<td class="head1">Date d'entrée</td>
			<td class="body1">: <?= $dateContrat ?></td>
		</tr>
	</table>
	<br>
	<table class="clientHeader">
		<tr>
			<td class="head2">Informations du Client</td>
		</tr>
	</table>
	<br>
	<table class="clienSection">
		<tr>
			<td class="head3">Nom</td>
			<td class="body3">: <?= $nomClient ?></td>
		</tr>
		<tr>
			<td class="head3">CIN</td>
			<td class="body3">: <?= $cin ?></td>
		</tr>
		<tr>
			<td class="head3">Adresse</td>
			<td class="body3">: <?= $adresse ?></td>
		</tr>
		<tr>
			<td class="head3">Téléphone 1</td>
			<td class="body3">: <?= $telephone ?></td>
		</tr>
		<tr>
			<td class="head3">Email</td>
			<td class="body3">: <?= $email ?></td>
		</tr>
		<tr>
			<td class="head3">Projet</td>
			<td class="body3">: <?= $programme ?></td>
		</tr>
	</table>
	<br>
	<table class="observationSection">
		<tr>
			<td class="head1">Observation</td>
			<td>..............................</td>
			<td>..............................</td>
			<td>.....................................</td>
		</tr>
		<tr>
		</tr>
		<tr>
			<td></td>
			<td>..............................</td>
			<td>..............................</td>
			<td>.....................................</td>
		</tr>
		<tr>
			<td></td>
			<td>..............................</td>
			<td>..............................</td>
			<td>.....................................</td>
		</tr>
		<tr>
			<td></td>
			<td>..............................</td>
			<td>..............................</td>
			<td>.....................................</td>
		</tr>
	</table>
    <br><br>
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
