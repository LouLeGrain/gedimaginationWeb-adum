<?php
// Autoload généré par Composer
$loader = require_once '../vendor/autoload.php';

$klein = new \Klein\Klein();

$klein->respond(function ($request, $response, $service, $app) use ($klein) {
    $app->register('twig', function () {
        $loader = new Twig_Loader_Filesystem('../views');
        return new Twig_Environment($loader, array('debug' => true));
    });
});

$klein->respond('GET', '/?', function ($request, $response, $service, $app) {
    $results = "stuff";
    echo $app->twig->render('index.html.twig', array('data' => $results));
});

$klein->respond('GET', '/connexion', function ($request, $response, $service, $app) {
    $results = "stuff";
    echo $app->twig->render('login.html.twig', array('data' => $results));
});

$klein->dispatch();
