<?php
//classes loading begin
    function classLoad ($myClass) {
        if(file_exists('model/'.$myClass.'.php')){
            include('model/'.$myClass.'.php');
        }
        elseif(file_exists('controller/'.$myClass.'.php')){
            include('controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('config.php');  
    //classes loading end
    session_start();
    if(isset($_SESSION['userMerlaTrav'])){
        //classes managers
        $usersManager = new UserManager($pdo);
        $mailManager = new MailManager($pdo);
        $todoManager  = new TodoProjetManager($pdo);
        $societeManager = new SocieteManager($pdo);
        $projetManager = new ProjetManager($pdo);
        //classes and vars
        //users number
        $users = $usersManager->getUsers();
        //$mails = $mailManager->getMails();
        $idProjet = $_GET['idProjet'];
        $idSociete = $_GET['idSociete'];
        $projet = $projetManager->getProjetById($idProjet);
        $societe = $societeManager->getSocieteById($projet->idSociete());
        $todos = $todoManager->getTodos();
        
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8" />
    <title>ImmoERP - Management Application</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/metro.css" rel="stylesheet" />
    <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/style_responsive.css" rel="stylesheet" />
    <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
    <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
    <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
    <link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css" />
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
    <!-- BEGIN HEADER -->
    <div class="header navbar navbar-inverse navbar-fixed-top">
        <!-- BEGIN TOP NAVIGATION BAR -->
        <?php 
        include("include/top-menu.php");
        ?>   
        <!-- END TOP NAVIGATION BAR -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN CONTAINER -->    
    <div class="page-container row-fluid sidebar-closed">
        <!-- BEGIN SIDEBAR -->
        <?php include("include/sidebar.php"); ?>
        <!-- END SIDEBAR -->
        <!-- BEGIN PAGE -->
        <div class="page-content">
            <!-- BEGIN PAGE CONTAINER-->
            <div class="container-fluid">
                <!-- BEGIN PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->           
                        <h3 class="page-title">
                            Gestion des tâches du projet
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-dashboard"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-sitemap"></i>
                                <a href="companies.php">Gestion des sociétés</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="company.php?idSociete=<?= $societe->id() ?>"><strong>Société <?= $societe->raisonSociale() ?></strong></a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-briefcase"></i>
                                <a href="projects-by-company.php?idSociete=<?= $idSociete ?>">Gestion des projets</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="project-management.php?idProjet=<?= $projet->id() ?>&idSociete=<?= $idSociete ?>">Projet <strong><?= $projet->nom() ?></strong></a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-check"></i>
                                <a>Liste des tâches du projet</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <!-- BEGIN PORTLET-->
                <div class="row-fluid">
                    <div class="span12">
                        <div class="portlet">
                            <div class="portlet-title line">
                                <h4><i class="icon-check"></i>Ajouter une tâche de projet</h4>
                                <!--div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div-->
                            </div>
                            <div class="portlet-body" id="chats">
                                <div class="chat-form">
                                    <form action="controller/TodoProjetActionController.php" method="POST">
                                        <div class="input-cont">   
                                            <input style="width: 600px" class="span4 m-wrap" type="text" name="todo" placeholder="Ajouter une tâche" />
                                            <select class="m-wrap" name="priority">
                                                <option value="Todo">Todo</option>
                                                <option value="InternalProcess">InternalProcess</option>
                                                <option value="ExternalProcess">ExternalProcess</option>
                                                <option value="Done">Done</option>
                                            </select>    
                                        </div>
                                        <div class="btn-cont"> 
                                            <input type="hidden" name="action" value="add" />
                                            <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                            <input type="hidden" name="idSociete" value="<?= $societe->id() ?>" />
                                            <span class="arrow"></span>
                                            <button type="submit" class="btn blue icn-only"><i class="icon-ok icon-white"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN INLINE NOTIFICATIONS PORTLET-->
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Todo</th>
                                    <th>InternalProcess</th>
                                    <th>ExternalProcess</th>
                                    <th>Done</th>    
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                    foreach($todos as $todo){
                                        $color = "";
                                        $priorityOption = "";
                                        if ( $todo->priority() == "Todo" ) {
                                            $color = "red";                                
                                        }
                                        else if ( $todo->priority() == "InternalProcess" ) {
                                            $color = "yellow";                 
                                        }
                                        else if ( $todo->priority() == "ExternalProcess" ) {
                                            $color = "green";                                
                                        }
                                        else if ( $todo->priority() == "Done" ) {
                                            $color = "blue";                                
                                        }
                                    ?>
                                    <tr>
                                    <td>
                                        <?php if ( $todo->priority() == "Todo" ) { ?>
                                            <a href="include/delete-task-projet.php?idTask=<?= $todo->id() ?>&idProjet=<?= $projet->id() ?>&idSociete=<?= $societe->id() ?>"><i class="icon-remove"></i></a>
                                            <a href="#updateTodo<?= $todo->id() ?>" data-toggle="modal" data-id="<?= $todo->id() ?>" class="btn <?= $color ?> get-down delete-checkbox"><?= $todo->todo() ?></a>
                                            <br />
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ( $todo->priority() == "InternalProcess" ) { ?>
                                            <a href="include/delete-task-projet.php?idTask=<?= $todo->id() ?>&idProjet=<?= $projet->id() ?>&idSociete=<?= $societe->id() ?>"><i class="icon-remove"></i></a>
                                            <a href="#updateTodo<?= $todo->id() ?>" data-toggle="modal" data-id="<?= $todo->id() ?>" class="btn <?= $color ?> get-down delete-checkbox"><?= $todo->todo() ?></a>
                                            <br />
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ( $todo->priority() == "ExternalProcess" ) { ?>
                                            <a href="include/delete-task-projet.php?idTask=<?= $todo->id() ?>&idProjet=<?= $projet->id() ?>&idSociete=<?= $societe->id() ?>"><i class="icon-remove"></i></a>
                                            <a href="#updateTodo<?= $todo->id() ?>" data-toggle="modal" data-id="<?= $todo->id() ?>" class="btn <?= $color ?> get-down delete-checkbox"><?= $todo->todo() ?></a>
                                            <br />
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ( $todo->priority() == "Done" ) { ?>
                                            <a href="include/delete-task-projet.php?idTask=<?= $todo->id() ?>&idProjet=<?= $projet->id() ?>&idSociete=<?= $societe->id() ?>"><i class="icon-remove"></i></a>
                                            <a href="#updateTodo<?= $todo->id() ?>" data-toggle="modal" data-id="<?= $todo->id() ?>" class="btn <?= $color ?> get-down delete-checkbox"><?= $todo->todo() ?></a>
                                            <br />    
                                        <?php } ?>
                                    </td>
                                    <!-- updateTodo box begin-->
                                    <div id="updateTodo<?= $todo->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h3>Modifier Todo Projet</h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" action="controller/TodoProjetActionController.php" method="post">
                                                <div class="control-group">
                                                    <label class="control-label">Todo</label>
                                                    <div class="controls">
                                                        <input type="text" name="todo" value="<?= $todo->todo() ?>" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Priorité</label>
                                                    <div class="controls">
                                                        <select name="priority">
                                                            <option value="<?= $todo->priority() ?>"><?= $todo->priority() ?></option>
                                                            <option disabled="disabled">-----------------</option>
                                                            <option value="Todo">Todo</option>
                                                            <option value="InternalProcess">InternalProcess</option>
                                                            <option value="ExternalProcess">ExternalProcess</option>
                                                            <option value="Done">Done</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <input type="hidden" name="idTodo" value="<?= $todo->id() ?>" />
                                                    <input type="hidden" name="idSociete" value="<?= $societe->id() ?>" />
                                                    <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                    <input type="hidden" name="action" value="update" />
                                                    <div class="controls">  
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- updateTodo box end -->
                                    </tr>    
                                    <?php 
                                    }
                                    ?>
                            </tbody>
                        </table>
                        <!-- END INLINE NOTIFICATIONS PORTLET-->
                    </div>
                </div>
                <!-- END PORTLET-->
                <!-- END PAGE CONTENT-->
            </div>
            <!-- END PAGE CONTAINER-->  
        </div>
        <!-- END PAGE -->       
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="footer">
        2015 &copy; ImmoERP. Management Application.
        <div class="span pull-right">
            <span class="go-top"><i class="icon-angle-up"></i></span>
        </div>
    </div>
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS -->
    <!-- Load javascripts at bottom, this will reduce page load time -->
    <script src="assets/js/jquery-1.8.3.min.js"></script>           
    <script src="assets/breakpoints/breakpoints.js"></script>           
    <script src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>  
    <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.blockui.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>    
    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
    <script src="assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="assets/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="assets/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/jquery.pulsate.min.js"></script>
    <!-- ie8 fixes -->
    <!--[if lt IE 9]>
    <script src="assets/js/excanvas.js"></script>
    <script src="assets/js/respond.js"></script>
    <![endif]-->
    <script src="assets/js/app.js"></script>        
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");  // set current page
            App.init();
        });
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php
}
else{
    header('Location:index.php');    
}
?>