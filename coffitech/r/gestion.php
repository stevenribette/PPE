<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
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

    require ("function/navbar.php");
    navbar();

    if(isset($_GET['stockage'])){
        stockage();
    }
    else if(isset($_GET['client'])){
        client();
    }
    else if(isset($_GET['personnel'])){
        personnel();
    }
    else if(isset($_GET['fournisseur'])){
        fournisseur();
    }else if(isset($_GET['personnel'])){
        personnel();
    }else if(isset($_GET['produit'])){
        produit();
    }else if(isset($_GET['devis'])){
        document("devis");
    }else if(isset($_GET['commande'])){
        document("commandes");
    }else if(isset($_GET['factures'])){
        document("facture");
    }else{
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