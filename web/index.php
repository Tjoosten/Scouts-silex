<?php

require_once __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Symfony\Component\Translation\Loader\YamlFileLoader;

$app = new Application();

// dotenv config loader
$dotenv = new Dotenv('../');
$dotenv->load();

// Enable it only for development.
$app['debug'] = true;

// Register singleton's.
$app->register(new SessionServiceProvider());
$app->register(new DoctrineServiceProvider(), [
    'dbs.options' => [
        'mysql' => [
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'CodeStart',
            'user'      => 'root',
            'password'  => 'password',
            'charset'   => 'utf8',
        ]
    ]
]);

// Twig templating engine.
$app->register(new TwigServiceProvider(), [
    'twig.path' => '../views'
]);

// Translation.
$app->register(new TranslationServiceProvider(), [
    'locale_fallbacks' => ['en'],
]);

$app['translator'] = $app->share($app->extend('translator', function($translator) {
    $translator->addLoader('yaml', new YamlFileLoader());
    $translator->addResource('yaml', '../translations/nl.yml', 'nl');
    return $translator;
}));

// set local
$app['translator']->setLocale('nl');

// routing
$app->mount('/authencation', include '../controllers/authencation.php');

// Bootstrap this thing.
$app->run();
