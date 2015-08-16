<?php
class CompteBancaireManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(CompteBancaire $compteBancaire){
    	$query = $this->_db->prepare(' INSERT INTO t_comptebancaire (
		numero, idSociete, dateCreation, createdBy, created)
		VALUES (:numero, :idSociete, :dateCreation, :createdBy, :created)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':numero', $compteBancaire->numero());
		$query->bindValue(':idSociete', $compteBancaire->idSociete());
		$query->bindValue(':dateCreation', $compteBancaire->dateCreation());
		$query->bindValue(':createdBy', $compteBancaire->createdBy());
		$query->bindValue(':created', $compteBancaire->created());
		$query->execute();
		$query->closeCursor();
	}

	public function update(CompteBancaire $compteBancaire){
    	$query = $this->_db->prepare(' UPDATE t_compteBancaire SET 
		numero=:numero, dateCreation=:dateCreation, createdBy=:createdBy, created=:created
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $compteBancaire->id());
		$query->bindValue(':numero', $compteBancaire->numero());
		$query->bindValue(':dateCreation', $compteBancaire->dateCreation());
		$query->bindValue(':createdBy', $compteBancaire->createdBy());
		$query->bindValue(':created', $compteBancaire->created());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_compteBancaire
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getCompteBancaireById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_compteBancaire
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new CompteBancaire($data);
	}

	public function getCompteBancaires(){
		$compteBancaires = array();
		$query = $this->_db->query('SELECT * FROM t_compteBancaire
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$compteBancaires[] = new CompteBancaire($data);
		}
		$query->closeCursor();
		return $compteBancaires;
	}
	
	public function getCompteBancairesByIdSociete($idSociete){
		$compteBancaires = array();
		$query = $this->_db->prepare('SELECT * FROM t_compteBancaire WHERE idSociete=:idSociete
		ORDER BY id DESC');
		$query->bindValue(':idSociete', $idSociete);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$compteBancaires[] = new CompteBancaire($data);
		}
		$query->closeCursor();
		return $compteBancaires;
	}
	
	public function getCompteBancairesByLimits($begin, $end){
		$compteBancaires = array();
		$query = $this->_db->query('SELECT * FROM t_compteBancaire
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$compteBancaires[] = new CompteBancaire($data);
		}
		$query->closeCursor();
		return $compteBancaires;
	}
	
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_compteBancaire
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}