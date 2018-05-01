<?php
require '../src/autoload.php';
if (!Helpers::isParticipationTime()) {
    $_SESSION['infos']['info'] = "Trop tard ! Les participations sont closes !";
    header("Location:tableaudebord.php");
    exit;
}
Helpers::uploadImg();
