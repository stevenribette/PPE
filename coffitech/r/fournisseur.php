<?php
function fournisseur(){
	$fournisseur = new fournisseur;
    $fournisseur->lfournisseur();
    //$fournisseur->nfournisseur();
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
                <tr>
                <form method="post" id="mf' . $Row[0] . '" class="form-inline">
                <td>' . $Row[1] . '
                    <section class="' . $Row[0] . ' collapse" >   
                    <div class="form-group">
                        <input type="text" name="fours" class="form-control" value="' . $Row[1] . '" placeholder="Entrer la raison sociale">
                    </div>');
                print('
                </section>
                </td>
                <td>' . $Row[2] . '
                <section class="' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="fouadresse" class="form-control" value="' . $Row[2] . '" placeholder="Entrer l\'adresse">
                </div>
                </section>
                </td>
                <td>' . $Row[3] . '
                <section class="' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="foucp" class="form-control" value="' . $Row[3] . '" placeholder="Entrer le code postal">
                </div>
                </section>
                </td>
                <td>' . $Row[4] . '
                <section class="' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="fouville" class="form-control" value="' . $Row[4] . '" placeholder="Entrer la ville">
                </div>
                </section>
                </td>
                <td>
                    <a data-target=".' . $Row[0] . '" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse"><span class="glyphicon glyphicon-pencil"></span></a>
                    <section class="' . $Row[0] . ' collapse" >
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
                </tr>
                ');
            }
            if (isset($_GET['suppfou'])) {
                $sql = 'DELETE FROM fournisseur WHERE fou_id=' . $_GET['suppfou'];
                mysqli_query($db, $sql);
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
}
?>