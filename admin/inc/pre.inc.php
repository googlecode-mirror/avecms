<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 * @subpackage admin
 */

if (defined('ACP'))
{
	$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));
	$config_vars = $AVE_Template->get_config_vars();
	$AVE_Template->assign('config_vars', $config_vars);

	$_REQUEST['sub']    = (!isset($_REQUEST['sub']))    ? '' : addslashes($_REQUEST['sub']);
	$_REQUEST['action'] = (!isset($_REQUEST['action'])) ? '' : addslashes($_REQUEST['action']);
	$_REQUEST['submit'] = (!isset($_REQUEST['submit'])) ? '' : addslashes($_REQUEST['submit']);
}

?>