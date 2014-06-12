<?php
/**
 * @package   ImpressPages
 */


namespace Plugin\User;


class Slot {

    public static function User_login()
    {
        if (ipUser()->loggedIn()) {
            return '';
        } else {
            $form = FormModel::loginForm();
            $data = array (
                'form' => $form,
                'registrationUrl' => ipRouteUrl('User_registration'),
                'passwordResetUrl' => ipRouteUrl('User_passwordReset1')

            );
            return ipView('view/login.php', $data)->render();
        }
    }
    public static function User_passwordReset()
    {
        $form = FormModel::passwordResetForm1();
        $data = array (
            'form' => $form
        );
        return ipView('view/passwordReset1.php', $data)->render();
    }
    public static function User_profile()
    {
        if (ipUser()->loggedIn()) {
            $form = FormModel::profileForm();
            $data = array (
                'form' => $form,
                'isProfileUpdated' => false
            );

            if (!empty($_SESSION['user']['profileUpdated'])) {
                $data['isProfileUpdated'] = true;
                unset($_SESSION['user']['profileUpdated']);
            }

            return ipView('view/profile.php', $data)->render();
        } else {
            return '';
        }
    }
    public static function User_registration()
    {
        if (ipUser()->loggedIn()) {
            return '';
        } else {
            $form = FormModel::registrationForm();
            $data = array (
                'form' => $form
            );
            return ipView('view/registration.php', $data)->render();
        }

    }

    public static function User_logout()
    {
        if (ipUser()->loggedIn()) {
            $form = FormModel::logoutForm();
            $data = array (
                'form' => $form
            );
            return ipView('view/logout.php', $data)->render();
        } else {
            return '';
        }
    }


    public static function User_delete()
    {
        if (ipUser()->loggedIn()) {
            $form = FormModel::deleteForm();
            $data = array (
                'form' => $form
            );
            return ipView('view/delete.php', $data)->render();
        } else {
            return '';
        }
    }
}
