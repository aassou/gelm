<?php
class PiecesProjetManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(PiecesProjet $piecesProjet){
    	$query = $this->_db->prepare(' INSERT INTO t_piecesprojet (
		url,description,idProjet,createdBy,created)
		VALUES (:url,:description,:idProjet,:createdBy,:created)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':url', $piecesProjet->url());
		$query->bindValue(':description', $piecesProjet->description());
		$query->bindValue(':idProjet', $piecesProjet->idProjet());
		$query->bindValue(':createdBy', $piecesProjet->createdBy());
		$query->bindValue(':created', $piecesProjet->created());
		$query->execute();
		$query->closeCursor();
	}

	public function update(PiecesProjet $piecesProjet){
    	$query = $this->_db->prepare(' UPDATE t_piecesProjet SET 
		url=:url,description=:description,idProjet=:idProjet,createdBy=:createdBy,created=:created
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $piecesProjet->id());
		$query->bindValue(':url', $piecesProjet->url());
		$query->bindValue(':description', $piecesProjet->description());
		$query->bindValue(':idProjet', $piecesProjet->idProjet());
		$query->bindValue(':createdBy', $piecesProjet->createdBy());
		$query->bindValue(':created', $piecesProjet->created());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_piecesProjet
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getPiecesProjetById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_piecesProjet
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new PiecesProjet($data);
	}

	public function getPiecesProjets(){
		$piecesProjets = array();
		$query = $this->_db->query('SELECT * FROM t_piecesProjet
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$piecesProjets[] = new PiecesProjet($data);
		}
		$query->closeCursor();
		return $piecesProjets;
	}
	public function getPiecesProjetsByLimits($begin, $end){
		$piecesProjets = array();
		$query = $this->_db->query('SELECT * FROM t_piecesProjet
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$piecesProjets[] = new PiecesProjet($data);
		}
		$query->closeCursor();
		return $piecesProjets;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_piecesProjet
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
	
	/////////////////////////////////////////////////////////////////////////////////////
	
	public function getPiecesProjetByIdProjet($idProjet){
		$piecesProjet = array();
		$query = $this->_db->prepare('SELECT * FROM t_piecesprojet WHERE idProjet=:idProjet');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();		
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$piecesProjet[] = new PiecesProjet($data);
		}
		$query->closeCursor();
		return $piecesProjet;
	}

}