<?php
class Projet{

	//attributes
	private $_id;
	private $_nom;
	private $_numeroTitre;
	private $_emplacement;
	private $_superficie;
	private $_description;
	private $_dateCreation;
	private $_createdBy;
	private $_created;
	private $_idSociete;

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

	public function setNumeroTitre($numeroTitre){
		$this->_numeroTitre = $numeroTitre;
   	}

	public function setEmplacement($emplacement){
		$this->_emplacement = $emplacement;
   	}

	public function setSuperficie($superficie){
		$this->_superficie = $superficie;
   	}

	public function setDescription($description){
		$this->_description = $description;
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
	
	public function setIdSociete($idSociete){
    	$this->_idSociete = $idSociete;
    }

	//getters
	public function id(){
    	return $this->_id;
    }
	public function nom(){
		return $this->_nom;
   	}

	public function numeroTitre(){
		return $this->_numeroTitre;
   	}

	public function emplacement(){
		return $this->_emplacement;
   	}

	public function superficie(){
		return $this->_superficie;
   	}

	public function description(){
		return $this->_description;
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
	
	public function idSociete(){
    	return $this->_idSociete;
    }

}