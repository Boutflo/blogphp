<?php

session_start();
require_once 'config/init.conf.php' ;
require_once 'config/bdd.conf.php' ;
include 'include/header.inc.php';

$select = "SELECT id, "
        ."titre, "
        ."texte, "
        ."DATE_FORMAT (date, '%d/%m/%Y') as date_fr "
        ."FROM articles "
        ."WHERE publie = :publie;" ;

//echo $select;
/* @var $bdd PDO */
$sth = $bdd->prepare($select);
$sth->bindValue(':publie',1,PDO::PARAM_BOOL);
if($sth->execute() == TRUE){
   $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
  //  print_r($tab_articles);
  
} else {
    echo 'une erreur est survenue...';
}
    

?>

 <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h1 class="mt-5">A Bootstrap 4 Starter Template</h1>
          <p class="lead">Complete with pre-defined file paths and responsive navigation!</p>
          <ul class="list-unstyled">
            <li>Bootstrap 4.0.0-beta</li>
            <li>jQuery 3.2.1</li>
          </ul>
        </div>
      </div>
    </div>
 <div>
 <?php
    foreach ($tab_articles as $value) {
 ?>
     <div class="card col-md-4">
  <img class="card-img-top" src="img/<?= $value['id'] ?>.jpg " alt="<?= $value['titre'] ?>">
  <div class="card-body">
    <h4 class="card-title"><?= $value['titre'] ?> </h4>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>
    <?php
    }
    ?>
     
 </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  </body>
  
  <?php
  include 'include/footer.inc.php';
  ?>
  
  
  

