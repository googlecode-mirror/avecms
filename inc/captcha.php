<?php

$base_dir = explode('/inc', str_replace("\\", "/", dirname(__FILE__)));
define('BASE_DIR', $base_dir[0]);

require(BASE_DIR . '/inc/config.php');
require(BASE_DIR . '/inc/db.config.php');

if ($config['session_save_handler'])
{
    require(BASE_DIR . '/functions/func.session.php');
}
else
{
    ini_set('session.save_handler', 'files');
}
session_name('cp');
session_start();

require(BASE_DIR . '/lib/kcaptcha/kcaptcha.php');

$captcha = new KCAPTCHA();

$_SESSION['captcha_keystring'] = $captcha->getKeyString();

?>