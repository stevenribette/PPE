<?php
function login()
            {
                $page = $_SERVER['PHP_SELF'];
                if ($page == '/PPE/coffitech/index.php') {
                    require("r/function/connect.php");
                } else {
                    require("function/connect.php");
                }
                session_start();
                $MesErreur = "";
                $status = 0;

                if (isset($_POST['logout']))
                    $logout = "true";
                else
                    $logout = "false";

                if (!(isset($_SESSION['login'])) && count($_POST) == 0) {
                    $status = 0;
                    $_SESSION['on'] = "false";
                    if ($page == '/PPE/coffitech/r/gestion.php') {
                        print('<meta http-equiv="refresh" content="0;URL=../index.php">');
                    }
                } else if (!(isset($_SESSION['login'])) && isset($_POST['login'])) {
                    $Resul = mysqli_query($db, 'SELECT * FROM user_connect');
                    while ($Row = mysqli_fetch_array($Resul)) {
                        if ($Row[1] == $_POST['pseudo'] && $Row[2] == $_POST['password']) {
                            $_SESSION['login'] = $Row[0];
                            $_SESSION['pseudo'] = $Row[1];
                            $nom = $_SESSION['pseudo'];
                            $filename = "./r/profil/$nom";
                            if(!is_dir($filename)){
                                mkdir($filename);
                            }
                            if ($page == '/PPE/coffitech/index.php') {
                                print('<meta http-equiv="refresh" content="1";URL=r/gestion.php">');
                                print('</section><div class="alert alert-success">
                                        <strong>Success!</strong> Connection en cours
                                        </div>');
                            }
                        }
                    }
                } else if ($logout == "true") {
                    $_SESSION = array();
                    session_destroy();
                    print('<meta http-equiv="refresh" content="0;URL=../index.php">');
                } else if (isset($_SESSION['login'])) {
                    $status = 1;
                    $resultat = mysqli_query($db, 'SELECT * FROM user_connect WHERE us_id="' . $_SESSION['login'] . '"');
                    while ($Row = mysqli_fetch_array($resultat)) {
                        $_SESSION['Level'] = $Row[3];
                    }
                    if ($page == '/PPE/coffitech/index.php') {
                        print('<meta http-equiv="refresh" content="0;URL=r/gestion.php">');
                    }
                }
                print('<div id="login" >');
                if ($status == 0 && $page == '/PPE/coffitech/index.php') {
                    print('<form method="POST" class="form-inline" >');
                    print('<input type="hidden" name="login" value="true" />');
                    print('<p>Identifiant :<input type="text" name="pseudo" /></p>');
                    print('<p>Mot de passe :<input type="password" name="password" /></p>');
                    print('<p><button type="submit" value="Se Connecter" class="glyphicon glyphicon-log-in btn btn-primary btn-block"></button></p>');
                    print($MesErreur);
                    print('</form>');

                } else if ($status == 1) {
                    if ($page == '/PPE/coffitech/index.php') {
                        print('<div id="loginOn" >');
                        print('<br />');
                    }


                    print('<form method="POST" class="form-inline" >');
                    print('<input type="hidden" name="logout" value="true" />');
                    print('<button type="submit" value="Déconnecter" class="glyphicon glyphicon-log-out btn btn-primary"></button>');
                    print('</form>');
                    print('</div>');
                }
                print('</div>');
            }
			?>