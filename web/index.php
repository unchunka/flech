<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../view',
));

$app['twig']->addExtension(new Twig_Extensions_Extension_I18n());

$app->get('/', function () use ($app) {
	return $app['twig']->render('home.twig');
});

$app->get('/home', function () use ($app) {
	return $app['twig']->render('home.twig');
})->bind('home');

$app->get('/contact', function () use ($app) {
	return $app['twig']->render('contact.twig');
})->bind('contact');

$app->get('/citations', function () use ($app) {
	return $app['twig']->render('citations.twig');
})->bind('citations');

$app->get('/links', function () use ($app) {
    return $app['twig']->render('links.twig');
})->bind('links');

$app->get('/news', function () use ($app) {
    return $app['twig']->render('news.twig');
})->bind('news');

$app->get('/randos', function () use ($app) {
    return $app['twig']->render('hiking.twig');
})->bind('randos');

$app->run();

?>