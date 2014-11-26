<?php echo ipRenderWidget('Heading', array('title' => __('Login', 'User', false))) ?>
<?php echo $form->render() ?>
<a class="ipUserRegistrationLink" href="<?php echo escAttr($registrationUrl) ?>"><?php _e('Register', 'User') ?></a>
</br>
<a class="ipUserPasswordResetLink" href="<?php echo escAttr($passwordResetUrl) ?>"><?php _e('Forgot password', 'User') ?></a>
