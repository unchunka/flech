<?php

namespace Controller;

use Model\Hike;
use Model\Difficulty;
use Model\PDOManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Silex\Application;
use Silex\Provider\MonologServiceProvider;
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

        /* DO NOT ACTIVATE LOG * /
        $this->app->register(new MonologServiceProvider(), array(
            'monolog.name' => 'system',
            'monolog.logfile' => __DIR__.'/../logs/system-'. date('d-m-y').'.log',
            'monolog.level' => Logger::WARNING
        ));

        $app['logger'] = function () {
            $t = new Logger('app');
            $t->pushHandler(new StreamHandler(__DIR__.'/../logs/debug-'. date('d-m-y').'.log',Logger::DEBUG));
            return $t;
        };
        /**/

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

        $app->get('/quotes', function () use ($app) {
            return $app['twig']->render('quotes.twig');
        })->bind('quotes');

        $app->get('/liens', function () use ($app) {
            return $app['twig']->render('links.twig');
        })->bind('links');

        $app->get('/pictures', function () use ($app) {
            return $app['twig']->render('pictures.twig');
        })->bind('pictures');

        $app->get('/hiking', function () use($app) {
            $hikes = Hike::findAll();
            $difficulties = Difficulty::findAll();
            return $app['twig']->render('hiking.twig', ['hikes' => $hikes, 'difficulties' => $difficulties]);
        })->bind('hiking');

        $app->get('/equipment', function () use($app) {
            $hikes = Hike::findAll();
            return $app['twig']->render('equipment.twig', ['hikes' => $hikes]);
        })->bind('equipment');

    }

    public function run () {

        $this->app->run();

    }

    public function commit() {

        PDOManager::getInstance()->getPDO()->commit();

    }


}