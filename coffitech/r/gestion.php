<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="../css/style.css" />
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
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
            <H1>Welcome in coffitech gestion</H1>
        </div>
    <?php
    }
    ?>
</body>
</html>