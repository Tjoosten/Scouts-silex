<?php

use Symfony\Component\HttpFoundation\Request;

$page = $app['controllers_factory'];

$page->get('/', function() use($app) {
    $viewVariables['title'] = $app['translator']->trans('title_frontpage');

    return $app['twig']->render('frontpage.html.twig', $viewVariables);
});

return $page;