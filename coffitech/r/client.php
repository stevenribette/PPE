<?php
function client(){
    $client = new client;
    print('<div class="container">');
    $client->lclient();
    $client->nclient();
    print('</div>');
}
class client{
    function lclient()
    {
        ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Mail</th>
                    <th>Tel</th>
                    <th>Adresse</th>
                    <th>Code postal</th>
                    <th>Ville</th>
                    <th>Modifier</th>
                    <th>Effacer</th>
                </tr>
                </thead>
                <tbody>
                <?php
                require('function/connect.php');
                //exécution de la requête
                $result = mysqli_query($db, 'SELECT * FROM client ORDER BY cli_id DESC ');
                //lecture des resultats
                while ($Row = mysqli_fetch_array($result)) {
                    $supp = '<a href="gestion.php?client&amp;suppcli=' . $Row[0] . '" ><span class="glyphicon glyphicon-remove"></span></a>';
                    print('
                <tr id="#cli'.$Row[0].'">
                <form method="post" id="mc' . $Row[0] . '" class="form-inline">
                <td>' . $Row[1] . '
                    <section class="c' . $Row[0] . ' collapse" >   
                    <div class="form-group">
                        <input type="text" name="clinom" class="form-control" value="' . $Row[1] . '" placeholder="Entrer le nom">
                    </div>');
                    print('
                </section>
                </td>
                <td>' . $Row[2] . '
                <section class="c' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="cliprenom" class="form-control" value="' . $Row[2] . '" placeholder="Entrer le prenom">
                </div>
                </section>
                </td>
                <td>' . $Row[3] . '
                <section class="c' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="climail" class="form-control" value="' . $Row[3] . '" placeholder="Entrer le mail">
                </div>
                </section>
                </td>
                <td>(+33)' . $Row[4] . '
                <section class="c' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="clitel" class="form-control" value="' . $Row[4] . '" placeholder="Entrer le numero">
                </div>
                </section>
                </td>
                <td>' . $Row[5] . '
                <section class="c' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="cliadresse" class="form-control" value="' . $Row[5] . '" placeholder="Entrer l\'adresse">
                </div>
                </section>
                </td>
                <td>' . $Row[6] . '
                <section class="c' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="clicp" class="form-control" value="' . $Row[6] . '" placeholder="Entrer le code postal">
                </div>
                </section>
                </td>
                <td>' . $Row[7] . '
                <section class="c' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="cliville" class="form-control" value="' . $Row[7] . '" placeholder="Entrer la ville">
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
                        if (!empty($_POST['clinom']) && !empty($_POST['cliprenom']) && !empty($_POST['climail']) && !empty($_POST['clitel']) && !empty($_POST['cliadresse']) && !empty($_POST['clicp']) && !empty($_POST['cliville'])) {
                                $sql = 'UPDATE client
                                SET cli_nom = "' . $_POST['clinom'] . '",cli_prenom = "' . $_POST['cliprenom'] . '",cli_mail = "' . $_POST['climail'] . '",cli_tel = "' . $_POST['clitel'] . '",cli_adresse = "' . $_POST['cliadresse'] . '",cli_cp = "' . $_POST['clicp'] . '",cli_ville = "' . $_POST['cliville'] . '" 
                                WHERE cli_id = ' . $Row[0];
                            mysqli_query($db, $sql);
                            print('<meta http-equiv="refresh" content="0";URL=gestion.php?client#lclient">');
                        } else {
                            print('
                            <div class="alert alert-danger">
                                <strong>Danger!</strong> Vous n\'avez pas remplit tous les champs
                            </div > ');
                        }
                    }
                    print('</form>
                <td>' . $supp . '</td>
                </tr>
                ');
                }
                if (isset($_GET['suppcli'])) {
                    $sql = 'DELETE FROM client WHERE cli_id=' . $_GET['suppcli'];
                    mysqli_query($db, $sql);
                    print('<meta http-equiv="refresh" content="0;URL=gestion.php?client#lclient">');
                }
                //libération des ressources
                mysqli_free_result($result);
                //fermer la connexion
                mysqli_close($db);
                ?>
                </tbody>
            </table>
        <?php
    }

    function nclient()
    {
        ?>

        <!-- les boutons d'actions -->
        <button id="nclient" class="btn btn-primary" type="button" data-target="#Monnsetup" data-toggle="collapse"
                aria-expanded="false" aria-controls="MonCollapse">Ajouter un client
        </button>

        <!-- le contenu masqué -->
        <section id="Monnsetup" class="collapse">
            </br>
            <form method="post" class="form-inline">
                <fieldset>
                    <legend>Contact</legend>
                    <div class="form-group">
                        <label class="sr-only mb-2 mr-sm-2 mb-sm-0">NOM</label>
                        <input type="text" name="post_clinom" class="form-control" placeholder="Entrer le nom">
                    </div>
                    <div class="form-group">
                        <label class="sr-only mb-2 mr-sm-2 mb-sm-0">PRENOM</label>
                        <input type="text" name="post_cliprenom" class="form-control" placeholder="Entrer le prenom">
                    </div>
                    <div class="form-group">
                        <label class="sr-only mb-2 mr-sm-2 mb-sm-0">MAIL</label>
                        <input type="email" name="post_climail" class="form-control" placeholder="Entrer l'email">
                    </div>
                    <div class="form-group">
                        <label class="sr-only mb-2 mr-sm-2 mb-sm-0">TEL</label>
                        <input type="tel" name="post_clitel" class="form-control" placeholder="Entrer le telephone">
                    </div>
                </fieldset>
                </br>
                <fieldset>
                    <legend>Location</legend>
                    <div class="form-group">
                        <label class="sr-only mb-2 mr-sm-2 mb-sm-0">ADRESSE</label>
                        <input type="text" name="post_cliadresse" class="form-control" placeholder="Entrer l'adresse">
                    </div>
                    <div class="form-group">
                        <label class="sr-only mb-2 mr-sm-2 mb-sm-0">CP</label>
                        <input type="text" name="post_clicp" class="form-control" placeholder="Entrer le code postal">
                    </div>
                    <div class="form-group">
                        <label class="sr-only mb-2 mr-sm-2 mb-sm-0">VILLE</label>
                        <input type="text" name="post_cliville" class="form-control" placeholder="Entrer la ville">
                    </div>
                </fieldset>
                </br>
                <button name="ncli" type="submit" class="btn btn-primary btn-block">Ajouter</button>
                <?php
                require('function/connect.php');
                if (isset($_POST['ncli'])) {
                    if (!empty($_POST['post_clinom']) && !empty($_POST['post_cliprenom']) && !empty($_POST['post_climail']) && !empty($_POST['post_clitel']) && !empty($_POST['post_cliadresse']) && !empty($_POST['post_clicp']) && !empty($_POST['post_cliville'])) {
                        $req = 'SELECT cli_mail FROM client WHERE cli_mail = "' . $_POST['post_climail'] . '" ';
                        $res = mysqli_query($db, $req);
                        $donnee = mysqli_fetch_array($res);
                        //libération des ressources
                        mysqli_free_result($res);
                        if ($donnee['cli_mail'] == '') {
                            if(preg_match('`[0-9]{10}`',$_POST['post_clitel'])){
                                $req = 'SELECT cli_adresse FROM client WHERE cli_adresse = "' . $_POST['post_cliadresse'] . '"';
                                $res = mysqli_query($db, $req);
                                $donnee = mysqli_fetch_array($res);
                                //libération des ressources
                                mysqli_free_result($res);
                                if ($donnee['cli_adresse'] == '') {
                                    $sql = 'INSERT INTO client set cli_nom = "' . $_POST['post_clinom'] . '",cli_prenom = "' . $_POST['post_cliprenom'] . '",cli_mail = "' . $_POST['post_climail'] . '",cli_tel = "' . $_POST['post_clitel'] . '",cli_adresse = "' . $_POST['post_cliadresse'] . '",cli_cp = "' . $_POST['post_clicp'] . '",cli_ville = "' . $_POST['post_cliville'] . '" ';
                                    mysqli_query($db, $sql);
                                    print('</section><meta http-equiv="refresh" content="1;URL=gestion.php?client#lclient">');
                                    print('
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> client ajouté avec succès
                                    </div>');
                                }else{
                                    print('</section><div class="alert alert-danger">
                                    <strong>Danger!</strong> Un client se situe déjà à l\'adresse '.$donnee[0].'
                                    </div>');
                                }
                            }else{
                                print('</section><div class="alert alert-danger">
                                <strong>Danger!</strong> Le numéro n\'est pas au bon format
                                </div>');
                            }
                        }else{
                            print('</section><div class="alert alert-danger">
                            <strong>Danger!</strong> Un client utilise déjà l\'adresse mail '.$donnee[0].'
                            </div>');
                        }
                    }else{
                        print('</section>
                            <div class="alert alert-danger">
                                <strong>Danger!</strong> Vous n\'avez pas remplit tous les champs du formulaire
                            </div >');
                    }
                    //fermer la connexion
                    mysqli_close($db);
                }
                ?>
            </form>
        </section>
        </div>
        </br>
        <?php
    }
}
?>