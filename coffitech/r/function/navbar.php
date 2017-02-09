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
                <li class="dropdown" id="stockage">
                    <a class="dropdown-toggle" href="#">Stockage
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="gestion.php?stockage#lelement">Liste des élément</a></li>
                        <li><a href="gestion.php?stockage#nelement">Ajouter un élément</a></li>
                        <li><a href="gestion.php?stockage#lsetup">Liste des setup</a></li>
                        <li><a href="gestion.php?stockage#nsetup">Ajouter un setup</a></li>
                    </ul>
                </li>
                <li class="dropdown" id="client">
                    <a class="dropdown-toggle" href="#">Client
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="gestion.php?client#lelement">Liste des Client</a></li>
                        <li><a href="gestion.php?client#nelement">Ajouter un client</a></li>
                    </ul>
                </li>
                <li class="dropdown" id="fournisseur">
                    <a class="dropdown-toggle" href="#">Fournisseur
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="gestion.php?fournisseur#lelement">Liste des fournisseurs</a></li>
                        <li><a href="gestion.php?fournisseur#nelement">Ajouter un fournisseur</a></li>
                    </ul>
                </li>
                <li class="dropdown" id="personnel">
                    <a class="dropdown-toggle" href="#">Personnel
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="gestion.php?personnel#lelement">Liste du personnel</a></li>
                        <li><a href="gestion.php?personnel#nelement">Ajouter un employer</a></li>
                    </ul>
                </li>
                <li class="dropdown" id="produit">
                    <a class="dropdown-toggle" href="#">Produit
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="gestion.php?produit#lelement">Liste des produits</a></li>
                        <li><a href="gestion.php?produit#nelement">Ajouter un produit</a></li>
                    </ul>
                </li>
                <li class="dropdown" id="document">
                    <a class="dropdown-toggle" href="#">Document
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="gestion.php?devis">Devis</a></li>
                        <li><a href="gestion.php?commande">Commande</a></li>
                        <li><a href="gestion.php?facture">Facture</a></li>
                    </ul>
                </li>
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
    if(isset($_SESSION['Level'])){
        if($_SESSION['Level'] == 1){
            ?>
            <script>
            $('#stockage').addClass('hidden');
            $('#client').addClass('hidden');
            $('#fournisseur').addClass('hidden');
            $('#personnel').addClass('hidden');
            $('#produit').addClass('hidden');
            $("#document .dropdown-toggle").attr("data-toggle", "dropdown");
            </script>
            <?php
        }
        else if($_SESSION['Level'] == 2){
            ?>
            <script>
                $('#client').addClass('hidden');
                $('#personnel').addClass('hidden');
                $("#stockage .dropdown-toggle").attr("data-toggle", "dropdown");
                $("#fournisseur .dropdown-toggle").attr("data-toggle", "dropdown");
                $("#produit .dropdown-toggle").attr("data-toggle", "dropdown");
                $("#document .dropdown-toggle").attr("data-toggle", "dropdown");
            </script>
            <?php
        }
        else if($_SESSION['Level'] == 3){
            ?>
            <script>
                $('#stockage').addClass('hidden');
                $('#fournisseur').addClass('hidden');
                $('#produit').addClass('hidden');
                $('#document').addClass('hidden');
                $("#client .dropdown-toggle").attr("data-toggle", "dropdown");
                $("#personnel .dropdown-toggle").attr("data-toggle", "dropdown");
            </script>
            <?php
        }
        else if($_SESSION['Level'] == 5){
            ?>
            <script>
                $("#stockage .dropdown-toggle").attr("data-toggle", "dropdown");
                $("#fournisseur .dropdown-toggle").attr("data-toggle", "dropdown");
                $("#produit .dropdown-toggle").attr("data-toggle", "dropdown");
                $("#document .dropdown-toggle").attr("data-toggle", "dropdown");
                $("#client .dropdown-toggle").attr("data-toggle", "dropdown");
                $("#personnel .dropdown-toggle").attr("data-toggle", "dropdown");
            </script>
            <?php
        }
    }
}
?>