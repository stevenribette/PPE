<?php
function stockage ()
{
    ?>
    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Code</th>
                <th>Libelle</th>
                <th>Etat</th>
                <th>Effacer</th>
            </tr>
            </thead>
            <tbody>
            <?php
            require('connect.php');
            //exécution de la requête
            $result = mysqli_query($db, 'SELECT * FROM ordinateur');
            //lecture des resultats
            while ($Row = mysqli_fetch_array($result)) {
                $supp = '<a href="gestion.php?stockage&amp;suppord=' . $Row[0] . '" >X</a>';
                print('<tr><td>' . $Row[2] . '</td><td>' . $Row[1] . '</td><td>' . $Row[3] . '</td><td>' . $supp . '</td></tr>');
            }

            if (isset($_GET['suppord'])) {
                $sql = 'DELETE FROM ordinateur WHERE ord_id=' . $_GET['suppord'];
                mysqli_query($db, $sql);
                $nom = $_GET['suppord'];
                print('<meta http-equiv="refresh" content="0;URL=gestion.php?stockage">');
            }
            //libération des ressources
            mysqli_free_result($result);
            //fermer la connexion
            mysqli_close($db);
            ?>
            <tr></tr>
            <?php
            require('connect.php');
            //exécution de la requête
            $result = mysqli_query($db, 'SELECT * FROM souris');
            //lecture des resultats
            while ($Row = mysqli_fetch_array($result)) {
                $supp = '<a href="gestion.php?stockage&amp;suppsou=' . $Row[0] . '" >X</a>';
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
            require('connect.php');
            //exécution de la requête
            $result = mysqli_query($db, 'SELECT * FROM clavier');
            //lecture des resultats
            while ($Row = mysqli_fetch_array($result)) {
                $supp = '<a href="gestion.php?stockage&amp;suppcla=' . $Row[0] . '" >X</a>';
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
            require('connect.php');
            //exécution de la requête
            $result = mysqli_query($db, 'SELECT * FROM ecran');
            //lecture des resultats
            while ($Row = mysqli_fetch_array($result)) {
                $supp = '<a href="gestion.php?stockage&amp;suppecr=' . $Row[0] . '" >X</a>';
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
    </div>
    <?php
}
?>