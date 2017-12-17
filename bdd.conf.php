<?php

// connection à la database blog sur le serveur de base de donnée 
try {
    
    $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8','root','root') ;
    $bdd->exec("set names utf8") ;
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // masquer lors de l'hébergement
} catch (Exception $e) {
   die('Erreur : ' . $e->getMessage()) ;
}

?>