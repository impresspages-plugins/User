<?php
/**
 * @package   ImpressPages
 */



namespace Plugin\User;


class FormModel {

    public static function loginForm()
    {
        $form = new \Ip\Form();
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_PUBLIC);
        $form->addClass('ipsUserLoginForm');

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa', // HTML "name" attribute
                'value' => 'User.loginAjax'
            ));
        $form->addField($field);

        $field = new \Ip\Form\Field\Text(
            array(
                'name' => 'username', // HTML "name" attribute
                'label' => __('Email', 'User', false) // Field label that will be displayed next to input field
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

        $form = ipFilter('User_loginForm', $form);

        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'login', // HTML "name" attribute
                'value' => __('Login', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);

        $form = ipFilter('User_loginForm2', $form);

        return $form;
    }

    public static function registrationForm()
    {
        $form = new \Ip\Form();
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_PUBLIC);
        $form->addClass('ipsUserRegistrationForm');

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

        $form = ipFilter('User_registrationForm', $form);


        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'register', // HTML "name" attribute
                'value' => __('Register', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);

        $form = ipFilter('User_registrationForm2', $form);

        return $form;
    }

    public static function passwordResetForm1()
    {
        $form = new \Ip\Form();
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_PUBLIC);
        $form->addClass('ipsUsePasswordResetForm');


        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa', // HTML "name" attribute
                'value' => 'User.passwordReset1'
            ));
        $form->addField($field);



        $field = new \Ip\Form\Field\Text(
            array(
                'name' => 'username', // HTML "name" attribute
                'label' => __('Email', 'User', false) // Field label that will be displayed next to input field
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

        $form = ipFilter('User_passwordResetForm', $form);

        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'submit', // HTML "name" attribute
                'value' => __('Submit', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);

        $form = ipFilter('User_passwordResetForm2', $form);

        return $form;
    }

    public static function passwordResetForm2($userId, $secret)
    {
        $form = new \Ip\Form();
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_PUBLIC);
        $form->addClass('ipsUserPasswordReset2Form');


        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa', // HTML "name" attribute
                'value' => 'User.passwordReset3'
            ));
        $form->addField($field);


        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'userId', // HTML "name" attribute
                'value' => $userId
            ));
        $form->addField($field);

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'secret', // HTML "name" attribute
                'value' => $secret
            ));
        $form->addField($field);

        $field = new \Ip\Form\Field\Blank(
            array(
                'name' => 'globalError'
            ));
        $form->addField($field);

        $field = new \Ip\Form\Field\Password(
            array(
                'name' => 'password', // HTML "name" attribute
                'label' => __('New password', 'User', false) // Field label that will be displayed next to input field
            ));
        $field->addvalidator('Required');
        $form->addField($field);

        $form = ipFilter('User_passwordResetForm', $form);

        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'submit', // HTML "name" attribute
                'value' => __('Save', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);

        $form = ipFilter('User_passwordResetForm2', $form);

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
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_PUBLIC);

        $form->addClass('ipsUserProfileForm');

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


        $form = ipFilter('User_profileForm', $form);








        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'save', // HTML "name" attribute
                'value' => __('Save', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);


        if (class_exists('Ip\Form\Field\Info')) {
            $field = new \Ip\Form\Field\Info(
                array(
                    'name' => 'passwordResetLink', // HTML "name" attribute
                    'html' => ipView('view/updatePasswordLink.php', array('updatePasswordUrl' => ipRouteUrl('User_updatePassword')))->render()
                ));
            $form->addField($field);
        }

        $form = ipFilter('User_profileForm2', $form);


        return $form;
    }

    public static function passwordUpdateForm()
    {
        $form = new \Ip\Form();
        $form->addClass('ipsUserPasswordUpdateForm');
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_PUBLIC);

        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa', // HTML "name" attribute
                'value' => 'User.updatePasswordAjax'
            ));
        $form->addField($field);



        $field = new \Ip\Form\Field\Password(
            array(
                'name' => 'currentPassword', // HTML "name" attribute
                'label' => __('Current password', 'User', false), // Field label that will be displayed next to input field
            ));
        $field->addvalidator('Required');
        $form->addField($field);


        $field = new \Ip\Form\Field\Password(
            array(
                'name' => 'newPassword', // HTML "name" attribute
                'label' => __('New password', 'User', false), // Field label that will be displayed next to input field
            ));
        $field->addvalidator('Required');
        $form->addField($field);


        $form = ipFilter('User_passwordUpdateForm', $form);

        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'update', // HTML "name" attribute
                'value' => __('Update', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);

        $form = ipFilter('User_passwordUpdateForm2', $form);

        return $form;

    }




    public static function deleteForm()
    {
        $form = new \Ip\Form();
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_PUBLIC);
        $form->addClass('ipsUserDeleteForm');


        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'sa', // HTML "name" attribute
                'value' => 'User.delete'
            ));
        $form->addField($field);

        $form = ipFilter('User_deleteForm', $form);

        $field = new \Ip\Form\Field\Submit(
            array(
                'name' => 'delete', // HTML "name" attribute
                'value' => __('Delete profile', 'User', false) // Field label that will be displayed next to input field
            ));
        $form->addField($field);

        $form = ipFilter('User_deleteForm2', $form);

        return $form;
    }


}
