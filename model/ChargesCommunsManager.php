<?php
class ChargesCommunsManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(ChargesCommuns $chargesCommuns){
    	$query = $this->_db->prepare(
    	'INSERT INTO t_chargescommuns (
		dateOperation, designation, beneficiaire, numeroCheque, montant, idSociete, idProjet, created, createdBy)
		VALUES (:dateOperation, :designation, :beneficiaire, :numeroCheque, :montant, :idSociete, :idProjet, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':dateOperation', $chargesCommuns->dateOperation());
		$query->bindValue(':designation', $chargesCommuns->designation());
		$query->bindValue(':beneficiaire', $chargesCommuns->beneficiaire());
		$query->bindValue(':numeroCheque', $chargesCommuns->numeroCheque());
		$query->bindValue(':montant', $chargesCommuns->montant());
		$query->bindValue(':idSociete', $chargesCommuns->idSociete());
		$query->bindValue(':idProjet', $chargesCommuns->idProjet());
		$query->bindValue(':created', $chargesCommuns->created());
		$query->bindValue(':createdBy', $chargesCommuns->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(ChargesCommuns $chargesCommuns){
    	$query = $this->_db->prepare(' UPDATE t_chargescommuns SET 
		dateOperation=:dateOperation, designation=:designation, beneficiaire=:beneficiaire, numeroCheque=:numeroCheque, montant=:montant, idProjet=:idProjet, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $chargesCommuns->id());
		$query->bindValue(':dateOperation', $chargesCommuns->dateOperation());
		$query->bindValue(':designation', $chargesCommuns->designation());
		$query->bindValue(':beneficiaire', $chargesCommuns->beneficiaire());
		$query->bindValue(':numeroCheque', $chargesCommuns->numeroCheque());
		$query->bindValue(':montant', $chargesCommuns->montant());
		$query->bindValue(':idProjet', $chargesCommuns->idProjet());
		$query->bindValue(':updated', $chargesCommuns->updated());
		$query->bindValue(':updatedBy', $chargesCommuns->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_chargescommuns
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getChargesCommunsById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_chargescommuns
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new ChargesCommuns($data);
	}

	public function getChargesCommuns(){
		$chargesCommuns = array();
		$query = $this->_db->query('SELECT * FROM t_chargescommuns
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$chargesCommuns[] = new ChargesCommuns($data);
		}
		$query->closeCursor();
		return $chargesCommuns;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_chargescommuns
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
		$id = $data['last_id'];
		return $id;
	}
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    
    public function getChargesCommunsBySociete($idSociete){
        $chargesCommuns = array();
        $query = $this->_db->prepare(
        'SELECT * FROM t_chargescommuns
        WHERE idSociete=:idSociete
        ');
        $query->bindValue(':idSociete', $idSociete);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $chargesCommuns[] = new ChargesCommuns($data);
        }
        $query->closeCursor();
        return $chargesCommuns;
    }
    
    public function getTotalByIdSociete($idSociete) {
        $query = $this->_db->prepare(
        'SELECT SUM(montant) AS total 
        FROM t_chargescommuns
        WHERE idSociete=:idSociete');
        $query->bindValue(':idSociete', $idSociete);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
    
    public function getChargesCommunsByDatesByIdSociete($idSociete, $dateFrom, $dateTo) {
        $chargesCommuns = array();
        $query = $this->_db->prepare('SELECT * FROM t_chargescommuns WHERE idSociete=:idSociete
        AND dateOperation BETWEEN :dateFrom AND :dateTo ORDER BY dateOperation ASC');
        $query->bindValue(':idSociete', $idSociete);
        $query->bindValue(':dateFrom', $dateFrom);
        $query->bindValue(':dateTo', $dateTo);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $chargesCommuns[] = new ChargesCommuns($data);
        }
        $query->closeCursor();
        return $chargesCommuns;
    }   

}