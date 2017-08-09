<?php

namespace Controller;

use Model\Hike;
use Monolog\Logger;
use Silex\Application;
use Silex\Provider\MonologServiceProvider;
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

        $this->app->register(new MonologServiceProvider(), array(
            'monolog.logfile' => __DIR__.'/../logs/errors-'. date('d-m-y').'.log',
            'monolog.level' => Logger::WARNING
        ));

    }

    public function initRooting () {

        $app = $this->app;

        $app->get('/', function () use ($app) {
            return $app['twig']->render('home.twig');
        });

        $app->get('/home', function () use ($app) {
            return $app['twig']->render('home.twig');
        })->bind('home');

        $app->get('/me', function () use ($app) {
            return $app['twig']->render('me.twig');
        })->bind('me');

        $app->get('/citations', function () use ($app) {
            return $app['twig']->render('citations.twig');
        })->bind('citations');

        $app->get('/liens', function () use ($app) {
            return $app['twig']->render('links.twig');
        })->bind('links');

        $app->get('/pictures', function () use ($app) {
            return $app['twig']->render('pictures.twig');
        })->bind('pictures');

        $app->get('/randos', function () use($app) {
            $hikes = Hike::findAll();
            return $app['twig']->render('hiking.twig', ['hikes' => $hikes]);
        })->bind('randos');

    }

    public function run () {

        $this->app->run();

    }


}