<?php

$routes['passwordReset'] = array(
    'name' => 'User_passwordReset1',
    'controller' => 'SiteController',
    'action' => 'passwordReset'
);

$routes['passwordReset/{userId}/{secret}'] = array(
    'name' => 'User_passwordReset2',
    'controller' => 'SiteController',
    'action' => 'passwordReset2'
);

$routes['registration'] = array(
    'name' => 'User_registration',
    'controller' => 'SiteController',
    'action' => 'registration'
);

$routes['login'] = array(
    'name' => 'User_login',
    'controller' => 'SiteController',
    'action' => 'login'
);





