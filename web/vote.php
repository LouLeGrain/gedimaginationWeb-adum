<?php
require '../src/autoload.php';
Display::infos();
if (isset($_SESSION['auth'])) {
    include 'headerLogged.php';
    $email = $_SESSION['auth']['email'];
} else {
    include 'header.php';
    $email = "monmail@monfournisseur.fr";
}
Helpers::processVotes();
?>
        <div>
            <h1>Votes</h1>
            <p>Vous pouvez voter pour le jeu concours uniquement en renseignant votre email. </p>
            <div class="row">
                <h2>Voter</h2><hr/>
                <form  method="post" action="vote.php" enctype="multipart/form-data">
                <div class='row'>
                    <div class="form-group col-md-4 col-lg-4">
                            <label>Saisissez votre e-mail : </label>
                        <input class="form-control" maxlength="50" id="mailParticipation" type="text" name="mailSaisi" value="<?echo $email ?>" placeholder="<?echo $email ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label>Sélectionnez vos 3 gagnants : </label>
                    <div class="row">
                    <div class='col-md-4 col-lg-4'>
                        <select name="idImgVote1" class="form-control">
                            <?Display::optionsForm();?>
                        </select>
                        <fieldset class="rating one">
    <input type="radio" id="star5" name="vote1" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
    <input type="radio" id="star4half" name="vote1" value="4.5" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
    <input type="radio" id="star4" name="vote1" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
    <input type="radio" id="star3half" name="vote1" value="3.5" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
    <input type="radio" id="star3" name="vote1" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
    <input type="radio" id="star2half" name="vote1" value="2.5" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
    <input type="radio" id="star2" name="vote1" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
    <input type="radio" id="star1half" name="vote1" value="1.5" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
    <input type="radio" id="star1" name="vote1" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
    <input type="radio" id="starhalf" name="vote1" value="0.5" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
</fieldset>
                    </div>
                    <div class='col-md-4 col-lg-4'>
                        <select name="idImgVote2" class="form-control">
                            <?Display::optionsForm();?>
                        </select>
                        <fieldset class="rating two">
    <input type="radio" id="star5-2" name="vote2" value="5" /><label class = "full" for="star5-2" title="Awesome - 5 stars"></label>
    <input type="radio" id="star4half-2" name="vote2" value="4.5" /><label class="half" for="star4half-2" title="Pretty good - 4.5 stars"></label>
    <input type="radio" id="star4-2" name="vote2" value="4" /><label class = "full" for="star4-2" title="Pretty good - 4 stars"></label>
    <input type="radio" id="star3half-2" name="vote2" value="3.5" /><label class="half" for="star3half-2" title="Meh - 3.5 stars"></label>
    <input type="radio" id="star3-2" name="vote2" value="3" /><label class = "full" for="star3-2" title="Meh - 3 stars"></label>
    <input type="radio" id="star2half-2" name="vote2" value="2.5" /><label class="half" for="star2half-2" title="Kinda bad - 2.5 stars"></label>
    <input type="radio" id="star2-2" name="vote2" value="2" /><label class = "full" for="star2-2" title="Kinda bad - 2 stars"></label>
    <input type="radio" id="star1half-2" name="vote2" value="1.5" /><label class="half" for="star1half-2" title="Meh - 1.5 stars"></label>
    <input type="radio" id="star1-2" name="vote2" value="1" /><label class = "full" for="star1-2" title="Sucks big time - 1 star"></label>
    <input type="radio" id="starhalf-2" name="vote2" value="0.5" /><label class="half" for="starhalf-2" title="Sucks big time - 0.5 stars"></label>
</fieldset>
                    </div>
                    <div class='col-md-4 col-lg-4'>
                        <select name="idImgVote3" class="form-control">
                            <?Display::optionsForm();?>
                        </select>
                        <fieldset class="rating three">
    <input type="radio" id="star5-3" name="vote3" value="5" /><label class = "full" for="star5-3" title="Awesome - 5 stars"></label>
    <input type="radio" id="star4half-3" name="vote3" value="4.5" /><label class="half" for="star4half-3" title="Pretty good - 4.5 stars"></label>
    <input type="radio" id="star4-3" name="vote3" value="4" /><label class = "full" for="star4-3" title="Pretty good - 4 stars"></label>
    <input type="radio" id="star3half-3" name="vote3" value="3.5" /><label class="half" for="star3half-3" title="Meh - 3.5 stars"></label>
    <input type="radio" id="star3-3" name="vote3" value="3" /><label class = "full" for="star3-3" title="Meh - 3 stars"></label>
    <input type="radio" id="star2half-3" name="vote3" value="2.5" /><label class="half" for="star2half-3" title="Kinda bad - 2.5 stars"></label>
    <input type="radio" id="star2-3" name="vote3" value="2" /><label class = "full" for="star2-3" title="Kinda bad - 2 stars"></label>
    <input type="radio" id="star1half-3" name="vote3" value="1.5" /><label class="half" for="star1half-3" title="Meh - 1.5 stars"></label>
    <input type="radio" id="star1-3" name="vote3" value="1" /><label class = "full" for="star1-3" title="Sucks big time - 1 star"></label>
    <input type="radio" id="starhalf-3" name="vote3" value="0.5" /><label class="half" for="starhalf-3" title="Sucks big time - 0.5 stars"></label>
</fieldset>
                    </div>
                     </div>  <!-- Fin row  -->
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Voter !</button>
                </div>
            </form>
            </div>
            <div class="col-md-12 col-lg-12 jumbotron">
                <h2>Participations</h2>
                <?php Display::participations();?>
            </div>
            </div>
        </div>

<?php include 'footer.php';?>
