<?php
class Societe{

	//attributes
	private $_id;
	private $_raisonSociale;
	private $_dateCreation;
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
	public function setRaisonSociale($raisonSociale){
		$this->_raisonSociale = $raisonSociale;
   	}

	public function setDateCreation($dateCreation){
		$this->_dateCreation = $dateCreation;
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
	public function raisonSociale(){
		return $this->_raisonSociale;
   	}

	public function dateCreation(){
		return $this->_dateCreation;
   	}

	public function createdBy(){
		return $this->_createdBy;
   	}

	public function created(){
		return $this->_created;
   	}

}