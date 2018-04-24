<?
class User
{
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
        $votes = $req->fetch();
        if ($votes) {
            $nbGaime = array_sum($votes);
            $reqbis = $pdo->prepare("UPDATE ImageParticipation SET nbGaime = $nbGaime WHERE id = $idImage");
            $reqbis->execute();
            return $nbGaime;
        } else {
            return false;
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

    public static function supprimerUser()
    {
        $pdo = Database::getPDO();
        $id = $_SESSION['auth']['id'];
        $req = $pdo->prepare("DELETE from Utilisateur where id = $id");
        $req->execute();
        deconnect();
        header('Location: index.php');
        $_SESSION['infos']['deleted'] = 'Votre compte à été supprimé';
        exit();
    }

}
