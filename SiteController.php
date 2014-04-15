<?php
/**
 * @package   ImpressPages
 */


namespace Plugin\User;


class SiteController extends \Ip\Controller
{


    public function register()
    {
        ipRequest()->mustBePost();
        $post = ipRequest()->getPost();

        $form = FormModel::registrationForm();

        $errors = $form->validate($post);

        if (ipRequest()->getPost('username') && Model::getByUsername(ipRequest()->getPost('username'))) {
            $errors['username'] = __("This username is already taken", 'User', false);
        }
        if (Model::getByEmail(ipRequest()->getPost('email'))) {
            $errors['email'] = __("This email is already registered", 'User', false);
        }


        $errors = ipFilter('User_registerFormValidate', $errors, array('post' => $post));

        if (!empty($errors)) {
            $data = array (
                'status' => 'error',
                'errors' => $errors
            );
            return new \Ip\Response\Json($data);
        }


        $data = $form->filterValues($post);

        $username = isset($data['username']) ? $data['username'] : null;
        $email = $data['email'];
        $password = $data['password'];

        $userId = Service::add($username, $email, $password);
        ipUser()->login($userId);

        $eventData = array(
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'postData' => $post
        );
        ipEvent('User_register', $eventData);

        $redirect = ipConfig()->baseUrl();
        $profilePage = ipContent()->getPage('User_profile');
        if ($profilePage) {
            $redirect = $profilePage->getLink();
        }
        ipFilter('User_registrationRedirectUrl', $redirect, $eventData);


        $data = array (
            'status' => 'ok',
            'redirectUrl' => $redirect,
            'id' => $userId
        );
        return new \Ip\Response\Json($data);
    }

    public function delete()
    {
        ipRequest()->mustBePost();

        if (!ipUser()->loggedIn()) {
            //redirect to login page
            if (!empty($_SERVER['HTTP_REFERER'])) {
                Model::setRedirectAfterLogin($_SERVER['HTTP_REFERER']);
            }
            $data = array (
                'status' => 'error',
                'redirectUrl' => Model::loginUrl()
            );
            return new \Ip\Response\Json($data);
        }



        $userId = ipUser()->userId();

        $post = ipRequest()->getPost();

        $form = FormModel::deleteForm();

        $errors = $form->validate($post);

        $errors = ipFilter('User_deleteFormValidate', $errors, array('post' => $post));

        if (!empty($errors)) {
            $data = array (
                'status' => 'error',
                'errors' => $errors
            );
            return new \Ip\Response\Json($data);
        }


        $eventData = array (
            'userId' => ipUser()->userId()
        );

        ipEvent('User_delete', $eventData);


        ipUser()->logout();
        Service::delete($userId);

        $redirect = ipConfig()->baseUrl();
        ipFilter('User_deleteRedirectUrl', $redirect, $eventData);


        $data = array (
            'status' => 'ok',
            'redirectUrl' => $redirect
        );

        return new \Ip\Response\Json($data);

    }

    public function update()
    {
        ipRequest()->mustBePost();

        if (!ipUser()->loggedIn()) {
            //redirect to login page
            if (!empty($_SERVER['HTTP_REFERER'])) {
                Model::setRedirectAfterLogin($_SERVER['HTTP_REFERER']);
            }
            $data = array (
                'status' => 'error',
                'redirectUrl' => Model::loginUrl()
            );
            return new \Ip\Response\Json($data);
        }

        $post = ipRequest()->getPost();

        $form = FormModel::profileForm();

        $errors = $form->validate($post);

        if (!empty($post['id'])) {
            $user = Service::get($post['id']);
            if (!$user) {
                $errors['id'] = "User doesn't exist"; // should never happen
            }
        }

        $errors = ipFilter('User_profileFormValidate', $errors, array('post' => $post));

        if (!empty($errors)) {
            $data = array (
                'status' => 'error',
                'errors' => $errors
            );
            return new \Ip\Response\Json($data);
        }



        $data = $form->filterValues($post);

        Service::update($user['id'], $data);

        $eventData = array(
            'postData' => $data
        );
        ipEvent('User_profileUpdate', $eventData);


        $data = array (
            'status' => 'ok',
            'id' => $user['id']
        );
        return new \Ip\Response\Json($data);


    }


    public function logout()
    {
        ipRequest()->mustBePost();
        $userId = ipUser()->userId();
        ipUser()->logout();


        $redirect = ipConfig()->baseUrl();
        if (!empty($_SERVER["HTTP_REFERER"])) {
            $redirect = $_SERVER["HTTP_REFERER"];
        }
        $data = array(
            'userId' => $userId
        );
        ipFilter('User_logoutRedirectUrl', $redirect, $data);


        $data = array (
            'status' => 'ok',
            'redirectUrl' => $redirect,
            'id' => $userId
        );
        return new \Ip\Response\Json($data);
    }

    public function login()
    {
        ipRequest()->mustBePost();
        $user = null;
        if (ipRequest()->getPost('username')){
            $user = Service::getByEmail(ipRequest()->getPost('username'));
            if (!$user) {
                $errors['username'] = __('Following user doesn\'t exist', 'User', false);
            }
        } elseif(ipRequest()->getPost('email')) {
            $user = Service::getByEmail(ipRequest()->getPost('email'));
            if (!$user) {
                $errors['email'] = __('Following user doesn\'t exist', 'User', false);
            }
        }

        if (empty($errors) && !Service::checkPassword($user['id'], ipRequest()->getPost('password'))) {
            $errors['password'] = __('Incorrect password', 'User', false);
        }

        if (!empty($errors)) {
            $data = array (
                'status' => 'error',
                'errors' => $errors
            );
            return new \Ip\Response\Json($data);
        }


        ipUser()->login($user['id']);

        $redirect = ipConfig()->baseUrl();
        if (!empty($_SERVER["HTTP_REFERER"])) {
            $redirect = $_SERVER["HTTP_REFERER"];
        }
        if (isset($_SESSION['User_redirectAfterLogin'])) {
            $redirect = $_SESSION['User_redirectAfterLogin'];
        }
        $data = array(
            'userId' => $user['id']
        );
        ipFilter('User_loginRedirectUrl', $redirect, $data);


        $data = array (
            'status' => 'ok',
            'redirectUrl' => $redirect,
            'id' => $user['id']
        );
        return new \Ip\Response\Json($data);



    }

}
