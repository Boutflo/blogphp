<?php

session_start();
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'config/connexion.inc.php';

require_once('libs/Smarty.class.php');

//Fonction de cryptage
function cryptPassword($mdp) {
    $mdp_crypt = sha1($mdp);
    return $mdp_crypt;
}

// si var post sumbit difféeent nul
if (isset($_POST['submit'])) {
    // iniation avr notif et session notif result égale faux
    $notification = "Aucune notifcation";
    $_SESSION['notification_result'] = FALSE;
    // si var posté nom, prenom, email et mdp difféeent de vide  
    if (!empty($_POST['nom']) AND ! empty($_POST['prenom']) AND ! empty($_POST['email']) AND ! empty($_POST['mdp'])) {
        // requête sql insertion sur utilisateurs valeur nom rpenom email mdp
        $insert = "INSERT INTO utilisateurs (nom, prenom, email, mdp) "
                . "VALUES (:nom, :prenom, :email, :mdp)";

        /* @var $bdd PDO */
        $sth = $bdd->prepare($insert);
        $sth->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
        $sth->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $sth->bindValue(':mdp', cryptPassword($_POST['mdp']), PDO::PARAM_STR);
        // si requête sql marche afficher notif réussite et notif égale à vrai
        if ($sth->execute() == TRUE) {
            $notification = "Félicitation, votre utilisateur est créé";
            $_SESSION['notification_result'] = TRUE;

            // sinon notif reuslt est faux et notif d'erreur
        } else {
            $notification = "Une erreur est survenue lors de l'insertion de l'article dans la BDD";
            $_SESSION['notification_result'] = FALSE;
        }

        // sinon notif result faux et notif erreur
    } else {
        $notification = "Veuillez renseigner les champs obligatoires";
        $_SESSION['notification_result'] = FALSE;
    }
    // redirection vers inscription.php
    $_SESSION['notification'] = $notification;
    header('Location: index.php');
    exit();
} else {
    include 'include/header.inc.php';




    $smarty = new Smarty();

    $smarty->setTemplateDir('templates/');
    $smarty->setCompileDir('templates_c/');

    $smarty->assign('session', $_SESSION);


// si session notification pas nulle
    if (isset($_SESSION['notification'])) {
// initation variable notif result et si elle est vrai afficher alerte sucess ou danger
        $notification_result = $_SESSION['notification_result'] == TRUE ? 'alert-success' : 'alert-danger';
        $smarty->assign('notification_result', $notification_result);
        unset($_SESSION['notification']); // effacer la notification
        unset($_SESSION['notification_result']);
    }

    $smarty->display('inscription.tpl');
    include 'include/footer.inc.php';
}
    
   