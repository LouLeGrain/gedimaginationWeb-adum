<?php
// Faire bien attention au contexte d'appel de chaque fonction (gestion d'exceptions quasi inexistante)
require 'db.php';

function getDb()
{
    return Database::getDB();
}

function insertUser()
{
    $pdo = getDb();
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

function connect()
{
    if (!empty($_POST) && !empty($_POST['login']) && !empty($_POST['mdp'])) {
        $pdo = getDb();
        $req = $pdo->prepare('SELECT * FROM Utilisateur WHERE email ="' . $_POST['login'] . '";');
        $req->execute();
        $user = $req->fetch();
        if ($user == null) {
            $_SESSION['infos']['danger'] = 'Identifiant inconnu';
            header('Location: connexion.php');
            exit();
        } elseif (password_verify($_POST['mdp'], $user['mdp'])) {
            $_SESSION['auth'] = $user;
            $_SESSION['infos']['success'] = 'Vous êtes maintenant connecté. <a class="alert-link" href="tableaudebord.php">Aller au tableau de bord</a>';
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['infos']['danger'] = 'Mmot de passe incorrect';
            header('Location: connexion.php');
        }
    }
}

function deconnect()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    unset($_SESSION['auth']);
}

function loggedOnly()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['auth'])) {
        $_SESSION['infos']['danger'] = "Vous n'avez pas le droit d'accéder à cette page. Connectez vous à votre compte pour accéder à votre tableau de bord";
        header('Location: connexion.php');
        exit();
    }
}

function uploadImg()
{
    $dossier = 'participations/';
    if (!file_exists($dossier)) {
        mkdir($dossier, 0700);
    }
    $fichier = basename($_FILES['imgParticipation']['name']);
    $taille_maxi = 3000000;
    $taille = filesize($_FILES['imgParticipation']['tmp_name']);
    $extensions = array('.png', '.gif', '.jpg', '.jpeg');
    $extension = strrchr($_FILES['imgParticipation']['name'], '.');
//Début des vérifications de sécurité...
    if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
    {
        $_SESSION['infos']['danger'] = 'Vous devez uploader un fichier de type png, gif, jpg, ou jpeg';
        header('Location: tableaudebord.php');
        exit();
    }
    if ($taille > $taille_maxi) {
        $_SESSION['infos']['danger'] = 'Le fichier est trop gros... La taille maximale est de 3Mo';
        header('Location: tableaudebord.php');
        exit();
    }

    //On formate le nom du fichier ici...
    $fichier = strtr($fichier,
        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);

    if (move_uploaded_file($_FILES['imgParticipation']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
    {
        $_SESSION['infos']['success'] = 'Upload effectué, votre participation à été prise en compte';
        $pdo = getDb();
        // On génère l'url
        $url = $dossier . $fichier;
        // On l'enregistre dans la session pour alléger le nombre de requetes
        setImgUrlInSession($url);
        // On enregistre l'url de l'image dans la base de données
        $req = $pdo->prepare("INSERT INTO ImageParticipation SET url = '$url'");
        $req->execute();
        $img_id = $pdo->lastInsertId();
        // On mets a jour l'id de l'image du participant dans la variable de session
        $_SESSION['auth']['idImageParticipation'] = $img_id;
        // Puis dans la base de données
        $req = $pdo->prepare("UPDATE `Utilisateur` SET `idImageParticipation` = '$img_id' WHERE `email` ='" . $_SESSION['auth']['email'] . "';");
        $req->execute();

    } else //Sinon (la fonction renvoie FALSE).
    {
        $_SESSION['infos']['danger'] = 'Echec de l\'upload !';
    }
    header('Location: tableaudebord.php');
    exit();
}

function displayInfos()
{
    if (isset($_SESSION['infos'])) {
        foreach ($_SESSION['infos'] as $type => $content) {
            switch ($type) {
                case "success":
                    echo "<div class='alert alert-success alert-dismissable text-center'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong><span class='glyphicon glyphicon-ok'></span> </strong> $content</div>";
                    break;
                case "danger":
                    echo "<div class='alert alert-warning alert-dismissable text-center'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Oops !</strong> $content</div>";
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

function displayParticipation()
{
    if (isset($_SESSION['auth']['urlImageParticipation'])) {
        $url = $_SESSION['auth']['urlImageParticipation'];
        echo "<img src='$url' id='maParticipation' alt='Ma participation au concours (session)'/>";
    } elseif (!is_null($_SESSION['auth']['idImageParticipation'])) {
        $url = getImgUrl();
        setImgUrlInSession($url);
        echo "<img src='$url' id='maParticipation' alt='Ma participation au concours (cherchée)'/>";
    } else {
        echo "<div class='alert alert-info alert-dismissable text-center'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <strong>Vous n'avez pas encore participé ! Participez vite à l'aide du formulaire ci-dessus</strong></div>";
    }
}

function setImgUrlInSession($imgUrl)
{
    $_SESSION['auth']['urlImageParticipation'] = $imgUrl;
}

function getImgUrl()
{
    $pdo = getDb();
    $id = $_SESSION['auth']['idImageParticipation'];
    $req = $pdo->prepare("SELECT url FROM ImageParticipation WHERE id  = '$id'");
    $req->execute();
    $res = $req->fetch();
    return (string) $res[0];
}

function displayWinners()
{
    // du 03/03/2018 au 31/03/2018
    $gagnants = getTopThree();
    foreach ($gagnants as $position => $gagnant) {
        $nom = $gagnant['nom'];
        $note = $gagnant['note'];
        $url = $gagnant['url'];
        $position++;
        echo "<h3><b>N°$position : $nom</b> avec une note de <b>$note</b> sur 5</h3><br/><img src='$url' width='100%' alt='participation de $nom'/>";
    }
}

function getTopThree()
{
    $pdo = getDb();
    $req = $pdo->prepare("SELECT Utilisateur.nom, url, note from ImageParticipation JOIN Utilisateur ON ImageParticipation.id = Utilisateur.idImageParticipation ORDER by note DESC LIMIT 3");
    $req->execute();
    return $req->fetchAll();
}

function modifierUser()
{
    if ($_POST['nom'] != $_SESSION['auth']['nom']) {
        modifierNom($_POST['nom']);
    }

    if ($_POST['email'] != $_SESSION['auth']['email']) {
        modifierEmail($_POST['email']);
    }

    if (!isset($_SESSION['infos']['success'])) {
        $_SESSION['infos']['success'] = 'Rien a modifier !';
    }

    header('Location: tableaudebord.php');
    exit();

}

function modifierNom($nom)
{
    $pdo = getDb();
    $req = $pdo->prepare("UPDATE `Utilisateur` SET `nom` = '$nom' WHERE `email` ='" . $_SESSION['auth']['email'] . "';");
    $req->execute();
    $_SESSION['infos']['success'] = 'Modification de données utilisateur effectuée (nom)';
    $_SESSION['auth']['nom'] = $_POST['nom'];
}
function modifierEmail($email)
{
    $pdo = getDb();
    $req = $pdo->prepare("UPDATE `Utilisateur` SET `email` = '$email' WHERE `email` ='" . $_SESSION['auth']['email'] . "';");
    $req->execute();
    $_SESSION['infos']['success'] = 'Modification de données utilisateur effectuée (email)';
    $_SESSION['auth']['email'] = $_POST['email'];
}
function supprimerUser()
{
    $pdo = getDb();
    $id = $_SESSION['auth']['id'];
    $req = $pdo->prepare("DELETE from Utilisateur where id = $id");
    $req->execute();
    deconnect();
    header('Location: index.php');
    $_SESSION['infos']['deleted'] = 'Votre compte à été supprimé';
    exit();
}
