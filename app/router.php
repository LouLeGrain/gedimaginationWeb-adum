<?php
require_once '../vendor/autoload.php';
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

// Login POST'd
$klein->respond('POST', '/connexion', function ($request, $response, $service) {
    require '../src/User.php';
    $user = User::findByEmail($request->param('login'));
    if (null !== $user) {
        //récup valeurs entrées
        $rawPasswd = $_POST["mdp"];
        $login = $_POST["login"];

        //on va chercher le mdp crypté correspondant a l'email
        $query = $app->db->prepare("Select * from User where email='" . $login . "';");
        $query->execute();
        $results = $query->fetch();

        //on crypte le mdp entré, salage avec l'id
        $password = sha1($results["id"] . $rawPasswd);

        if ($password !== $user->password) {
            throw new InvalidPasswordException();
        } else {
            // Set our current user to the newly logged in user's ID
            $service->startSession();
            $_SESSION['current_user'] = $user->id;

            // Redirect to our logged-in home page
            $response->redirect('/tableaudebord');
        }
    }
});

$klein->respond(array('POST', 'GET'), '/tableaudebord', function ($request, $response, $service, $app) {
    if ($request->server()['HTTP_REFERER'] == "http://gedimagination/connexion") {
        echo $app->twig->render('dashboard.html.twig', array('user' => User::findById($_SESSION['current_user'])));
    } else {
        echo $app->twig->render('dashboard.html.twig');
    }

});

$klein->dispatch();
