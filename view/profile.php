<?php echo ipRenderWidget('Heading', array('title' => __('Profile', 'User', false))); ?>
<?php if ($isProfileUpdated) { ?>
    <?php echo ipRenderWidget('Text', array('text' => '<p><span class="note">' . __('User profile has been successfully updated.', 'User') . '</span></p>')); ?>
<?php } ?>
<div class="ipWidget">
    <?php echo $form->render() ?>
</div>
