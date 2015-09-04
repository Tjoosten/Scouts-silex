<?php

use Symfony\Component\HttpFoundation\Request;

$authencation = $app['controllers_factory'];

/**
 * Get the login view
 *
 * @link GET authencation/login.
 *
 * @param Request $request.
 * @param $app
 */
$authencation->get('/login', function(Request $request) use($app) {
    $viewVariables['title'] = $app['translator']->trans('title_login');

    return $app['twig']->render('login.html.twig', $viewVariables);
});

/**
 * Try to login in against the database.
 *
 * @link POST authencation/login.
 *
 * @param Request $request.
 * @param $app
 */
$authencation->post('/login', function(Request $request) use($app) {
    $statement = 'SELECT * FROM users WHERE email = ? and password = ?';

    $bindParams = [
        (string) $request->get('username'),
        (string) $request->get('password'),
    ];

    $query = $app['dbs']['mysql']->fetchAssoc($statement, $bindParams);

    if (! count($query) == 1) {
        $sessionData['message'] = '';
        $sessionData['message'] = $app['translator']->trans('message_loginError');
        $sessionData['heading'] = $app['translator']->trans('heading_loginError');

        $redirect = $app->redirect($_SERVER['HTTP_REFERER']);
    } else {
        $sessionData['class']   = 'alert alert-success';
        $sessionData['message'] = $app['translator']->trans('message_loginSuccess');
        $sessionData['heading'] = $app['translator']->trans('heading_loginSuccess');

        $redirect = $app->redirect($_SERVER['HTTP_REFERER']);
    }

    $app['session']->getFlashBag()->add('notification', $sessionData);
    return $redirect;
});

return $authencation;