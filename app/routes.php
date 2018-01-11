<?php

use Symfony\Component\HttpFoundation\Request;

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('accueil');

// Page d'inscription 
$app->get('/inscription', function () use ($app) {
    return $app['twig']->render('register.html.twig');
})->bind('inscription');

// Login form
$app->get('/connexion', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('connexion');