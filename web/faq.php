<?php
require '../src/autoload.php';
Display::infos();
Display::header();
?>
        <div>
            <h1>Foire aux questions</h1>
            <div class="row">
                <main>
                  <div class="topic">
    <div class="open">
      <h2 class="question">0. Chouette, un concours ! Quel est le principe ?</h2>
      <span class="faq-t"></span>
    </div>
    <p class="answer">Le concours <b>Gedima'gination</b> est organisé par votre magasin Negomat' pour fêter son entrée dans le groupe Gedimat. Le but est de recenser vos superbes réalisations avec nos produits, puis de vous faire élire les 3 meilleures, classées selon le nombre de G'aime reçus !</p>
  </div>
  <div class="topic">
    <div class="open">
      <h2 class="question">1. Qui peut participer ?</h2>
      <span class="faq-t"></span>
    </div>
    <p class="answer">Vous <b>devez</b> être un client de Negomat' inscrit sur ce site pour participer. À ce titre, une vérification des 4 premiers chiffres d'un ticket de caisse est effectuée lors de la mise en ligne de votre photo participation.</p>
  </div>
  <div class="topic">
    <div class="open">
    <h2 class="question">2. Comment s'inscrire ?
</h2><span class="faq-t"></span>
    </div>
    <p class="answer">Il suffit de vous inscrire en remplissant un simple formulaire <a href="inscription.php">à cette page</a>
  <br/><img class="img-thumbnail" src="lib/faq01.gif" alt="Procédure d'inscription"/>
  <br/>Une fois inscrit, vous serez redirigé sur la page de connexion afin d'accéder à votre espace membres pour participer : le tableau de bord</p>
  </div>
  <div class="topic">
    <div class="open">
    <h2 class="question">3. Comment participer ?</h2><span class="faq-t"></span>
    </div>
    <p class="answer">Il y a un formulaire dédié prévu à cet effet dans <a href="tableaudebord.php">votre tableau de bord</a>.
<br/><img class="img-thumbnail" src="lib/faq01.jpeg" alt="Formulaire de participation"></p>
  </div>
  <div class="topic">
    <div class="open">
    <h2 class="question">4. J'ai posté ma (super) photo, comment je gagne maintenant ?
</h2><span class="faq-t"></span>
    </div>
    <p class="answer">Une fois votre photo mise en ligne, elle s'affichera sur <a href="vote.php">la page de vote</a> aux côtés des participations des autres concurrents. Les votes sont ouverts une semaine avant la fin du concours, et ce jusqu'à un mois après la fermeture du concours. </p>
  </div>
  <div class="topic">
    <div class="open">
    <h2 class="question">5. Qui peut voter ?
</h2><span class="faq-t"></span>
    </div>
    <p class="answer">N'importe quel client ayant une adresse mail ! La page de vote de l'application n'étant disponible que via la présente tablette dans votre magasin Negomat'</p>
  </div>
  <div class="topic">
    <div class="open">
    <h2 class="question">6. Comment voter ?
</h2><span class="faq-t"></span>
    </div>
    <p class="answer">Via <a href="vote.php">la page de vote</a> : une fois votre e-mail entré, choisissez <b>3 gagnants distincts</b> et attribuez leur une note de 1 à 5, puis validez !
  <br/><img class="img-thumbnail" src="lib/faq02.gif" alt="Procédure de vote"/>
</p>
  </div>
</main>
            </div>
        </div>
<?php include 'footer.php';?>
