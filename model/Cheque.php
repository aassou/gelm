<?php
class Cheque{

	//attributes
	private $_id;
	private $_dateCheque;
	private $_numero;
	private $_designationSociete;
	private $_designationPersonne;
	private $_montant;
	private $_statut;
	private $_url;
	private $_idProjet;
	private $_idSociete;
	private $_compteBancaire;
	private $_createdBy;
	private $_created;

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
	public function setDateCheque($dateCheque){
		$this->_dateCheque = $dateCheque;
   	}

	public function setNumero($numero){
		$this->_numero = $numero;
   	}

	public function setDesignationSociete($designationSociete){
		$this->_designationSociete = $designationSociete;
   	}

	public function setDesignationPersonne($designationPersonne){
		$this->_designationPersonne = $designationPersonne;
   	}

	public function setMontant($montant){
		$this->_montant = $montant;
   	}

	public function setStatut($statut){
		$this->_statut = $statut;
   	}

	public function setUrl($url){
		$this->_url = $url;
   	}

	public function setIdProjet($idProjet){
		$this->_idProjet = $idProjet;
   	}
	
	public function setIdSociete($idSociete){
		$this->_idSociete = $idSociete;
   	}
	
	public function setCompteBancaire($compteBancaire){
		$this->_compteBancaire = $compteBancaire;
   	}
	
	public function setCreatedBy($createdBy){
		$this->_createdBy = $createdBy;
   	}

	public function setCreated($created){
		$this->_created = $created;
   	}

	//getters
	public function id(){
    	return $this->_id;
    }
	public function dateCheque(){
		return $this->_dateCheque;
   	}

	public function numero(){
		return $this->_numero;
   	}

	public function designationSociete(){
		return $this->_designationSociete;
   	}

	public function designationPersonne(){
		return $this->_designationPersonne;
   	}

	public function montant(){
		return $this->_montant;
   	}

	public function statut(){
		return $this->_statut;
   	}

	public function url(){
		return $this->_url;
   	}

	public function idProjet(){
		return $this->_idProjet;
   	}
	
	public function idSociete(){
		return $this->_idSociete;
   	}
	
	public function compteBancaire(){
		return $this->_compteBancaire;
	}
	
	public function createdBy(){
		return $this->_createdBy;
   	}

	public function created(){
		return $this->_created;
   	}

}