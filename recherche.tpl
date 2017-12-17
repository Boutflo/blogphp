{foreach from=$tab_articles item=value}

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Affiche image selon la valeur du tableau id et valeur titre et valeur texte  -->
    <div class="row">
        <div class="card col-md-6">
            <img class="card-img-top" src="img/{$value['id']}.jpg " alt="{$value['titre']}">
            <div class="card-body">
                <h4 class="card-title">{$value['titre']} </h4>
                <p class="card-text">{$value['texte']}</p>
                <a class="btn btn-primary">'Créé le : ' . {$value.date_fr} . '</a>  
                <a href="article.php?action=modifier$id_article={$value['id']}" class="btn btn-warning">Modifier l'article</a>
                <a href="article.php?action=supprimer&id_article={$value['id']}" class="btn btn-danger">Supprimer l'article</a>
            </div>
        </div>
    {/foreach}





    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
