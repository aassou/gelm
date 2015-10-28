<?php
class ProjetManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Projet $projet){
    	$query = $this->_db->prepare(' INSERT INTO t_projet (
		nom,numeroTitre,emplacement,superficie,description,dateCreation,status,createdBy,created, idSociete)
		VALUES (:nom,:numeroTitre,:emplacement,:superficie,:description,
		:dateCreation,:status,:createdBy,:created, :idSociete)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $projet->nom());
		$query->bindValue(':numeroTitre', $projet->numeroTitre());
		$query->bindValue(':emplacement', $projet->emplacement());
		$query->bindValue(':superficie', $projet->superficie());
		$query->bindValue(':description', $projet->description());
		$query->bindValue(':dateCreation', $projet->dateCreation());
		$query->bindValue(':status', $projet->status());
		$query->bindValue(':createdBy', $projet->createdBy());
		$query->bindValue(':created', $projet->created());
		$query->bindValue(':idSociete', $projet->idSociete());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Projet $projet){
    	$query = $this->_db->prepare(' UPDATE t_projet SET 
		nom=:nom,numeroTitre=:numeroTitre,emplacement=:emplacement,
		superficie=:superficie, description=:description,dateCreation=:dateCreation,
		createdBy=:createdBy,created=:created, idSociete=:idSociete
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $projet->id());
		$query->bindValue(':nom', $projet->nom());
		$query->bindValue(':numeroTitre', $projet->numeroTitre());
		$query->bindValue(':emplacement', $projet->emplacement());
		$query->bindValue(':superficie', $projet->superficie());
		$query->bindValue(':description', $projet->description());
		$query->bindValue(':dateCreation', $projet->dateCreation());
		$query->bindValue(':createdBy', $projet->createdBy());
		$query->bindValue(':created', $projet->created());
		$query->bindValue(':idSociete', $projet->idSociete());
		$query->execute();
		$query->closeCursor();
	}
	
	public function updateStatus($idProjet, $status){
    	$query = $this->_db->prepare('UPDATE t_projet SET status=:status WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $idProjet);
		$query->bindValue(':status', $status);
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_projet
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getProjetById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_projet
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Projet($data);
	}

	public function getProjets(){
		$projets = array();
		$query = $this->_db->query('SELECT * FROM t_projet ORDER BY status ASC, id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$projets[] = new Projet($data);
		}
		$query->closeCursor();
		return $projets;
	}

	public function getProjetsByLimits($begin, $end){
		$projets = array();
		$query = $this->_db->query('SELECT * FROM t_projet
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$projets[] = new Projet($data);
		}
		$query->closeCursor();
		return $projets;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_projet
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////
	
	public function getProjetsByIdSociete($idSociete){
		$projets = array();
		$query = $this->_db->prepare('SELECT * FROM t_projet WHERE idSociete=:idSociete 
		ORDER BY status ASC, id DESC');
		$query->bindValue(':idSociete', $idSociete);
		$query->execute();	
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$projets[] = new Projet($data);
		}
		$query->closeCursor();
		return $projets;
	}
	
	public function getProjetsByIdSocieteByLimits($idSociete, $begin, $end){
		$projets = array();
		$query = $this->_db->prepare('SELECT * FROM t_projet WHERE idSociete=:idSociete
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		$query->bindValue(':idSociete', $idSociete);
		$query->execute();	
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$projets[] = new Projet($data);
		}
		$query->closeCursor();
		return $projets;
	}
	
	public function getProjetsNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS projectNumbers FROM t_projet');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['projectNumbers'];
    }
    
    public function getProjetsNumberByIdSociete($idSociete){
        $query = $this->_db->prepare('SELECT COUNT(*) AS projectNumbers FROM t_projet WHERE idSociete=:idSociete');
        $query->bindValue(':idSociete', $idSociete);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['projectNumbers'];
    }
	
	public function exists($nomProjet){
        $query = $this->_db->prepare(" SELECT COUNT(*) FROM t_projet WHERE REPLACE(nom, ' ', '') LIKE REPLACE(:nomProjet, ' ', '') ");
        $query->execute(array(':nomProjet' => $nomProjet));
        //get result
        return $query->fetchColumn();
    }
}