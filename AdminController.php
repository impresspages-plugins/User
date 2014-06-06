<?php
namespace Plugin\User;

class AdminController extends \Ip\GridController
{

    protected function config()
    {

        $gridConfig = array(
            'title' => __('Users', 'User', false),
            'table' => 'user',
            'sortField' => 'id',
            'createPosition' => 'top',
            'allowCreate' => false,
            'allowSort' => false,
            'fields' => array(
                array(
                    'label' => '',
                    'field' => 'id',
                    'preview' => function ($value, $recordData)
                        {
                            $manageUrl = ipRouteUrl('User_loginAsUser', array('userId'=> $recordData['id']));
                            return '<a target="_blank" class="btn btn-default" href="' . $manageUrl . '" >' . __('Login', 'User') . '</a>';
                        },
                    'allowSearch' => false
                ),
                array(
                    'label' => __('Id', 'User', false),
                    'field' => 'id',
                    'allowSearch' => false,
                    'allowUpdate' => false
                ),
                array(
                    'label' => __('User name', 'User', false),
                    'field' => 'username',
                ),
                array(
                    'label' => __('Email', 'User', false),
                    'field' => 'email',
                ),
                array(
                    'label' => __('Password', 'User', false),
                    'field' => 'hash',
                    'type' => 'Password',
                    'preview' => false
                )
            ),
            'beforeDelete' => array('Plugin\User\GridHelper', 'beforeDelete'),
            'beforeUpdate' => array('Plugin\User\GridHelper', 'beforeUpdate'),
            'updateFilter' => array('Plugin\User\GridHelper', 'updateFilter')
        );

        $gridConfig = ipFilter('User_adminGridConfig', $gridConfig);
        return $gridConfig;
    }


    public function loginAsUser($userId)
    {
        if (ipUser()->loggedIn()) {
            ipUser()->logout();
        }
        ipUser()->login($userId);
        return new \Ip\Response\Redirect(ipConfig()->baseUrl());
    }


}
