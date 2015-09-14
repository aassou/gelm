<?php
class Caisse{

	//attributes
	private $_id;
	private $_nom;
	private $_dateCreation;
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
	public function setNom($nom){
		$this->_nom = $nom;
   	}

	public function setDateCreation($dateCreation){
		$this->_dateCreation = $dateCreation;
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
	public function nom(){
		return $this->_nom;
   	}

	public function dateCreation(){
		return $this->_dateCreation;
   	}

	public function created(){
		return $this->_created;
   	}

	public function createdBy(){
		return $this->_createdBy;
   	}

}