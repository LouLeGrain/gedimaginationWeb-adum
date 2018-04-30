<?php
require '../src/autoload.php';
User::supprimer();
header('Location: index.php');
exit();
