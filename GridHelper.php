<?php
/**
 * @package   ImpressPages
 */




namespace Plugin\User;


class GridHelper
{
    public static function beforeDelete($id)
    {
        Service::delete($id);
    }
    public static function beforeUpdate($id, $postData)
    {
        Service::update($id, $postData);
    }

    public static function updateFilter($id, $data)
    {
        //remove username and email as these fields will be updated by beforeUpdate.
        unset($data['username']);
        unset($data['email']);
        unset($data['password']);
        return $data;
    }
}
