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
    require ("function/navbar.php");
    navbar();
require('connect.php');
$result = mysqli_query($db, 'SELECT us_identifiant FROM user_connect where us_id ='.$_SESSION['login'].' ');
while ($Row = mysqli_fetch_array($result)) {
    $identifiant = $Row[0];
}
print('<br/><p>');
//On vérifie si un fichier à bien été choisis et qu'il n'y a pas d'erreur
if (isset($_FILES['fichier']) AND $_FILES['fichier']['error'] == 0)
{
    $nom = $identifiant;
    $dir_nom = "profil/$nom"; // dossier listé (pour lister le répertoir courant : $dir_nom = '.'  --> ('point')
    $dir = opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas');
    $nam = 0;
    while($entry = readdir($dir))
        if(is_file($dir_nom.'/'.$entry))
            $nam++;
    $nam = $nam + 1;
    $info = pathinfo($_FILES['fichier']['name']);
    $extension = $info['extension'];
    $extension_autoriser = array('jpg');
    if(in_array($extension, $extension_autoriser))
    {
    //on stock le fichier
        move_uploaded_file($_FILES['fichier']['tmp_name'],$dir_nom."/".basename($identifiant.".".$extension));

        $message = "le fichier &#224 &#233t&#233 stocker &#224 cette adresse: http://coffitech/r/profil/".$identifiant."/".$identifiant.".".$extension."";
    }
    else
    {
        $message = "Le fichier doit être au format JPG.";
    }

}
else // si il y a eu une erreur
{
    $message = "Le formulaire n'est pas rempli ou une erreur est survenu.";
}
print('<div class="wrapper">
        <div class="jumbotron text-center">
            <h1>'.$message.'</h1>
        </div>
    </div>');
print('<meta http-equiv="refresh" content="3;URL=gestion.php">');
print('<br/>Vous aller être redirig&#233 dans 3 secondes');
print('</p>');
?>
</body>
</html>