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

        $eventData = array(
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'postData' => $post
        );
        ipEvent('User_register', $eventData);

        $data = array (
            'status' => 'ok',
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

//        $userId = ipRequest()->getPost('id');
//
//        if (!$userId) {
//            throw new \Ip\Exception('Missing required parameters');
//        }
//
//        if ($userId == ipAdminId()) {
//            throw new \Ip\Exception("Can't delete yourself");
//        }
//
//        Service::delete($userId);
//
//        $data = array (
//            'status' => 'ok'
//        );
//        return new \Ip\Response\Json($data);
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

//        if (!isset($post['id']) || !isset($post['username']) || !isset($post['email'])) {
//            throw new \Ip\Exception('Missing required parameters');
//        }
//
//
//
//        $form = FormModel::profileForm();
//        $form->removeSpamCheck();
//        $errors = $form->validate($post);
//
//        $userId = $post['id'];
//        $username = $post['username'];
//        $email = $post['email'];
//        if (isset($post['password'])) {
//            $password = $post['password'];
//        } else {
//            $password = null;
//        }
//
//
//        $existingUser = Service::getByUsername($username);
//        if ($existingUser && $existingUser['id'] != $userId) {
//            $errors['username'] = __('Already taken', 'Ip-admin', false);
//        }
//
//        $errors = ipFilter('User_profileFormValidate', $errors, array('post' => $post));
//
//
//        if ($errors) {
//            $data = array (
//                'status' => 'error',
//                'errors' => $errors
//            );
//            return new \Ip\Response\Json($data);
//        }
//
//        Service::update($userId, $username, $email, $password);
//
//        $data = array (
//            'status' => 'ok'
//        );
//        return new \Ip\Response\Json($data);
    }


}
