
<!-- Page Content -->
<div class="container">


    <div class="row">
        <div class="col-lg-12 text-center">
            <!-- si param url égale à ajouter  -->
            <!-- afficher "ajouter un article"  -->
            {if ($_GET['action'] == "ajouter")}
                <h1 class="mt-5">Ajouter un article</h1>
            {/if}
            <!-- si param url égale à ajouter  -->
            <!-- afficher "modifier un article"  -->
            {if ($_GET['action'] == "modifier")}
                <h1 class="mt-5">Modifier un article</h1>

            {/if}
        </div>

        <!-- affichage notification  -->
        {if isset($session['notification'])}
            <div class="alert {$notification_result} alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {$session['notification']} 
            </div>
        {/if}

        <form action="article.php" method="post" enctype="multipart/form-data" id=form_article">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="titre" class="col-form-label">Titre</label>
                    <!-- si var tab du tableau 0 défini avec le champ titre  -->
                    <!-- var tab sur le tableau   égale au champ titre-->
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre de l'article">

                    {if (isset($tab['0']['titre']))}

                        {$tab['0']['titre']}

                    {/if}


                </div>
            </div>
            <div class="form-row"> 
                <div class="form-group col-md-6">
                    <label for="texte">Texte</label>
                    <!-- si var tab du tableau 0 défini avec le champ texte  -->
                    <!-- var tab sur le tableau égale au champ texte-->
                    <textarea class="form-control" id="texte" name="texte" rows="10"style="width:500px"  >

                        {if (isset($tab['0']['texte']))}
                            {$tab['0']['texte']}
                        {/if}
                    </textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="fichier">Insérer un fichier</label>
                <input type="file" class="form-control-file" id="fichier" name="fichier">
                <!-- si param url égale à modifier-->
                {if ($_GET['action'] == "modifier")}
                    <!-- afficher image selon l'id-->
                    <hr><img class="img-top" height=100 src="img/{$tab['0']['id']}.jpg">
                {/if}



                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="1" id="publie" name="publie"> Publier
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"  name="submit" value="submit">Envoyer</button>
                <!-- Passer l'id article dans l'url après l'envoit de l'article-->
                <input type="hidden" name="id_article" value="{$_GET['id_article']}">
                <!-- si param url égale à modifier ->
                {if ($_GET['action'] == "modifier")}
                     <input type="hidden" name="action" value="modifier">
                {/if}
                <!-- si param url égale à ajouter-->
                {if ($_GET['action'] == "ajouter")}
                    <input type="hidden" name="action" value="ajouter">
                {/if}




            </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>



