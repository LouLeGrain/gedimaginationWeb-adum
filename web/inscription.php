<?php
require '../src/autoload.php';
include 'header.php';
Display::infos();?>
        <div id="content"><h2 class="text-center">Inscription</h2>
<div class="well">
    <form class="form-signin form-horizontal" id="formLogin" role="form" action="inscriptionConf.php" method="post">
        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
            <input type="text" name="login" class="form-control" placeholder="Email" required autofocus>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <input type="text" name="nom" class="form-control" placeholder="Nom / prénom" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <input type="password" name="mdp" class="form-control" placeholder="Mot de passe" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> S'inscrire</button>
            </div>
        </div>
    </form>
</div>
</div>
<?php include 'footer.php';?>
