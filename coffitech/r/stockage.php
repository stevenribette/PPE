<?php
function stockage (){
    listeelement();
    nelement();
    listesetup();
        nsetup();
}
function listeelement()
{
    $materiel = array("ordinateur","souris","clavier","ecran");
    $base = array("ord","sou","cla","ecran");
    ?>
    <div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-6">
            <form method="get" class="search-form">
                <div class="form-group has-feedback">
                    <label class="sr-only">Recherche</label>
                    <input type="text" name="post_search" class="form-control" id="search" placeholder="Recherche">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
                <?php
                require('function/connect.php');
                if (count($_GET) > 0) {
                    if (!empty($_GET['post_search'])) {
                        $versearch = $_GET['post_search'];
                        $reqord = 'SELECT ord_id FROM ordinateur WHERE ord_libelle LIKE ' % $versearch % ' ';
                        $reqsou = 'SELECT sou_id FROM souris WHERE sou_libelle LIKE ' % $versearch % ' ';
                        $reqcla = 'SELECT cla_id FROM clavier WHERE cla_libelle LIKE ' % $versearch % ' ';
                        $reqecran = 'SELECT ecran_id FROM ecran WHERE ecran_libelle LIKE ' % $versearch % ' ';
                        $resord = mysqli_query($db, $reqord);
                        $ressou = mysqli_query($db, $reqsou);
                        $rescla = mysqli_query($db, $reqcla);
                        $resecran = mysqli_query($db, $reqecran);
                        $query = mysqli_query($db, $reqord, $reqsou, $reqcla, $reqecran);
                        echo($query);
                        $donnee = mysqli_fetch_array($resord, $ressou, $rescla, $resecran);

                        $verif = mysql_num_rows($query);
                        if ($verif != 0) {

                        }
                        //libération des ressources
                        mysqli_free_result($resord);
                        if ($donnee['ord_id'] == '') {
                            if ($donnee['sou_id'] == '') {
                                if ($donnee['cla_id'] == '') {
                                    if ($donnee['ecran_id'] == '') {
                                        if ($_GET['post_search'] != '') {
                                            print('<div class="alert alert-warning">
                                            <strong>Attention!</strong> Aucun élément ne porte déjà cette dénomination
                                            </div>');
                                        }
                                    }
                                }
                            }
                        } else {
                            print('<div class="alert alert-warning">
                            <strong>Attention!</strong> Vous n\'avez effectué aucune recherche
                            </div>');
                        }
                        print('<tr id=' . $Row[1] . '><td>' . $Row[2] . '</td><td>' . $Row[1] . '</td><td>' . $Row[3] . '</td><td>' . $supp . '</td></tr>');
                    } else {
                    }
                    //fermer la connexion
                    mysqli_close($db);
                }
                ?>
            </form>
        </div>
    </div>
    <table class="table table-striped" id="lelement">
    <thead>
    <tr>
        <th>Code</th>
        <th>Designation</th>
        <th>Marque</th>
        <th>Effacer</th>
    </tr>
    </thead>
    <tbody>
    <?php
    require('function/connect.php');
    $i = 0;
    while ($i < count($materiel)) {
        //exécution de la requête
        $result = mysqli_query($db, 'SELECT * FROM '.$materiel[$i].' ORDER BY '.$base[$i].'_id DESC ');
        //lecture des resultats
        while ($Row = mysqli_fetch_array($result)) {
            $supp = '<a href="gestion.php?stockage&amp;supp'.$base[$i].'=' . $Row[0] . '" ><span class="glyphicon glyphicon-remove"></span></a>';
            $modif = '<div class="form-group">
                    <input type="text" name="'.$base[$i].'libelle" class="form-control" placeholder="Entrer la designation">
                    </div>';
            print('<tr><td>' . $Row[2] . '</td>
        <td><label class="mb-2 mr-sm-2 mb-sm-0 " id="' . $Row[1] . '">' . $Row[1] . ' </label>
        <button class="btn btn-default btn-sm pull-right" type="button" data-target="#' . $Row[0] . '" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse"><span class="glyphicon glyphicon-pencil"></span></button>
        <section id="' . $Row[0] . '" class="collapse" >
            <form method="post" id="'.$base[$i].'element" class="form-inline">
                ' . $modif . '<button name="'.$base[$i].'element" type="submit" class="btn btn-info">Modifier</button>');
            if (isset($_POST[''.$base[$i].'element'])) {
                if (!empty($_POST[''.$base[$i].'libelle'])) {
                    $sql = 'UPDATE '.$materiel[$i].'
                SET '.$base[$i].'_libelle = "' . $_POST[''.$base[$i].'libelle'] . '"
                WHERE '.$base[$i].'_id = ' . $Row[0];
                    mysqli_query($db, $sql);
                    print('<meta http-equiv="refresh" content="0";URL=gestion.php?stockage#lelement">');
                } else {
                    print('</section><div class="alert alert-danger">
                            <strong>Danger!</strong> Vous n\'avez pas indiquez la désignation
                            </div>');
                }
            }
            print('
            </form>
        </section>
        </td>
        <td>' . $Row[3] . '</td>
        <td>' . $supp . '</td></tr>');
        }
        if (isset($_GET['supp'.$base[$i].''])) {
            $sql = 'DELETE FROM '.$materiel[$i].' WHERE '.$base[$i].'_id=' . $_GET['supp'.$base[$i].''];
            mysqli_query($db, $sql);
            $nom = $_GET['supp'.$base[$i].''];
            print('<meta http-equiv="refresh" content="0;URL=gestion.php?stockage#lelement">');
        }
        $i++;
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

function nelement(){
    ?><!-- les boutons d'actions -->
    <button id="nelement" class="btn btn-primary" type="button" data-target="#Monnelement" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse">Ajouter un élèment</button>

    <!-- le contenu masqué -->

    <section id="Monnelement" class="collapse">
    </br>
    <form method="post" class="form-inline">
        <div class="form-group">
            <label class="sr-only">Type</label>
            <select class="form-control mb-2 mr-sm-2 mb-sm-0" name="post_type">
                <option>ordinateur</option>
                <option>souris</option>
                <option>clavier</option>
                <option>ecran</option>
            </select>
        </div>
        <div class="form-group">
            <label class="sr-only mb-2 mr-sm-2 mb-sm-0">Libelle</label>
            <input type="text" name="post_libelle" class="form-control" placeholder="Entrer la designation">
        </div>
        <div class="form-group">
            <label class="sr-only mb-2 mr-sm-2 mb-sm-0">Marque</label>
            <input type="text" name="post_marque" class="form-control" placeholder="Entrer la marque">
        </div>
        <button name="nelement" type="submit" class="btn btn-primary">Ajouter</button>
        <?php
        require('function/connect.php');
        if (isset($_POST['nelement'])) {
            if (!empty($_POST['post_libelle'])) {
                if (!empty($_POST['post_marque'])) {
                if ($_POST['post_type'] == "ordinateur") {
                    $debut = "ord";
                } else if ($_POST['post_type'] == "souris") {
                    $debut = "sou";
                } else if ($_POST['post_type'] == "clavier") {
                    $debut = "cla";
                } else if ($_POST['post_type'] == "ecran") {
                    $debut = "ecran";
                }
                $verlibelle = $_POST['post_libelle'];
                $vertype = $_POST['post_type'];
                $req = 'SELECT ' . $debut . '_libelle FROM ' . $vertype . ' WHERE ' . $debut . '_libelle = "' . $verlibelle . '"';
                $res = mysqli_query($db, $req);
                $donnee = mysqli_fetch_array($res);
                //libération des ressources
                mysqli_free_result($res);
                if ($donnee[$debut . '_libelle'] == '') {
                    $req = 'SELECT MAX(' . $debut . '_id) FROM ' . $vertype . '';
                    $result = mysqli_query($db, $req);
                    $code = mysqli_fetch_array($result);
                    $req = 'SELECT ' . $debut . '_code FROM ' . $vertype . ' WHERE ' . $debut . '_id = '.$code[0].'';
                    $result = mysqli_query($db, $req);
                    $code = mysqli_fetch_array($result);
                    //libération des ressources
                    mysqli_free_result($result);
                    $code = substr($code[0], -2);
                    if($code == 0){
                        $code = 0;
                    }
                    $code++;
                    if ($code <= 9){
                        $code = "0" . $code;
                    }
                    $sql = 'INSERT INTO ' . $vertype . ' set ' . $debut . '_libelle = "' . $verlibelle . '", ' . $debut . '_code = "' . strtoupper($debut) . $code . '", ' . $debut . '_marque ="'.$_POST['post_marque'].'"';
                    mysqli_query($db, $sql);
                    print('</section><meta http-equiv="refresh" content="1;URL=gestion.php?stockage#lelement">');
                    print('<div class="alert alert-success">
                              <strong>Success!</strong> Nouvel élélement ajouter à la base
                                </div>');
                } else {
                    print('</section><div class="alert alert-danger">
                            <strong>Danger!</strong> Un élément existant porte déjà ce nom
                            </div>');
                }
            }else{
                print('</section><div class="alert alert-danger">
                        <strong>Danger!</strong> Vous n\'avez pas indiquez la marque
                        </div>');
                }
            } else {
                print('</section><div class="alert alert-danger">
                            <strong>Danger!</strong> Vous n\'avez pas indiquez la désignation
                            </div>');
            }
            //fermer la connexion
            mysqli_close($db);
        }
        ?>
    </form>
    </section>
    </br>
    <?php
}
function listesetup(){
    ?>
    <table class="table table-striped" id="lsetup">
    <thead>
    <tr>
        <th>Code</th>
        <th>Ordinateur</th>
        <th>Souris</th>
        <th>Clavier</th>
        <th>Ecran</th>
        <th>Etat</th>
        <th>Effacer</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $materiel = array("ordinateur", "souris", "clavier", "ecran");
    $base = array("ord", "sou", "cla", "ecran");
    require('function/connect.php');
    //exécution de la requête
    $result = mysqli_query($db, 'SELECT * FROM setup');
    //lecture des resultats
    while ($Row = mysqli_fetch_array($result)) {
        $supp = '<a href="gestion.php?stockage&amp;suppsetup=' . $Row[0] . '" ><span class="glyphicon glyphicon-remove"></span></a>';
        $modutil = '<a href="gestion.php?stockage&amp;modutilsetup=' . $Row[0] . '" >Utiliser</a>';
        $moddispo = '<a href="gestion.php?stockage&amp;moddisposetup=' . $Row[0] . '" >Disponible</a>';
        $modhs = '<a href="gestion.php?stockage&amp;modhssetup=' . $Row[0] . '" >Hors-service</a>';
        print('<tr id=' . $Row[1] . '><td>' . $Row[1] . '</td>');
        $i = 0;
        while ($i < count($materiel)) {
            $req = 'SELECT ' . $base[$i] . '_libelle, ' . $base[$i] . '_code, ' . $base[$i] . '_marque FROM ' . $materiel[$i] . ' WHERE ' . $base[$i] . '_id = "' . $Row[$i+2] . '"';
            $res = mysqli_query($db, $req);
            $ver = mysqli_fetch_array($res);
            print('<td>
            <div class="dropdown">
              <button class="btn btn-info dropdown-toggle btn-xs btn-block" type="button" data-toggle="dropdown">' . $ver[0] . '
                    <span class="caret"></span></button>
              <ul class="dropdown-menu">
                <li><a title="Code">' . $ver[1] . '</a></li>
                <li><a title="Marque">' . $ver[2] . '</a></li>
              </ul>
            </div></td>');

            if($ver[1] == null){
                $sql = 'UPDATE setup
                SET etat = "hors-service"
                WHERE setup_id = '. $Row[0] .' ';
                mysqli_query($db, $sql);
            }

            $i++;
        }
        //libération des ressources
        mysqli_free_result($res);
        print('<td><div class="dropdown" id="set">
          <button class="btn btn-info dropdown-toggle btn-xs btn-block" type="button" data-toggle="dropdown">'. $Row[6] .'
                <span class="caret"></span></button>');
        if($ver[1] != null) {
            print('<ul class="dropdown-menu">
            <li><button class="btn btn-info btn-block">' . $modutil . '</button></li>
            <li><button class="btn btn-info btn-block">' . $moddispo . '</button></li>
            <li><button class="btn btn-info btn-block">' . $modhs . '</button></li>
          </ul>');
        }
        print('</div>
        </td><td>' . $supp . '</td></tr>');
    }
    if(isset($_GET["modutilsetup"])) {
        $sql = 'UPDATE setup
        SET etat = "utiliser"
        WHERE setup_id = '. $_GET['modutilsetup'].' ';
        mysqli_query($db, $sql);
        print('<meta http-equiv="refresh" content="0;URL=gestion.php?stockage#lsetup">');
    }
    if(isset($_GET["moddisposetup"])) {
        $sql = 'UPDATE setup
        SET etat = "disponible"
        WHERE setup_id = '. $_GET['moddisposetup'].' ';
        mysqli_query($db, $sql);
        print('<meta http-equiv="refresh" content="0;URL=gestion.php?stockage#lsetup">');
    }
    if(isset($_GET["modhssetup"])) {
        $sql = 'UPDATE setup
        SET etat = "hors-service"
        WHERE setup_id = '. $_GET['modhssetup'].' ';
        mysqli_query($db, $sql);
        print('<meta http-equiv="refresh" content="0;URL=gestion.php?stockage#lsetup">');
    }
    if (isset($_GET['suppsetup'])) {
        $sql = 'DELETE FROM setup WHERE setup_id=' . $_GET['suppsetup'];
        mysqli_query($db, $sql);
        print($_GET['suppsetup']);
        print('<meta http-equiv="refresh" content="0;URL=gestion.php?stockage#lsetup">');
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
function nsetup(){
    $materiel = array("ordinateur", "souris", "clavier", "ecran");
    $base = array("ord", "sou", "cla", "ecran");
    $verlist = array(1,2,3,4);
        ?>

    <!-- les boutons d'actions -->
    <button id="nsetup" class="btn btn-primary" type="button" data-target="#Monnsetup" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse">Ajouter un setup</button>

    <!-- le contenu masqué -->
    <section id="Monnsetup" class="collapse">
        </br>
        <form method="post" class="form-inline">
            <?php
            $i=0;
            while ($i < count($materiel)) {

                print('<div class="form-group">
                    <label class="sr-only">'.$materiel[$i].'</label>
                    <select class="form-control" name="post_'.$base[$i].'">');
                        require('function/connect.php');
                        $result = mysqli_query($db, 'SELECT '.$base[$i].'_id, '.$base[$i].'_code as CODE FROM '.$materiel[$i].' WHERE NOT EXISTS(SELECT null FROM setup WHERE setup.'.$base[$i].'_id = '.$materiel[$i].'.'.$base[$i].'_id)');
                        while ($Row = mysqli_fetch_array($result)) {
                            print('<option>' . $Row['CODE'] . '</option>');
                        }
                    print('
                        </select>
                        </div>');
            $i++;}
            ?>
            <button name="nsetup" type="submit" class="btn btn-primary">Ajouter</button>
            <?php
            require('function/connect.php');
            if (isset($_POST['nsetup'])){
                if(empty($_POST['post_ord']) || empty($_POST['post_sou']) || empty($_POST['post_cla']) || empty($_POST['post_ecran'])){
                    print('</section><div class="alert alert-danger">
                            <strong>Danger!</strong> Un setup doit être constituer d\'un ordinateur, d\'une souris, d\'un clavier, et d\'un écran 
                            </div>');
                } else {
                    $i=0;
                    while ($i < count($materiel)) {
                        $req = 'SELECT ' . $base[$i] . '_id FROM ' . $materiel[$i] . ' WHERE ' . $base[$i] . '_code = "' . $_POST['post_' . $base[$i] . ''] . '"';
                        $res = mysqli_query($db, $req);
                        $ver = mysqli_fetch_array($res);
                        $verlist[$i] = $ver[0];
                        $i++;
                    }
                    //libération des ressources
                    mysqli_free_result($res);
                    $req = 'SELECT MAX(setup_id) FROM setup';
                    $result = mysqli_query($db, $req);
                    $code = mysqli_fetch_array($result);
                    $req = 'SELECT setup_code FROM setup WHERE setup_id = '.$code[0].' ';
                    $result = mysqli_query($db, $req);
                    $code = mysqli_fetch_array($result);
                    mysqli_free_result($result);
                    $code = substr($code[0], -2);
                    if($code == 0){
                        $code = 0;
                    }
                    $code++;
                    if ($code <= 9){
                        $code = "0" . $code;
                    }
                    $sql = 'INSERT INTO setup set setup_code = "' . strtoupper("set") . $code . '", ord_id = "' . $verlist[0] . '", sou_id = "'. $verlist[1] . '", cla_id = "' . $verlist[2] . '", ecran_id = "' . $verlist[3] . '", etat = "disponible"';
                    mysqli_query($db, $sql);
                    print('</section><div class="alert alert-success">
                              <strong>Success!</strong> Nouveau setup ajouter à la base
                                </div>');
                    print('<meta http-equiv="refresh" content="1";URL=gestion.php?stockage#lsetup">');
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
?>