<?php
function document($typedoc)
{
    print('<nav class="navbar navbar-default navbar-lower">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a href="gestion.php?'.$typedoc.'#lelement">');
                print('Liste des ');
                print($typedoc);
                if ($typedoc != "devis"){
                    print('s');
                }
                print('</a>
                </li>
                <li>
                    <a href="gestion.php?'.$typedoc.'#nelement">');
                    print('Ajouter ');
                    if ($typedoc == "devis"){
                        print('un ');
                    }else{
                        print('une ');
                    }
                    print($typedoc);
                print('</a>
                </li>
            </ul>
        </div>
    </nav>');


}
?>