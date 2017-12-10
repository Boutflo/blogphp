<?php

session_start();
require_once 'config/init.conf.php' ;
require_once 'config/bdd.conf.php' ;

//Fonction de cryptage
function cryptPassword($mdp){
    $mdp_crypt = sha1($mdp);
    return $mdp_crypt;
    }
    
 if (isset($_POST['submit'])) {
     
  $notification = "Aucune notifcation";
  $_SESSION['notification_result'] = FALSE;
    
 if (!empty($_POST['nom']) AND ! empty($_POST['prenom']) AND ! empty($_POST['email']) AND ! empty($_POST['mdp'])) {

      $insert = "INSERT INTO utilisateurs (nom, prenom, email, mdp) " 
                . "VALUES (:nom, :prenom, :email, :mdp)";

        /* @var $bdd PDO */
        $sth = $bdd->prepare($insert);
        $sth->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
        $sth->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $sth->bindValue(':mdp', cryptPassword($_POST['mdp']), PDO::PARAM_STR);

 if ($sth->execute() == TRUE) {
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
    $_SESSION['notification'] = $notification;
    header('Location: inscription.php');
    exit();


} else {
include 'include/header.inc.php';

?>

 <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h1 class="mt-5">S'inscrire sur le blog</h1>
          
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
         
        
     <form action="inscription.php" method="post" enctype="multipart/form-data" id="form_inscription">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nom" class="col-form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
                </div>
            <div class="form-group col-md-6"></div>
             </div>
            <div class="form-row">
                 <div class="form-group col-md-6">
                    <label for="prenom" class="col-form-label">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
                 </div>  
                 <div class="form-group col-md-6"></div>
                  </div>
         <div class="form-row">
                 <div class="form-group col-md-6">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                 </div>  
             <div class="form-group col-md-6"></div>
         </div>
         <div class="form-row">
                 <div class="form-group col-md-6">
                    <label for="mdp" class="col-form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
                 </div>  
             <div class="form-group col-md-6"></div>
            <button type="submit" class="btn btn-primary"  name="submit">Envoyer</button>
        </div>
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