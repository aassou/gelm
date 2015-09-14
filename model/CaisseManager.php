<?php
class CaisseManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Caisse $caisse){
    	$query = $this->_db->prepare(' INSERT INTO t_caisse (
		nom,dateCreation,created,createdBy)
		VALUES (:nom,:dateCreation,:created,:createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $caisse->nom());
		$query->bindValue(':dateCreation', $caisse->dateCreation());
		$query->bindValue(':created', $caisse->created());
		$query->bindValue(':createdBy', $caisse->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Caisse $caisse){
    	$query = $this->_db->prepare(' UPDATE t_caisse SET nom=:nom,dateCreation=:dateCreation WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $caisse->id());
		$query->bindValue(':nom', $caisse->nom());
		$query->bindValue(':dateCreation', $caisse->dateCreation());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_caisse
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getCaisseById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_caisse
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Caisse($data);
	}

	public function getCaisses(){
		$caisses = array();
		$query = $this->_db->query('SELECT * FROM t_caisse
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$caisses[] = new Caisse($data);
		}
		$query->closeCursor();
		return $caisses;
	}
	public function getCaissesByLimits($begin, $end){
		$caisses = array();
		$query = $this->_db->query('SELECT * FROM t_caisse
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$caisses[] = new Caisse($data);
		}
		$query->closeCursor();
		return $caisses;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_caisse
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}