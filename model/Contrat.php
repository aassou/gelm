<?php
class Contrat{
        
    //attributes
	private $_id;
	private $_dateCreation;
	private $_prixVente;
	private $_avance;
    private $_taille;
	private $_modePaiement;
	private $_idProjet;
	private $_idBien;
	private $_typeBien;
	private $_status;
	private $_numeroCheque;
	private $_nomClient;
	private $_cin;
	private $_adresse;
	private $_telephone;
	private $_note;
    
    //le constructeur
   	public function __construct($data){
        $this->hydrate($data);
    }
    
    //la focntion hydrate sert à attribuer les valeurs en utilisant les setters d'une façon dynamique!
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
    
    public function setDateCreation($dateCreation){
        $this->_dateCreation = $dateCreation;
    }
    
    public function setPrixVente($prixVente){
        $this->_prixVente = $prixVente;
    }
    
    public function setAvance($avance){
        $this->_avance = $avance;
    }
    
    public function setTaille($taille){
        $this->_taille = $taille;
    }
    
	public function setModePaiement($modePaiement){
        $this->_modePaiement = $modePaiement;
    }
    
    public function setNomClient($nomClient){
        $this->_nomClient = $nomClient;
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
    
    public function setIdProjet($idProjet){
        $this->_idProjet = $idProjet;
    }
    
    public function setIdBien($idBien){
        $this->_idBien = $idBien;
    }
	
	public function setTypeBien($typeBien){
        $this->_typeBien = $typeBien;
    }
	
	public function setStatus($status){
        $this->_status = $status;
    }
	
	public function setNumeroCheque($numeroCheque){
        $this->_numeroCheque = $numeroCheque;
    }
	
	public function setNote($note){
		$this->_note = $note;
	}
    
    //getters
    
    public function id(){
        return $this->_id;
    }
    
    public function dateCreation(){
        return $this->_dateCreation;
    }
    
    public function prixVente(){
        return $this->_prixVente;
    }
    
    public function avance(){
        return $this->_avance;
    }
    
    public function taille(){
        return $this->_taille;
    }
    
	public function modePaiement(){
        return $this->_modePaiement;
    }
    
    public function idProjet(){
        return $this->_idProjet;
    }
    
    public function idBien(){
        return $this->_idBien;
    }
	
	public function typeBien(){
        return $this->_typeBien;
    }
	
	public function status(){
        return $this->_status;
    }
	
	public function numeroCheque(){
        return $this->_numeroCheque;
    }
	
	public function nomClient(){
        return $this->_nomClient;
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
	
	public function note(){
		return $this->_note;
	}
}
