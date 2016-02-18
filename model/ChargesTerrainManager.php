<?php
class ChargesTerrainManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(ChargesTerrain $chargesTerrain){
    	$query = $this->_db->prepare(' INSERT INTO t_chargesterrain (
		dateOperation,designation,beneficiaire,numeroCheque,montant,idProjet,created,createdBy)
		VALUES (:dateOperation,:designation,:beneficiaire,:numeroCheque,:montant,:idProjet,:created,:createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':dateOperation', $chargesTerrain->dateOperation());
		$query->bindValue(':designation', $chargesTerrain->designation());
		$query->bindValue(':beneficiaire', $chargesTerrain->beneficiaire());
		$query->bindValue(':numeroCheque', $chargesTerrain->numeroCheque());
		$query->bindValue(':montant', $chargesTerrain->montant());
		$query->bindValue(':idProjet', $chargesTerrain->idProjet());
		$query->bindValue(':created', $chargesTerrain->created());
		$query->bindValue(':createdBy', $chargesTerrain->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(ChargesTerrain $chargesTerrain){
    	$query = $this->_db->prepare(' UPDATE t_chargesterrain SET 
		dateOperation=:dateOperation,designation=:designation,beneficiaire=:beneficiaire,
		numeroCheque=:numeroCheque,montant=:montant,idProjet=:idProjet
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $chargesTerrain->id());
		$query->bindValue(':dateOperation', $chargesTerrain->dateOperation());
		$query->bindValue(':designation', $chargesTerrain->designation());
		$query->bindValue(':beneficiaire', $chargesTerrain->beneficiaire());
		$query->bindValue(':numeroCheque', $chargesTerrain->numeroCheque());
		$query->bindValue(':montant', $chargesTerrain->montant());
		$query->bindValue(':idProjet', $chargesTerrain->idProjet());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_chargesterrain
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getChargesTerrainById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_chargesterrain
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new ChargesTerrain($data);
	}

	public function getChargesTerrains(){
		$chargesTerrains = array();
		$query = $this->_db->query('SELECT * FROM t_chargesterrain
		ORDER BY dateOperation DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesTerrains[] = new ChargesTerrain($data);
		}
		$query->closeCursor();
		return $chargesTerrains;
	}
	
	public function getChargesTerrainsByIdProjet($idProjet){
		$chargesTerrains = array();
		$query = $this->_db->prepare('SELECT * FROM t_chargesterrain WHERE idProjet=:idProjet
		ORDER BY id DESC');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesTerrains[] = new ChargesTerrain($data);
		}
		$query->closeCursor();
		return $chargesTerrains;
	}
	
	public function getChargesTerrainsLastWeekByIdProjet($idProjet){
		$chargesTerrains = array();
		$query = $this->_db->prepare('SELECT * FROM t_chargesterrain WHERE idProjet=:idProjet
		AND dateOperation BETWEEN SUBDATE(CURDATE(),7) AND CURDATE() ORDER BY id DESC');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesTerrains[] = new ChargesTerrain($data);
		}
		$query->closeCursor();
		return $chargesTerrains;
	}
	
	public function getChargesTerrainsByDatesByIdProjet($idProjet, $dateFrom, $dateTo){
		$chargesTerrains = array();
		$query = $this->_db->prepare('SELECT * FROM t_chargesterrain WHERE idProjet=:idProjet
		AND dateOperation BETWEEN :dateFrom AND :dateTo ORDER BY id DESC');
		$query->bindValue(':idProjet', $idProjet);
		$query->bindValue(':dateFrom', $dateFrom);
		$query->bindValue(':dateTo', $dateTo);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesTerrains[] = new ChargesTerrain($data);
		}
		$query->closeCursor();
		return $chargesTerrains;
	}
	
	public function getChargesTerrainsByLimits($begin, $end){
		$chargesTerrains = array();
		$query = $this->_db->query('SELECT * FROM t_chargesterrain
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesTerrains[] = new ChargesTerrain($data);
		}
		$query->closeCursor();
		return $chargesTerrains;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_chargesterrain
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
	///////////////////////////////////////////////////////////////////////////////////////////
	
	public function getTotalByIdProjet($idProjet){
		$query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_chargesterrain WHERE idProjet=:idProjet');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$total = $data['total'];
		return $total;
	}

}