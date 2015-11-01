<?php
class Terrain{

	//attributes
	private $_id;
	private $_numeroTitre;
	private $_nom;
	private $_superficie;
    private $_surplan;
	private $_emplacement;
	private $_prix;
	private $_status;
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

	public function setEmplacement($emplacement){
		$this->_emplacement = $emplacement;
   	}

	public function setPrix($prix){
		$this->_prix = $prix;
   	}
	
	public function setStatus($status){
		$this->_status = $status;
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

	public function emplacement(){
		return $this->_emplacement;
   	}

	public function prix(){
		return $this->_prix;
   	}
	
	public function status(){
		return $this->_status;
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