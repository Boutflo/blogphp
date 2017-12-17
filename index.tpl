<!-- Page Content -->
<div class="container">


    <!--Si variable est vrai -->

    {if $is_connect == TRUE}
        <!--  Afficher alerte avec variables nom et prenom  -->
        <div class="alert alert-info" role="alert">
            <strong>Connecté</strong> en tant que {$nom_connect} {$prenom_connect}
        </div> 
    {/if}

    <div class="row"> 
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Articles</h1>
        </div>
    </div>

    <!--  Afficher alerte incluant variable -->
    {if isset($session['notification'])}
        <div class="alert {$notification_result} alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {$session['notification']} 
        </div>
    {/if}

    <!-- Affiche image selon la valeur du tableau id et valeur titre  -->
    <div class="row">
        <!-- Revu tableau tab article. assigne chaque valeur tableau à variable value-->
        {foreach from=$tab_articles item=value}
            <div class="card col-md-6">
                <img class="card-img-top" src="img/{$value['id']}.jpg " alt="{$value['titre']}">
                <div class="card-body">
                    <h4 class="card-title">{$value['titre']} </h4>
                    <p class="card-text">{$value['texte']}</p>
                    <a href="#" class="btn btn-primary">Créé le : {$value['date_fr']}</a>  
                    <a href="article.php?action=modifier&id_article={$value['id']}" class="btn btn-warning">Modifier l'article</a>
                    <a href="article.php?action=supprimer&id_article={$value['id']}" class="btn btn-danger">Supprimer l'article</a>
                    <a href="page.php?action=article&id_article={$value['id']}" class="btn btn-info">Voir l'article</a>
                </div>
            </div>
        {/foreach}
        <div class="row" >    
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <!-- tant que $i inférieur nombre page, créer les pages et rajouter 1 -->
                    {for $i=1 to $nb_pages}
                        <li class="page-item {if $page_courante == $i}active{/if}">
                            <a class="page-link" href="?page={$i}">{$i}</a></li>
                        {/for}
                </ul>
            </nav>   

        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>



