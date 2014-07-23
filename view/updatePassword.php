<?php echo ipRenderWidget('Heading', array('title' => __('Update password', 'User', false))); ?>
<?php if ($isPasswordUpdated) { ?>
    <?php echo ipRenderWidget('Text', array('text' => '<p><span class="note">' . __('Password has been successfully updated.', 'User') . '</span></p>')); ?>
<?php } ?>
<?php echo $form->render() ?>
