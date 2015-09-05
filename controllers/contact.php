<?php

use Symfony\Component\HttpFoundation\Request;

$page = $app['controllers_factory'];

$page->get('/', function() use($app) {
    $viewVariables['title']  = $app['translator']->trans();
    $viewVariables['active'] = 2;

    return $app['twig']->render('contact.html.twig', $viewVariables);
});

$page->post('/', function() use($app) {

});

return $page;