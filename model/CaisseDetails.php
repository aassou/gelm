<?php
class CaisseDetails{

	//attributes
	private $_id;
	private $_dateOperation;
	private $_personne;
	private $_designation;
	private $_projet;
	private $_type;
	private $_montant;
	private $_commentaire;
    private $_idCaisse;
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

	public function setPersonne($personne){
		$this->_personne = $personne;
   	}

	public function setDesignation($designation){
		$this->_designation = $designation;
   	}

	public function setProjet($projet){
		$this->_projet = $projet;
   	}

	public function setType($type){
		$this->_type = $type;
   	}

	public function setMontant($montant){
		$this->_montant = $montant;
   	}

	public function setCommentaire($commentaire){
		$this->_commentaire = $commentaire;
   	}

	public function setCreated($created){
		$this->_created = $created;
   	}

	public function setCreatedBy($createdBy){
		$this->_createdBy = $createdBy;
   	}
    
    public function setIdCaisse($idCaisse){
        $this->_idCaisse = $idCaisse;
    }
	//getters
	public function id(){
    	return $this->_id;
    }
    
	public function dateOperation(){
		return $this->_dateOperation;
   	}

	public function personne(){
		return $this->_personne;
   	}

	public function designation(){
		return $this->_designation;
   	}

	public function projet(){
		return $this->_projet;
   	}

	public function type(){
		return $this->_type;
   	}

	public function montant(){
		return $this->_montant;
   	}

	public function commentaire(){
		return $this->_commentaire;
   	}

    public function idCaisse(){
        return $this->_idCaisse;
    }

	public function created(){
		return $this->_created;
   	}

	public function createdBy(){
		return $this->_createdBy;
   	}

}