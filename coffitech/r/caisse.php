<?php
function caisse(){
    $caisse = new caisse;
    print('<div class="container">');
    $caisse->lticket();
    print('</br>');
    $caisse->nticket();
    print('</div>');
}
class caisse{
    function lticket(){
    }
    function nticket(){

    }
}
?>