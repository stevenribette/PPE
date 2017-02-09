<?php
function stockage (){
    listeelement();
    nelement();
    listesetup();
        nsetup();
}
function listeelement()
{
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
    //exécution de la requête
    $result = mysqli_query($db, 'SELECT * FROM ordinateur');
    //lecture des resultats
    while ($Row = mysqli_fetch_array($result)) {
        $supp = '<a href="gestion.php?stockage&amp;suppord=' . $Row[0] . '" ><span class="glyphicon glyphicon-remove"></span></a>';
        $modif  = '<div class="form-group">
                    <input type="text" name="clibelle" class="form-control" placeholder="Entrer la designation">
                    </div>';
        print('<tr><td>' . $Row[2] . '</td>
        <td><label class="mb-2 mr-sm-2 mb-sm-0 " id="' . $Row[1] . '">' . $Row[1] . ' </label>
        <button class="btn btn-default btn-sm pull-right" type="button" data-target="#' . $Row[0] . '" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse"><span class="glyphicon glyphicon-pencil"></span></button>
        <section id="' . $Row[0] . '" class="collapse" >
            <form method="post" id="celement" class="form-inline">
                '. $modif .'<button name="celement" type="submit" class="btn btn-info">Modifier</button>');
            if(isset($_POST["celement"])) {
                if (!empty($_POST['clibelle'])) {
                    $sql = 'UPDATE ordinateur
                SET ord_libelle = "'.$_POST['clibelle'].'"
                WHERE ord_id = '. $Row[0];
                    mysqli_query($db, $sql);
                    print('<meta http-equiv="refresh" content="0";URL=gestion.php?stockage#lelement">');
                }
                else{
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
    if (isset($_GET['suppord'])) {
        $sql = 'DELETE FROM ordinateur WHERE ord_id=' . $_GET['suppord'];
        mysqli_query($db, $sql);
        $nom = $_GET['suppord'];
        print('<meta http-equiv="refresh" content="0;URL=gestion.php?stockage#lelement">');
    }
    //libération des ressources
    mysqli_free_result($result);
    //fermer la connexion
    mysqli_close($db);
    ?>
    <tr></tr>
    <?php
    require('function/connect.php');
    //exécution de la requête
    $result = mysqli_query($db, 'SELECT * FROM souris');
    //lecture des resultats
    while ($Row = mysqli_fetch_array($result)) {
        $supp = '<a href="gestion.php?stockage&amp;suppsou=' . $Row[0] . '" >X</a>';
        $modif  = "modifier";
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
    require('function/connect.php');
    //exécution de la requête
    $result = mysqli_query($db, 'SELECT * FROM clavier');
    //lecture des resultats
    while ($Row = mysqli_fetch_array($result)) {
        $supp = '<a href="gestion.php?stockage&amp;suppcla=' . $Row[0] . '" >X</a>';
        $modif  = "modifier";
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
    require('function/connect.php');
    //exécution de la requête
    $result = mysqli_query($db, 'SELECT * FROM ecran');
    //lecture des resultats
    while ($Row = mysqli_fetch_array($result)) {
        $supp = '<a href="gestion.php?stockage&amp;suppecr=' . $Row[0] . '" >X</a>';
        $modif  = "modifier";
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
<?php
}

function nelement(){
    ?><!-- les boutons d'actions -->
    <button class="btn btn-primary" type="button" data-target="#Monnelement" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse">Ajouter un élèment</button>

    <!-- le contenu masqué -->

    <section id="Monnelement" class="collapse">
    </br>
    <form method="post" id="nelement" class="form-inline">
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
                    //libération des ressources
                    mysqli_free_result($result);
                    $code = $code[0];
                    $code++;
                    $sql = 'INSERT INTO ' . $vertype . ' set ' . $debut . '_libelle = "' . $verlibelle . '", ' . $debut . '_code = "' . strtoupper($debut) . $code . '", ' . $debut . '_marque ="'.$_POST['post_marque'].'"';
                    mysqli_query($db, $sql);
                    print('</section><meta http-equiv="refresh" content="1;URL=gestion.php?stockage">');
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
    require('function/connect.php');
    //exécution de la requête
    $result = mysqli_query($db, 'SELECT * FROM setup');
    //lecture des resultats
    while ($Row = mysqli_fetch_array($result)) {
        $supp = '<a href="gestion.php?stockage&amp;suppsetup=' . $Row[0] . '" >X</a>';
        $modutil = '<a href="gestion.php?stockage&amp;modutilsetup=' . $Row[0] . '" >Utiliser</a>';
        $moddispo = '<a href="gestion.php?stockage&amp;moddisposetup=' . $Row[0] . '" >Disponible</a>';
        $modhs = '<a href="gestion.php?stockage&amp;modhssetup=' . $Row[0] . '" >Hors-service</a>';
        $req1 = 'SELECT ord_libelle, ord_code, ord_marque FROM ordinateur WHERE ord_id = "' . $Row[2] . '"';
        $req2 = 'SELECT sou_libelle, sou_code, sou_marque FROM souris WHERE sou_id = "' . $Row[3] . '"';
        $req3 = 'SELECT cla_libelle, cla_code, cla_marque FROM clavier WHERE cla_id = "' . $Row[4] . '"';
        $req4 = 'SELECT ecran_libelle, ecran_code, ecran_marque FROM ecran WHERE ecran_id = "' . $Row[5] . '"';
        $res1 = mysqli_query($db, $req1);
        $res2 = mysqli_query($db, $req2);
        $res3 = mysqli_query($db, $req3);
        $res4 = mysqli_query($db, $req4);
        $ord_ver = mysqli_fetch_array($res1);
        $sou_ver = mysqli_fetch_array($res2);
        $cla_ver = mysqli_fetch_array($res3);
        $ecran_ver = mysqli_fetch_array($res4);
        //libération des ressources
        mysqli_free_result($res1);
        mysqli_free_result($res2);
        mysqli_free_result($res3);
        mysqli_free_result($res4);
        print('<tr id=' . $Row[1] . '><td>' . $Row[1] . '</td><td>
        <div class="dropdown">
          <button class="btn btn-info dropdown-toggle btn-xs btn-block" type="button" data-toggle="dropdown">'. $ord_ver[0] .'
                <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><a title="Code">'. $ord_ver[1] .'</a></li>
            <li><a title="Marque">'. $ord_ver[2] .'</a></li>
          </ul>
        </div>
        </td><td>
        <div class="dropdown">
          <button class="btn btn-info dropdown-toggle btn-xs btn-block" type="button" data-toggle="dropdown">'. $sou_ver[0] .'
                <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><a title="Code">'. $sou_ver[1] .'</a></li>
            <li><a title="Marque">'. $sou_ver[2] .'</a></li>
          </ul>
        </div>
        </td><td>
        <div class="dropdown">
          <button class="btn btn-info dropdown-toggle btn-xs btn-block" type="button" data-toggle="dropdown">'. $cla_ver[0] .'
                <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><a title="Code">'. $cla_ver[1] .'</a></li>
            <li><a title="Marque">'. $cla_ver[2] .'</a></li>
          </ul>
        </div>
        </td><td>
        <div class="dropdown">
          <button class="btn btn-info dropdown-toggle btn-xs btn-block" type="button" data-toggle="dropdown">'. $ecran_ver[0] .'
                <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><a title="Code">'. $ecran_ver[1] .'</a></li>
            <li><a title="Marque">'. $ecran_ver[2] .'</a></li>
          </ul>
        </div>
        </td><td>
        <div class="dropdown">
          <button class="btn btn-info dropdown-toggle btn-xs btn-block" type="button" data-toggle="dropdown">'. $Row[6] .'
                <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><button class="btn btn-info btn-block">'. $modutil .'</button></li>
            <li><button class="btn btn-info btn-block">'. $moddispo .'</button></li>
            <li><button class="btn btn-info btn-block">'. $modhs .'</button></li>
          </ul>
        </div>
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
        ?>

    <!-- les boutons d'actions -->
    <button class="btn btn-primary" type="button" data-target="#Monnsetup" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse">Ajouter un setup</button>

    <!-- le contenu masqué -->
    <section id="Monnsetup" class="collapse">
        </br>
        <form method="post" id="nsetup" class="form-inline">
            <div class="form-group">
                <label class="sr-only">Ordinateur</label>
                <select class="form-control" name="post_ord">
                    <?php
                    require('function/connect.php');
                    $result1 = mysqli_query($db, 'SELECT ord_id, ord_code as CODE FROM ordinateur WHERE NOT EXISTS(SELECT null FROM setup WHERE setup.ord_id = ordinateur.ord_id)');
                    while ($Row1 = mysqli_fetch_array($result1)) {
                        print('<option>' . $Row1['CODE'] . '</option>');
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="sr-only">Souris</label>
                <select class="form-control" name="post_sou">
                    <?php
                    require('function/connect.php');
                    //exécution de la requête
                    $result2 = mysqli_query($db, 'SELECT sou_id, sou_code as CODE FROM souris WHERE NOT EXISTS(SELECT null FROM setup WHERE setup.sou_id = souris.sou_id)');
                    //lecture des resultats
                    while ($Row2 = mysqli_fetch_array($result2)) {
                        print('<option>' . $Row2['CODE'] . '</option>');
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="sr-only">Clavier</label>
                <select class="form-control" name="post_cla">
                    <?php
                    require('function/connect.php');
                    //exécution de la requête
                    $result3 = mysqli_query($db, 'SELECT cla_id, cla_code as CODE FROM clavier WHERE NOT EXISTS(SELECT null FROM setup WHERE setup.cla_id = clavier.cla_id)');
                    //lecture des resultats
                    while ($Row3 = mysqli_fetch_array($result3)) {
                        print('<option>' . $Row3['CODE'] . '</option>');
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="sr-only">Ecran</label>
                <select class="form-control" name="post_ecran">
                    <?php
                    require('function/connect.php');
                    //exécution de la requête
                    $result4 = mysqli_query($db, 'SELECT ecran_id, ecran_code as CODE FROM ecran WHERE NOT EXISTS(SELECT null FROM setup WHERE setup.ecran_id = ecran.ecran_id)');
                    //lecture des resultats
                    while ($Row4 = mysqli_fetch_array($result4)) {
                        print('<option>' . $Row4['CODE'] . '</option>');
                    }
                    ?>
                </select>
            </div>
            <button name="nsetup" type="submit" class="btn btn-primary">Ajouter</button>
            <?php
            require('function/connect.php');
            if (isset($_POST['nsetup'])){
                if(empty($_POST['post_ord']) || empty($_POST['post_sou']) || empty($_POST['post_cla']) || empty($_POST['post_ecran'])){
                    print('</section><div class="alert alert-danger">
                            <strong>Danger!</strong> Un setup doit être constituer d\'un ordinateur, d\'une souris, d\'un clavier, et d\'un écran 
                            </div>');
                } else {
                    $req1 = 'SELECT ord_id FROM ordinateur WHERE ord_code = "' . $_POST['post_ord'] . '"';
                    $req2 = 'SELECT sou_id FROM souris WHERE sou_code = "' . $_POST['post_sou'] . '"';
                    $req3 = 'SELECT cla_id FROM clavier WHERE cla_code = "' . $_POST['post_cla'] . '"';
                    $req4 = 'SELECT ecran_id FROM ecran WHERE ecran_code = "' . $_POST['post_ecran'] . '"';
                    $res1 = mysqli_query($db, $req1);
                    $res2 = mysqli_query($db, $req2);
                    $res3 = mysqli_query($db, $req3);
                    $res4 = mysqli_query($db, $req4);
                    $ord_ver = mysqli_fetch_array($res1);
                    $sou_ver = mysqli_fetch_array($res2);
                    $cla_ver = mysqli_fetch_array($res3);
                    $ecran_ver = mysqli_fetch_array($res4);
                    //libération des ressources
                    mysqli_free_result($res1);
                    mysqli_free_result($res2);
                    mysqli_free_result($res3);
                    mysqli_free_result($res4);
                    $req = 'SELECT MAX(setup_id) FROM setup';
                    $result = mysqli_query($db, $req);
                    $code = mysqli_fetch_array($result);
                    $code = $code[0];
                    if ($code == null){
                        $code = 0;
                    }
                    $code++;
                    $sql = 'INSERT INTO setup set setup_code = "' . strtoupper("set") . $code . '", ord_id = "' . $ord_ver[0] . '", sou_id = "'. $sou_ver[0] . '", cla_id = "' . $cla_ver[0] . '", ecran_id = "' . $ecran_ver[0] . '", etat = "disponible"';
                    mysqli_query($db, $sql);
                    print('<meta http-equiv="refresh" content="1;URL=gestion.php?stockage#lsetup">');
                    print('</section><div class="alert alert-success">
                              <strong>Success!</strong> Nouveau setup ajouter à la base
                                </div>');
                }
                //fermer la connexion
                mysqli_close($db);
            }
            ?>
        </form>
        </section>
        </br>
    </div>
    <?php
}
?>