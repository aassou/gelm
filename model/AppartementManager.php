<?php
class AppartementManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Appartement $appartement){
    	$query = $this->_db->prepare(' INSERT INTO t_appartement (
		numeroTitre,nom,superficie,surplan,prix,niveau,facade,nombrePiece,status,cave,idProjet,created,createdBy)
		VALUES (:numeroTitre,:nom,:superficie,:surplan,:prix,:niveau,:facade,:nombrePiece,:status,:cave,:idProjet,:created,:createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':numeroTitre', $appartement->numeroTitre());
		$query->bindValue(':nom', $appartement->nom());
		$query->bindValue(':superficie', $appartement->superficie());
        $query->bindValue(':surplan', $appartement->surplan());
		$query->bindValue(':prix', $appartement->prix());
		$query->bindValue(':niveau', $appartement->niveau());
		$query->bindValue(':facade', $appartement->facade());
		$query->bindValue(':nombrePiece', $appartement->nombrePiece());
		$query->bindValue(':status', $appartement->status());
		$query->bindValue(':cave', $appartement->cave());
		$query->bindValue(':idProjet', $appartement->idProjet());
		$query->bindValue(':created', $appartement->created());
		$query->bindValue(':createdBy', $appartement->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Appartement $appartement){
    	$query = $this->_db->prepare(' UPDATE t_appartement SET 
		numeroTitre=:numeroTitre,nom=:nom,superficie=:superficie,surplan=:surplan,prix=:prix,
		niveau=:niveau,facade=:facade,nombrePiece=:nombrePiece,cave=:cave WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $appartement->id());
		$query->bindValue(':numeroTitre', $appartement->numeroTitre());
		$query->bindValue(':nom', $appartement->nom());
		$query->bindValue(':superficie', $appartement->superficie());
        $query->bindValue(':surplan', $appartement->surplan());
		$query->bindValue(':prix', $appartement->prix());
		$query->bindValue(':niveau', $appartement->niveau());
		$query->bindValue(':facade', $appartement->facade());
		$query->bindValue(':nombrePiece', $appartement->nombrePiece());
		$query->bindValue(':cave', $appartement->cave());
		$query->execute();
		$query->closeCursor();
	}
	
	public function updateStatus($status, $id){
		$query = $this->_db->prepare(' UPDATE t_appartement SET status=:status WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->bindValue(':status', $status);
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_appartement WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getAppartementById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_appartement
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Appartement($data);
	}
	
	public function getNumberAppartementByIdProjet($idProjet){
    	$query = $this->_db->prepare(' SELECT COUNT(*) AS nombreAppartement FROM t_appartement WHERE idProjet=:idProjet')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$nombreAppartement = $data['nombreAppartement']; 
		$query->closeCursor();
		return $nombreAppartement;
	}
	
	public function getNumberBienByIdProjet($idProjet){
    	$query = $this->_db->prepare(' SELECT COUNT(*) AS nombre FROM t_appartement WHERE idProjet=:idProjet')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$nombre = $data['nombre']; 
		$query->closeCursor();
		return $nombre;
	}
	
	public function getNumberBienDisbonibleByIdProjet($idProjet){
    	$query = $this->_db->prepare(' SELECT COUNT(*) AS nombre FROM t_appartement WHERE idProjet=:idProjet AND status="Disponible" ')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$nombre = $data['nombre']; 
		$query->closeCursor();
		return $nombre;
	}
    
    public function getNumberBiens(){
        $query = $this->_db->query(' SELECT COUNT(*) AS nombre FROM t_appartement')
        or die (print_r($this->_db->errorInfo()));
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $nombre = $data['nombre']; 
        $query->closeCursor();
        return $nombre;
    }
    
    public function getNumberBienDisbonible(){
        $query = $this->_db->query(' SELECT COUNT(*) AS nombre FROM t_appartement WHERE status="Disponible" ')
        or die (print_r($this->_db->errorInfo()));
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $nombre = $data['nombre']; 
        $query->closeCursor();
        return $nombre;
    }
    
    public function getNumberBienVendu(){
        $query = $this->_db->query(' SELECT COUNT(*) AS nombre FROM t_appartement WHERE status="Vendu" ')
        or die (print_r($this->_db->errorInfo()));
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $nombre = $data['nombre']; 
        $query->closeCursor();
        return $nombre;
    }

    public function getNumberBienPromesseVente(){
        $query = $this->_db->query(' SELECT COUNT(*) AS nombre FROM t_appartement WHERE status="Promesse de Vente" ')
        or die (print_r($this->_db->errorInfo()));
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $nombre = $data['nombre']; 
        $query->closeCursor();
        return $nombre;
    }
	
	public function getNumberBienVenduByIdProjet($idProjet){
    	$query = $this->_db->prepare(' SELECT COUNT(*) AS nombre FROM t_appartement WHERE idProjet=:idProjet AND status="Vendu" ')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$nombre = $data['nombre']; 
		$query->closeCursor();
		return $nombre;
	}
	
	public function getNumberBienPromesseVenteByIdProjet($idProjet){
    	$query = $this->_db->prepare(' SELECT COUNT(*) AS nombre FROM t_appartement WHERE idProjet=:idProjet AND status="Promesse de Vente" ')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$nombre = $data['nombre']; 
		$query->closeCursor();
		return $nombre;
	}

	public function getAppartements(){
		$appartements = array();
		$query = $this->_db->query('SELECT * FROM t_appartement
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$appartements[] = new Appartement($data);
		}
		$query->closeCursor();
		return $appartements;
	}

	public function getAppartementsByIdProjet($idProjet){
		$appartements = array();
		$query = $this->_db->prepare('SELECT * FROM t_appartement
		WHERE idProjet=:idProjet ORDER BY status ASC');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$appartements[] = new Appartement($data);
		}
		$query->closeCursor();
		return $appartements;
	}

	public function getAppartementsByLimits($begin, $end){
		$appartements = array();
		$query = $this->_db->query('SELECT * FROM t_appartement
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$appartements[] = new Appartement($data);
		}
		$query->closeCursor();
		return $appartements;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_appartement
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
    
    public function getTotalPrixAppartementsByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT SUM(prix) AS prixTotal FROM t_appartement WHERE idProjet=:idProjet')
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['prixTotal'];
    }
    
    //////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function getAppartementsNonVendu(){
        $appartements = array();
        $query = $this->_db->query(
        "SELECT * FROM t_appartement WHERE status='Disponible' ORDER BY status ASC, niveau ASC, idProjet ASC, niveau ASC")
        or die(print_r($this->_db->errorInfo()));
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $appartements[] = new Appartement($data);
        }
        $query->closeCursor();
        return $appartements;
    }

}