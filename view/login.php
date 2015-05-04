

<?php echo ipRenderWidget('Heading', array('title' => __('Login', 'User', false))) ?>
<div class="ipWidget">
    <?php echo $form->render() ?>
</div>
<div class="ipWidget">
    <p>
        <a class="ipUserRegistrationLink" href="<?php echo escAttr($registrationUrl) ?>"><?php _e('Register', 'User') ?></a>
    </p>
    <p>
        <a class="ipUserPasswordResetLink" href="<?php echo escAttr($passwordResetUrl) ?>"><?php _e('Forgot password', 'User') ?></a>
    </p>
</div>
