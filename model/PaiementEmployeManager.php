<?php
class PaiementEmployeManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(PaiementEmploye $paiementEmploye){
    	$query = $this->_db->prepare(' INSERT INTO t_paiementEmploye (
		dateOperation,montant,numeroCheque,idProjet,idEmploye,created,createdBy)
		VALUES (:dateOperation,:montant,:numeroCheque,:idProjet,:idEmploye,:created,:createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':dateOperation', $paiementEmploye->dateOperation());
		$query->bindValue(':montant', $paiementEmploye->montant());
		$query->bindValue(':numeroCheque', $paiementEmploye->numeroCheque());
		$query->bindValue(':idProjet', $paiementEmploye->idProjet());
		$query->bindValue(':idEmploye', $paiementEmploye->idEmploye());
		$query->bindValue(':created', $paiementEmploye->created());
		$query->bindValue(':createdBy', $paiementEmploye->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(PaiementEmploye $paiementEmploye){
    	$query = $this->_db->prepare(' UPDATE t_paiementEmploye SET dateOperation=:dateOperation, montant=:montant, 
		numeroCheque=:numeroCheque, idEmploye=:idEmploye WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $paiementEmploye->id());
		$query->bindValue(':dateOperation', $paiementEmploye->dateOperation());
		$query->bindValue(':montant', $paiementEmploye->montant());
		$query->bindValue(':numeroCheque', $paiementEmploye->numeroCheque());
		$query->bindValue(':idEmploye', $paiementEmploye->idEmploye());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_paiementEmploye
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getPaiementEmployeById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_paiementEmploye
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new PaiementEmploye($data);
	}
	
	public function getPaiementEmployeNumberByIdProjet($idProjet){
		$query = $this->_db->prepare(' SELECT COUNT(*) AS paiementNumber FROM t_paiementemploye WHERE idProjet=:idProjet');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$paiementNumber = $data['paiementNumber'];
		return $paiementNumber;
	}
	
	public function getPaiementsByIdProjet($idProjet){
		$paiementEmployes = array();
		$query = $this->_db->prepare('SELECT * FROM t_paiementEmploye WHERE idProjet=:idProjet ORDER BY id DESC');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$paiementEmployes[] = new PaiementEmploye($data);
		}
		$query->closeCursor();
		return $paiementEmployes;
	}
	
	public function getTotalPaiementsByIdProjetByIdEmploye($idProjet, $idEmploye){
		$query = $this->_db->prepare(' SELECT SUM(montant) AS total FROM t_paiementEmploye WHERE idProjet=:idProjet AND idEmploye=:idEmploye');
		$query->bindValue(':idProjet', $idProjet);
		$query->bindValue(':idEmploye', $idEmploye);
		$query->execute();
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$total = $data['total'];
		return $total;
	}

	public function getPaiementEmployes(){
		$paiementEmployes = array();
		$query = $this->_db->query('SELECT * FROM t_paiementEmploye
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$paiementEmployes[] = new PaiementEmploye($data);
		}
		$query->closeCursor();
		return $paiementEmployes;
	}
	public function getPaiementEmployesByLimits($begin, $end){
		$paiementEmployes = array();
		$query = $this->_db->query('SELECT * FROM t_paiementEmploye
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$paiementEmployes[] = new PaiementEmploye($data);
		}
		$query->closeCursor();
		return $paiementEmployes;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_paiementEmploye
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}