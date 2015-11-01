<?php
class Locaux{

	//attributes
	private $_id;
	private $_numeroTitre;
	private $_nom;
	private $_superficie;
    private $_surplan;
	private $_facade;
	private $_prix;
	private $_mezzanine;
	private $_status;
	private $_idProjet;
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
	
	public function setNumeroTitre($numeroTitre){
    	$this->_numeroTitre = $numeroTitre;
    }
	
	public function setNom($nom){
		$this->_nom = $nom;
   	}

	public function setSuperficie($superficie){
		$this->_superficie = $superficie;
   	}
    
    public function setSurplan($surplan){
        $this->_surplan = $surplan;
    }

	public function setFacade($facade){
		$this->_facade = $facade;
   	}

	public function setPrix($prix){
		$this->_prix = $prix;
   	}

	public function setMezzanine($mezzanine){
		$this->_mezzanine = $mezzanine;
   	}

	public function setStatus($status){
		$this->_status = $status;
   	}

	public function setIdProjet($idProjet){
		$this->_idProjet = $idProjet;
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
	
	public function numeroTitre(){
    	return $this->_numeroTitre;
    }
	
	public function nom(){
		return $this->_nom;
   	}

	public function superficie(){
		return $this->_superficie;
   	}
    
    public function surplan(){
        return $this->_surplan;
    }

	public function facade(){
		return $this->_facade;
   	}

	public function prix(){
		return $this->_prix;
   	}

	public function mezzanine(){
		return $this->_mezzanine;
   	}

	public function status(){
		return $this->_status;
   	}

	public function idProjet(){
		return $this->_idProjet;
   	}

	public function createdBy(){
		return $this->_createdBy;
   	}

	public function created(){
		return $this->_created;
   	}

}