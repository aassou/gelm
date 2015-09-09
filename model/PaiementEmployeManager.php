<?php
class PaiementEmployeManager{

	//attributes
	private $_db;

<<<<<<< HEAD
	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(PaiementEmploye $paiementEmploye){
=======
	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(PaiementEmploye $paiementEmploye){
>>>>>>> 32d8c2d0dbce6a6ed5c3ce01d84e1dca4c37cc04
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

<<<<<<< HEAD
	public function update(PaiementEmploye $paiementEmploye){
=======
	public function update(PaiementEmploye $paiementEmploye){
>>>>>>> 32d8c2d0dbce6a6ed5c3ce01d84e1dca4c37cc04
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

<<<<<<< HEAD
	public function delete($id){
=======
	public function delete($id){
>>>>>>> 32d8c2d0dbce6a6ed5c3ce01d84e1dca4c37cc04
    	$query = $this->_db->prepare(' DELETE FROM t_paiementEmploye
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

<<<<<<< HEAD
	public function getPaiementEmployeById($id){
=======
	public function getPaiementEmployeById($id){
>>>>>>> 32d8c2d0dbce6a6ed5c3ce01d84e1dca4c37cc04
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
	
<<<<<<< HEAD
=======
	public function getPaiementsByIdProjetByIdEmploye($idProjet, $idEmploye){
		$paiementEmployes = array();
		$query = $this->_db->prepare('SELECT * FROM t_paiementEmploye 
		WHERE idProjet=:idProjet AND idEmploye=:idEmploye ORDER BY id DESC');
		$query->bindValue(':idProjet', $idProjet);
		$query->bindValue(':idEmploye', $idEmploye);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$paiementEmployes[] = new PaiementEmploye($data);
		}
		$query->closeCursor();
		return $paiementEmployes;
	}
	
>>>>>>> 32d8c2d0dbce6a6ed5c3ce01d84e1dca4c37cc04
	public function getTotalPaiementsByIdProjetByIdEmploye($idProjet, $idEmploye){
		$query = $this->_db->prepare(' SELECT SUM(montant) AS total FROM t_paiementEmploye WHERE idProjet=:idProjet AND idEmploye=:idEmploye');
		$query->bindValue(':idProjet', $idProjet);
		$query->bindValue(':idEmploye', $idEmploye);
		$query->execute();
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$total = $data['total'];
		return $total;
	}

<<<<<<< HEAD
	public function getPaiementEmployes(){
		$paiementEmployes = array();
		$query = $this->_db->query('SELECT * FROM t_paiementEmploye
=======
	public function getPaiementEmployes(){
		$paiementEmployes = array();
		$query = $this->_db->query('SELECT * FROM t_paiementEmploye
>>>>>>> 32d8c2d0dbce6a6ed5c3ce01d84e1dca4c37cc04
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$paiementEmployes[] = new PaiementEmploye($data);
		}
		$query->closeCursor();
		return $paiementEmployes;
	}
<<<<<<< HEAD
	public function getPaiementEmployesByLimits($begin, $end){
		$paiementEmployes = array();
		$query = $this->_db->query('SELECT * FROM t_paiementEmploye
=======
	public function getPaiementEmployesByLimits($begin, $end){
		$paiementEmployes = array();
		$query = $this->_db->query('SELECT * FROM t_paiementEmploye
>>>>>>> 32d8c2d0dbce6a6ed5c3ce01d84e1dca4c37cc04
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$paiementEmployes[] = new PaiementEmploye($data);
		}
		$query->closeCursor();
		return $paiementEmployes;
	}
<<<<<<< HEAD
	public function getLastId(){
=======
	public function getLastId(){
>>>>>>> 32d8c2d0dbce6a6ed5c3ce01d84e1dca4c37cc04
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_paiementEmploye
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}