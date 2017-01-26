<?php
	$db = mysqli_connect('localhost','root', '', 'coffitech');

    /**
     $serverName = "STEVENRIBETTE\sqlexpress";
    $connectionInfo = array( "Database"=>"tournament");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    class sql
    {
        private $connexion_sql;

        function __construct()
        {
            $this->connexion_bdd = new PDO('sqlsrv:Server=STEVENRIBETTE\SQLEXPRESS;Database=tournament', '', '');

            // Fixe les options d'erreur (ici nous utiliserons les exceptions)
            $this->connexion_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function requete($requete)
        {
            $prepare = $this->connexion_bdd->prepare($requete);
            $prepare->execute();

            return $prepare;
        }
    }
    $sql = new sql();
    */
?>