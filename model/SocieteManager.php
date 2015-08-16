<?php
class SocieteManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Societe $societe){
    	$query = $this->_db->prepare(' INSERT INTO t_societe (
		raisonSociale, dateCreation, createdBy, created)
		VALUES (:raisonSociale, :dateCreation, :createdBy, :created)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':raisonSociale', $societe->raisonSociale());
		$query->bindValue(':dateCreation', $societe->dateCreation());
		$query->bindValue(':createdBy', $societe->createdBy());
		$query->bindValue(':created', $societe->created());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Societe $societe){
    	$query = $this->_db->prepare(' UPDATE t_societe SET 
		raisonSociale=:raisonSociale, dateCreation=:dateCreation 
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $societe->id());
		$query->bindValue(':raisonSociale', $societe->raisonSociale());
		$query->bindValue(':dateCreation', $societe->dateCreation());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_societe WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getSocieteById($id){
        $query = $this->_db->prepare('SELECT * FROM t_societe WHERE id =:id')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Societe($data);
    }

	public function getSocietes(){
		$societes = array();
		$query = $this->_db->query('SELECT * FROM t_societe
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$societes[] = new Societe($data);
		}
		$query->closeCursor();
		return $societes;
	}
	public function getSocietesByLimits($begin, $end){
		$societes = array();
		$query = $this->_db->query('SELECT * FROM t_societe
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$societes[] = new Societe($data);
		}
		$query->closeCursor();
		return $societes;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_societe
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
	
	///////////////////////////////////////////////////////////////////////////////////
	
	public function getSocietesNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS societesNumber FROM t_societe');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['societesNumber'];
    }

}