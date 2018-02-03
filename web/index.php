<?php
session_start();
require 'helpers.php';
displayInfos();
if (isset($_SESSION['auth'])) {
    include 'headerLogged.php';
} else {
    include 'header.php';
}
?>
        <div id="content">
            <h1>Concours Gedimagination</h1>
            <p>Bienvenue sur le site du concours Gedimagination développé par Négomat suite à la collaboration des groupes <b>Gedimat</b> et <b>Interway</b></p>
<br/>Vous pouvez vous inscrire au concours en créant un compte dans la section "Inscription" prévue a cet effet (accessible en haut à droite)<p/>
            <h2>Règlement</h2>
            <p>
<b>Calendrier du jeu concours</b>: Le jeu concours est ouvert du <b>03/03/2018</b> au <b>31/03/2018</b>. Les votes peuvent débuter la semaine suivant la clôture des inscriptions et durent un mois. Le classement des meilleures réalisations sera effectué dès la clôture des votes et communiquée aux participants.
<br/><b>Participant</b> : Pour participer au jeu (s’inscrire et poster une photo), il faut être client chez NEGOMAT, professionnel ou particulier.
<br/><b>Votant</b> : Pour voter, il faut être client du magasin et avoir fait un achat le jour du vote. Un seul vote par ticket de caisse n’est autorisé.
<br/><b>Vote</b> Chaque votant choisit ses trois réalisations préférées en attribuant à chacune un nombre de G’aime compris entre 1 et 5.
<br/><b>Gagnants</b> : Les trois gagnants du jeu concours sont les participants qui ont récolté le plus grand nombre de G’aime
            </p>
            <h2></h2>
        </div>
<?php include 'footer.php';?>
