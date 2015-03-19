<?php
    $email = $data['email'].'sdf';
    $size = 20;
    $gravatar = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=mm&s=" . $size;
?>
<div class="pluginUser">
    <a class="_logout" href="<?php echo $logoutUrl ?>"><?php _e('Logout', 'User', 'attr') ?></a>
    <a class="_profile" href="<?php echo $profileUrl ?>"><img src="<?php echo escAttr($gravatar) ?>" alt="<?php _e('Profile', 'User', 'attr') ?>"/></a>
</div>
