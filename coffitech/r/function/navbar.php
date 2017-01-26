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
                <li class="active"><a href="gestion.php?stockage">Stockage</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">Client
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="newclient.php">Ajouter</a></li>
                            <li><a href="modclient.php">Modifier</a></li>
                        </ul>
                </li>
                <li><a href="#personnel.php">Personnel</a></li>
                <li><a href="#fournisseurs.php">Fournisseurs</a></li>
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