<?
class Helpers
{
    public static function uploadImg()
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
            $_SESSION['infos']['warning'] = 'Vous devez uploader un fichier de type png, gif, jpg, ou jpeg';
            header('Location: tableaudebord.php');
            exit();
        }
        if ($taille > $taille_maxi) {
            $_SESSION['infos']['warning'] = 'Le fichier est trop gros... La taille maximale est de 3Mo';
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
            $pdo = Database::getPDO();
            // On génère l'url
            $url = $dossier . $fichier;
            // On l'enregistre dans la session pour alléger le nombre de requetes
            self::setImgUrlInSession($url);
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
            $_SESSION['infos']['warning'] = 'Echec de l\'upload !';
        }
        header('Location: tableaudebord.php');
        exit();
    }

    public static function setImgUrlInSession($imgUrl)
    {
        $_SESSION['auth']['urlImageParticipation'] = $imgUrl;
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

    public static function processVotes()
    {
        $pdo = Database::getPDO();
        if (isset($_POST['mailSaisi'])) {
            $mailSaisi = $_POST['mailSaisi'];
            if (isset($_SESSION['auth'])) {
                $idVotant = $_SESSION['auth']['id'];
            } else { //si le votant à pas de compte on le créé
                $req = $pdo->prepare("INSERT INTO Utilisateur SET email = ?, role = 'voter'");
                $req->execute([$mailSaisi]);
                $idVotant = $pdo->lastInsertId();
            }

            if (!User::hasVoted($idVotant)) {

                // Préparation des requetes
                $idImageVotee1 = $_POST['idImgVote1'];
                $noteImageVotee1 = $_POST['vote1'];

                $idImageVotee2 = $_POST['idImgVote2'];
                $noteImageVotee2 = $_POST['vote2'];

                $idImageVotee3 = $_POST['idImgVote3'];
                $noteImageVotee3 = $_POST['vote3'];

                $params = [$mailSaisi];

                $req1 = $pdo->prepare("INSERT INTO Vote (idImage, idVotant, note) VALUES('$idImageVotee1', '$idVotant', '$noteImageVotee1')");
                $req1bis = $pdo->prepare("UPDATE ImageParticipation SET nbGaime = nbGaime+$noteImageVotee1 WHERE id = $idImageVotee1");
                $req2 = $pdo->prepare("INSERT INTO Vote (idImage, idVotant, note) VALUES('$idImageVotee2', '$idVotant', '$noteImageVotee2')");
                $req2bis = $pdo->prepare("UPDATE ImageParticipation SET nbGaime = nbGaime+$noteImageVotee2 WHERE id = $idImageVotee2");
                $req3 = $pdo->prepare("INSERT INTO Vote (idImage, idVotant, note) VALUES('$idImageVotee3', '$idVotant', '$noteImageVotee3')");
                $req3bis = $pdo->prepare("UPDATE ImageParticipation SET nbGaime = nbGaime+$noteImageVotee3 WHERE id = $idImageVotee3");
                //je fais un tableau de requetes
                $requetes = array($req1, $req1bis, $req2, $req2bis, $req3, $req3bis);
                $resultats = false; //flag en cas d'échec de requête
                //puis je les éxécute toutes
                foreach ($requetes as $requete) {
                    $resultats = $requete->execute();
                    if (!$resultats) {
                        $_SESSION['infos']['warning'] = 'Vous ne pouvez pas voter pour deux mêmes photos';
                    }
                }
                $_SESSION['infos']['success'] = 'Vos votes ont bien été pris en compte ! Rendez vous lors de l\'annonce des résultats !';
            } else {
                $_SESSION['infos']['warning'] = 'Vous avez déjà voté !';
            }
        }
    }

}
