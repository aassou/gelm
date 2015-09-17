<?php
class ContratDetailsManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(ContratDetails $contratDetails){
    	$query = $this->_db->prepare(' INSERT INTO t_contratDetails (
		dateOperation, montant, numeroCheque, idContratEmploye, created, createdBy)
		VALUES (:dateOperation, :montant, :numeroCheque, :idContratEmploye, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':dateOperation', $contratDetails->dateOperation());
		$query->bindValue(':montant', $contratDetails->montant());
		$query->bindValue(':numeroCheque', $contratDetails->numeroCheque());
		$query->bindValue(':idContratEmploye', $contratDetails->idContratEmploye());
		$query->bindValue(':created', $contratDetails->created());
		$query->bindValue(':createdBy', $contratDetails->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(ContratDetails $contratDetails){
    	$query = $this->_db->prepare(' UPDATE t_contratDetails SET 
		dateOperation=:dateOperation, montant=:montant, numeroCheque=:numeroCheque, idContratEmploye=:idContratEmploye
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $contratDetails->id());
		$query->bindValue(':dateOperation', $contratDetails->dateOperation());
		$query->bindValue(':montant', $contratDetails->montant());
		$query->bindValue(':numeroCheque', $contratDetails->numeroCheque());
		$query->bindValue(':idContratEmploye', $contratDetails->idContratEmploye());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_contratDetails
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getContratDetailsById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_contratDetails
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new ContratDetails($data);
	}

	public function getContratDetailss(){
		$contratDetailss = array();
		$query = $this->_db->query('SELECT * FROM t_contratDetails
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratDetailss[] = new ContratDetails($data);
		}
		$query->closeCursor();
		return $contratDetailss;
	}

	public function getContratDetailssByLimits($begin, $end){
		$contratDetailss = array();
		$query = $this->_db->query('SELECT * FROM t_contratDetails
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratDetailss[] = new ContratDetails($data);
		}
		$query->closeCursor();
		return $contratDetailss;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_contratDetails
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}