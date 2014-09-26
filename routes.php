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

$routes['updatePassword'] = array(
    'name' => 'User_updatePassword',
    'controller' => 'SiteController',
    'action' => 'updatePassword'
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

$routes['logout'] = array(
    'name' => 'User_logout',
    'controller' => 'SiteController',
    'action' => 'logout'
);

$routes['profile'] = array(
    'name' => 'User_profile',
    'controller' => 'SiteController',
    'action' => 'profile'
);


$routes['loginAsUser/{userId}'] = array(
    'name' => 'User_loginAsUser',
    'controller' => 'AdminController',
    'action' => 'loginAsUser'
);

