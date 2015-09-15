<?php
class CaisseDetailsManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(CaisseDetails $caisseDetails){
    	$query = $this->_db->prepare(' INSERT INTO t_caisseDetails (
		dateOperation,personne,designation,projet,type,montant,commentaire,idCaisse,created,createdBy)
		VALUES (:dateOperation,:personne,:designation,:projet,:type,:montant,:commentaire,:idCaisse,:created,:createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':dateOperation', $caisseDetails->dateOperation());
		$query->bindValue(':personne', $caisseDetails->personne());
		$query->bindValue(':designation', $caisseDetails->designation());
		$query->bindValue(':projet', $caisseDetails->projet());
		$query->bindValue(':type', $caisseDetails->type());
		$query->bindValue(':montant', $caisseDetails->montant());
		$query->bindValue(':commentaire', $caisseDetails->commentaire());
        $query->bindValue(':idCaisse', $caisseDetails->idCaisse());
		$query->bindValue(':created', $caisseDetails->created());
		$query->bindValue(':createdBy', $caisseDetails->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(CaisseDetails $caisseDetails){
    	$query = $this->_db->prepare(' UPDATE t_caisseDetails SET 
		dateOperation=:dateOperation,personne=:personne,designation=:designation,projet=:projet,type=:type,
		montant=:montant,commentaire=:commentaire WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $caisseDetails->id());
		$query->bindValue(':dateOperation', $caisseDetails->dateOperation());
		$query->bindValue(':personne', $caisseDetails->personne());
		$query->bindValue(':designation', $caisseDetails->designation());
		$query->bindValue(':projet', $caisseDetails->projet());
		$query->bindValue(':type', $caisseDetails->type());
		$query->bindValue(':montant', $caisseDetails->montant());
		$query->bindValue(':commentaire', $caisseDetails->commentaire());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_caisseDetails
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getCaisseDetailsById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_caisseDetails
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new CaisseDetails($data);
	}

	public function getCaisseDetails(){
		$caisseDetailss = array();
		$query = $this->_db->query('SELECT * FROM t_caisseDetails
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$caisseDetailss[] = new CaisseDetails($data);
		}
		$query->closeCursor();
		return $caisseDetailss;
	}
    
    public function getCaisseDetailsByIdCaisse($idCaisse){
        $caisseDetails = array();
        $query = $this->_db->prepare('SELECT * FROM t_caisseDetails WHERE idCaisse=:idCaisse ORDER BY id DESC');
        $query->bindValue(':idCaisse', $idCaisse);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $caisseDetails[] = new CaisseDetails($data);
        }
        $query->closeCursor();
        return $caisseDetails;
    }

    public function getCaisseDetailsByIdCaisseByDate($idCaisse, $from, $to){
        $caisseDetails = array();
        $query = $this->_db->prepare('SELECT * FROM t_caisseDetails WHERE idCaisse=:idCaisse
        AND (dateOperation BETWEEN :from AND :to) ORDER BY id DESC');
        $query->bindValue(':idCaisse', $idCaisse);
        $query->bindValue(':from', $from);
        $query->bindValue(':to', $to);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $caisseDetails[] = new CaisseDetails($data);
        }
        $query->closeCursor();
        return $caisseDetails;
    }
    
	public function getCaisseDetailsByLimits($begin, $end){
		$caisseDetailss = array();
		$query = $this->_db->query('SELECT * FROM t_caisseDetails
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$caisseDetailss[] = new CaisseDetails($data);
		}
		$query->closeCursor();
		return $caisseDetailss;
	}
    
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_caisseDetails
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}