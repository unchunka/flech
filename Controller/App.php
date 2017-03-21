<?php

namespace Controller;

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;

class App {

    private $app;

    function __construct () {

        $this->app = new Application();

        $this->app['debug'] = true;

        $this->app->register(new UrlGeneratorServiceProvider());

        $this->app->register(new TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/../View',
        ));

        $this->app['twig']->addExtension(new \Twig_Extensions_Extension_I18n());

    }

    function initRooting () {

        $app = $this->app;

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

    }

    public function run () {

        $this->app->run();

    }

}