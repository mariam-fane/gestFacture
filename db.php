<?php
      // Connexion à la base de données
  try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=mariam;charset=utf8', 'root', '');

        //echo 'Connexion reussie';
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }
 
        ?>