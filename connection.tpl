
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Connection de l'utilisateur</h1>

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

    <form action="connection.php" method="post" enctype="multipart/form-data" id="form_connection">
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
            <button type="submit" class="btn btn-primary"  name="submit">Connection !!!!</button>
        </div>
    </form>

</div>


<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script src="js/dist/jquery.validate.min.js"></script>
<script src="js/dist/localization/message_fr.min.js"></script>


<script>
    $(document).ready(function () {
        $("#form_connection").validate();
    });
</script>


