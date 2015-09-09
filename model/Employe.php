<?php
class Employe{

	//attributes
	private $_id;
	private $_nom;
	private $_cin;
	private $_adresse;
	private $_telephone;
	private $_dateCreation;
	private $_created;
	private $_createdBy;

<<<<<<< HEAD
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

	public function setCin($cin){
		$this->_cin = $cin;
   	}

	public function setAdresse($adresse){
		$this->_adresse = $adresse;
   	}

	public function setTelephone($telephone){
		$this->_telephone = $telephone;
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

	public function cin(){
		return $this->_cin;
   	}

	public function adresse(){
		return $this->_adresse;
   	}

	public function telephone(){
		return $this->_telephone;
   	}

	public function dateCreation(){
		return $this->_dateCreation;
   	}

	public function created(){
		return $this->_created;
   	}

	public function createdBy(){
		return $this->_createdBy;
=======
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

	public function setCin($cin){
		$this->_cin = $cin;
   	}

	public function setAdresse($adresse){
		$this->_adresse = $adresse;
   	}

	public function setTelephone($telephone){
		$this->_telephone = $telephone;
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

	public function cin(){
		return $this->_cin;
   	}

	public function adresse(){
		return $this->_adresse;
   	}

	public function telephone(){
		return $this->_telephone;
   	}

	public function dateCreation(){
		return $this->_dateCreation;
   	}

	public function created(){
		return $this->_created;
   	}

	public function createdBy(){
		return $this->_createdBy;
>>>>>>> 32d8c2d0dbce6a6ed5c3ce01d84e1dca4c37cc04
   	}

}