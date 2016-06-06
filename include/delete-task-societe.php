<?php 
    include('../config.php');  
    include('../model/TodoSocieteManager.php');
    $todoManager = new TodoSocieteManager($pdo);
    $task_id = $_GET['idTask'];
    $idSociete = $_GET['idSociete'];
    $todoManager->delete($task_id);
    header('Location:../todo-societe.php?idSociete='.$idSociete);
?>