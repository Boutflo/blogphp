<?php

session_start();

// Fichier requis ou inclu pour le programme
require_once 'config/bdd.conf.php';
require_once 'config/connexion.inc.php';
require_once 'include/fonction.inc.php';

require_once 'libs/Smarty.class.php';

//si la variable submit postée est ifférente de nulle
if (isset($_POST['submit'])) {
    // requête insertion table commentaire
    $sql = "INSERT INTO commentaire (pseudo, email, commentaire, id_article) "
            . "VALUES (:pseudo, :email, :commentaire, :id_article) ";
    $sth = $bdd->prepare($sql);
    $sth->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $sth->bindValue(':commentaire', $_POST['commentaire'], PDO::PARAM_STR);
    $sth->bindValue(':id_article', $_POST['id_article'], PDO::PARAM_STR);
    // notification article publié si excécution requête SQL est vrau 
    if ($sth->execute() == TRUE) {
        $notification = 'Article publié !';
        $_SESSION['notification_result'] = TRUE;
        $_SESSION['notification'] = $notification;
        header('Location: page.php?action=article&id_article=' . $_POST['id_article'] . '');
        exit();
        //sinon notif erreur sur l'envoi
    } else {
        $notification = "Erreur pendant l'envoi du commentaire";
        $_SESSION['notification_result'] = FALSE;
        $_SESSION['notification'] = $notification;
        header('Location: page.php?action=article&id=' . $_POST['id_article'] . '');
        exit();
    }
}

// Si la param URL action et param url action égale à la variable ajouter
if (isset($_GET['action']) && $_GET['action'] == 'article') {
    //requête seléction article 
    $select_article = "SELECT id, "
            . "titre, "
            . "texte, "
            . "DATE_FORMAT(date, '%d/%m/%Y') as date_fr "
            . "FROM articles "
            . "WHERE id = :id "
            . "AND publie = :publie ";
    $sth = $bdd->prepare($select_article);
    $sth->bindValue(':id', $_GET['id_article'], PDO::PARAM_INT);
    $sth->bindValue(':publie', 1, PDO::PARAM_BOOL);
   // requête inner join entre la bdd commentaire et articles
    $select_com = "SELECT commentaire, pseudo "
            . "FROM commentaire AS c "
            . "INNER JOIN articles AS a ON c.id_article = a.id "
            . "WHERE c.id_article = :id ";
    $sth2 = $bdd->prepare($select_com);
    $sth2->bindValue(':id', $_GET['id_article'], PDO::PARAM_INT);
    // si première et 2ème requête sql s'éxecute
    if ($sth->execute() == TRUE) {
        if ($sth2->execute() == TRUE) {
            // les variable égale à un tableau des requêtes sql
            $tab_articles = $sth->fetchALl(PDO::FETCH_ASSOC);
            $tab_com = $sth2->fetchALl(PDO::FETCH_ASSOC);
        }
    }
}


$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');

$smarty->assign('is_connect', $is_connect);
  
$smarty->assign('tab_articles', $tab_articles);
$smarty->assign('tab_com', $tab_com);
$smarty->assign('tab_get', $_GET);


  if (isset($_SESSION['notification'])) {
// initation variable notif result et si elle est vrai afficher alerte sucess ou danger
        $notification_result = $_SESSION['notification_result'] == TRUE ? 'alert-success' : 'alert-danger';
        $smarty->assign('notification_result', $notification_result);
        unset($_SESSION['notification']); // effacer la notification
        unset($_SESSION['notification_result']);
    }

include 'include/header.inc.php';
$smarty->display('templates/page.tpl');
require_once 'include/footer.inc.php';
?>
