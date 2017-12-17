<?php

session_start();

//require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'config/connexion.inc.php';

require_once('libs/Smarty.class.php');

// si la connection est vrai
if ($is_connect == TRUE) {

// si il y a param url égale à ajouter
    if ($_GET['action'] == "ajouter") {
        $tab = "";
    }

// si il y a param url égale à modifier
    if ($_GET['action'] == "modifier") {

        $id_article = $_GET['id_article'];
        $action = $_GET['action'];
        //requête sql sélection article par leur id
        $sql = "SELECT * "
                . "FROM articles "
                . "WHERE id = :id_article";

        // @var $bdd PDO 
        $sth = $bdd->prepare($sql);
        $sth->bindValue(':id_article', $id_article, PDO::PARAM_INT);
        if ($sth->execute() == TRUE) {
            $tab = $sth->fetchAll(PDO::FETCH_ASSOC);
        }
    }

// si il y a param url égale à supprimer
    if ($_GET['action'] == "supprimer") {
        $id_article = $_GET['id_article'];
        $action = $_GET['action'];
        $sql = "DELETE FROM articles "
                . " WHERE id = :id_article";

        $sth = $bdd->prepare($sql);
        $sth->bindValue(':id_article', $id_article, PDO::PARAM_INT);
        // si exécution requete est bonne afficher notifcation
        if ($sth->execute() == TRUE) {
            $notification = "Suppression réussi réussie !!!!!!!!!!";
            $_SESSION['notification'] = $notification;
            $_SESSION['notification_result'] = TRUE;
            header("Location: index.php");
            exit();
        }
        $action = "";
    }
// si variable submit différent de nul
    if (isset($_POST['submit'])) {

        // Si paramètre fichier et error téléchargé est égale à 0
        if ($_FILES['fichier']['error'] == 0) {
            // initier variable notification
            $notification = "Aucune notifcation";
            // param notif result est égale à faux
            $_SESSION['notification_result'] = FALSE;
            // initier variable date du jour 
            $date_du_jour = date("Y-m-d");

            // Si param posté "titre" est diffént vide et param posté "texte" différent vide
            if (!empty($_POST['titre']) AND ! empty($_POST['texte'])) {
                // initiation variable publie qui défini param publie posté 
                // si param publie posté alors il vaut 0
                $publie = isset($_POST['publie']) ? $_POST['publie'] : 0;

                // si param posté égale à ajouter
                if ($_POST['action'] == "ajouter") {
                    // insertion dans table articles les valeurs
                    $sql = "INSERT INTO articles (titre, texte, date, publie) "
                            . "VALUES (:titre, :texte, :date, :publie)";
                }
                // si param posté égale à ajouter
                if ($_POST['action'] == "modifier") {
                    $sql = "UPDATE articles "
                            . "SET titre = :titre,"
                            . "texte = :texte, "
                            . "publie = :publie "
                            . "WHERE id = :id ";
                }


                /* @var $bdd PDO */
                $sth = $bdd->prepare($sql);
                $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
                if ($_POST['action'] == "ajouter") {
                    $sth->bindValue(':date', $date_du_jour, PDO::PARAM_STR);
                }
                $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);
                if ($_POST['action'] == "modifier") {
                    $sth->bindValue(':id', $_POST['id_article'], PDO::PARAM_INT);
                }

                // si excécution requête est vrai
                if ($sth->execute() == TRUE) {
                    // initation variable qui retourne id de la dernière ligne
                    if ($_POST['action'] == "ajouter") {
                        $id_article = $bdd->lastInsertId();
                        $notification = "Félicitation, votre article est inséré";
                        $_SESSION['notification_result'] = TRUE;
                        header('Location: index.php');
                        exit();
                    }
                    // si param posté égale à modifier
                    if ($_POST['action'] == "modifier") {
                        $id_article = $_POST['id_article'];
                    }

                    // initiation variable qui est égale param fichier name
                    $extension = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);

                    move_uploaded_file($_FILES['fichier']['tmp_name'], 'img/' . $id_article . '.' . $extension);

                    // notif réussite insertion fichier
                    /*  $notification = "Félicitation, votre article est inséré";
                      $_SESSION['notification_result'] = TRUE;
                      header('Location: index.php');
                      exit(); */
                } else {
                    // Sinon notif erreur avec notif result égale à faux
                    $notification = "Une erreur est survenue lors de l'insertion de l'article dans la BDD";
                    $_SESSION['notification_result'] = FALSE;
                }
            } else {
                // si condition d'avant pas rempli alors erreur
                $notification = "Veuillez renseigner les champs obligatoires";
                $_SESSION['notification_result'] = FALSE;
            }
        } else {
            // sinon ereeur
            $notification = "Une erreur est survenue lors du traitement de l'image";
            $_SESSION['notification_result'] = FALSE;
        }
    } else {

        include 'include/header.inc.php';



        $smarty = new Smarty();

        $smarty->setTemplateDir('templates/');
        $smarty->setCompileDir('templates_c/');

        $smarty->assign('session', $_SESSION);
        $smarty->assign('is_connect', $is_connect);
        $smarty->assign('_GET', $_GET);
        $smarty->assign('tab', $tab);



// si session notification pas nulle
        if (isset($_SESSION['notification'])) {
// initation variable notif result et si elle est vrai afficher alerte sucess ou danger
            $notification_result = $_SESSION['notification_result'] == TRUE ? 'alert-success' : 'alert-danger';
            $smarty->assign('notification_result', $notification_result);
            unset($_SESSION['notification']); // effacer la notification
            unset($_SESSION['notification_result']);
        }

        $smarty->display('article.tpl');
        include 'include/footer.inc.php';
    }
} else
    echo "Vous n'avez pas les droits";
    
