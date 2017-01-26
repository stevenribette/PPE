<?php
function stockage ()
{
    ?>
    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Code</th>
                <th>Libelle</th>
                <th>Etat</th>
                <th>Effacer</th>
            </tr>
            </thead>
            <tbody>
            <?php
            require('connect.php');
            //exécution de la requête
            $result = mysqli_query($db, 'SELECT * FROM ordinateur');
            //lecture des resultats
            while ($Row = mysqli_fetch_array($result)) {
                $supp = '<a href="gestion.php?stockage&amp;suppord=' . $Row[0] . '" >X</a>';
                print('<tr><td>' . $Row[2] . '</td><td>' . $Row[1] . '</td><td>' . $Row[3] . '</td><td>' . $supp . '</td></tr>');
            }

            if (isset($_GET['suppord'])) {
                $sql = 'DELETE FROM ordinateur WHERE ord_id=' . $_GET['suppord'];
                mysqli_query($db, $sql);
                $nom = $_GET['suppord'];
                print('<meta http-equiv="refresh" content="0;URL=gestion.php?stockage">');
            }
            //libération des ressources
            mysqli_free_result($result);
            //fermer la connexion
            mysqli_close($db);
            ?>
            <tr></tr>
            <?php
            require('connect.php');
            //exécution de la requête
            $result = mysqli_query($db, 'SELECT * FROM souris');
            //lecture des resultats
            while ($Row = mysqli_fetch_array($result)) {
                $supp = '<a href="gestion.php?stockage&amp;suppsou=' . $Row[0] . '" >X</a>';
                print('<tr><td>' . $Row[2] . '</td><td>' . $Row[1] . '</td><td>' . $Row[3] . '</td><td>' . $supp . '</td></tr>');
            }

            if (isset($_GET['suppsou'])) {
                $sql = 'DELETE FROM souris WHERE sou_id=' . $_GET['suppsou'];
                mysqli_query($db, $sql);
                $nom = $_GET['suppsou'];
                print('<meta http-equiv="refresh" content="0;URL=gestion.php?stockage">');
            }
            //libération des ressources
            mysqli_free_result($result);
            //fermer la connexion
            mysqli_close($db);
            ?>
            <tr></tr>
            <?php
            require('connect.php');
            //exécution de la requête
            $result = mysqli_query($db, 'SELECT * FROM clavier');
            //lecture des resultats
            while ($Row = mysqli_fetch_array($result)) {
                $supp = '<a href="gestion.php?stockage&amp;suppcla=' . $Row[0] . '" >X</a>';
                print('<tr><td>' . $Row[2] . '</td><td>' . $Row[1] . '</td><td>' . $Row[3] . '</td><td>' . $supp . '</td></tr>');
            }

            if (isset($_GET['suppcla'])) {
                $sql = 'DELETE FROM clavier WHERE cla_id=' . $_GET['suppcla'];
                mysqli_query($db, $sql);
                $nom = $_GET['suppcla'];
                print('<meta http-equiv="refresh" content="0;URL=gestion.php?stockage">');
            }
            //libération des ressources
            mysqli_free_result($result);
            //fermer la connexion
            mysqli_close($db);
            ?>
            <tr></tr>
            <?php
            require('connect.php');
            //exécution de la requête
            $result = mysqli_query($db, 'SELECT * FROM ecran');
            //lecture des resultats
            while ($Row = mysqli_fetch_array($result)) {
                $supp = '<a href="gestion.php?stockage&amp;suppecr=' . $Row[0] . '" >X</a>';
                print('<tr><td>' . $Row[2] . '</td><td>' . $Row[1] . '</td><td>' . $Row[3] . '</td><td>' . $supp . '</td></tr>');
            }

            if (isset($_GET['suppecr'])) {
                $sql = 'DELETE FROM ecran WHERE ecran_id=' . $_GET['suppecr'];
                mysqli_query($db, $sql);
                $nom = $_GET['suppecr'];
                print('<meta http-equiv="refresh" content="0;URL=gestion.php?stockage">');
            }
            //libération des ressources
            mysqli_free_result($result);
            //fermer la connexion
            mysqli_close($db);
            ?>
            </tbody>
        </table>
        <form method="post" id="ajouter">
            <div class="form-group">
                <label>Type</label>
                <select class="form-control" name="post_type">
                    <option>ordinateur</option>
                    <option>souris</option>
                    <option>clavier</option>
                    <option>ecran</option>
                </select>
            </div>
            <div class="form-group">
                <label>Libelle</label>
                <input type="text" name="post_libelle" class="form-control" placeholder="Entrer le libelle">
            </div>
            <div class="form-group">
                <label>Etat</label>
                <select class="form-control" name="post_etat">
                    <option>disponible</option>
                    <option>utiliser</option>
                </select>
            </div>
            <?php
            require('connect.php');
            if (count($_POST) > 0){
                if(!empty($_POST['post_libelle'])){
                    if($_POST['post_type'] == "ordinateur"){
                        $debut = "ord";
                    }else if($_POST['post_type'] == "souris"){
                        $debut = "sou";
                    } else if($_POST['post_type'] == "clavier"){
                        $debut = "cla";
                    } else if($_POST['post_type'] == "ecran"){
                        $debut = "ecran";
                    }
                    $verlibelle = $_POST['post_libelle'];
                    $vertype = $_POST['post_type'];
                    $req = 'SELECT '.$debut.'_libelle FROM '.$vertype.' WHERE '.$debut.'_libelle = "'.$verlibelle.'"';
                    $res = mysqli_query($db, $req);
                    $donnee = mysqli_fetch_array($res);
                    //libération des ressources
                    mysqli_free_result($res);
                    if($donnee[$debut.'_libelle']=='')
                    {
                        $req = 'SELECT MAX('.$debut.'_id) FROM '.$vertype.'';
                        $result = mysqli_query($db, $req);
                        $code = mysqli_fetch_array($result);
                        //libération des ressources
                        mysqli_free_result($result);
                        $code = $code[0];
                        $code++;
                        $sql = 'INSERT INTO '.$vertype.' set '.$debut.'_libelle = "'. $verlibelle. '", '.$debut.'_code = "'.strtoupper($debut).$code.'", etat = "'. $_POST['post_etat']. '"';
                        mysqli_query($db, $sql);
                        print('<meta http-equiv="refresh" content="1;URL=gestion.php?stockage">');
                        print('<div class="alert alert-success">
                              <strong>Success!</strong> Nouvel élélement ajouter à la base
                                </div>');
                    }
                    else
                    {
                        print('<div class="alert alert-danger">
                            <strong>Danger!</strong> Le libelle que vous avez indiquez existe déjà
                            </div>');
                    }
                } else {
                    print('<div class="alert alert-danger">
                            <strong>Danger!</strong> Vous n\'avez pas indiquez le libelle
                            </div>');
                }
                //fermer la connexion
                mysqli_close($db);
            }
            ?>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
    </br>
    <?php
}
?>