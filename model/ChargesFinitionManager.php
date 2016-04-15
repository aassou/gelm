<?php
class ChargesFinitionManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(ChargesFinition $chargesFinition){
    	$query = $this->_db->prepare(' INSERT INTO t_chargesfinition (
		dateOperation,designation,beneficiaire,numeroCheque,montant,idProjet,created,createdBy)
		VALUES (:dateOperation,:designation,:beneficiaire,:numeroCheque,:montant,:idProjet,:created,:createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':dateOperation', $chargesFinition->dateOperation());
		$query->bindValue(':designation', $chargesFinition->designation());
		$query->bindValue(':beneficiaire', $chargesFinition->beneficiaire());
		$query->bindValue(':numeroCheque', $chargesFinition->numeroCheque());
		$query->bindValue(':montant', $chargesFinition->montant());
		$query->bindValue(':idProjet', $chargesFinition->idProjet());
		$query->bindValue(':created', $chargesFinition->created());
		$query->bindValue(':createdBy', $chargesFinition->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(ChargesFinition $chargesFinition){
    	$query = $this->_db->prepare(' UPDATE t_chargesfinition SET 
		dateOperation=:dateOperation,designation=:designation,beneficiaire=:beneficiaire,
		numeroCheque=:numeroCheque,montant=:montant,idProjet=:idProjet
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $chargesFinition->id());
		$query->bindValue(':dateOperation', $chargesFinition->dateOperation());
		$query->bindValue(':designation', $chargesFinition->designation());
		$query->bindValue(':beneficiaire', $chargesFinition->beneficiaire());
		$query->bindValue(':numeroCheque', $chargesFinition->numeroCheque());
		$query->bindValue(':montant', $chargesFinition->montant());
		$query->bindValue(':idProjet', $chargesFinition->idProjet());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_chargesfinition
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getChargesFinitionById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_chargesfinition
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new ChargesFinition($data);
	}

	public function getChargesFinitions(){
		$chargesFinitions = array();
		$query = $this->_db->query('SELECT * FROM t_chargesfinition
		ORDER BY dateOperation DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesFinitions[] = new ChargesFinition($data);
		}
		$query->closeCursor();
		return $chargesFinitions;
	}
	
	public function getChargesFinitionsByIdProjet($idProjet){
		$chargesFinitions = array();
		$query = $this->_db->prepare('SELECT * FROM t_chargesfinition WHERE idProjet=:idProjet
		ORDER BY dateOperation DESC');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesFinitions[] = new ChargesFinition($data);
		}
		$query->closeCursor();
		return $chargesFinitions;
	}

	public function getChargesFinitionsByDatesByIdProjet($idProjet, $dateFrom, $dateTo){
		$chargesFinitions = array();
		$query = $this->_db->prepare('SELECT * FROM t_chargesfinition WHERE idProjet=:idProjet
		AND dateOperation BETWEEN :dateFrom AND :dateTo ORDER BY id DESC');
		$query->bindValue(':idProjet', $idProjet);
		$query->bindValue(':dateFrom', $dateFrom);
		$query->bindValue(':dateTo', $dateTo);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesFinitions[] = new ChargesFinition($data);
		}
		$query->closeCursor();
		return $chargesFinitions;
	}

	public function getChargesFinitionsLastWeekByIdProjet($idProjet){
		$chargesFinitions = array();
		$query = $this->_db->prepare('SELECT * FROM t_chargesfinition WHERE idProjet=:idProjet
		AND dateOperation BETWEEN SUBDATE(CURDATE(),7) AND CURDATE() ORDER BY id DESC');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesFinitions[] = new ChargesFinition($data);
		}
		$query->closeCursor();
		return $chargesFinitions;
	}
	
	public function getChargesFinitionsByLimits($begin, $end){
		$chargesFinitions = array();
		$query = $this->_db->query('SELECT * FROM t_chargesfinition
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesFinitions[] = new ChargesFinition($data);
		}
		$query->closeCursor();
		return $chargesFinitions;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_chargesfinition
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
	///////////////////////////////////////////////////////////////////////////////////////////
	
	public function getTotalByIdProjet($idProjet){
		$query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_chargesfinition WHERE idProjet=:idProjet');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$total = $data['total'];
		return $total;
	}
}