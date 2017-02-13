<?php
function fournisseur(){
	$fournisseur = new fournisseur;
    $fournisseur->lfournisseur();
    //$fournisseur->nfournisseur();
    $fournisseur->lcontact();
}
class fournisseur{
    function lfournisseur()
    {
        ?>
        <div class="container">
        <table class="table table-striped" id="lfournisseur">
            <thead>
            <tr>
                <th>Raison Sociale</th>
                <th>Adresse</th>
                <th>Code Postal</th>
                <th>Ville</th>
                <th>Modifier</th>
                <th>Effacer</th>
                <th>Contact</th>
            </tr>
            </thead>
            <tbody>
            <?php
            require('function/connect.php');
            //exécution de la requête
            $result = mysqli_query($db, 'SELECT * FROM fournisseur ORDER BY fou_id DESC ');
            //lecture des resultats
            while ($Row = mysqli_fetch_array($result)) {
                $supp = '<a href="gestion.php?fournisseur&amp;suppfou=' . $Row[0] . '" ><span class="glyphicon glyphicon-remove"></span></a>';
                print('
                <tr id="#fou'.$Row[0].'">
                <form method="post" id="mf' . $Row[0] . '" class="form-inline">
                <td>' . $Row[1] . '
                    <section class="f' . $Row[0] . ' collapse" >   
                    <div class="form-group">
                        <input type="text" name="fours" class="form-control" value="' . $Row[1] . '" placeholder="Entrer la raison sociale">
                    </div>');
                print('
                </section>
                </td>
                <td>' . $Row[2] . '
                <section class="f' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="fouadresse" class="form-control" value="' . $Row[2] . '" placeholder="Entrer l\'adresse">
                </div>
                </section>
                </td>
                <td>' . $Row[3] . '
                <section class="f' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="foucp" class="form-control" value="' . $Row[3] . '" placeholder="Entrer le code postal">
                </div>
                </section>
                </td>
                <td>' . $Row[4] . '
                <section class="f' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="fouville" class="form-control" value="' . $Row[4] . '" placeholder="Entrer la ville">
                </div>
                </section>
                </td>      
                <td>
                    <a data-target=".f' . $Row[0] . '" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse"><span class="glyphicon glyphicon-edit"></span></a>
                    <section class="f' . $Row[0] . ' collapse" >
                        <button name="mf' . $Row[0] . '" type="submit" class="btn btn-info">Modifier</button>
                    </section>
                </td>');
                if (isset($_POST['mf' . $Row[0] . ''])) {
                    if (!empty($_POST['fours']) && !empty($_POST['fouadresse']) && !empty($_POST['foucp']) && !empty($_POST['fouville'])) {
                        $sql = 'UPDATE fournisseur
                                SET fou_rs = "' . $_POST['fours'] . '",fou_adresse = "' . $_POST['fouadresse'] . '",fou_cp = "' . $_POST['foucp'] . '",fou_ville = "' . $_POST['fouville'] . '" 
                                WHERE fou_id = ' . $Row[0];
                        mysqli_query($db, $sql);
                        print('<meta http-equiv="refresh" content="0";URL=gestion.php?fournisseur#lfournisseur">');
                    } else {
                        print('
                    <div class="alert alert-danger">
                        <strong>Danger!</strong> Vous n\'avez pas indiquez la raison sociale
                    </div > ');
                    }
                }
                print('</form>
                <td>' . $supp . '</td>
                <td><a href="#con'.$Row[0].'"><span class="glyphicon glyphicon-user"></span></a></td>
                </tr>
                ');
            }
            if (isset($_GET['suppfou'])) {
                $sql = 'DELETE FROM fournisseur WHERE fou_id=' . $_GET['suppfou'];
                $sql2 = 'DELETE FROM contact WHERE fou_id=' . $_GET['suppfou'];
                mysqli_query($db, $sql);
                mysqli_query($db, $sql2);
                print('<meta http-equiv="refresh" content="0;URL=gestion.php?fournisseur#lfournisseur">');
            }
            //libération des ressources
            mysqli_free_result($result);
            //fermer la connexion
            mysqli_close($db);
            ?>
            </tbody>
        </table>
        </div>
        <?php
    }

    function lcontact()
    {
        ?>
        <div class="container">
            <table class="table table-striped" id="lfournisseur">
                <thead>
                <tr>
                    <th>Société</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Mail</th>
                    <th>Telephone</th>
                    <th>Modifier</th>
                </tr>
                </thead>
                <tbody>
                <?php
                require('function/connect.php');
                //exécution de la requête
                $result = mysqli_query($db, 'SELECT * FROM contact ORDER BY con_id DESC ');
                //lecture des resultats
                while ($Row = mysqli_fetch_array($result)) {

                    $res = mysqli_query($db, 'SELECT fou_rs FROM fournisseur WHERE fou_id = "'.$Row[0].'" ');
                    $ver = mysqli_fetch_array($res);
                    print('
                <tr id="con'.$Row[5].'">
                <form method="post" id="mc' . $Row[0] . '" class="form-inline">
                <td><a href="#fou'.$Row[5].'"><span class="glyphicon glyphicon-asterisk"></span></a>' . $ver[0] . '');
                    print('
                </td>
                <td>' . $Row[1] . '
                <section class="c' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="connom" class="form-control" value="' . $Row[1] . '" placeholder="Entrer le nom">
                </div>
                </section>
                </td>
                <td>' . $Row[2] . '
                <section class="c' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="conprenom" class="form-control" value="' . $Row[2] . '" placeholder="Entrer le prenom">
                </div>
                </section>
                </td>
                <td>' . $Row[3] . '
                <section class="c' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="conmail" class="form-control" value="' . $Row[3] . '" placeholder="Entrer le mail">
                </div>
                </section>
                </td>
                <td>(+33)' . $Row[4] . '
                <section class="c' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="contel" class="form-control" value="' . $Row[4] . '" placeholder="Entrer le telephone">
                </div>
                </section>
                </td>
                <td>
                    <a data-target=".c' . $Row[0] . '" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse"><span class="glyphicon glyphicon-edit"></span></a>
                    <section class="c' . $Row[0] . ' collapse" >
                        <button name="mc' . $Row[0] . '" type="submit" class="btn btn-info">Modifier</button>
                    </section>
                </td>');
                    if (isset($_POST['mc' . $Row[0] . ''])) {
                        if (!empty($_POST['connom']) && !empty($_POST['conprenom']) && !empty($_POST['conmail']) && !empty($_POST['contel'])) {
                            $sql = 'UPDATE contact
                                SET con_nom = "' . $_POST['connom'] . '",con_prenom = "' . $_POST['conprenom'] . '",con_mail = "' . $_POST['conmail'] . '",con_tel = "' . $_POST['contel'] . '" 
                                WHERE con_id = ' . $Row[0];
                            mysqli_query($db, $sql);
                            print('<meta http-equiv="refresh" content="0";URL=gestion.php?fournisseur#lcontact">');
                        } else {
                            print('
                    <div class="alert alert-danger">
                        <strong>Danger!</strong> Vous n\'avez pas indiquez la raison sociale
                    </div > ');
                        }
                    }
                    print('</form>
                </tr>
                ');
                }
                //libération des ressources
                mysqli_free_result($result);
                //fermer la connexion
                mysqli_close($db);
                ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
?>