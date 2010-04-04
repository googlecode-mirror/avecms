<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

if (defined('ACP'))
{
	$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . (empty($_SESSION['admin_lang']) ? DEFAULT_COUNTRY : addslashes($_SESSION['admin_lang']))  . '/main.txt');
}
else
{
	echo 'Извините, но Вы не имеете права доступа к данному разделу!';
}

?>