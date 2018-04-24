<?php
require '../src/autoload.php';
Database::supprimerUser();
header('Location: index.php');
exit();
