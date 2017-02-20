<?php
function produit(){
    $produit = new produit;
    print('<div class="container">');
    print('<div class="col-sm-6">');
    $produit->lproduit();
    print('</div>');
    print('<div class="col-sm-6">');
    $produit->nproduit();
    $produit->ncategorie();
    $produit->dcategorie();
    print('</div>');
    print('</div>');
}
class produit{
    function lproduit()
    {
        ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Libelle</th>
                <th>Qte</th>
                <th>PU.HT</th>
                <th>Categorie</th>
                <th>Modifier</th>
                <th>Effacer</th>
            </tr>
            </thead>
            <tbody id="lproduit">
            <?php
            require('function/connect.php');
            //exécution de la requête
            $result = mysqli_query($db, 'SELECT * FROM produit ORDER BY pdt_id DESC ');
            //lecture des resultats
            while ($Row = mysqli_fetch_array($result)) {
                $supp = '<a href="gestion.php?produit&amp;supppdt=' . $Row[0] . '" ><span class="glyphicon glyphicon-remove"></span></a>';
                print('
                <tr id="#pdt'.$Row[0].'">
                <form method="post" id="mpdt' . $Row[0] . '" class="form-inline">
                <td>' . $Row[1] . '
                    <section class="pdt' . $Row[0] . ' collapse" >   
                    <div class="form-group">
                        <input type="text" name="pdtlibelle" class="form-control" value="' . $Row[1] . '" placeholder="Entrer le libelle">
                    </div>');
                print('
                </section>
                </td>
                <td>' . $Row[2] . '
                <section class="pdt' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="number" name="pdtqte" class="form-control" placeholder="Quantité" value="'.$Row[2].'" min="0" max="9999">
                    </div>
                </section>
                </td>
                <td>' . $Row[3] . '
                <section class="pdt' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <input type="number" name="pdtpuht" class="form-control" placeholder="Montant" value="'.$Row[3].'" min="0" max="9999">
                    </div>
                </section>
                </td>');
                $listres = mysqli_query($db, 'SELECT cat_libelle FROM categorie');
                $res = mysqli_query($db, 'SELECT cat_libelle FROM categorie WHERE cat_id = "'.$Row[4].'" ');
                $ver = mysqli_fetch_array($res);
                print('
                <script>$(function(){
                    $(\'select[value]\').each(function(){
                        $(this).val(this.getAttribute("value"));
                    });
                });</script>
                <td>' . $ver[0] . '
                <section class="pdt' . $Row[0] . ' collapse" >   
                <div class="form-group">
                    <select class="form-control" name="pdtcat" value="' . $ver[0] . '">');
                    while ($elem = mysqli_fetch_array($listres)) {
                        print('<option>' . $elem[0] . '</option>');
                    }
                print('</select>
                </div>
                </section>
                </td>
                <td>
                    <a data-target=".pdt' . $Row[0] . '" data-toggle="collapse" aria-expanded="false" aria-controls="MonCollapse"><span class="glyphicon glyphicon-edit"></span></a>
                    <section class="pdt' . $Row[0] . ' collapse" >
                        <button name="mpdt' . $Row[0] . '" type="submit" class="btn btn-info">Modifier</button>
                    </section>
                </td>');
                if (isset($_POST['mpdt' . $Row[0] . ''])) {
                    if (!empty($_POST['pdtlibelle']) && !empty($_POST['pdtqte']) && !empty($_POST['pdtpuht']) && !empty($_POST['pdtcat'])){
                        $res = mysqli_query($db, 'SELECT cat_id FROM categorie WHERE cat_libelle = "' . $_POST['pdtcat'] . '" ');
                        $ver = mysqli_fetch_array($res);
                        $sql = 'UPDATE produit
                                SET pdt_libelle = "' . $_POST['pdtlibelle'] . '", pdt_qte = "' . $_POST['pdtqte'] . '",pdt_pu_ht = "' . $_POST['pdtpuht'] . '",cat_id = "' . $ver[0] . '" 
                                WHERE pdt_id = ' . $Row[0];
                        mysqli_query($db, $sql);
                        print('<meta http-equiv="refresh" content="0";URL=gestion.php?produit#lproduit">');
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
            if (isset($_GET['supppdt'])) {
                $sql = 'DELETE FROM produit WHERE pdt_id=' . $_GET['supppdt'];
                mysqli_query($db, $sql);
                print('<meta http-equiv="refresh" content="0;URL=gestion.php?produit#lproduit">');
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

    function nproduit()
    {
        require('function/connect.php');
        print('
        <form method="post" class="form-inline" id="nproduit">
            <fieldset>
                <legend>Ajouter un produit</legend>
                <div class="form-group">
                    <input type="text" name="post_pdtlibelle" class="form-control" placeholder="Entrer le libelle">
                </div>
                <div class="form-group">
                    <input type="number" name="post_pdtqte" class="form-control" placeholder="Quantité" min="0" max="9999">
                </div>
                <div class="form-group">
                    <input type="number" name="post_pdtpuht" class="form-control" placeholder="Montant" min="0" max="9999">
                </div>
                <div class="form-group">
                    <select class="form-control" name="post_pdtcat">');
                    $listres = mysqli_query($db, 'SELECT cat_libelle FROM categorie');
                        while ($elem = mysqli_fetch_array($listres)) {
                        print('<option>' . $elem[0] . '</option>');
                        }
                    print('</select>
                </div>
            </br></br>
            <button name="npdt" type="submit" class="btn btn-primary btn-block">Ajouter</button>
            </fieldset>');
            if (isset($_POST['npdt'])) {
                if (!empty($_POST['post_pdtlibelle']) && !empty($_POST['post_pdtqte']) && !empty($_POST['post_pdtpuht']) && !empty($_POST['post_pdtcat'])){
                    $req = 'SELECT pdt_id FROM produit WHERE pdt_libelle = "' . $_POST['post_pdtlibelle'] . '" ';
                    $res = mysqli_query($db, $req);
                    $donnee = mysqli_fetch_array($res);
                    //libération des ressources
                    mysqli_free_result($res);
                    if ($donnee['pdt_id'] == '') {
                            $res = mysqli_query($db, 'SELECT cat_id FROM categorie WHERE cat_libelle = "' . $_POST['post_pdtcat'] . '" ');
                            $ver = mysqli_fetch_array($res);
                            $sql = 'INSERT INTO produit
                                    SET pdt_libelle = "' . $_POST['post_pdtlibelle'] . '", pdt_qte = "' . $_POST['post_pdtqte'] . '",pdt_pu_ht = "' . $_POST['post_pdtpuht'] . '",cat_id = "' . $ver[0] . '"';
                            mysqli_query($db, $sql);
                            print('</section><meta http-equiv="refresh" content="1;URL=gestion.php?produit#lproduit">');
                            print('
                            <div class="alert alert-success">
                                <strong>Success!</strong> produit ajouté avec succès
                            </div>');
                    }else{
                        print('<div class="alert alert-danger">
                        <strong>Danger!</strong> Un produit porte déjà ce libelle : '.$donnee[0].'
                        </div>');
                    }
                }else{
                    print('
                        <div class="alert alert-danger">
                            <strong>Danger!</strong> Vous n\'avez pas remplit tous les champs du formulaire
                        </div >');
                }
                //fermer la connexion
                mysqli_close($db);
            }
            ?>
        </form>
        </br>
        <?php
    }

    function ncategorie()
    {
        require('function/connect.php');
        print('
        <form method="post" class="form-inline">
            <fieldset>
                <legend>Ajouter une categorie</legend>
                <div class="form-group">
                    <input type="text" name="post_catlibelle" class="form-control" placeholder="Entrer le libelle">
                </div>
            </br></br>
            <button name="ncat" type="submit" class="btn btn-primary btn-block">Ajouter</button>
            </fieldset>');
        if (isset($_POST['ncat'])) {
            if (!empty($_POST['post_catlibelle'])){
                $req = 'SELECT cat_id FROM categorie WHERE cat_libelle = "' . $_POST['post_catlibelle'] . '" ';
                $res = mysqli_query($db, $req);
                $donnee = mysqli_fetch_array($res);
                //libération des ressources
                mysqli_free_result($res);
                if ($donnee['cat_id'] == '') {
                    $sql = 'INSERT INTO categorie
                                    SET cat_libelle = "' . $_POST['post_catlibelle'] . '"';
                    mysqli_query($db, $sql);
                    print('</section><meta http-equiv="refresh" content="1;URL=gestion.php?produit#lcategorie">');
                    print('
                            <div class="alert alert-success">
                                <strong>Success!</strong> Catégorie ajouté avec succès
                            </div>');
                }else{
                    print('<div class="alert alert-danger">
                        <strong>Danger!</strong> Une catégorie porte déjà ce libelle : '.$donnee[0].'
                        </div>');
                }
            }else{
                print('
                        <div class="alert alert-danger">
                            <strong>Danger!</strong> Vous n\'avez pas remplit tous les champs du formulaire
                        </div >');
            }
            //fermer la connexion
            mysqli_close($db);
        }
        ?>
        </form>
        </br>
        <?php
    }
    function dcategorie()
    {
        require('function/connect.php');
        print('
        <form method="post" class="form-inline">
            <fieldset>
                <legend>Supprimer une categorie</legend>
                <div class="form-group">
                    <select class="form-control" name="post_dcat">');
                    $listres = mysqli_query($db, 'SELECT cat_libelle FROM categorie');
                        while ($elem = mysqli_fetch_array($listres)) {
                        print('<option>' . $elem[0] . '</option>');
                        }
                    print('</select>
                </div>
            </br></br>
            <button name="dcat" type="submit" class="btn btn-primary btn-block">Supprimer</button>
            </fieldset>');
        if (isset($_POST['dcat'])) {
            if (!empty($_POST['post_dcat'])){
                $req = 'SELECT cat_id FROM categorie WHERE cat_libelle = "' . $_POST['post_dcat'] . '" ';
                $res = mysqli_query($db, $req);
                $donnee = mysqli_fetch_array($res);
                $req = 'SELECT pdt_id FROM produit WHERE cat_id = "' . $donnee[0] . '" ';
                $res = mysqli_query($db, $req);
                $donnee2 = mysqli_fetch_array($res);
                //libération des ressources
                mysqli_free_result($res);
                if ($donnee2['pdt_id'] == '') {
                    $sql = 'DELETE FROM categorie WHERE cat_id=' . $donnee[0];
                    mysqli_query($db, $sql);
                    print('</section><meta http-equiv="refresh" content="1;URL=gestion.php?produit#lcategorie">');
                    print('
                            <div class="alert alert-success">
                                <strong>Success!</strong> Catégorie supprimer avec succès
                            </div>');
                }else{
                    print('<div class="alert alert-danger">
                        <strong>Danger!</strong> Un produit fait partie de cette categorie : ' . $_POST['post_dcat'] . '
                        </div>');
                }
            }else{
                print('<div class="alert alert-warning">
                    <strong>Attention</strong> Aucune categorie n\'a pu être selectioner
                    </div>');
            }
        //fermer la connexion
        mysqli_close($db);
        }
        ?>
        </form>
        </br>
        <?php
    }
}
?>