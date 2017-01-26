<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="css/style.css" />
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <title>Connexion</title>
</head>
<body>
<div class="wrapper">
    <div class="jumbotron text-center">
        <h1>Coffitech Gestion</h1>
        <p></p>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
        </div>
        <div id="loginbox" class="col-sm-4">
            <p>
            <?php
            require("r/function/login.php");
            login();
            ?>
            </p>
        </div>
        <div class="col-sm-4">
        </div>
    </div>
</div>
</body>
</html>