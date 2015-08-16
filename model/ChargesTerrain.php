<?php
class ChargesTerrain{

	//attributes
	private $_id;
	private $_dateOperation;
	private $_designation;
	private $_beneficiaire;
	private $_numeroCheque;
	private $_montant;
	private $_idProjet;
	private $_created;
	private $_createdBy;

	//le constructeur
    public function __construct($data){
        $this->hydrate($data);
    }
    
    //la focntion hydrate sert à attribuer les valeurs en utilisant les setters d\'une façon dynamique!
    public function hydrate($data){
        foreach ($data as $key => $value){
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

	//setters
	public function setId($id){
    	$this->_id = $id;
    }
	public function setDateOperation($dateOperation){
		$this->_dateOperation = $dateOperation;
   	}

	public function setDesignation($designation){
		$this->_designation = $designation;
   	}

	public function setBeneficiaire($beneficiaire){
		$this->_beneficiaire = $beneficiaire;
   	}

	public function setNumeroCheque($numeroCheque){
		$this->_numeroCheque = $numeroCheque;
   	}

	public function setMontant($montant){
		$this->_montant = $montant;
   	}

	public function setIdProjet($idProjet){
		$this->_idProjet = $idProjet;
   	}

	public function setCreated($created){
		$this->_created = $created;
   	}

	public function setCreatedBy($createdBy){
		$this->_createdBy = $createdBy;
   	}

	//getters
	public function id(){
    	return $this->_id;
    }
	public function dateOperation(){
		return $this->_dateOperation;
   	}

	public function designation(){
		return $this->_designation;
   	}

	public function beneficiaire(){
		return $this->_beneficiaire;
   	}

	public function numeroCheque(){
		return $this->_numeroCheque;
   	}

	public function montant(){
		return $this->_montant;
   	}

	public function idProjet(){
		return $this->_idProjet;
   	}

	public function created(){
		return $this->_created;
   	}

	public function createdBy(){
		return $this->_createdBy;
   	}

}