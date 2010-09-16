<?php

/**
 * AVE.cms - module Google Weather
 *
 * @package AVE.cms
 * @subpackage module_Weather
 * @author N.Popova, npop@abv.bg
 * @since 2.09
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
	$modul['ModulName'] = "Google Weather";
	$modul['ModulPfad'] = "gweather";
	$modul['ModulVersion'] = "1.0";
	$modul['description'] = "Weather is weather module which utilizes the Google API allowing you to display weather data and related information from regions from all over the world very easily.<br />You can enrich your website with your own weather channel, were all weather conditions from any place of the world will look as you want to be, using the most reliable weather forecast source and combining with the most professional style.<br />System tag <strong>[cp_gweather]</strong>.";
	$modul['Autor'] = "N.Popova, npop@abv.bg";
	$modul['MCopyright'] = "&copy; 2010 N.Popova, npop@abv.bg";
	$modul['Status'] = 1;
	$modul['IstFunktion'] = 1;
	$modul['AdminEdit'] = 1;
	$modul['ModulFunktion'] = "mod_weather";
	$modul['CpEngineTagTpl'] = "[mod_gweather]";
	$modul['CpEngineTag'] = "#\\\[mod_gweather]#";
	$modul['CpPHPTag'] = "<?php mod_weather(); ?>";
}

function mod_weather()
{
	global $AVE_Template;

	require(BASE_DIR . "/modules/gweather/class.gweather.php");

	$tpl_dir   = BASE_DIR . '/modules/gweather/templates/';
	$lang_file = BASE_DIR . "/modules/gweather/lang/" . $_SESSION['user_language'] . ".txt";

	if (! is_file(BASE_DIR . '/cache/')) {@mkdir(BASE_DIR . '/cache/', 0777);}

	$weather = new Weather();
	$weather->weatherInit();
	$weather->weatherDataGet();
	$weather->weatherDataParse();

	$AVE_Template->config_load($lang_file);

	$AVE_Template->assign('config'     , $weather->config);
	$AVE_Template->assign('werror'     , $weather->error);
	$AVE_Template->assign('main_icon'  , $weather->weatherIconGet((string)$weather->parsedData['current_icon'], $weather->config['current_icon_size']));
	$AVE_Template->assign('parsedData' , $weather->parsedData);

	$AVE_Template->display($tpl_dir . $weather->config['template'] . '.tpl');
}

if (defined('ACP') && ! empty($_REQUEST['moduleaction']))
{
	include_once(BASE_DIR . "/modules/gweather/class.gweather.php");

	$tpl_dir   = BASE_DIR . '/modules/gweather/templates/';
	$lang_file = BASE_DIR . "/modules/gweather/lang/" . $_SESSION['user_language'] . ".txt";

	$weather = new Weather();

	$AVE_Template->config_load($lang_file, "admin");

	switch($_REQUEST['moduleaction'])
	{
		case '1':
			$weather->weatherSettingsEdit($tpl_dir, $lang_file);
			break;
	}
}

?>