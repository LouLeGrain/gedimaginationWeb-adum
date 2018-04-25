<?

class Display
{
    public static function header()
    {
        if (isset($_SESSION['auth'])) {
            include 'headerLogged.php';
        } else {
            include 'header.php';
        }
    }

    public static function loggedOnly()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['auth'])) {
            $_SESSION['infos']['warning'] = "Vous n'avez pas le droit d'accéder à cette page. Connectez vous à votre compte pour accéder à votre tableau de bord";
            header('Location: connexion.php');
            exit();
        }
    }
/**
 * Undocumented function
 *
 * @return void
 */
    public static function infos()
    {
        if (isset($_SESSION['infos'])) {
            foreach ($_SESSION['infos'] as $type => $content) {
                switch ($type) {
                    case "success":
                        echo "<div class='alert alert-success alert-dismissable text-center'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong><span class='glyphicon glyphicon-ok'></span> </strong> $content</div>";
                        break;
                    case "warning":
                        echo "<div class='alert alert-warning alert-dismissable text-center'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Erreur !</strong> $content</div>";
                        break;
                    case "info":
                        echo "<div class='alert alert-info alert-dismissable text-center'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong><span class='glyphicon glyphicon-info-sign'></span> Info :</strong> $content</div>";
                        break;
                    case "deleted":
                        echo "<div class='alert alert-info alert-dismissable text-center'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong><span class='glyphicon glyphicon-info-sign'></span> Info :</strong> $content</div>";
                        break;
                }
                array_shift($_SESSION['infos']);
            }
        }

    }

    public static function participation()
    {
        if (isset($_SESSION['auth']['urlImageParticipation'])) {
            $url = $_SESSION['auth']['urlImageParticipation'];
            echo "<img src='$url' id='maParticipation' alt='Ma participation au concours (session)'/>";
        } elseif (!is_null($_SESSION['auth']['idImageParticipation'])) {
            $url = User::getImgUrl();
            $_SESSION['auth']['urlImageParticipation'] = User::getImgUrl();
            echo "<img src='$url' id='maParticipation' alt='Ma participation au concours (cherchée)'/>";
        } else {
            echo "<div class='alert alert-info alert-dismissable text-center'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Vous n'avez pas encore participé ! Participez vite à l'aide du formulaire ci-dessus</strong></div>";
        }
    }

    public static function participations()
    {
        $participants = Database::getParticipants();
        foreach ($participants as $participant) {
            $nom = $participant['nom'];
            $nbGaime = (!User::getNbGaime($participant['idImageParticipation'])) ? 0 : User::getNbGaime($participant['idImageParticipation']);
            $url = $participant['url'];
            echo "<div class='col-md-6 col-lg-6'>
        <div class='thumbnail'>
        <img src='$url' class='media-object' alt='participation de $nom'/>
        <div class='caption text-center'><h3>$nom <b>($nbGaime G'aime)</b></h3></div>
        </div>
        </div>";
        }
    }

    public static function gagnants()
    {
        // du 03/03/2018 au 31/03/2018
        $aujourdhui = new DateTime();
        $dateFinConcours = new DateTime("31-03-2018");
        // $dateFinConcours = new DateTime("03/03/2019"); //test d'affichage
        if ($dateFinConcours > $aujourdhui) {
            echo "<p>Le concours n'est pas terminé! Rien n'est encore joué, <a href='inscription.php'>cliquez ici</a> pour vous inscrire et participer</p>";
        } else {

            $gagnants = Database::getTopThree();
            foreach ($gagnants as $position => $gagnant) {
                $nom = $gagnant['nom'];
                $nbGaime = (!User::getNbGaime($gagnant['idImageParticipation'])) ? 0 : User::getNbGaime($gagnant['idImageParticipation']);
                $url = $gagnant['url'];
                $position++;
                echo "<div class='col-md-4 col-lg-4'>
        <div class='thumbnail'>
        <img src='$url' class='media-object' alt='participation de $nom'/>
        <div class='caption text-center'><h3>$nom <br/>(<b>$nbGaime</b> G'aime)</h3></div>
        </div>
        </div>";
            }
        }
    }

    public static function optionsForm()
    {
        $participants = Database::getParticipants();
        foreach ($participants as $participant) {
            $nom = $participant['nom'];
            $idImg = $participant['idImageParticipation'];
            echo "<option value='$idImg'><b>$nom</b>";
        }
    }

}
