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
            'allowUpdate' => false,
            'allowDelete' => false,
            'allowSort' => false,
            'fields' => array(
                array(
                    'label' => __('Id', 'User', false),
                    'field' => 'id',
                ),
                array(
                    'label' => __('User name', 'User', false),
                    'field' => 'username',
                ),                array(
                    'label' => __('Email', 'User', false),
                    'field' => 'email',
                ),
            )
        );

        $gridConfig = ipFilter('User_adminGridConfig', $gridConfig);
        return $gridConfig;
    }

}
