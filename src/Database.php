<?
class Database
{
    private static $datasource = 'mysql:host=localhost; dbname=gedimagination';
    private static $username = 'root';
    private static $password = 'root';
    private static $pdo;

    public static function getPDO()
    {
        if (!isset(self::$db)) {
            self::$pdo = new PDO(self::$datasource, self::$username, self::$password);
        }
        return self::$pdo;
    }

    public static function insertUser()
    {
        $pdo = self::getPDO();
        // On enregistre les informations dans la base de données
        $req = $pdo->prepare("INSERT INTO Utilisateur SET email = ?, mdp = ?, nom = ?, role = 'user'");
        // On ne sauvegardera pas le mot de passe en clair dans la base mais plutôt un hash
        $password = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
        $req->execute([$_POST['login'], $password, $_POST['nom']]);
        $user_id = $pdo->lastInsertId();
        $_SESSION['infos']['success'] = 'Vous avez bien été inscrit.';
        $_SESSION['infos']['info'] = 'Vous devez être client de Negomat pour participer, la vérification s\'effectue à la publication de votre photo.';
        header('Location: connexion.php');
        exit();
    }

    public static function connect()
    {
        if (!empty($_POST) && !empty($_POST['login']) && !empty($_POST['mdp'])) {
            $pdo = self::getPDO();
            $req = $pdo->prepare('SELECT * FROM Utilisateur WHERE email ="' . $_POST['login'] . '";');
            $req->execute();
            $user = $req->fetch();
            if ($user == null) {
                $_SESSION['infos']['warning'] = 'Identifiant inconnu';
                header('Location: connexion.php');
                exit();
            } elseif (password_verify($_POST['mdp'], $user['mdp'])) {
                $_SESSION['auth'] = $user;
                $_SESSION['infos']['success'] = 'Vous êtes maintenant connecté. <a class="alert-link" href="tableaudebord.php">Aller au tableau de bord</a>';
                header('Location: index.php');
                exit();
            } else {
                $_SESSION['infos']['warning'] = 'Mmot de passe incorrect';
                header('Location: connexion.php');
            }
        }
    }

    public static function deconnect()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['auth']);
    }

    public static function getTopThree()
    {
        $pdo = self::getPDO();
        $req = $pdo->prepare("SELECT Utilisateur.nom, idImageParticipation, url from ImageParticipation JOIN Utilisateur ON ImageParticipation.id = Utilisateur.idImageParticipation LIMIT 3");
        $req->execute();
        return $req->fetchAll();
    }

    public static function getParticipants()
    {
        $pdo = self::getPDO();
        $req = $pdo->prepare("SELECT Utilisateur.nom, idImageParticipation, Imageparticipation.url, Utilisateur.id FROM ImageParticipation JOIN Utilisateur ON ImageParticipation.id = Utilisateur.idImageParticipation");
        $req->execute();
        return $req->fetchAll();
    }

}
