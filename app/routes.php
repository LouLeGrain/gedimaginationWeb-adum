<?php

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});

// Page d'inscription 
$app->get('/register', function () use ($app) {
    return $app['twig']->render('register.html.twig');
});
// TODO : Page d'inscription