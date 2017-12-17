<?php

// Initier une session
session_start();

// Fichier requis ou inclu pour le programme
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'config/connexion.inc.php';
require_once 'include/fonction.inc.php';

require_once('libs/Smarty.class.php');


// Param nb article par page de 2
$nb_articles_par_page = 2;

// si param page posté alors page = 1
$page_courante = isset($_GET['page']) ? $_GET['page'] : 1;

// appel foncion pagination
$index = pagination($page_courante, $nb_articles_par_page);

// appel fonction nombre total article publié
$nb_total_article_publie = nb_total_article_publie($bdd);

// calcul nombre total article divisé par nba total article par page
$nb_pages = ceil($nb_total_article_publie / $nb_articles_par_page);


// Requête SQL sélectionnant le champ id, titre et texte de la table article
// quand le champ publie est activé et limité par index et nb articles
$select = "SELECT id, "
        . "titre, "
        . "texte, "
        . "DATE_FORMAT (date, '%d/%m/%Y') as date_fr "
        . "FROM articles "
        . "WHERE publie = :publie "
        . "LIMIT :index, :nb_articles_par_page;";

// Prépare requête select, associe la valeur publie à 1
$sth = $bdd->prepare($select);
$sth->bindValue(':publie', 1, PDO::PARAM_BOOL);
$sth->bindValue(':index', $index, PDO::PARAM_INT);
$sth->bindValue(':nb_articles_par_page', $nb_articles_par_page, PDO::PARAM_INT);





// Si excécution vartiable est vrai, mettre variable sth dans un tab avec champ
if ($sth->execute() == TRUE) {
    $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
    //  print_r($tab_articles);
    // Sinon notifier erreur
} else {
    echo 'une erreur est survenue...';
}



$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

$smarty->assign('is_connect', $is_connect);
if ($is_connect == TRUE) {
    $smarty->assign('nom_connect', $nom_connect);
    $smarty->assign('prenom_connect', $prenom_connect);
}
$smarty->assign('session', $_SESSION); //tableau
$smarty->assign('tab_articles', $tab_articles);
$smarty->assign('nb_pages', $nb_pages);
$smarty->assign('page_courante', $page_courante);
$smarty->assign('nb_total_article_publie', $nb_total_article_publie);


// si session notification pas nulle
if (isset($_SESSION['notification'])) {
// initation variable notif result et si elle est vrai afficher alerte sucess ou danger
    $notification_result = $_SESSION['notification_result'] == TRUE ? 'alert-success' : 'alert-danger';
    $smarty->assign('notification_result', $notification_result);
    unset($_SESSION['notification']); // effacer la notification
    unset($_SESSION['notification_result']);
}

//** un-comment the following line to show the debug console
//$smarty->debugging = true;
include 'include/header.inc.php';
$smarty->display('index.tpl');
include 'include/footer.inc.php';







