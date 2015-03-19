<?php
/**
 * @package   ImpressPages
 */



namespace Plugin\User;


class Event
{
    public static function ipBeforeController()
    {
        ipAddJs('assets/user.js');
        ipAddCss('assets/user.css');
    }
}
