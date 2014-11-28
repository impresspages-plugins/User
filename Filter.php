<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 14.11.28
 * Time: 21.16
 */

namespace Plugin\User;


class Filter {
    public static function ipUserData($data)
    {
        $user = Service::get($data['id']);
        if (!$user || $user['isDeleted']) {
            return $data;
        }

        $data = array_merge($user, $data);
        return $data;
    }
}
