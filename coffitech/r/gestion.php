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
    /*
    require ("client.php");
    require ("personnel.php");
    require ("fournisseur.php");
    */
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
    else if(isset($_GET['fournisseurs'])){
        fournisseur();
    }else{
    ?>
        <div class="container">
            <div class="row">
                <?php
                    require ("profil.php");
                    profil();
                ?>
            </div>
        </div>
    <?php
    }
    ?>
</body>
</html>