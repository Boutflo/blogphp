<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">S'inscrire sur le blog</h1>

        </div>
    </div>
    <!-- Formulaire inscription -->
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


