<?php
require 'helpers.php';
deconnect();
$_SESSION['infos']['success'] = 'Vous êtes maintenant déconnecté. À bientôt !';
header('Location: index.php');
exit();
