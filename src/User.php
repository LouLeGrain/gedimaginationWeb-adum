<?
class User
{

    public static function create($email = null, $mdp = null, $nom = null, $role = "voter")
    {
        if (isset($_POST['login']) && $email == null) {
            $email = $_POST['login'];
        }

        if (isset($_POST['mdp']) && $mdp == null) {
            if (isset($_POST['mdpConf']) && $_POST['mdpConf'] == $_POST['mdp']) {
                $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
                $role = "user";
            } else {
                $_SESSION['infos']['warning'] = 'Lors de la confirmation du mot de passe !';
                header("Location:inscription.php");
                exit;
            }
        }

        if (isset($_POST['nom']) && $nom == null) {
            $nom = $_POST['nom'];
        }
        $pdo = Database::getPDO();
        // On enregistre les informations dans la base de données
        if (!User::isAlreadyRegistered($_POST['login'])) {
            $req = $pdo->prepare("INSERT INTO Utilisateur SET email = ?, mdp = ?, nom = ?, role = ?");
            $inscrit = $req->execute([$email, $mdp, $nom, $role]);
            if ($inscrit) {
                $_SESSION['infos']['success'] = 'Vous avez bien été inscrit.';
                $_SESSION['infos']['info'] = 'Vous devez être client de Negomat pour participer, la vérification s\'effectue à la publication de votre photo.';
                header('Location: connexion.php');
                exit;
            } else {
                $_SESSION['infos']['warning'] = 'Lors de votre inscription en base de donnée';
                header('Location: inscription.php');
                exit;
            }
        } else {
            $_SESSION['infos']['warning'] = 'Vous êtes déjà inscrit avec ce mail';
            header('Location: inscription.php');
            exit;
        }
        exit;
    }

/**
 * Récupère le nombre de G'aime selon l'id de l'image passée en paramètre
 *  En profite pour mettre à jour le nombre de G'aime dans la base
 * @param int $idImage
 * @return double la note calculée ou false si il y a aucun vote
 */
    public static function getNbGaime($idImage)
    {
        $pdo = Database::getPDO();
        $req = $pdo->prepare("SELECT note FROM Vote WHERE idImage = $idImage;");
        $req->execute();
        $votes = $req->fetchAll();
        if ($votes) {
            $nbGaime = 0;
            foreach ($votes as $vote) {
                $nbGaime += $vote['note'];
            }
            $reqbis = $pdo->prepare("UPDATE ImageParticipation SET nbGaime = $nbGaime WHERE id = $idImage");
            $reqbis->execute();
            return $nbGaime;
        } else {
            return 0;
        }
    }

    public static function getImgUrl()
    {
        $pdo = Database::getPDO();
        $id = $_SESSION['auth']['idImageParticipation'];
        $req = $pdo->prepare("SELECT url FROM ImageParticipation WHERE id  = '$id'");
        $req->execute();
        $res = $req->fetch();
        return (string) $res[0];
    }

    public static function isAlreadyRegistered($email)
    {
        $pdo = Database::getPDO();
        $req = $pdo->prepare("SELECT * FROM Utilisateur WHERE email ='$email';");
        $req->execute();
        $user = $req->fetch();
        if ($user === false) {
            return false;
        } else {
            return true;
        }
    }

    public static function hasVoted($idVotant = null)
    {
        if ($idVotant == null) {
            if (isset($_SESSION['auth']['id'])) {
                $idVotant = $_SESSION['auth']['id'];
            }
        }
        $pdo = Database::getPDO();
        $req = $pdo->prepare("SELECT * FROM Vote WHERE idVotant=$idVotant;");
        $req->execute();
        $user = $req->fetch();
        if ($user === false) {
            return false;
        } else {
            return true;
        }
    }

    public static function modifier()
    {
        if ($_POST['nom'] != $_SESSION['auth']['nom']) {
            self::modifierNom($_POST['nom']);
        }

        if ($_POST['email'] != $_SESSION['auth']['email']) {
            self::modifierEmail($_POST['email']);
        }

        if (!isset($_SESSION['infos']['success'])) {
            $_SESSION['infos']['success'] = 'Rien a modifier !';
        }

        header('Location: tableaudebord.php');
        exit();

    }

    public static function modifierNom($nom)
    {
        $pdo = Database::getPDO();
        $req = $pdo->prepare("UPDATE `Utilisateur` SET `nom` = '$nom' WHERE `email` ='" . $_SESSION['auth']['email'] . "';");
        $req->execute();
        $_SESSION['infos']['success'] = 'Modification de données utilisateur effectuée (nom)';
        $_SESSION['auth']['nom'] = $_POST['nom'];
    }

    public static function modifierEmail($email)
    {
        $pdo = Database::getPDO();
        $req = $pdo->prepare("UPDATE `Utilisateur` SET `email` = '$email' WHERE `email` ='" . $_SESSION['auth']['email'] . "';");
        $req->execute();
        $_SESSION['infos']['success'] = 'Modification de données utilisateur effectuée (email)';
        $_SESSION['auth']['email'] = $_POST['email'];
    }

    public static function supprimer()
    {
        $pdo = Database::getPDO();
        $id = $_SESSION['auth']['id'];
        $req = $pdo->prepare("DELETE from Utilisateur where id = $id");
        $req->execute();
        Database::deconnect();
        header('Location: index.php');
        $_SESSION['infos']['deleted'] = 'Votre compte à été supprimé';
        exit();
    }

}
