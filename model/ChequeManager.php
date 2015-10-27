<?php
class ChequeManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Cheque $cheque){
    	$query = $this->_db->prepare(' INSERT INTO t_cheque (
		dateCheque,numero,designationSociete,designationPersonne,montant,statut,url,
		idProjet, idSociete, compteBancaire, createdBy, created)
		VALUES (:dateCheque, :numero, :designationSociete, :designationPersonne, 
		:montant, :statut, :url, :idProjet, :idSociete, :compteBancaire, :createdBy, :created)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':dateCheque', $cheque->dateCheque());
		$query->bindValue(':numero', $cheque->numero());
		$query->bindValue(':designationSociete', $cheque->designationSociete());
		$query->bindValue(':designationPersonne', $cheque->designationPersonne());
		$query->bindValue(':montant', $cheque->montant());
		$query->bindValue(':statut', $cheque->statut());
		$query->bindValue(':url', $cheque->url());
		$query->bindValue(':idProjet', $cheque->idProjet());
		$query->bindValue(':idSociete', $cheque->idSociete());
		$query->bindValue(':compteBancaire', $cheque->compteBancaire());
		$query->bindValue(':createdBy', $cheque->createdBy());
		$query->bindValue(':created', $cheque->created());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Cheque $cheque){
    	$query = $this->_db->prepare(' UPDATE t_cheque SET 
		dateCheque=:dateCheque,numero=:numero,designationSociete=:designationSociete,designationPersonne=:designationPersonne,montant=:montant,statut=:statut,idProjet=:idProjet
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $cheque->id());
		$query->bindValue(':dateCheque', $cheque->dateCheque());
		$query->bindValue(':numero', $cheque->numero());
		$query->bindValue(':designationSociete', $cheque->designationSociete());
		$query->bindValue(':designationPersonne', $cheque->designationPersonne());
		$query->bindValue(':montant', $cheque->montant());
		$query->bindValue(':statut', $cheque->statut());
		//$query->bindValue(':url', $cheque->url());
		$query->bindValue(':idProjet', $cheque->idProjet());
		$query->execute();
		$query->closeCursor();
	}
	
	public function updateCopieCheque($url, $idCheque){
    	$query = $this->_db->prepare(' UPDATE t_cheque SET url=:url
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $idCheque);
		$query->bindValue(':url', $url);
		$query->execute();
		$query->closeCursor();
	}

	public function updateStatut($idCheque, $statut){
    	$query = $this->_db->prepare(' UPDATE t_cheque SET statut=:statut
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $idCheque);
		$query->bindValue(':statut', $statut);
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_cheque
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getChequeById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_cheque
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Cheque($data);
	}

	public function getCheques(){
		$cheques = array();
		$query = $this->_db->query('SELECT * FROM t_cheque
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$cheques[] = new Cheque($data);
		}
		$query->closeCursor();
		return $cheques;
	}
	public function getChequesByLimits($begin, $end){
		$cheques = array();
		$query = $this->_db->query('SELECT * FROM t_cheque
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$cheques[] = new Cheque($data);
		}
		$query->closeCursor();
		return $cheques;
	}
	
	public function getChequesBySociete($idSociete){
		$cheques = array();
		$query = $this->_db->prepare('SELECT * FROM t_cheque WHERE idSociete=:idSociete
		ORDER BY id DESC');
		$query->bindValue(':idSociete', $idSociete);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$cheques[] = new Cheque($data);
		}
		$query->closeCursor();
		return $cheques;
	}
	
	public function getChequesBySocieteByDesignation($idSociete, $designation){
		$cheques = array();
		$query = $this->_db->prepare('SELECT * FROM t_cheque WHERE idSociete=:idSociete 
		AND idProjet=:idProjet ORDER BY id DESC');
		$query->bindValue(':idSociete', $idSociete);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$cheques[] = new Cheque($data);
		}
		$query->closeCursor();
		return $cheques;
	}
	
	public function getChequesBySocieteByProjet($idSociete, $idProjet){
		$cheques = array();
		$query = $this->_db->prepare('SELECT * FROM t_cheque WHERE idSociete=:idSociete 
		AND idProjet=:idProjet ORDER BY id DESC');
		$query->bindValue(':idSociete', $idSociete);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$cheques[] = new Cheque($data);
		}
		$query->closeCursor();
		return $cheques;
	}
	
	public function getChequesBySocieteByLimits($idSociete, $begin, $end){
		$cheques = array();
		$query = $this->_db->prepare('SELECT * FROM t_cheque WHERE idSociete=:idSociete
		ORDER BY dateCheque DESC LIMIT '.$begin.', '.$end);
		$query->bindValue(':idSociete', $idSociete);
		$query->execute();
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$cheques[] = new Cheque($data);
		}
		$query->closeCursor();
		return $cheques;
	}
	
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_cheque
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

	////////////////////////////////////////////////////////////////////////////////////
	
	public function getChequeNumbers(){
        $query = $this->_db->query('SELECT COUNT(*) AS chequeNumbers FROM t_cheque');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['chequeNumbers'];
    }

}