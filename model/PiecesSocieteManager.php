<?php
class PiecesSocieteManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(PiecesSociete $piecesSociete){
    	$query = $this->_db->prepare(' INSERT INTO t_piecessociete (
		url,description,idSociete,createdBy,created)
		VALUES (:url,:description,:idSociete,:createdBy,:created)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':url', $piecesSociete->url());
		$query->bindValue(':description', $piecesSociete->description());
		$query->bindValue(':idSociete', $piecesSociete->idSociete());
		$query->bindValue(':createdBy', $piecesSociete->createdBy());
		$query->bindValue(':created', $piecesSociete->created());
		$query->execute();
		$query->closeCursor();
	}

	public function update(PiecesSociete $piecesSociete){
    	$query = $this->_db->prepare(' UPDATE t_piecessociete SET 
		url=:url,description=:description,idSociete=:idSociete,createdBy=:createdBy,created=:created
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $piecesSociete->id());
		$query->bindValue(':url', $piecesSociete->url());
		$query->bindValue(':description', $piecesSociete->description());
		$query->bindValue(':idSociete', $piecesSociete->idSociete());
		$query->bindValue(':createdBy', $piecesSociete->createdBy());
		$query->bindValue(':created', $piecesSociete->created());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_piecessociete
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getPiecesSocieteById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_piecessociete
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new PiecesSociete($data);
	}

	public function getPiecesSocietes(){
		$piecesSocietes = array();
		$query = $this->_db->query('SELECT * FROM t_piecessociete
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$piecesSocietes[] = new PiecesSociete($data);
		}
		$query->closeCursor();
		return $piecesSocietes;
	}
	
	public function getPiecesSocietesByIdSociete($idSociete){
		$piecesSocietes = array();
		$query = $this->_db->prepare('SELECT * FROM t_piecessociete WHERE idSociete=:idSociete');
		$query->bindValue(':idSociete', $idSociete);
		$query->execute();		
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$piecesSocietes[] = new PiecesSociete($data);
		}
		$query->closeCursor();
		return $piecesSocietes;
	}
	
	public function getPiecesSocietesByLimits($begin, $end){
		$piecesSocietes = array();
		$query = $this->_db->query('SELECT * FROM t_piecessociete
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$piecesSocietes[] = new PiecesSociete($data);
		}
		$query->closeCursor();
		return $piecesSocietes;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_piecessociete
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}