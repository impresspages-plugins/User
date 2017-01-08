<?php echo ipRenderWidget('Heading', array('title' => __('Registration', 'User', false))); ?>
<div class="ipWidget">
    <?php echo $form->render() ?>
</div>
<div class="ipWidget">
    <p>
        <a class="ipUserLoginLink" href="<?php echo escAttr($loginUrl) ?>"><?php _e('Login', 'User') ?></a>
    </p>
</div>