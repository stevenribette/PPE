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
        require('function/connect.php');
        //exécution de la requête
        $result = mysqli_query($db, 'SELECT * FROM commande_'.$type.' WHERE '.$base.'_val = "Y" ORDER BY '.$base.'_id DESC ');
        //lecture des resultats
        while ($Row = mysqli_fetch_array($result)) {
            $supp = '<a href="gestion.php?commande' . $min . '&amp;suppcom' . $min . '=' . $Row[0] . '" ><span class="glyphicon glyphicon-remove"></span></a>';
            $valid = '<a href="gestion.php?commande' . $min . '&amp;validcom' . $min . '=' . $Row[0] . '" ><span class="glyphicon glyphicon-ok"></span></a>';
            print('
                <tr id="#'.$base.''.$Row[0].'">
                <form method="post" id="mc'.$min.'' . $Row[0] . '" class="form-inline">
                <td>' . $Row[1] . '</td>');
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
            $sql = 'UPDATE commande_'.$type.' SET '.$base.'_val = "N"  WHERE '.$base.'_id=' . $_GET['suppcom' . $min . ''];
            mysqli_query($db, $sql);
            print('<meta http-equiv="refresh" content="0";URL=gestion.php?document' . $min . '">');
        }
        if (isset($_GET['validcom' . $min . ''])) {
            $sql = 'UPDATE commande_'.$type.' SET '.$base.'_val = "N"  WHERE '.$base.'_id=' . $_GET['suppcom' . $min . ''];
            mysqli_query($db, $sql);
            print('<meta http-equiv="refresh" content="0";URL=gestion.php?document' . $min . '">');
        }
        //libération des ressources
        mysqli_free_result($result);
        //fermer la connexion
        mysqli_close($db);
        print('</tbody>
            </table>');
    }

    function ajouter($type){

    }
}
?>