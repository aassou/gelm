<?php
class ChargesConstructionManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(ChargesConstruction $chargesConstruction){
    	$query = $this->_db->prepare(' INSERT INTO t_chargesconstruction (
		dateOperation,designation,beneficiaire,numeroCheque,montant,idProjet,created,createdBy)
		VALUES (:dateOperation,:designation,:beneficiaire,:numeroCheque,:montant,:idProjet,:created,:createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':dateOperation', $chargesConstruction->dateOperation());
		$query->bindValue(':designation', $chargesConstruction->designation());
		$query->bindValue(':beneficiaire', $chargesConstruction->beneficiaire());
		$query->bindValue(':numeroCheque', $chargesConstruction->numeroCheque());
		$query->bindValue(':montant', $chargesConstruction->montant());
		$query->bindValue(':idProjet', $chargesConstruction->idProjet());
		$query->bindValue(':created', $chargesConstruction->created());
		$query->bindValue(':createdBy', $chargesConstruction->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(ChargesConstruction $chargesConstruction){
    	$query = $this->_db->prepare(' UPDATE t_chargesconstruction SET 
		dateOperation=:dateOperation,designation=:designation,beneficiaire=:beneficiaire,
		numeroCheque=:numeroCheque,montant=:montant,idProjet=:idProjet
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $chargesConstruction->id());
		$query->bindValue(':dateOperation', $chargesConstruction->dateOperation());
		$query->bindValue(':designation', $chargesConstruction->designation());
		$query->bindValue(':beneficiaire', $chargesConstruction->beneficiaire());
		$query->bindValue(':numeroCheque', $chargesConstruction->numeroCheque());
		$query->bindValue(':montant', $chargesConstruction->montant());
		$query->bindValue(':idProjet', $chargesConstruction->idProjet());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_chargesconstruction
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getChargesConstructionById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_chargesconstruction
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new ChargesConstruction($data);
	}

	public function getChargesConstructions(){
		$chargesConstructions = array();
		$query = $this->_db->query('SELECT * FROM t_chargesconstruction
		ORDER BY dateOperation DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesConstructions[] = new ChargesConstruction($data);
		}
		$query->closeCursor();
		return $chargesConstructions;
	}
	
	public function getChargesConstructionsByIdProjet($idProjet){
		$chargesConstructions = array();
		$query = $this->_db->prepare('SELECT * FROM t_chargesconstruction WHERE idProjet=:idProjet
		ORDER BY id DESC');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesConstructions[] = new ChargesConstruction($data);
		}
		$query->closeCursor();
		return $chargesConstructions;
	}
	
	public function getChargesConstructionsLastWeekByIdProjet($idProjet){
		$chargesConstructions = array();
		$query = $this->_db->prepare('SELECT * FROM t_chargesconstruction WHERE idProjet=:idProjet
		AND dateOperation BETWEEN SUBDATE(CURDATE(),7) AND CURDATE() ORDER BY id DESC');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesConstructions[] = new ChargesConstruction($data);
		}
		$query->closeCursor();
		return $chargesConstructions;
	}
	
	public function getChargesConstructionsByDatesByIdProjet($idProjet, $dateFrom, $dateTo){
		$chargesConstructions = array();
		$query = $this->_db->prepare('SELECT * FROM t_chargesconstruction WHERE idProjet=:idProjet
		AND dateOperation BETWEEN :dateFrom AND :dateTo ORDER BY id DESC');
		$query->bindValue(':idProjet', $idProjet);
		$query->bindValue(':dateFrom', $dateFrom);
		$query->bindValue(':dateTo', $dateTo);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesConstructions[] = new ChargesConstruction($data);
		}
		$query->closeCursor();
		return $chargesConstructions;
	}
	
	public function getChargesConstructionsByLimits($begin, $end){
		$chargesConstructions = array();
		$query = $this->_db->query('SELECT * FROM t_chargesconstruction
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesConstructions[] = new ChargesConstruction($data);
		}
		$query->closeCursor();
		return $chargesConstructions;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_chargesconstruction
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
	///////////////////////////////////////////////////////////////////////////////////////////
	
	public function getTotalByIdProjet($idProjet){
		$query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_chargesconstruction WHERE idProjet=:idProjet');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$total = $data['total'];
		return $total;
	}

}