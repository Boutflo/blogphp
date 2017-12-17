<?php

require_once 'config/init.conf.php' ;
require_once 'config/bdd.conf.php' ;
require_once 'config/connexion.inc.php';
require_once 'include/fonction.inc.php';
include 'include/header.inc.php';

require_once('libs/Smarty.class.php');

// Param nb article par page de 2
$nb_articles_par_page = 2;

// si param page posté alors page = 1
$page_courante = isset($_GET['page']) ? $_GET['page'] : 1;

// appel fonction pagination
$index = pagination($page_courante, $nb_articles_par_page);

// appel fonction nombre total article publié
$nb_total_article_publie = nb_total_article_publie($bdd);

// calcul nombre total article divisé par nba total article par page
$nb_pages = ceil($nb_total_article_publie / $nb_articles_par_page);
$recherche = isset($_GET['recherche']) ? $_GET['recherche'] : "";
         $select = "SELECT id, "
        ."titre, "
        ."texte, "
        ."DATE_FORMAT (date, '%d/%m/%Y') as date_fr "
        ."FROM articles "
        ."WHERE (titre LIKE :recherche OR texte LIKE :recherche) "
        ."AND publie = 1 " 
        ."LIMIT :index, :nb_articles_par_page;";

// Prépare requête select, associe la valeur publie à 1
$sth = $bdd->prepare($select);
$sth->bindValue(':recherche', '%' . $recherche . '%', PDO::PARAM_STR);
$sth->bindValue(':publie',1,PDO::PARAM_BOOL);
$sth->bindValue(':index',$index,PDO::PARAM_INT);
$sth->bindValue(':nb_articles_par_page',$nb_articles_par_page,PDO::PARAM_INT);
if($sth->execute() == TRUE){
 $tab_articles= $sth->fetchAll(PDO::FETCH_ASSOC); 
}

  
$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');

$smarty->assign('tab_articles',$tab_articles); 
$smarty->assign('nb_articles_par_page',$nb_articles_par_page); 
$smarty->assign('page_courante',$page_courante); 
$smarty->assign('index',$index); 
$smarty->assign('nb_total_article_publie',$nb_total_article_publie); 
$smarty->assign('nb_pages',$nb_pages); 
$smarty->assign('recherche',$recherche); 

  $smarty->display('recherche.tpl');
  include 'include/footer.inc.php';
     
  


     
     
     
 