<?php

use Symfony\Component\HttpFoundation\Request;

$page = $app['controllers_factory'];

/**
 * 
 */
$page->get('/', function() use($app) {
    $viewVariables['title']  = $app['translator']->trans('title_frontpage');
    $viewVariables['active'] = 0; // 0 because there is no statement for this active status. 

    return $app['twig']->render('frontpage.html.twig', $viewVariables);
});

return $page;
