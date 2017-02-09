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
<nav class="navbar navbar-default navbar-fixed-bottom">
    <div class="container-fluid">
        <div class="navbar-header" id="navbar">
            <a class="navbar-brand" href="https://github.com/stevenribette/PPE">Crée par Steven Ribette, Quentin Jost, Antoine Gudolle et Yann Gbedo</a>
        </div>
        <ul class="nav navbar-nav">
        </ul>
    </div>
</nav>
</body>
</html>