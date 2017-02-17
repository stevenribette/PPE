<?php
function caisse(){
    $caisse = new caisse;
    print('<div class="container">');
    print('<div class="col-sm-6">');
    $caisse->lticket();
    print('</div>');
    print('<div class="col-sm-6">');
    $caisse->nticket();
    print('</div>');
    print('</div>');
}
class caisse{
    function lticket(){
        ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Code</th>
                <th>Date</th>
                <th>Produit</th>
                <th>Qte</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody id="lticket">
            <?php
            require('function/connect.php');
            //exécution de la requête
            $result = mysqli_query($db, 'SELECT * FROM ticket ORDER BY tic_id DESC ');
            //lecture des resultats
            while ($Row = mysqli_fetch_array($result)) {
                print('
                <tr id="#tic'.$Row[0].'">
                <td>' . $Row[1] . '</td>
                <td>' . $Row[2] . '</td>');
                $req = mysqli_query($db, 'SELECT pdt_libelle FROM produit WHERE pdt_id =' . $Row[3] . ' ');
                $code = mysqli_fetch_array($req);
                print('<td>' . $code[0] . '</td>
                <td>' . $Row[4] . '</td>');
                $req = mysqli_query($db, 'SELECT pdt_pu_ht FROM produit WHERE pdt_id =' . $Row[3] . ' ');
                $code = mysqli_fetch_array($req);
                $puht = $code[0];
                $res = mysqli_query($db, 'SELECT tva_taux FROM tva WHERE tva_id = "' . $Row[5] . '" ');
                $ver = mysqli_fetch_array($res);
                $total = $Row[4] * $puht;
                $tva = ($total / 100) * $ver[0] ;
                $total = $total + $tva;
                print('<td>' . $total . '</td>');
                print('<td></td>');
                print('</tr>
                ');
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
    function nticket(){
        require('function/connect.php');
        print('
        <form method="post" class="form-inline" id="nticket">
            <fieldset>
                <legend>Ajouter un ticket</legend>
                <div class="form-group">
                    <input type="number" name="post_ticqte" class="form-control" placeholder="Quantité" min="1" max="9999">
                </div>');
                print('<div class="form-group">
                    <select class="form-control" name="post_ticpdt">');
                    $listres = mysqli_query($db, 'SELECT pdt_libelle FROM produit');
                        while ($elem = mysqli_fetch_array($listres)) {
                        print('<option>' . $elem[0] . '</option>');
                        }
                    print('</select>
                </div>
            </br></br>
            <button name="ntic" type="submit" class="btn btn-primary btn-block">Ajouter</button>
            </fieldset>');
        if (isset($_POST['ntic'])) {
            if (!empty($_POST['post_ticqte']) && !empty($_POST['post_ticpdt'])){
                $req = 'SELECT pdt_qte FROM produit WHERE pdt_libelle = "' . $_POST['post_ticpdt'] . '" ';
                $res = mysqli_query($db, $req);
                $donnee = mysqli_fetch_array($res);
                //libération des ressources
                mysqli_free_result($res);
                if ($donnee['pdt_qte'] > $_POST['post_ticqte']) {
                    $req = 'SELECT MAX(tic_id) FROM ticket';
                    $result = mysqli_query($db, $req);
                    $code = mysqli_fetch_array($result);
                    $req = 'SELECT tic_code FROM ticket WHERE tic_id = ' . $code[0] . ' ';
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
                    $res = mysqli_query($db, 'SELECT pdt_id FROM produit WHERE pdt_libelle = "' . $_POST['post_ticpdt'] . '" ');
                    $ver = mysqli_fetch_array($res);
                    $sql = 'INSERT INTO ticket SET tic_code = "' . strtoupper("tic") . $code . '", tic_date = "' .date("Y-m-d"). '",pdt_id = "' . $ver[0] . '",ltic_qte = "' . $_POST['post_ticqte'] . '",tva_id = "1"';
                    mysqli_query($db, $sql);
                    print('</section><meta http-equiv="refresh" content="10;URL=gestion.php?caisse#lticket">');
                    print('
                            <div class="alert alert-success">
                                <strong>Success!</strong> ticket ajouté avec succès
                            </div>');
                }else{
                    print('<div class="alert alert-danger">
                        <strong>Danger!</strong> Il ne reste pas assez de ce produit en stock
                        </div>');
                }
            }else{
                print('
                        <div class="alert alert-danger">
                            <strong>Danger!</strong> Vous n\'avez pas indiqué la quantité
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
}
?>
