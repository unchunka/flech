<?php

namespace Controller;

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\Yaml\Yaml;

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

    public function initRooting () {

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

        $app->get('/liens', function () use ($app) {
            return $app['twig']->render('links.twig');
        })->bind('links');

        $app->get('/pictures', function () use ($app) {
            return $app['twig']->render('pictures.twig');
        })->bind('pictures');

        $app->get('/randos', function () use ($app) {
            return $app['twig']->render('hiking.twig');
        })->bind('randos');

    }

    public function initDoctrine () {

        $dbConfig = Yaml::parse(file_get_contents(__DIR__.'/../config/db.yml'));

        $this->app->register(new DoctrineServiceProvider(), [
            'db.options' => [
                'driver'   => 'pdo_mysql',
                'dbname' => $dbConfig['dbname'],
                'host' => $dbConfig['host'],
                'user' => $dbConfig['user'],
                'password' => $dbConfig['password'],
                'charset' => 'UTF8'
            ],
        ]);

        //$dd = $this->app['db']->fetchAll('SELECT * FROM hike');
        //$d = 2;

    }

    public function run () {

        $this->app->run();

    }

}