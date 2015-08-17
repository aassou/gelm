<?php
class MaisonManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Maison $maison){
    	$query = $this->_db->prepare(' INSERT INTO t_maison (
		numeroTitre,nom,superficie,prix,emplacement,status,nombreEtage,idProjet,created,createdBy)
		VALUES (:numeroTitre,:nom,:superficie,:prix,:emplacement,:status,:nombreEtage,:idProjet,:created,:createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':numeroTitre', $maison->numeroTitre());
		$query->bindValue(':nom', $maison->nom());
		$query->bindValue(':superficie', $maison->superficie());
		$query->bindValue(':prix', $maison->prix());
		$query->bindValue(':emplacement', $maison->emplacement());
		$query->bindValue(':status', $maison->status());
		$query->bindValue(':nombreEtage', $maison->nombreEtage());
		$query->bindValue(':idProjet', $maison->idProjet());
		$query->bindValue(':created', $maison->created());
		$query->bindValue(':createdBy', $maison->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Maison $maison){
    	$query = $this->_db->prepare(' UPDATE t_maison SET 
		numeroTitre=:numeroTitre,nom=:nom,superficie=:superficie,prix=:prix,emplacement=:emplacement,nombreEtage=:nombreEtage
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $maison->id());
		$query->bindValue(':numeroTitre', $maison->numeroTitre());
		$query->bindValue(':nom', $maison->nom());
		$query->bindValue(':superficie', $maison->superficie());
		$query->bindValue(':prix', $maison->prix());
		$query->bindValue(':emplacement', $maison->emplacement());
		$query->bindValue(':nombreEtage', $maison->nombreEtage());
		$query->execute();
		$query->closeCursor();
	}
	
	public function updateStatus($status, $id){
		$query = $this->_db->prepare(' UPDATE t_maison SET status=:status WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->bindValue(':status', $status);
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_maison WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getMaisonById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_maison
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Maison($data);
	}

	public function getMaisons(){
		$maisons = array();
		$query = $this->_db->query('SELECT * FROM t_maison
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$maisons[] = new Maison($data);
		}
		$query->closeCursor();
		return $maisons;
	}
	
	public function getMaisonsByIdProjet($idProjet){
		$maisons = array();
		$query = $this->_db->prepare('SELECT * FROM t_maison WHERE idProjet=:idProjet ORDER BY id DESC');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$maisons[] = new Maison($data);
		}
		$query->closeCursor();
		return $maisons;
	}
	
	public function getMaisonsByLimits($begin, $end){
		$maisons = array();
		$query = $this->_db->query('SELECT * FROM t_maison
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$maisons[] = new Maison($data);
		}
		$query->closeCursor();
		return $maisons;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_maison
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}