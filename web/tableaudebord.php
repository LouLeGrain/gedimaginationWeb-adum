<?php
require '../src/autoload.php';
Display::loggedOnly();
Display::header();
Display::infos();
?>
        <div>
            <h1>Tableau de Bord</h1>
            <p>Vous pouvez participer au jeu concours en envoyant votre candidature via le formulaire dédié ! (taille d'image limitée à 3Mo)</p>
            <div class="row">
            <div class="col-md-6 col-lg-6">
                <h2>Participer</h2><hr/>
                <form  method="post" action="participation.php" enctype="multipart/form-data">
                <div class='alert alert-info'>Entrez les 4 premiers numéros de votre ticket de caisse</div>
                <div class="form-group">
                    <input class="form-control col-md-2 col-lg-2" maxlength="4" id="ticket" type="text" name="codeTicket" placeholder="Ex : 0472"/>
                </div>
                <div class="form-group">
                        <input type="file" name="imgParticipation" class="voffset">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Participer !</button>
                </div>
            </form>
            </div>
            <div class="col-md-6 col-lg-6">
                <h2>Informations</h2><hr/>
                <form class="form-signin form-horizontal" role="form" action="modifConf.php" method="post">
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="Email" required value="<?echo $_SESSION['auth']['email']; ?>"/>
                    </div>
                    <div class="form-group">
                            <input type="text" name="nom" class="form-control" placeholder="Nom / prénom" required value="<?echo $_SESSION['auth']['nom']; ?>">
                    </div>
                    <div class="form-group">
                            <button type="submit" class="btn btn-default btn-primary">Modifier</button>
                            <button class="btn btn-default btn-danger disabled">Réinitialiser mon mot de passe</button>
                    </div>
                </form>
                    <form class="form-signin form-horizontal" role="form" action="supprConf.php" method="post">
                    <div class="form-group voffset">
                        <button class="btn btn-default btn-danger">Supprimer mon compte</button>
                    </div>
                </form>
            </div>
            <div class="col-md-12 col-lg-12 jumbotron">
                <h2>Ma participation</h2>
                <?php Display::participation();?>
            </div>
            </div>
        </div>

<?php include 'footer.php';?>
