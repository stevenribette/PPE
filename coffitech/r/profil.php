<?php
function profil (){
    require ("connect.php");
    $result = mysqli_query($db, 'SELECT us_identifiant FROM user_connect where us_id ='.$_SESSION['login'].' ');
    while ($Row = mysqli_fetch_array($result)) {
        $identifiant = $Row[0];
    }
    $dir_nom = 'profil/'.$identifiant; // dossier listé (pour lister le répertoir courant : $dir_nom = '.'  --> ('point')
    $dir = opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant }

    $fichier= array(); // on déclare le tableau contenant le nom des fichiers

    while($element = readdir($dir)) {
        if($element != '.' && $element != '..') {
            if (!is_dir($dir_nom.'/'.$element)) {$fichier[] = $element;}
            else {$dossier[] = $element;}
        }
    }
    closedir($dir);
    $pseudo = 0;
    if ($identifiant == "Admin" ){
        $pseudo = "Administrateur";
    }else if ($identifiant == "Directeur" ){
        $pseudo = "Directeur";
    } else if ($identifiant == "Rcommercial" ){
        $pseudo = "Responsable commercial";
    } else if ($identifiant == "Rfinancier" ){
        $pseudo = "Responsable financier";
    }
    print('<div class="wrapper">
        <div class="jumbotron text-center">
            <h1>'.$pseudo.'</h1>
        </div>
    </div>
    <div class="col-sm-4">');
    print('<form id="upload" action="stocker.php" method="post" enctype="multipart/form-data">');
    print('<button class="btn btn-secondary" type="button" data-target="#Monnelement" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse">');
    if(empty($fichier))
    {
        print('<img class="img-circle" src="http://1plusx.com/app/mu-plugins/all-in-one-seo-pack-pro/images/default-user-image.png">');
    }
    if(!empty($fichier)){
        rsort($fichier);// pour le tri croissant, rsort() pour le tri décroissant
        foreach($fichier as $lien) {
            echo"<img class=\"img-circle\" src=\"$dir_nom/$lien \">";
        }
    }
    print('</button>

    <!-- le contenu masqué -->

    <section id="Monnelement" class="collapse">');
    print('<input type="file" name="fichier" class="btn btn-default btn-block">
            <input class="btn btn-primary btn-block" type="submit" value="Personnaliser"/>
            </section></form>');
    print('</div><div class="col-sm-4">
    <table class="table table-striped" id="lelement">
    <thead>
    <tr>
        <th><p>Vous avez accès aux fonctions suivantes:</p></th>
    </tr>
    </thead>
    <tbody>
    ');
    $droits = array("Stockage","Client","Fournisseurs","Personnel", "Produit", "Document");
    if($_SESSION['Level'] == 5){
        $i=0;
        while($i < count($droits)){
            print('<tr><td>'.$droits[$i].'</td></tr>');
            $i++;
        }
    }else if($_SESSION['Level'] == 3){
        print('<tr><td>'.$droits[1].'</td></tr>');
        print('<tr><td>'.$droits[3].'</td></tr>');
    }else if($_SESSION['Level'] == 2){
        print('<tr><td>'.$droits[0].'</td></tr>');
        print('<tr><td>'.$droits[2].'</td></tr>');
        print('<tr><td>'.$droits[4].'</td></tr>');
        print('<tr><td>'.$droits[5].'</td></tr>');
    }
    else if($_SESSION['Level'] == 1){
        print('<tr><td>'.$droits[5].'</p>');
    }
    print('</tbody>
            </table>
            </div>');
}
?>