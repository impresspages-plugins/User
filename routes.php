<?php


$routes['passwordReset/{userId}/{secret}'] = array(
    'name' => 'User_passwordReset2',
    'controller' => 'SiteController',
    'action' => 'passwordReset2'
);

$routes['hello-world'] = function() {
    return 'Hello world!';
};

$routes['test'] = array(
    'name' => 'asdfadf',
    'action' => function() {
            return 'test';
        }
);




//$routes['passwordReset/{userId}/{secret}'] = array(
//    'name' => 'User_passwordReset',
//    'controller' => 'SiteController',
//    'action' => 'passwordReset'
//);


