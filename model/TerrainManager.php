<?php
class TerrainManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Terrain $terrain){
    	$query = $this->_db->prepare(' INSERT INTO t_terrain (
		numeroTitre,nom,superficie,surplan,emplacement,prix, status, idProjet,created,createdBy)
		VALUES (:numeroTitre,:nom,:superficie,:surplan,:emplacement,:prix, :status,:idProjet,:created,:createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':numeroTitre', $terrain->numeroTitre());
		$query->bindValue(':nom', $terrain->nom());
		$query->bindValue(':superficie', $terrain->superficie());
        $query->bindValue(':surplan', $terrain->surplan());
		$query->bindValue(':emplacement', $terrain->emplacement());
		$query->bindValue(':prix', $terrain->prix());
		$query->bindValue(':status', $terrain->status());
		$query->bindValue(':idProjet', $terrain->idProjet());
		$query->bindValue(':created', $terrain->created());
		$query->bindValue(':createdBy', $terrain->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Terrain $terrain){
    	$query = $this->_db->prepare(' UPDATE t_terrain SET 
		numeroTitre=:numeroTitre,nom=:nom,superficie=:superficie,surplan=:surplan,emplacement=:emplacement,prix=:prix
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $terrain->id());
		$query->bindValue(':numeroTitre', $terrain->numeroTitre());
		$query->bindValue(':nom', $terrain->nom());
		$query->bindValue(':superficie', $terrain->superficie());
        $query->bindValue(':surplan', $terrain->surplan());
		$query->bindValue(':emplacement', $terrain->emplacement());
		$query->bindValue(':prix', $terrain->prix());
		$query->execute();
		$query->closeCursor();
	}

	public function updateStatus($status, $id){
		$query = $this->_db->prepare(' UPDATE t_terrain SET status=:status WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->bindValue(':status', $status);
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_terrain WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getNumberBienByIdProjet($idProjet){
    	$query = $this->_db->prepare(' SELECT COUNT(*) AS nombre FROM t_terrain WHERE idProjet=:idProjet')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$nombre = $data['nombre']; 
		$query->closeCursor();
		return $nombre;
	}

	public function getTerrainById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_terrain
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Terrain($data);
	}

	public function getTerrains(){
		$terrains = array();
		$query = $this->_db->query('SELECT * FROM t_terrain
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$terrains[] = new Terrain($data);
		}
		$query->closeCursor();
		return $terrains;
	}
	
	public function getTerrainsByIdProjet($idProjet){
		$terrains = array();
		$query = $this->_db->prepare('SELECT * FROM t_terrain WHERE idProjet=:idProjet ORDER BY status ASC');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$terrains[] = new Terrain($data);
		}
		$query->closeCursor();
		return $terrains;
	}
	
	public function getTerrainsByLimits($begin, $end){
		$terrains = array();
		$query = $this->_db->query('SELECT * FROM t_terrain
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$terrains[] = new Terrain($data);
		}
		$query->closeCursor();
		return $terrains;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_terrain
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}