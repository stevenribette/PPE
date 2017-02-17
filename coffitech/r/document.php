<?php
function document($typedoc)
{
    $document = new document;
    print('<div class="container">');
    $document->$typedoc();
    print('</div>');
}
class document {
    function commande(){
        ?>
        <nav class="navbar navbar-default navbar-lower">
            <div class="container-fluid">
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a href="gestion.php?commandec">Commandes client</a>
                    </li>
                    <li class="nav-item">
                        <a href="gestion.php?commandef">Commandes fournisseur</a>
                    </li>
                </ul>
            </div>
        </nav>
    <?php
    }

    function facture (){

    }

    function caisse (){

    }
    function commandec (){
        $this->commande();
        $commande = new commande;
        $commande->afficher("client");
        $commande->ajouter("client");
    }
    function commandef (){
        $this->commande();
        $commande = new commande;
        $commande->afficher("fournisseur");
        $commande->ajouter("fournisseur");
    }
}
class commande {

    function afficher($type){
        require('function/connect.php');
        if($type == "client"){
            $base = "comc";
            $base2 = "cli";
            $min = "c";
            $cfname ="cli_nom";
        }else{
            $base = "comf";
            $base2 = "fou";
            $min = "f";
            $cfname ="fou_rs";
        }
        print('<table class="table table-striped">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>'.$type.'</th>
                    <th>Modifier</th>
                    <th>Annuler</th>
                    <th>Valider</th>
                </tr>
                </thead>
                <tbody>');
        //exécution de la requête
        $result = mysqli_query($db, 'SELECT * FROM commande_'.$type.' WHERE '.$base.'_val = "N" ORDER BY '.$base.'_id DESC ');
        //lecture des resultats
        while ($Row = mysqli_fetch_array($result)) {
            $supp = '<a href="gestion.php?commande' . $min . '&amp;suppcom' . $min . '=' . $Row[0] . '" ><span class="glyphicon glyphicon-remove"></span></a>';
            $valid = '<a href="gestion.php?commande' . $min . '&amp;validcom' . $min . '=' . $Row[0] . '" ><span class="glyphicon glyphicon-ok"></span></a>';
            print('
                <tr id="#'.$base.''.$Row[0].'">
                <form method="post" id="mc'.$min.'' . $Row[0] . '" class="form-inline">
                <td>
                    <a id="licommande" href="gestion.php?commande' . $min . '&amp;licom' . $min . '=' . $Row[0] . '">' . $Row[1] . '
                    </a>
                </td>');
            print('<td>' . $Row[2] . '
                <section class="c' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="text" name="'.$base.'titre" class="form-control" value="' . $Row[2] . '" placeholder="Entrer le libelle">
                </div>
                </section>
                </td>');
            print('<td>' . $Row[3] . '
                <section class="c' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="date" name="'.$base.'date" class="form-control" value="' . $Row[3] . '" max="'.date("Y-m-d").'" min="2010-01-01" placeholder="Entrer la date">
                </div>
                </section>
                </td>');
            $listres = mysqli_query($db, 'SELECT '.$cfname.' FROM '.$type.'');
            $res = mysqli_query($db, 'SELECT '.$cfname.' FROM '.$type.' WHERE '.$base2.'_id = "'.$Row[4].'" ');
            $ver = mysqli_fetch_array($res);
            print('<td>' . $ver[0] . '
                <section class="c' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <select class="form-control" value="' . $ver[0] . '" name="'.$base.'client">');
                    while ($elem = mysqli_fetch_array($listres)) {
                        print('<option>' . $elem[0] . '</option>');
                    }
                print('</select>
                </div>
                </section>
                </td>');
            print('<td>
                    <a data-target=".c' . $Row[0] . '" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse"><span class="glyphicon glyphicon-edit"></span></a>
                    <section class="c' . $Row[0] . ' collapse" >
                        <button name="mc'.$min.'' . $Row[0] . '" type="submit" class="btn btn-info">Modifier</button>
                    </section>
                </td>');
            if (isset($_POST['mc'.$min.'' . $Row[0] . ''])) {
                if (!empty($_POST[''.$base.'titre']) && !empty($_POST[''.$base.'date']) && !empty($_POST[''.$base.'client'])) {
                    $res = mysqli_query($db, 'SELECT '.$base2.'_id FROM '.$type.' WHERE '.$cfname.' = "'.$_POST[''.$base.'client'].'" ');
                    $ver = mysqli_fetch_array($res);
                    $sql = 'UPDATE commande_'.$type.'
                                SET '.$base.'_titre = "' . $_POST[''.$base.'titre'] . '",'.$base.'_date = "' . $_POST[''.$base.'date'] . '", '.$base2.'_id = "' . $ver[0] . '" 
                                WHERE '.$base.'_id = ' . $Row[0];
                    mysqli_query($db, $sql);
                    print('<meta http-equiv="refresh" content="0";URL=gestion.php?commande'.$min.'">');
                } else {
                    print('
                            <div class="alert alert-danger">
                                <strong>Danger!</strong> Vous n\'avez pas remplit tous les champs
                            </div > ');
                }
            }
            print('</form>');
            print('<td>' . $supp . '</td><td>' . $valid . '</td>
                </tr>');
        }
        if (isset($_GET['suppcom' . $min . ''])) {
            $sql = 'UPDATE commande_'.$type.' SET '.$base.'_val = "C"  WHERE '.$base.'_id=' . $_GET['suppcom' . $min . ''];
            mysqli_query($db, $sql);
            print('<meta http-equiv="refresh" content="0;URL=gestion.php?commande' . $min . '">');
        }
        if (isset($_GET['validcom' . $min . ''])) {
            $sql = 'UPDATE commande_'.$type.' SET '.$base.'_val = "Y"  WHERE '.$base.'_id=' . $_GET['suppcom' . $min . ''];
            mysqli_query($db, $sql);
            print('<meta http-equiv="refresh" content="0;URL=gestion.php?commande' . $min . '">');
        }
        //libération des ressources
        mysqli_free_result($result);
        print('</tbody>
            </table>');
        if (isset($_GET['licom' . $min . ''])) {
            print('<table class="table table-striped">
                <thead>
                <tr>
                    <th>Page</th>
                    <th>Pdt</th>
                    <th>Qte</th>
                    <th title="HT">PU</th>
                    <th title="TTC">Total</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
                </thead>
                <tbody>');
            $result = mysqli_query($db, 'SELECT * FROM ligne_commande_' . $type . ' WHERE ' . $base . '_id = "'. $_GET['licom' . $min . ''].'" ORDER BY l' . $base . '_id DESC ');
            //lecture des resultats
            $i = 1;
            while ($Row = mysqli_fetch_array($result)) {
                $supp = '<a href="gestion.php?commande' . $min . '&amp;supplicom' . $min . '=' . $Row[0] . '" ><span class="glyphicon glyphicon-remove"></span></a>';
                print('<tr><form method="post" id="mlc'.$min.'' . $Row[0] . '" class="form-inline">');
                print('<td>' . $i . '</td>');
                if($type == "client") {
                    $res = mysqli_query($db, 'SELECT setup_code FROM setup WHERE setup_id = "' . $Row[1] . '" ');
                    $ver = mysqli_fetch_array($res);
                    print('<td>' . $ver[0] . '');
                    $listres = mysqli_query($db, 'SELECT setup_code FROM setup WHERE etat = "disponible"');
                    print('<section class="lic' . $Row[0] . ' collapse" >   
                            <div class="form-group">
                                <select class="form-control" value="' . $ver[0] . '" name="l'.$base.'setup">');
                    while ($elem = mysqli_fetch_array($listres)) {
                        print('<option>' . $elem[0] . '</option>');
                    }
                    print('</select>
                            </div>
                            </section></td>');
                }else if($type == "fournisseur") {
                    print('<td>' . $Row[1] . '
                            <section class="lic' . $Row[0] . ' collapse" >   
                            <div class="form-group">
                                <input type="text" name="l'.$base.'libelle" class="form-control" value="' . $Row[1] . '" placeholder="Entrer le libelle">
                            </div>
                            </section>
                            </td>');
                }
                print('<td>' . $Row[2] . '
                <section class="lic' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="number" name="l'.$base.'qte" class="form-control" placeholder="Quantité" value="'.$Row[2].'" min="1" max="9999">
                    </div>
                </section>
                </td>');
                if($type == "client") {
                    $puht = 6.25;
                }else if($type == "fournisseur") {
                    $puht = $Row[5] ;
                }
                print('<td> '.$puht.'');
                if($type == "fournisseur") {
                    print('<section class="lic' . $Row[0] . ' collapse" >   
                            <div class="form-group">
                                <input type="number" name="l'.$base.'puht" class="form-control" placeholder="Montant" value="'.$Row[5].'" min="1" max="9999">
                                </div>
                            </section>');
                }
                print('</td>');
                $res = mysqli_query($db, 'SELECT tva_taux FROM tva WHERE tva_id = "' . $Row[4] . '" ');
                $ver = mysqli_fetch_array($res);
                $total = $Row[2] * $puht;
                $tva = ($total / 100) * $ver[0] ;
                $total = $total + $tva;
                print('<td>' . $total . '</td>');
                print('<td>
                    <a data-target=".lic' . $Row[0] . '" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse"><span class="glyphicon glyphicon-edit"></span></a>
                    <section class="lic' . $Row[0] . ' collapse" >
                        <button name="mlc'.$min.'' . $Row[0] . '" type="submit" class="btn btn-info">Modifier</button>
                    </section>
                </td>');
                if (isset($_POST['mlc'.$min.'' . $Row[0] . ''])) {
                    if($type == "client") {
                        if (!empty($_POST['l' . $base . 'setup']) && !empty($_POST['l' . $base . 'qte'])) {
                            $res = mysqli_query($db, 'SELECT setup_id FROM setup WHERE setup_code = "' . $_POST['l' . $base . 'setup'] . '" ');
                            $ver = mysqli_fetch_array($res);
                            $sql = 'UPDATE ligne_commande_'.$type.'
                                SET setup_id = "'.$ver[0].'",l'.$base.'_qte = "' . $_POST['l'.$base.'qte'] . '" 
                                WHERE l'.$base.'_id = ' . $Row[0];
                            mysqli_query($db, $sql);
                            print('<meta http-equiv="refresh" content="0;URL=gestion.php?commande'.$min.'&amp;li'.$base.'=' . $_GET['licom' . $min . ''] . '">');
                        }else{
                            print('</section>
                                <div class="alert alert-danger">
                                    <strong>Danger!</strong> Vous n\'avez pas remplit tous les champs
                                </div >');
                        }
                    }else if($type == "fournisseur") {
                        if (!empty($_POST['l' . $base . 'libelle']) && !empty($_POST['l' . $base . 'qte'])&& !empty($_POST['l' . $base . 'puht'])) {
                            $sql = 'UPDATE ligne_commande_'.$type.'
                                SET l'.$base.'_libelle = "'.$_POST['l' . $base . 'libelle'].'",l'.$base.'_qte = "' . $_POST['l'.$base.'qte'] . '", pu_ht = "' . $_POST['l'.$base.'puht'] . '" 
                                WHERE l'.$base.'_id = ' . $Row[0];
                            mysqli_query($db, $sql);
                            print('<meta http-equiv="refresh" content="0;URL=gestion.php?commande'.$min.'&amp;li'.$base.'=' . $_GET['licom' . $min . ''] . '">');
                        }else{
                            print('</section>
                                <div class="alert alert-danger">
                                    <strong>Danger!</strong> Vous n\'avez pas remplit tous les champs
                                </div >');
                        }
                    }
                }
                print('<td>'.$supp.'</td>');
                print('</form></tr>');
                $i++;
            }
            print('<tr><form method="post" id="nlc'.$min.'' . $_GET['licom' . $min . ''] . '" class="form-inline">');
            print('<td></td>');
            print('<td>');
            print('<div class="form-group">');
            if($type == "client") {
                $listres = mysqli_query($db, 'SELECT setup_code FROM setup WHERE etat = "disponible" && not exists (SELECT setup_id FROM ligne_commande_'.$type.' where setup.setup_id = ligne_commande_'.$type.'.setup_id && comc_id = "' . $_GET['licom' . $min . ''] . '") ');
                print('<select class="form-control" name="post_l'.$base.'setup">');
                while ($elem = mysqli_fetch_array($listres)) {
                    print('<option>' . $elem[0] . '</option>');
                }
                print('</select>');
            }else if($type == "fournisseur") {
                print('<input type = "text" name = "post_l'.$base.'libelle" class="form-control" placeholder = "Entrer le libelle" >');
            }
            print('</div>');
            print('</td>');
            print('<td><div class="form-group">
                    <input type="number" name="post_l'.$base.'qte" class="form-control" placeholder="Quantité" min="1" max="9999">
                    </div></td>');
            print('<td>');
            if($type == "fournisseur") {
                print('<div class="form-group">
                            <input type="number" name="post_l'.$base.'puht" class="form-control" placeholder="Montant" min="1" max="9999">
                        </div>');
            }
            print('</td>');
            print('<td></td>');
            print('<td></td>');
            print('<td><button name="nlc'.$min.'' . $_GET['licom' . $min . ''] . '" type="submit" class="btn btn-info">Ajouter</button></td>');
            if (isset($_POST['nlc'.$min.'' . $_GET['licom' . $min . ''] . ''])) {
                if($type == "client") {
                    if (!empty($_POST['post_l' . $base . 'setup']) && !empty($_POST['post_l' . $base . 'qte'])) {
                        $res = mysqli_query($db, 'SELECT setup_id FROM setup WHERE setup_code = "' . $_POST['post_l' . $base . 'setup'] . '" ');
                        $ver = mysqli_fetch_array($res);
                        $sql = 'INSERT INTO ligne_commande_'.$type.' set setup_id = "' . $ver[0]. '",l'.$base.'_qte = "' . $_POST['post_l'.$base.'qte']. '",'.$base.'_id = "'. $_GET['licom' . $min . ''].'", tva_id = "1"';
                        mysqli_query($db, $sql);
                        print('<meta http-equiv="refresh" content="0;URL=gestion.php?commande' . $min . '&amp;li'.$base.'=' . $_GET['licom' . $min . ''] . '">');
                    }else{
                        print('</section>
                                <div class="alert alert-danger">
                                    <strong>Danger!</strong> Vous n\'avez pas remplit tous les champs
                                </div >');
                    }
                }else if($type == "fournisseur") {
                    if (!empty($_POST['post_l' . $base . 'libelle']) && !empty($_POST['post_l' . $base . 'qte'])&& !empty($_POST['post_l' . $base . 'puht'])) {
                        $sql = 'INSERT INTO ligne_commande_'.$type.' set l'.$base.'_libelle = "' . $_POST['post_l' . $base . 'libelle'] . '",l'.$base.'_qte = "' . $_POST['post_l'.$base.'qte']. '",'.$base.'_id = "'. $_GET['licom' . $min . ''].'", tva_id = "1", pu_ht = "'.$_POST['post_l' . $base . 'puht'].'"';
                        mysqli_query($db, $sql);
                        print('<meta http-equiv="refresh" content="0;URL=gestion.php?commande' . $min . '&amp;li'.$base.'=' . $_GET['licom' . $min . ''] . '">');
                    }else{
                        print('</section>
                                <div class="alert alert-danger">
                                    <strong>Danger!</strong> Vous n\'avez pas remplit tous les champs
                                </div >');
                    }
                }
            }
            print('</form></tr>');
            print('</tbody>
                </table>');
        }
        if (isset($_GET['supplicom' . $min . ''])) {
            $sql = 'DELETE FROM ligne_commande_'.$type.' WHERE l'.$base.'_id=' . $_GET['supplicom' . $min . ''];
            mysqli_query($db, $sql);
            print('<meta http-equiv="refresh" content="0;URL=gestion.php?commande' . $min . '">');
        }
        print('</br>');
        //fermer la connexion
        mysqli_close($db);
    }

    function ajouter($type){
        require('function/connect.php');
        if($type == "client"){
            $base = "comc";
            $base2 = "cli";
            $min = "c";
            $cfname ="cli_nom";
        }else{
            $base = "comf";
            $base2 = "fou";
            $min = "f";
            $cfname ="fou_rs";
        }
        print('
        <button id="ncommande" class="btn btn-primary" type="button" data-target="#Macommande" data-toggle="collapse"
                aria-expanded="false" aria-controls="MonCollapse">Ajouter une commande
        </button>');
        print('
        <section id="Macommande" class="collapse">
            </br>
            <form method="post" class="form-inline">
                <fieldset>
                    <legend>Commande '.$type.'</legend>
                    <div class="form-group">
                        <input type="text" name="post_'.$base.'titre" class="form-control" placeholder="Entrer le libelle">
                    </div>');
        $listres = mysqli_query($db, 'SELECT '.$cfname.' FROM '.$type.'');
        print(' 
                <div class="form-group">
                    <select class="form-control" name="post_'.$base.'client" title="client">');
        while ($elem = mysqli_fetch_array($listres)) {
            print('<option>' . $elem[0] . '</option>');
        }
        print('</select>
                </div>');
        print('</fieldset>
                </br>
                <button name="nc'.$min.'" type="submit" class="btn btn-primary btn-block">Ajouter</button>');
        if (isset($_POST['nc'.$min.''])) {
            if (!empty($_POST['post_'.$base.'titre']) && !empty($_POST['post_'.$base.'client'])){
                $req = 'SELECT '.$base.'_id FROM commande_'.$type.' WHERE '.$base.'_titre = "' . $_POST['post_'.$base.'titre'] . '" ';
                $res = mysqli_query($db, $req);
                $donnee = mysqli_fetch_array($res);
                //libération des ressources
                mysqli_free_result($res);
                if ($donnee[''.$base.'_id'] == '') {
                    $req = 'SELECT MAX('.$base.'_id) FROM commande_'.$type.'';
                    $result = mysqli_query($db, $req);
                    $code = mysqli_fetch_array($result);
                    $req = 'SELECT '.$base.'_code FROM commande_'.$type.' WHERE '.$base.'_id = ' . $code[0] . ' ';
                    $result = mysqli_query($db, $req);
                    $code = mysqli_fetch_array($result);
                    mysqli_free_result($result);
                    $code = substr($code[0], -2);
                    if ($code == 0) {
                        $code = 0;
                    }
                    $code++;
                    if ($code <= 9) {
                        $code = "0" . $code;
                    }
                    $req = 'SELECT '.$base2.'_id FROM '.$type.' WHERE '.$cfname.' = "' . $_POST['post_'.$base.'client'] . '" ';
                    $res = mysqli_query($db, $req);
                    $donnee = mysqli_fetch_array($res);
                    //libération des ressources
                    mysqli_free_result($res);
                    $sql = 'INSERT INTO commande_'.$type.' set '.$base.'_code = "' . strtoupper($base) . $code . '",'.$base.'_titre = "' . $_POST['post_'.$base.'titre']. '",'.$base.'_date = "' .date("Y-m-d"). '", '.$base2.'_id = "'.$donnee[0].'", '.$base.'_val = "N"';
                    mysqli_query($db, $sql);
                    print('<meta http-equiv="refresh" content="0";URL=gestion.php?commande' . $min . '">');
                    print('</section><div class="alert alert-success">
                                        <strong>Success!</strong> Commande ajouté avec succès
                                    </div>');
                }else{
                    print('</section><div class="alert alert-danger">
                                    <strong>Danger!</strong> Une commande porte déjà ce libelle : '.$donnee[0].'
                                    </div>');
                }
            }else{
                print('</section>
                        <div class="alert alert-danger">
                            <strong>Danger!</strong> Vous n\'avez pas remplit tous les champs du formulaire
                        </div >');
            }
        }
        print('</form>
            </section>');
    }
}
?>