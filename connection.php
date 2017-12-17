<?php

session_start();
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'include/fonction.inc.php';
require_once 'config/connexion.inc.php';
include 'include/header.inc.php';

require_once('libs/Smarty.class.php');


// si param sumbot posté défini et différent de nul
if (isset($_POST['submit'])) {
    print_r($count_id);
    // initation var notif et param notif result est égale à faux
    $notification = "Aucune notifcation";
    $_SESSION['notification_result'] = FALSE;
    // Si param posté email différent de nul et param post mdp différent nul
    if (!empty($_POST['email']) AND ! empty($_POST['mdp'])) {

        // fonction cryptage mdp
        $mdp_hash = cryptPassword($_POST['mdp']);

        // initation var avec requete sql 
        $select_user = "SELECT email, "
                . "mdp "
                . "FROM utilisateurs "
                . "WHERE email = :email "
                . "AND mdp = :mdp";

        /* @var $bdd PDO */
        $sth = $bdd->prepare($select_user);
        $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $sth->bindValue(':mdp', $mdp_hash, PDO::PARAM_STR);

        // si excécution requête marche
        if ($sth->execute() == TRUE) {
            // compte nombre ligne requête
            $count = $sth->rowCount();
            // si var count au dessu de zero
            if ($count > 0) {
                // iniation var siid avec parem post email
                $sid = sid($_POST['email']);
                // requête sql maj BDD sur table utilisateurs avec sid et email
                $update_sid = "UPDATE utilisateurs "
                        . "SET sid = :sid "
                        . "WHERE email = :email ";
                // préparation maj BDD       
                $sth_update = $bdd->prepare($update_sid);
                $sth_update->bindValue(':sid', $sid, PDO::PARAM_STR);
                $sth_update->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                //  si requête est bien executé
                if ($sth_update->execute() == TRUE) {
                    // créer cookie sur sid pendant un jour
                    setcookie('sid', $sid, time() + 86400);
                    // notification et redirection page acceuil
                    $notification = "Connection réussie !!!!!!!!!!";
                    $_SESSION['notification'] = $notification;
                    $_SESSION['notification_result'] = TRUE;
                    header("Location: index.php");
                    exit();
                } else { // sinon notif erreur et var est fausse
                    $notification = "Une erreur technique est survenue...";
                    $_SESSION['notification_result'] = FALSE;
                }
            } else { // sinon notif erreur et var est fausse
                $notification = "L'email ou le mot de passe sont invalides";
                $_SESSION['notification_result'] = FALSE;
            }
        } else {
            // sinon notif erreur et vers est fausse
            $notification = "Une erreur technique est survenue...";
            $_SESSION['notification_result'] = FALSE;
        }
    } else { // sinon notif erreur et var est fausse
        $notification = 'Veuillez renseignez les champs obligatoire...';
        $_SESSION['notification_result'] = FALSE;
    }
    // redirection vers connection.php 
    $_SESSION['notification'] = $notification;
    header('Location: connection.php');
} else {




    $smarty = new Smarty();

    $smarty->setTemplateDir('templates/');
    $smarty->setCompileDir('templates_c/');

    $smarty->assign('session', $_SESSION);
    $smarty->assign('is_connect', $is_connect);
// $smarty->assign('mdp_hash',$mdp_hash); 
// $smarty->assign('count',$count); 
// $smarty->assign('count_id',$count_id); 
// si session notification pas nulle
    if (isset($_SESSION['notification'])) {
// initation variable notif result et si elle est vrai afficher alerte sucess ou danger
        $notification_result = $_SESSION['notification_result'] == TRUE ? 'alert-success' : 'alert-danger';
        $smarty->assign('notification_result', $notification_result);
        unset($_SESSION['notification']); // effacer la notification
        unset($_SESSION['notification_result']);
    }

    $smarty->display('connection.tpl');
    include 'include/footer.inc.php';
}
  