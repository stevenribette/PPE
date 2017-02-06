<?php
function navbar(){
    require("function/login.php");
        if (isset($_GET['deconnexion']))
        {
        session_destroy();
        exit();
        }

    ?>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header" id="navbar">
                <a class="navbar-brand" href="gestion.php">Coffitech Gestion</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Stockage
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="gestion.php?stockage#lelement">Liste des élément</a></li>
                        <li><a href="gestion.php?stockage#nelement" data-target="#Monnsetup" data-toggle="collapse.show">Ajouter un élément</a></li>
                        <li><a href="gestion.php?stockage#lsetup">Liste des setup</a></li>
                        <li><a href="gestion.php?stockage#nsetup">Ajouter un setup</a></li>
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
    </br>
    </br>
    </br>
	
<?php
}
?>