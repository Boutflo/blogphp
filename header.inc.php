

<!DOCTYPE html>
<html lang="fr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FB Blog</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="vendor/bootstrap/css/style.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style>
      body {
        padding-top: 54px;
      }
      @media (min-width: 992px) {
        body {
          padding-top: 56px;
        }
      }

    </style>

  </head>

  <body>

    <!-- Navigation -->
     
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Florent BOUTLEUX Blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Acceuil
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
                <?php
                if ($is_connect == TRUE){
                    ?>
              <a class="nav-link" href="article.php?action=ajouter">Ajouter un article</a>
            
            <?php
                 }
                 ?>
            <li class="nav-item">
            </li>
            <li class="nav-item">
              <a class="nav-link" href="inscription.php">Inscription</a>
            </li>
            <li class="nav-item">
                
                <?php
                // si var est fausse
                if ($is_connect == FALSE) {
                    ?>
                <!--a ffichage bouton connection -->
                <a class="nav-link" href="connection.php">Connection</a>
                <?php 
                } else { // sinon
                    ?>
                  <!--a ffichage bouton déconnection -->
                <a class="nav-link" href="deconnexion.php">Déconnection</a>
                 <?php
                }
                ?>
            </li>
              <form class="form-inline my-2 my-lg-0" method="get" role="search" id="recherche" action="recherche.php">
      <input class="form-control mr-sm-2" type="search" name ="recherche" placeholder="Rechercher" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" value="recherche">OK</button>
    </form>
            
          </ul>
        </div>
      </div>
    </nav>


