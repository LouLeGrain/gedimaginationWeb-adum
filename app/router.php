<?php
session_start();

$loader = require_once '../vendor/autoload.php';
$klein = new \Klein\Klein();
require 'helpers.php';

// Enregistrement des services
$klein->respond(function ($request, $response, $service, $app) {
    $app->register('db', function () {
        try {
            require 'config.php';
            return new PDO("mysql:host=" . $app['db.options']['host'] . ";dbname=" . $app['db.options']['dbname'], $app['db.options']['user'], $app['db.options']['password']);
        } catch (PDOException $e) {
            print "Erreur : " . $e->getMessage() . "<br/>";
            die();
        }});

    $app->register('twig', function () {
        $loader = new Twig_Loader_Filesystem('../views');
        return new Twig_Environment($loader, array('debug' => true));
    });
});

// Routes
$klein->respond('GET', '/?', function ($request, $response, $service, $app) {
    echo $app->twig->render('index.html.twig');
});

$klein->respond('GET', '/connexion', function ($request, $response, $service, $app) {
    echo $app->twig->render('login.html.twig');
});

$klein->respond(array('POST', 'GET'), '/tableaudebord', function ($request, $response, $service, $app) {
    if ($request->server()['HTTP_REFERER'] == "http://gedimagination/connexion") {
        try {
            //récup valeurs entrées
            $rawPasswd = $_POST["mdp"];
            //instanciation tableau avec login & mdp
            $loginInputs[] = $_POST["login"];

            //on va chercher le mdp crypté correspondant a l'email
            $query = $app->db->prepare("Select * from User where email='" . $loginInputs[0] . "';");
            $query->execute();
            $results = $query->fetch();

            //on crypte le mdp entré, salage avec l'id
            $password = sha1($results["id"] . $rawPasswd);
            $loginInputs[] = $password;

            //on compare le mdp crypté de la bdd à celui entré
            if ($results["mdp"] == $loginInputs[1]) {
                $app->twig->addGlobal('logged', true);
                //TODO: vérifier l'utilisation des globales twig (pas persistentes ?) / switch sur $_Session
            } else {
                $app->twig->addGlobal('logged', false);
            }
        } catch (PDOException $e) {
            echo "Erreur: " . $e;
        }
        echo $app->twig->render('dashboard.html.twig', array('user' => $results));
    } else {
        echo $app->twig->render('dashboard.html.twig');
    }

});

$klein->dispatch();
