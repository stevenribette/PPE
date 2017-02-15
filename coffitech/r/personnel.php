<?php
function personnel(){
    $personnel = new personnel;
    print('<nav class="navbar navbar-default navbar-lower">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a href="gestion.php?fonction">Fonction</a>
                </li>
                <li>
                    <a href="gestion.php?salaire">Salaire</a>
                </li>
                <li>
                    <a href="gestion.php?personnel#lelement">Personnel</a>
                </li>
            </ul>
        </div>
    </nav>');
    print('<div class="container">');
    $personnel->lpersonnel();
    $personnel->npersonnel();
    print('</div>');
}
class personnel{
    function lpersonnel()
    {
        ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Mail</th>
                <th>Adresse</th>
                <th>Code postal</th>
                <th>Ville</th>
                <th>Date embauche</th>
                <th>Fonction</th>
                <th title="brut mensuel">Salaire</th>
                <th>Modifier</th>
                <th>Effacer</th>
            </tr>
            </thead>
            <tbody>
            <?php
            require('function/connect.php');
            //exécution de la requête
            $result = mysqli_query($db, 'SELECT * FROM personnel ORDER BY pers_id DESC ');
            //lecture des resultats
            while ($Row = mysqli_fetch_array($result)) {
                $supp = '<a href="gestion.php?personnel&amp;supppers=' . $Row[0] . '" ><span class="glyphicon glyphicon-remove"></span></a>';
                print('
                <tr id="#cli'.$Row[0].'">
                <form method="post" id="mp' . $Row[0] . '" class="form-inline">
                <td>' . $Row[1] . '
                    <section class="p' . $Row[0] . ' collapse" >   
                    <div class="form-group">
                        <input type="text" name="persnom" class="form-control" value="' . $Row[1] . '" placeholder="Entrer le nom">
                    </div>');
                print('
                </section>
                </td>
                <td>' . $Row[2] . '
                <section class="p' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="persprenom" class="form-control" value="' . $Row[2] . '" placeholder="Entrer le prenom">
                </div>
                </section>
                </td>
                <td>' . $Row[3] . '
                <section class="p' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="persmail" class="form-control" value="' . $Row[3] . '" placeholder="Entrer le mail">
                </div>
                </section>
                </td>
                <td>' . $Row[4] . '
                <section class="p' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="persadresse" class="form-control" value="' . $Row[4] . '" placeholder="Entrer l\'adresse">
                </div>
                </section>
                </td>
                <td>' . $Row[5] . '
                <section class="p' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="perscp" class="form-control" value="' . $Row[5] . '" placeholder="Entrer le code postal">
                </div>
                </section>
                </td>
                <td>' . $Row[6] . '
                <section class="p' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="persville" class="form-control" value="' . $Row[6] . '" placeholder="Entrer la ville">
                </div>
                </section>
                </td>
                <td>' . $Row[7] . '
                <section class="p' . $Row[0] . ' collapse" >
                <div class="form-group">
                    <input type="date" name="persdate" class="form-control" value="' . $Row[7] . '" placeholder="Entrer la date">
                </div>
                </section>
                </td>');
                $res = mysqli_query($db, 'SELECT fonc_libelle FROM fonction WHERE fonc_id = "'.$Row[8].'" ');
                $ver = mysqli_fetch_array($res);
                $res2 = mysqli_query($db, 'SELECT pers_montant FROM salaire WHERE fonc_id = "'.$Row[8].'" ');
                $ver2 = mysqli_fetch_array($res2);
                $listres = mysqli_query($db, 'SELECT fonc_libelle FROM fonction');
                $listres2 = mysqli_query($db, 'SELECT pers_montant FROM salaire inner join fonction on fonction.fonc_id = salaire.fonc_id');
                print('
                <script>$(function(){
                    $(\'select[value]\').each(function(){
                        $(this).val(this.getAttribute("value"));
                    });
                });</script>
                <td><a href="gestion.php?fonction#'.$Row[8].'">' . $ver[0] . '</a>
                <section class="p' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <select class="form-control" name="persfonction" value="' . $ver[0] . '">');
                    while ($elem = mysqli_fetch_array($listres)) {
                        print('<option>' . $elem[0] . '</option>');
                    }
                print('</select>
                </div>
                </section>
                </td>
                <td><a href="gestion.php?salaire#'.$Row[8].'">' . $ver2[0] . ' €</a>
                </td>
                <td>
                    <a data-target=".p' . $Row[0] . '" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse"><span class="glyphicon glyphicon-edit"></span></a>
                    <section class="p' . $Row[0] . ' collapse" >
                        <button name="mp' . $Row[0] . '" type="submit" class="btn btn-info">Modifier</button>
                    </section>
                </td>');
                if (isset($_POST['mp' . $Row[0] . ''])) {
                    if (!empty($_POST['persnom']) && !empty($_POST['persprenom']) && !empty($_POST['persmail']) && !empty($_POST['persadresse']) && !empty($_POST['perscp']) && !empty($_POST['persville']) && !empty($_POST['persdate']) && !empty($_POST['persfonction'])) {
                        $res = mysqli_query($db, 'SELECT fonc_id FROM fonction WHERE fonc_libelle = "'.$_POST['persfonction'].'" ');
                        $ver = mysqli_fetch_array($res);
                        $sql = 'UPDATE personnel
                                SET pers_nom = "' . $_POST['persnom'] . '",pers_prenom = "' . $_POST['persprenom'] . '",pers_mail = "' . $_POST['persmail'] . '",pers_adresse = "' . $_POST['persadresse'] . '",pers_cp = "' . $_POST['perscp'] . '",pers_ville = "' . $_POST['persville'] . '", pers_date_embauche = "' . $_POST['persdate'] . '", fonc_id = "' . $ver[0] . '"
                                WHERE pers_id = ' . $Row[0];
                        mysqli_query($db, $sql);
                        print('<meta http-equiv="refresh" content="0";URL=gestion.php?personnel#lpersonnel">');
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
            if (isset($_GET['supppers'])) {
                $sql = 'DELETE FROM personnel WHERE pers_id=' . $_GET['supppers'];
                mysqli_query($db, $sql);
                print('<meta http-equiv="refresh" content="0;URL=gestion.php?personnel#lpersonnel">');
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

    function npersonnel()
    {
        require('function/connect.php');
        ?>

        <!-- les boutons d'actions -->
        <button id="nclient" class="btn btn-primary" type="button" data-target="#Monnsetup" data-toggle="collapse"
                aria-expanded="false" aria-controls="MonCollapse">Ajouter un employer
        </button>

        <!-- le contenu masqué -->
        <section id="Monnsetup" class="collapse">
            </br>
            <form method="post" class="form-inline">
                <fieldset>
                    <legend>Contact</legend>
                    <div class="form-group">
                        <label class="sr-only mb-2 mr-sm-2 mb-sm-0">NOM</label>
                        <input type="text" name="post_persnom" class="form-control" placeholder="Entrer le nom">
                    </div>
                    <div class="form-group">
                        <label class="sr-only mb-2 mr-sm-2 mb-sm-0">PRENOM</label>
                        <input type="text" name="post_persprenom" class="form-control" placeholder="Entrer le prenom">
                    </div>
                    <div class="form-group">
                        <label class="sr-only mb-2 mr-sm-2 mb-sm-0">MAIL</label>
                        <input type="email" name="post_persmail" class="form-control" placeholder="Entrer l'email">
                    </div>
                </fieldset>
                </br>
                <fieldset>
                    <legend>Location</legend>
                    <div class="form-group">
                        <label class="sr-only mb-2 mr-sm-2 mb-sm-0">ADRESSE</label>
                        <input type="text" name="post_persadresse" class="form-control" placeholder="Entrer l'adresse">
                    </div>
                    <div class="form-group">
                        <label class="sr-only mb-2 mr-sm-2 mb-sm-0">CP</label>
                        <input type="text" name="post_perscp" class="form-control" placeholder="Entrer le code postal">
                    </div>
                    <div class="form-group">
                        <label class="sr-only mb-2 mr-sm-2 mb-sm-0">VILLE</label>
                        <input type="text" name="post_persville" class="form-control" placeholder="Entrer la ville">
                    </div>
                </fieldset>
                </br>
                <fieldset>
                    <legend>Complément</legend>
                    <?php
                    print('<div class="form-group">
                        <input title="Date d\'embauche" type="date" name="post_persdate" class="form-control" max="'.date("Y-m-d").'" min="2010-01-01" placeholder="Entrer la date">
                    </div>');
                    $listres = mysqli_query($db, 'SELECT fonc_id, fonc_libelle FROM fonction');

                    print('<div class="form-group">
                    <select title="Fonction" class="form-control" name="post_persfonction">');
                    while ($elem = mysqli_fetch_array($listres)) {
                        print('<option value="' . $elem[0] . '">' . $elem[1] . '</option>');
                    }
                    print('
                    </select>
                    </div>');
                    ?>
                </fieldset>
                </br>
                <button name="npers" type="submit" class="btn btn-primary btn-block">Ajouter</button>
                <?php
                require('function/connect.php');
                if (isset($_POST['npers'])) {
                    if (!empty($_POST['post_persnom']) && !empty($_POST['post_persprenom']) && !empty($_POST['post_persmail']) && !empty($_POST['post_persadresse']) && !empty($_POST['post_perscp']) && !empty($_POST['post_persville']) && !empty($_POST['post_persdate']) && !empty($_POST['post_persfonction'])) {
                        $req = 'SELECT pers_mail FROM personnel WHERE pers_mail = "' . $_POST['post_persmail'] . '" ';
                        $res = mysqli_query($db, $req);
                        $donnee = mysqli_fetch_array($res);
                        //libération des ressources
                        mysqli_free_result($res);
                        if ($donnee['pers_mail'] == '') {
                            $req = 'SELECT pers_adresse FROM personnel WHERE pers_adresse = "' . $_POST['post_persadresse'] . '"';
                            $res = mysqli_query($db, $req);
                            $donnee = mysqli_fetch_array($res);
                            //libération des ressources
                            mysqli_free_result($res);
                            if ($donnee['pers_adresse'] == '') {
                                $sql = 'INSERT INTO personnel set pers_nom = "' . $_POST['post_persnom'] . '",pers_prenom = "' . $_POST['post_persprenom'] . '",pers_mail = "' . $_POST['post_persmail'] . '",pers_adresse = "' . $_POST['post_persadresse'] . '",pers_cp = "' . $_POST['post_perscp'] . '",pers_ville = "' . $_POST['post_persville'] . '",pers_date_embauche = "' . $_POST['post_persdate'] . '",fonc_id = "' . $_POST['post_persfonction'] . '" ';
                                mysqli_query($db, $sql);
                                print('</section><meta http-equiv="refresh" content="1";URL=gestion.php?personnel#lpersonnel">');
                                print('
                                <div class="alert alert-success">
                                    <strong>Success!</strong> Nouvel employé ajouté avec succès
                                </div>');
                            }else{
                                print('</section><div class="alert alert-danger">
                                <strong>Danger!</strong> Un membre du personnel habite déjà à l\'adresse '.$donnee[0].'
                                </div>');
                            }
                        }else{
                            print('</section><div class="alert alert-danger">
                            <strong>Danger!</strong> Un employé utilise déjà l\'adresse mail '.$donnee[0].'
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
function pers($type){
    require('function/connect.php');
    print('<nav class="navbar navbar-default navbar-lower">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a href="gestion.php?fonction">Fonction</a>
                </li>
                <li>
                    <a href="gestion.php?salaire">Salaire</a>
                </li>
                <li>
                    <a href="gestion.php?personnel#lelement">Personnel</a>
                </li>
            </ul>
        </div>
    </nav>');
    print('<div class="container">');
        print('<div class="col-sm-6">');
            print('<fieldset>');
                if ($type == "fonction") {
                    print('<legend>Liste</legend>');
                    print('<table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Libelle</th>
                        </tr>
                        </thead>
                        <tbody>');
                    $result = mysqli_query($db, 'SELECT * FROM fonction ORDER BY fonc_id DESC ');
                    //lecture des resultats
                    while ($Row = mysqli_fetch_array($result)) {
                        print('<tr id="' . $Row[0] . '"><td>');
                        print($Row[1]);
                        print('<a class="pull-right" href="gestion.php?fonction&amp;suppfonction=' . $Row[0] . '" ><span class="glyphicon glyphicon-remove"></span></a>');
                        print('</td></tr>');
                    }
                    if (isset($_GET['suppfonction'])) {
                        $req = 'SELECT fonc_id FROM personnel WHERE fonc_id =' . $_GET['suppfonction'];
                        $res = mysqli_query($db, $req);
                        $donnee = mysqli_fetch_array($res);
                        if ($donnee == '') {
                            $sql = 'DELETE FROM fonction WHERE fonc_id=' . $_GET['suppfonction'];
                            mysqli_query($db, $sql);
                            print('<meta http-equiv="refresh" content="0;URL=gestion.php?fonction">');
                        } else {
                            print('
                                <div class="alert alert-danger">
                                    <strong>Danger!</strong> Un membre du personnel est atribué a cette fonction
                                </div >');
                        }
                    }
                    print('</tbody></table>');
                }
                else if ($type == "salaire") {
                    print('<legend>Liste</legend>');
                    print('<table class="table table-striped">
                        <thead>
                        <tr>
                            <th title="hebdomadaire">Heures</th>
                            <th title="brut mensuel">Montant</th>
                            <th>Fonction</th>
                            <th>Effacer</th>
                        </tr>
                        </thead>
                        <tbody>');
                    $result = mysqli_query($db, 'SELECT * FROM salaire ORDER BY salaire_id DESC ');
                    //lecture des resultats
                    while ($Row = mysqli_fetch_array($result)) {
                        print('<tr id="' . $Row[0] . '">');
                        print('<td>'.$Row[1].'</td>');
                        print('<td>'.$Row[2].'</td>');
                        $req = mysqli_query($db, 'SELECT fonc_libelle FROM fonction WHERE fonc_id ="'.$Row[3].'" ');
                        $donnee = mysqli_fetch_array($req);
                        print('<td>'.$donnee[0].'</td>');
                        print('<td><a href="gestion.php?salaire&amp;suppsalaire=' . $Row[0] . '" ><span class="glyphicon glyphicon-remove"></span></a>');
                        print('</td></tr>');
                    }
                    if (isset($_GET['suppsalaire'])) {
                        $req = 'SELECT salaire_id FROM personnel WHERE salaire_id =' . $_GET['suppsalaire'];
                        $res = mysqli_query($db, $req);
                        $donnee = mysqli_fetch_array($res);
                        if ($donnee == '') {
                            $sql = 'DELETE FROM salaire WHERE salaire_id=' . $_GET['suppsalaire'];
                            mysqli_query($db, $sql);
                            print('<meta http-equiv="refresh" content="0;URL=gestion.php?salaire">');
                        } else {
                            print('
                                <div class="alert alert-danger">
                                    <strong>Danger!</strong> Ce salaire est atribué à un membre du personnel
                                </div >');
                        }
                    }
                    print('</tbody></table>');
                }
            print('</fieldset>');
        print('</div>');
        print('<div class="col-sm-6">');
            print('<fieldset>');
                if ($type == "fonction") {
                    print('<legend>Ajouter</legend>');
                    print('<form method="post" class="form-inline">');
                    print('<div class="form-group">
                    <label class="sr-only mb-2 mr-sm-2 mb-sm-0">Fonction</label>
                    <input type="text" name="post_fonction" class="form-control" placeholder="Entrer le libelle de la fonction">
                    </div>
                    <button name="nfonc" type="submit" class="btn btn-primary">Ajouter</button>');
                    if (isset($_POST['nfonc'])) {
                        if (!empty($_POST['post_fonction'])) {
                            $req = mysqli_query($db, 'SELECT fonc_id FROM fonction WHERE fonc_libelle ="' . $_POST['post_fonction'] . '" ');
                            $donnee = mysqli_fetch_array($req);
                            if ($donnee == '') {
                                $sql = 'INSERT INTO fonction set fonc_libelle = "' . $_POST['post_fonction'] . '"';
                                mysqli_query($db, $sql);
                                print('
                                <div class="alert alert-success">
                                    <strong>Success!</strong> Fonction ajouté avec succès
                                </div>');
                                print('<meta http-equiv="refresh" content="1";URL=gestion.php?fonction">');
                            } else {
                                print('
                                <div class="alert alert-danger">
                                    <strong>Danger!</strong> L\'élément ' . $_POST['post_fonction'] . ' existe déjà
                                </div>');
                            }
                        } else {
                            print('
                            <div class="alert alert-danger">
                                <strong>Danger!</strong> Vous n\'avez pas indiquez la désignation
                            </div>');
                        }
                    }
                    print('</form>');
                }else if ($type == "salaire") {
                    print('<legend>Ajouter</legend>');
                    print('<form method="post" class="form-inline">');
                    print('<div class="form-group">
                    <label class="sr-only mb-2 mr-sm-2 mb-sm-0">heures</label>
                    <input type="number" name="post_heures" class="form-control" placeholder="Horaire hebdomadaire" value="35" min="1" max="45">
                    </div>
                    <div class="form-group">
                    <label class="sr-only mb-2 mr-sm-2 mb-sm-0">montant</label>
                    <input type="number" name="post_montant" class="form-control" placeholder="Montant/heure en €" value="10" min="10" max="99999">
                    </div>');
                    $listres = mysqli_query($db, 'SELECT fonc_libelle FROM fonction WHERE NOT EXISTS(SELECT null FROM salaire WHERE salaire.fonc_id = fonction.fonc_id)');
                    print('<div class="form-group">
                    <select class="form-control" name="post_fonction">');
                    while ($elem = mysqli_fetch_array($listres)) {
                        print('<option>' . $elem[0] . '</option>');
                    }
                    print('
                    </select>
                    </div>
                    <button name="nsalaire" type="submit" class="btn btn-primary">Ajouter</button></br>');
                    if (isset($_POST['nsalaire'])) {
                        if (!empty($_POST['post_heures']) && !empty($_POST['post_montant'])) {
                            if ($_POST['post_heures'] == "35"){
                                $mmensuel = ($_POST['post_montant'] * "151,50");
                            }else{
                                $mmensuel = ($_POST['post_montant'] * $_POST['post_heures'])*4;
                            }
                            $req = mysqli_query($db, 'SELECT salaire_id FROM salaire WHERE heure_effect ="' . $_POST['post_heures'] . '" && pers_montant ="' . $mmensuel . '" ');
                            $donnee = mysqli_fetch_array($req);
                            if ($donnee == '') {
                                $req = mysqli_query($db, 'SELECT fonc_id FROM fonction WHERE fonc_libelle ="' . $_POST['post_fonction'] . '" ');
                                $donnee = mysqli_fetch_array($req);
                                $sql = 'INSERT INTO salaire set heure_effect = "' . $_POST['post_heures'] . '", pers_montant = "' . $mmensuel . '", fonc_id="'.$donnee[0].'"';
                                mysqli_query($db, $sql);
                                print('
                                <div class="alert alert-success">
                                    <strong>Success!</strong> Salaire type ajouté avec succès
                                </div>');
                                print('<meta http-equiv="refresh" content="1";URL=gestion.php?salaire">');
                            } else {
                                print('
                                <div class="alert alert-danger">
                                    <strong>Danger!</strong> Un salaire type utilise déjà les critères que vous avez remplis
                                </div>');
                            }
                        } else {
                            print('
                            <div class="alert alert-danger">
                                <strong>Danger!</strong> Vous n\'avez pas remplis tous les champs
                            </div>');
                        }
                    }
                    print('</form>');
                }
            print('</fieldset>');
        print('</div>');
    print('</div>');
}
?>