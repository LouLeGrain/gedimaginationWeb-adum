<?php
session_start();
include 'helpers.php';
supprimerUser();
header('Location: index.php');
exit();
