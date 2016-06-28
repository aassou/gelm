<?php
class TodoProjet{

	//attributes
	private $_id;
	private $_todo;
    private $_priority;
	private $_status;
    private $_responsable;
    private $_description;
    private $_idProjet;
    private $_idSociete;
	private $_created;
	private $_createdBy;
	private $_updated;
	private $_updatedBy;

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
	
	public function setTodo($todo){
		$this->_todo = $todo;
   	}
    
    public function setPriority($priority){
        $this->_priority = $priority;
    }

	public function setStatus($status){
		$this->_status = $status;
   	}
    
    public function setResponsable($responsable){
        $this->_responsable = $responsable;
    }
    
    public function setDescription($description){
        $this->_description = $description;
    }
    
    public function setIdProjet($idProjet){
        $this->_idProjet = $idProjet;
    }
    
    public function setIdSociete($idSociete){
        $this->_idSociete = $idSociete;
    }

	public function setCreated($created){
        $this->_created = $created;
    }

	public function setCreatedBy($createdBy){
        $this->_createdBy = $createdBy;
    }

	public function setUpdated($updated){
        $this->_updated = $updated;
    }

	public function setUpdatedBy($updatedBy){
        $this->_updatedBy = $updatedBy;
    }

	//getters
	public function id(){
    	return $this->_id;
    }
	
	public function todo(){
		return $this->_todo;
   	}
    
    public function priority(){
        return $this->_priority;
    }

	public function status(){
		return $this->_status;
   	}
    
    public function responsable(){
        return $this->_responsable;
    }
    
    public function description(){
        return $this->_description;
    }
    
    public function idProjet(){
        return $this->_idProjet;
    }
    
    public function idSociete(){
        return $this->_idSociete;
    }

	public function created(){
        return $this->_created;
    }

	public function createdBy(){
        return $this->_createdBy;
    }

	public function updated(){
        return $this->_updated;
    }

	public function updatedBy(){
        return $this->_updatedBy;
    }

}