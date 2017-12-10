<?php

session_start();
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';



if (isset($_POST['submit'])) {
   // print_r($_POST);
    print_r($_FILES);
    
    if($_FILES['fichier']['error'] == 0) {

    $notification = "Aucune notifcation";
    $_SESSION['notification_result'] = FALSE;
    $date_du_jour = date("Y-m-d");


    if (!empty($_POST['titre']) AND ! empty($_POST['texte'])) {

        $publie = isset($_POST['publie']) ? $_POST['publie'] : 0;


        $insert = "INSERT INTO articles (titre, texte, date, publie) " 
                . "VALUES (:titre, :texte, :date, :publie)";

        /* @var $bdd PDO */
        $sth = $bdd->prepare($insert);
        $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
        $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
        $sth->bindValue(':date', $date_du_jour , PDO::PARAM_STR);
        $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);

        if ($sth->execute() == TRUE) {
            
            $id_article = $bdd->lastInsertId();
            $extension = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
            /*
            $tab_extensions = aray(
                'jpg',
                'png',
                'jpeg'
        );
            
          $result_extension_image = in_array($extension, $tab_extensions);
          */ // faire plus tard, déplacer le code
            move_uploaded_file($_FILES['fichier']['tmp_name'], 'img/' . $id_article . '.' . $extension);
            
            
            $notification = "Félicitation, votre article est inséré";
            $_SESSION['notification_result'] = TRUE;
            
            
            
        } else {
            $notification = "Une erreur est survenue lors de l'insertion de l'article dans la BDD";
            $_SESSION['notification_result'] = FALSE;
        }
    } else {
        $notification = "Veuillez renseigner les champs obligatoires";
        $_SESSION['notification_result'] = FALSE;
    }
    } else { 
        $notification = "Une erreur est survenue lors du traitement de l'image";
        $_SESSION['notification_result'] = FALSE;
    }
    $_SESSION['notification'] = $notification;
    header('Location: article.php');
    exit();
} else {

    include 'include/header.inc.php';
    ?>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Ajouter un article</h1>

            </div>
        </div>
         <?php
        if(isset($_SESSION['notification'])) {
            $notification_result = $_SESSION['notification_result'] == TRUE ? 'alert-success' : 'alert-danger';
            ?>
        <div class="alert <?= $notification_result ?> alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
       <?php
            echo $_SESSION['notification'] ; // afficher la notif
            ?>
    </div>
       <?php
        unset($_SESSION['notification']); // effacer la notification
         unset($_SESSION['notification_result']);
        }
        ?>
        

        <form action="article.php" method="post" enctype="multipart/form-data" id=form_article">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="titre" class="col-form-label">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre de l'article">
                </div>
            </div>
            <div class="form-row"> 
                <div class="form-group col-md-6">
                    <label for="texte">Texte</label>
                    <textarea class="form-control" id="texte" name="texte" rows="3" ></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="fichier">Insérer un fichier</label>
                <input type="file" class="form-control-file" id="fichier" name="fichier">
            </div>

            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="1" id="publie" name="publie"> Publier
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"  name="submit">Envoyer</button>
        </form>




    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>


    <?php
    include 'include/footer.inc.php';
}
?>



