<div class="container">
    <div class="row">
        <div class="col-md-12">
            </br>
            </br>
        </div>
    </div>
    <div class="col-lg-12 text-left">
        <div class="row">
            {foreach from=$tab_articles item=value}
                <div class="card col-md-6">
                    <!-- afficher l'image avec comme valeur celle de l'id -->  
                    <img class="card-img-top" src="img/{$value.id}.jpg" alt="{$value.id}.jpg">
                    <div class="card-body">
                        <!-- afficher le titre avec comme valeur celle du titre -->  
                        <h4 class="card-title ">{$value.titre}</h4>
                        <!-- afficher le texte avec comme valeur celle du texte -->  
                        <p class="card-text" rows="4">{$value.texte}</p>
                        <!-- afficher la date avec comme valeur celle de la date -->  
                        <p class="card-text">{$value.date_fr}</p>
                        <div>
                            <a href="page.php?id_article={$value.id}&action=article" class="btn btn-dark" > Voir article</a>
                        </div>
                        <div class="col-md-12">
                            </br>
                        </div>
                        {if $is_connect == TRUE}
                            <a href="article.php?action=modifier&id_article={$value.id}" class="btn btn-info">Modifier l'article</a>
                            </br>
                            </br>
                         <a href="article.php?action=supprimer&id_article={$value['id']}" class="btn btn-danger">Supprimer l'article</a>
                        {/if}
                    </div>
                    <h2 class="mt-5 text-center">Créer votre commentaire</h2>
                    <form action="page.php" id="commentaire" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_article" value="{$value.id}">
                        <div class="form-group col-md-12">
                            <label for="pseudo" name="pseudo" class="col-form-label">Pseudo</label>
                            <input type="text" class="form-control" id="emai" name="pseudo" required placeholder="Pseudo">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="email" name="email" class="col-form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="test@test.fr">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="com" name="titre" class="col-form-label">Commentaire</label>
                            <textarea class="form-control" id="com" name="commentaire" required placeholder="commentaire" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <button  type="submit" name="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                    </form>
                    <h2 class="mt-5 text-center">Commentaire sur l'article :</h2>
                    <div class="col-md-12 ">
                        {foreach from=$tab_com item=value_com}
                            <p class="mt-5 text-left">Commentaire de {$value_com.pseudo} :</p>
                            <p class="commentaire col-md-12 border border-info  text-left">{$value_com.commentaire}</p>
                        {/foreach}
                    </div>
                </div>
            </div>
          <div class="col-md-12">
                    </br>
                    </br>
                </div>
            
        {/foreach}
    </div>
</div>
<div class="col-md-12">
    </br>
    </br>
</div>




<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>