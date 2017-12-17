<?php

//Fonction de cryptage mot de passe
function cryptPassword($mdp){
    $mdp_crypt = sha1($mdp);
    return $mdp_crypt;
    }
    
  //  fonction cryptage sid
function sid($email) {
    $sid = md5($email . time());
    return $sid;
}

// Fonction retour index pour pagination
function pagination($page_courante, $nb_articles_par_page){
    $index = ($page_courante -1) * $nb_articles_par_page;
    return $index ;
    
}

// Fonction comptage article publié
function nb_total_article_publie($bdd){
    /* @var $bdd PDO */
    $sql="SELECT COUNT(*) as nb_total_article_publie "
            . "FROM articles "
            . "WHERE publie = 1" ;
    $sth = $bdd->prepare($sql);
    $sth->execute();
    $tab_result = $sth->fetch(PDO::FETCH_ASSOC);
    
    return $tab_result['nb_total_article_publie'];
}