<?php 
    include('../config.php');  
    include('../model/TodoProjetManager.php');
    $todoManager = new TodoProjetManager($pdo);
    $task_id = $_GET['idTask'];
    //mysql_query("DELETE FROM tasks WHERE id='$task_id'");
    $todoManager->delete($task_id);
    $redirektLink = "Location:../todos.php";
    if ( isset($_GET['source']) and $_GET['source'] == "todos-archive" ) {
        $redirektLink = "Location:../todos-archive.php";
    }
    header($redirektLink);
?>