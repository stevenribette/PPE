<?php
function navbar(){
    require("function/login.php");
        if (isset($_GET['deconnexion']))
        {
        session_destroy();
        exit();
        }

    ?>
    <nav class="navbar navbar-default navbar-relative-top">
        <div class="container-fluid">
            <div class="navbar-header" id="navbar">
                <a class="navbar-brand" href="gestion.php">Coffitech Gestion</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Stockage
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="gestion.php?stockage#liste">Liste</a></li>
                        <li><a href="gestion.php?stockage#ajouter">Ajouter</a></li>
                        <li><a href="gestion.php?stockage#setup">Setup</a></li>
                    </ul>
                </li>
                <li><a href="gestion.php?client">Client</a></li>
                <li><a href="?personnel">Personnel</a></li>
                <li><a href="?fournisseurs">Fournisseurs</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <?php
                    login();
                    ?>
                </li>
            </ul>
        </div>
    </nav>
	
<?php
}
?>