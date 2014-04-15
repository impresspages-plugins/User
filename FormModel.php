<?php
/**
 * @package   ImpressPages
 */



namespace Plugin\User;


class FormModel {

    public static function loginForm()
    {
        $form = new \Ip\Form();

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa', // HTML "name" attribute
                'value' => 'User.login'
            ));
        $form->addField($field);

        $field = new \Ip\Form\Field\Text(
            array(
                'name' => 'username', // HTML "name" attribute
                'label' => __('Username or email', 'User', false) // Field label that will be displayed next to input field
            ));
        $field->addvalidator('Required');
        $form->addField($field);

        $field = new \Ip\Form\Field\Password(
            array(
                'name' => 'password', // HTML "name" attribute
                'label' => __('Password', 'User', false) // Field label that will be displayed next to input field
            ));
        $field->addvalidator('Required');
        $form->addField($field);


        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'login', // HTML "name" attribute
                'value' => __('Login', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);

        $form = ipFilter('User_loginForm', $form);

        return $form;
    }

    public static function registrationForm()
    {
        $form = new \Ip\Form();

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa', // HTML "name" attribute
                'value' => 'User.register'
            ));
        $form->addField($field);


        $field = new \Ip\Form\Field\Email(
            array(
                'name' => 'email', // HTML "name" attribute
                'label' => __('Email', 'User', false) // Field label that will be displayed next to input field
            ));
        $field->addAttribute('autocomplete', 'off');
        $field->addvalidator('Required');
        $form->addField($field);

        $field = new \Ip\Form\Field\Password(
            array(
                'name' => 'password', // HTML "name" attribute
                'label' => __('Password', 'User', false) // Field label that will be displayed next to input field
            ));
        $field->addAttribute('autocomplete', 'off');
        $field->addvalidator('Required');
        $form->addField($field);

        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'register', // HTML "name" attribute
                'value' => __('Register', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);

        $form = ipFilter('User_registrationForm', $form);

        return $form;
    }

    public static function passwordResetForm()
    {
        $form = new \Ip\Form();

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa', // HTML "name" attribute
                'value' => 'User.passwordReset'
            ));
        $form->addField($field);



        $field = new \Ip\Form\Field\Text(
            array(
                'name' => 'username', // HTML "name" attribute
                'label' => __('Username or email', 'User', false) // Field label that will be displayed next to input field
            ));
        $field->addvalidator('Required');
        $form->addField($field);

        $field = new \Ip\Form\Field\Captcha(
            array(
                'name' => 'captcha', // HTML "name" attribute
                'label' => __('Prove you are a human', 'User', false) // Field label that will be displayed next to input field
            ));
        $field->addvalidator('Required');
        $form->addField($field);



        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'submit', // HTML "name" attribute
                'value' => __('Submit', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);

        $form = ipFilter('User_passwordResetForm', $form);

        return $form;
    }


    public static function profileForm()
    {
        $userId = ipUser()->userId();
        if (!$userId) {
            throw new \Ip\Exception('User is not logged in');
        }
        $userData = Service::get($userId);
        if (!$userData) {
            throw new \Ip\Exception('User doesn\'t exist');
        }

        $form = new \Ip\Form();

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa', // HTML "name" attribute
                'value' => 'User.update'
            ));
        $form->addField($field);

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'id', // HTML "name" attribute
                'value' => $userData['id']
            ));
        $field->addvalidator('Required');
        $form->addField($field);



//        $field = new \Ip\Form\Field\Text(
//            array(
//                'name' => 'username', // HTML "name" attribute
//                'label' => __('Username', 'User', false), // Field label that will be displayed next to input field
//                'value' => $userData['username']
//            ));
//        $field->addvalidator('Required');
//        $form->addField($field);


        $field = new \Ip\Form\Field\Email(
            array(
                'name' => 'email', // HTML "name" attribute
                'label' => __('Email', 'User', false), // Field label that will be displayed next to input field
                'value' => $userData['email']
            ));
        $field->addvalidator('Required');
        $form->addField($field);



        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'save', // HTML "name" attribute
                'value' => __('Save', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);

        $form = ipFilter('User_passwordResetForm', $form);


        return $form;
    }

    public static function passwordUpdateForm()
    {
        $form = new \Ip\Form();

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa', // HTML "name" attribute
                'value' => 'User.updatePassword'
            ));
        $form->addField($field);



        $field = new \Ip\Form\Field\Password(
            array(
                'name' => 'newPassword', // HTML "name" attribute
                'label' => __('New password', 'User', false) // Field label that will be displayed next to input field
            ));
        $field->addvalidator('Required');
        $form->addField($field);

        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'update', // HTML "name" attribute
                'value' => __('Update', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);

        $form = ipFilter('User_passwordUpdateForm', $form);

        return $form;

    }

    public static function logoutForm()
    {
        $form = new \Ip\Form();

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa', // HTML "name" attribute
                'value' => 'User.logout'
            ));
        $form->addField($field);


        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'logout', // HTML "name" attribute
                'value' => __('Logout', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);

        $form = ipFilter('User_logoutForm', $form);

        return $form;
    }


    public static function deleteForm()
    {
        $form = new \Ip\Form();

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa', // HTML "name" attribute
                'value' => 'User.delete'
            ));
        $form->addField($field);


        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'delete', // HTML "name" attribute
                'value' => __('Delete profile', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);

        $form = ipFilter('User_deleteForm', $form);

        return $form;
    }


}
