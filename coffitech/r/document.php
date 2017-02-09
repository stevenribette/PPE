<?php
function document($typedoc)
{
        print('<nav class="navbar navbar-default navbar-lower">
            <div class="container-fluid">
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a href="gestion.php?'.$typedoc.'#lelement">Liste des '.$typedoc.'</a>
                    </li>
                    <li>
                        <a href="gestion.php?'.$typedoc.'#nelement">Ajouter un '.$typedoc.'</a>
                    </li>
                </ul>
            </div>
        </nav>');
}
?>