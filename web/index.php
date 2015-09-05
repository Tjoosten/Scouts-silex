<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Translation\Loader\YamlFileLoader;

$app = new Silex\Application();

// dotenv config loader
$dotenv = new Dotenv\Dotenv('../');
$dotenv->load();

// Check for existance in de .env file.
$checkConfigVars = $dotenv->required([]);
$checkConfigVars->notEmpty();

// Enable it only for development.
$app['debug'] = true;

// Register singleton's.
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider(), [
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
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => '../views'
]);

// Translation.
$app->register(new Silex\Provider\TranslationServiceProvider(), [
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
