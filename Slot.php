<?php
/**
 * @package   ImpressPages
 */


namespace Plugin\User;


class Slot {

    public static function User_login()
    {
        $form = Model::loginForm();
        $data = array (
            'form' => $form
        );
        return ipView('view/login.php', $data)->render();
    }
    public static function User_passwordReset()
    {
        $form = Model::passwordResetForm();
        $data = array (
            'form' => $form
        );
        return ipView('view/passwordReset.php', $data)->render();
    }
    public static function User_profile()
    {
        $form = Model::profileForm();
        $data = array (
            'form' => $form
        );
        return ipView('view/profile.php', $data)->render();
    }
    public static function User_registration()
    {
        $form = Model::registrationForm();
        $data = array (
            'form' => $form
        );
        return ipView('view/registration.php', $data)->render();
    }

    public static function User_logout()
    {
        $form = Model::logoutForm();
        $data = array (
            'form' => $form
        );
        return ipView('view/logout.php', $data)->render();
    }
}
