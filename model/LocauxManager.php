<?php
class LocauxManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Locaux $Locaux){
    	$query = $this->_db->prepare(' INSERT INTO t_locaux (
		numeroTitre, nom,superficie,surplan,facade,prix,mezzanine,status,idProjet,createdBy,created)
		VALUES (:numeroTitre,:nom,:superficie,:surplan,:facade,:prix,:mezzanine,:status,:idProjet,:createdBy,:created)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':numeroTitre', $Locaux->numeroTitre());
		$query->bindValue(':nom', $Locaux->nom());
		$query->bindValue(':superficie', $Locaux->superficie());
        $query->bindValue(':surplan', $Locaux->surplan());
		$query->bindValue(':facade', $Locaux->facade());
		$query->bindValue(':prix', $Locaux->prix());
		$query->bindValue(':mezzanine', $Locaux->mezzanine());
		$query->bindValue(':status', $Locaux->status());
		$query->bindValue(':idProjet', $Locaux->idProjet());
		$query->bindValue(':createdBy', $Locaux->createdBy());
		$query->bindValue(':created', $Locaux->created());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Locaux $Locaux){
    	$query = $this->_db->prepare(' UPDATE t_locaux SET 
		numeroTitre=:numeroTitre,nom=:nom,superficie=:superficie,surplan=:surplan,facade=:facade,prix=:prix,mezzanine=:mezzanine
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $Locaux->id());
		$query->bindValue(':numeroTitre', $Locaux->numeroTitre());
		$query->bindValue(':nom', $Locaux->nom());
		$query->bindValue(':superficie', $Locaux->superficie());
        $query->bindValue(':surplan', $Locaux->surplan());
		$query->bindValue(':facade', $Locaux->facade());
		$query->bindValue(':prix', $Locaux->prix());
		$query->bindValue(':mezzanine', $Locaux->mezzanine());
		$query->execute();
		$query->closeCursor();
	}

	public function updateStatus($status, $id){
		$query = $this->_db->prepare(' UPDATE t_locaux SET status=:status WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->bindValue(':status', $status);
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_locaux
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getNumberBienByIdProjet($idProjet){
    	$query = $this->_db->prepare(' SELECT COUNT(*) AS nombre FROM t_locaux WHERE idProjet=:idProjet')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$nombre = $data['nombre']; 
		$query->closeCursor();
		return $nombre;
	}
	
	public function getNumberBienDisbonibleByIdProjet($idProjet){
    	$query = $this->_db->prepare(' SELECT COUNT(*) AS nombre FROM t_locaux WHERE idProjet=:idProjet AND status="Disponible" ')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$nombre = $data['nombre']; 
		$query->closeCursor();
		return $nombre;
	}
	
	public function getNumberBienVenduByIdProjet($idProjet){
    	$query = $this->_db->prepare(' SELECT COUNT(*) AS nombre FROM t_locaux WHERE idProjet=:idProjet AND status="Vendu" ')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$nombre = $data['nombre']; 
		$query->closeCursor();
		return $nombre;
	}
	
	public function getNumberBienPromesseVenteByIdProjet($idProjet){
    	$query = $this->_db->prepare(' SELECT COUNT(*) AS nombre FROM t_locaux WHERE idProjet=:idProjet AND status="Promesse de Vente" ')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$nombre = $data['nombre']; 
		$query->closeCursor();
		return $nombre;
	}

	public function getLocauxById($id){
    	$query = $this->_db->prepare('SELECT * FROM t_locaux WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Locaux($data);
	}

	public function getLocauxs(){
		$Locaux = array();
		$query = $this->_db->query('SELECT * FROM t_locaux
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$Locaux[] = new Locaux($data);
		}
		$query->closeCursor();
		return $Locaux;
	}

	public function getLocauxByIdProjet($idProjet){
		$locaux = array();
		$query = $this->_db->prepare('SELECT * FROM t_locaux WHERE idProjet=:idProjet ORDER BY status ASC');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$locaux[] = new Locaux($data);
		}
		$query->closeCursor();
		return $locaux;
	}

	public function getLocauxsByLimits($begin, $end){
		$Locaux = array();
		$query = $this->_db->query('SELECT * FROM t_locaux
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$Locaux[] = new Locaux($data);
		}
		$query->closeCursor();
		return $Locaux;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_locaux
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
    
    public function getTotalPrixLocauxByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT SUM(prix) AS prixTotal FROM t_locaux WHERE idProjet=:idProjet')
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['prixTotal'];
    }
    
    //////////////////////////////////////////////////////////////////////////////////////////////
    
    public function getLocauxNonVendu(){
        $locaux = array();
        $query = $this->_db->query(
        "SELECT * FROM t_locaux WHERE status='Disponible' ORDER BY id ASC")
        or die(print_r($this->_db->errorInfo()));
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $locaux[] = new Locaux($data);
        }
        $query->closeCursor();
        return $locaux;
    }

}