<?php

require_once __DIR__.'/../vendor/autoload.php';

// Silex related use statements.
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Loader\YamlFileLoader;

// Routes related namespaces.
$app = new Application();

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

// Set up the swiftmailer.


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
$app->mount('/', include '../controllers/frontpage.php');
$app->mount('/contact', include '../controllers/contact.php');
$app->mount('/authencation', include '../controllers/authencation.php');

// Error handler.
$app->error(function(\Exception $e, $code ) {
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went wrong.';
    }

    return new Response($message);
});

// Bootstrap this thing.
$app->boot(); // Boot the security things.
$app->run();  // Run the application.
