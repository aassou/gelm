<?php
class TodoProjetManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(TodoProjet $todo){
    	$query = $this->_db->prepare(' INSERT INTO t_todoprojet (
		todo, priority, status, responsable, description, idProjet, created, createdBy)
		VALUES (:todo, :priority, :status, :responsable, :description, :idProjet ,:created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':todo', $todo->todo());
        $query->bindValue(':priority', $todo->priority());
		$query->bindValue(':status', $todo->status());
        $query->bindValue(':responsable', $todo->responsable());
        $query->bindValue(':description', $todo->description());
        $query->bindValue(':status', $todo->status());
        $query->bindValue(':idProjet', $todo->idProjet());
		$query->bindValue(':created', $todo->created());
		$query->bindValue(':createdBy', $todo->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(TodoProjet $todo){
    	$query = $this->_db->prepare(' UPDATE t_todoprojet SET 
		todo=:todo, status=:status, priority=:priority, responsable=:responsable, 
		description=:description, idProjet=:idProjet, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $todo->id());
		$query->bindValue(':todo', $todo->todo());
        $query->bindValue(':priority', $todo->priority());
		$query->bindValue(':status', $todo->status());
        $query->bindValue(':responsable', $todo->responsable());
        $query->bindValue(':description', $todo->description());
        $query->bindValue(':idProjet', $todo->idProjet());
		$query->bindValue(':updated', $todo->updated());
		$query->bindValue(':updatedBy', $todo->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

    public function updatePriority(TodoProjet $todo){
        $query = $this->_db->prepare(' UPDATE t_todoprojet SET priority=:priority WHERE id=:id')
        or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $todo->id());
        $query->bindValue(':priority', $todo->priority());
        $query->execute();
        $query->closeCursor();
    }

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_todoprojet
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getTodoById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_todoprojet
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new TodoProjet($data);
	}

	public function getTodos(){
		$todos = array();
		$query = $this->_db->query('SELECT * FROM t_todoprojet
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$todos[] = new TodoProjet($data);
		}
		$query->closeCursor();
		return $todos;
	}
    
    public function getTodosNotHidden(){
        $todos = array();
        $query = $this->_db->query(
        'SELECT * FROM t_todoprojet
        WHERE priority<>"Done-Hide"
        ORDER BY id DESC');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $todos[] = new TodoProjet($data);
        }
        $query->closeCursor();
        return $todos;
    }
    
    public function getTodosHidden(){
        $todos = array();
        $query = $this->_db->query(
        'SELECT * FROM t_todoprojet
        WHERE priority="Done-Hide"
        ORDER BY id DESC');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $todos[] = new TodoProjet($data);
        }
        $query->closeCursor();
        return $todos;
    }

	public function getTodosByLimits($begin, $end){
		$todos = array();
		$query = $this->_db->query('SELECT * FROM t_todoprojet
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$todos[] = new TodoProjet($data);
		}
		$query->closeCursor();
		return $todos;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_todoprojet
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

    public function getTodosNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS todoNumber FROM t_todoprojet WHERE status=0');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data['todoNumber'];
    }
    
    ////////////////////////////////////////////////////////////////////
    
    public function getTodosByUser($user){
        $todos = array();
        $query = $this->_db->prepare('SELECT * FROM t_todoprojet WHERE createdBy=:user
        ORDER BY priority DESC, id DESC');
        $query->bindValue(':user', $user);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $todos[] = new TodoProjet($data);
        }
        $query->closeCursor();
        return $todos;
    }
    
    public function getTodosNumberByUser($user){
        $query = $this->_db->prepare(
        'SELECT COUNT(*) AS todoNumber FROM t_todoprojet 
        WHERE status=0 AND createdBy=:user');
        $query->bindValue(':user', $user);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data['todoNumber'];
    }

}