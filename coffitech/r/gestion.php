<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css" />
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Gestion</title>
</head>
<body>
    <?php
    require ("stockage.php");
    require ("client.php");
    require ("personnel.php");
    require ("fournisseur.php");
    require ("produit.php");
    require ("document.php");
    require ("caisse.php");

    require ("function/navbar.php");
    navbar();

    if(isset($_GET['stockage'])){
        stockage();
    }
    else if(isset($_GET['client'])){
        client();
    }
    else if(isset($_GET['fournisseur'])){
        fournisseur();
    }
    else if(isset($_GET['personnel'])){
        personnel();
    }
    else if(isset($_GET['fonction'])){
        pers("fonction");
    }
    else if(isset($_GET['salaire'])){
        pers("salaire");
    }
    else if(isset($_GET['produit'])){
        produit();
    }
    else if(isset($_GET['commande'])){
        document("commande");
    }
    else if(isset($_GET['commandec'])){
        document("commandec");
    }
    else if(isset($_GET['commandef'])){
        document("commandef");
    }
    else if(isset($_GET['facture'])){
        document("facture");
    }
    else if(isset($_GET['caisse'])){
        document("caisse");
    }
    else{
    ?>
        <div class="container">
            <div class="row">
                <?php
                    require ("profil.php");
                    if(isset($_SESSION['login'])) {
                        profil();
                    }
                ?>
            </div>
        </div>
    <?php
    }
    ?>
</body>
</html>