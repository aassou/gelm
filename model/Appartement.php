<?php
class Appartement{

	//attributes
	private $_id;
	private $_numeroTitre;
	private $_nom;
	private $_superficie;
    private $_surplan;
	private $_prix;
	private $_niveau;
	private $_facade;
	private $_nombrePiece;
	private $_status;
	private $_cave;
	private $_par;
	private $_dateReservation;
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

	public function setPrix($prix){
		$this->_prix = $prix;
   	}

	public function setNiveau($niveau){
		$this->_niveau = $niveau;
   	}

	public function setFacade($facade){
		$this->_facade = $facade;
   	}

	public function setNombrePiece($nombrePiece){
		$this->_nombrePiece = $nombrePiece;
   	}

	public function setStatus($status){
		$this->_status = $status;
   	}

	public function setCave($cave){
		$this->_cave = $cave;
   	}

	public function setPar($par){
		$this->_par = $par;
   	}

	public function setDateReservation($dateReservation){
		$this->_dateReservation = $dateReservation;
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

	public function prix(){
		return $this->_prix;
   	}

	public function niveau(){
		return $this->_niveau;
   	}

	public function facade(){
		return $this->_facade;
   	}

	public function nombrePiece(){
		return $this->_nombrePiece;
   	}

	public function status(){
		return $this->_status;
   	}

	public function cave(){
		return $this->_cave;
   	}

	public function par(){
		return $this->_par;
   	}

	public function dateReservation(){
		return $this->_dateReservation;
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