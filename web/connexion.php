<?php
session_start();
include 'header.php';
require 'helpers.php';
displayInfos();
?>
        <div id="content"><h2 class="text-center">Authentification</h2>
        <br/>
<div class="well">
    <form class="form-signin form-horizontal" id="formLogin" role="form" action="connexionConf.php" method="post">
        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
            <input type="text" name="login" class="form-control" placeholder="Entrez votre email" required autofocus>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <input type="password" name="mdp" class="form-control" placeholder="Entrez votre mot de passe" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Se connecter</button>
            </div>
        </div>
    </form>
</div>
</div>
<?php include 'footer.php';?>
