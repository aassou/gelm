<?php
class PiecesSociete{

	//attributes
	private $_id;
	private $_url;
	private $_description;
	private $_idSociete;
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
	public function setUrl($url){
		$this->_url = $url;
   	}

	public function setDescription($description){
		$this->_description = $description;
   	}

	public function setIdSociete($idSociete){
		$this->_idSociete = $idSociete;
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
	public function url(){
		return $this->_url;
   	}

	public function description(){
		return $this->_description;
   	}

	public function idSociete(){
		return $this->_idSociete;
   	}

	public function createdBy(){
		return $this->_createdBy;
   	}

	public function created(){
		return $this->_created;
   	}

}