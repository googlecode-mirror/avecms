<?php

/**
 * AVE.cms - ћодуль –екомендовать
 *
 * @package AVE.cms
 * @subpackage module_Recommend
 * @since 1.4
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = '–екомендовать';
    $modul['ModulPfad'] = 'recommend';
    $modul['ModulVersion'] = '1.0';
    $modul['description'] = 'ƒанный модуль позвол€ет посетител€м выполн€ть отправку сообщени€ в случае, если пользователь считает данный сайт или страницу интересной и полезной. „тобы использовать данный модуль, разместите ситемный тег <strong>[mod_recommend]</strong> в нужном месте вашего шаблона сайта или на какой-либо странице. ƒанный модуль будет представлен в виде ссылки, по нажатию на которую откроетс€ дополнительное окно дл€ ввода информации.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['ModulTemplate'] = 0;
    $modul['AdminEdit'] = 0;
    $modul['ModulFunktion'] = 'mod_recommend';
    $modul['CpEngineTagTpl'] = '[mod_recommend]';
    $modul['CpEngineTag'] = '#\\\[mod_recommend]#';
    $modul['CpPHPTag'] = '<?php mod_recommend(); ?>';
}

function mod_recommend() {
//	require_once(BASE_DIR . '/modules/recommend/class.recommend.php');
//	require_once(BASE_DIR . '/functions/func.modulglobals.php');
//
//	set_modul_globals('recommend');
//	$recommend = new Recommend;
//	$recommend->displayLink();
	echo "<a href=\"javascript:void(0);\" onclick=\"popup('", ABS_PATH,
		"index.php?module=recommend&amp;action=form&amp;pop=1&amp;theme_folder=ave&amp;page=",
		base64_encode(get_redirect_link()), "','recommend','500','380','1')\">–екомендовать сайт</a>";
}

if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'recommend' && isset($_REQUEST['action']))
{
	require_once(BASE_DIR . '/modules/recommend/class.recommend.php');
	require_once(BASE_DIR . '/functions/func.modulglobals.php');

	set_modul_globals('recommend');

	$recommend = new Recommend;

	switch ($_REQUEST['action'])
	{
		case 'form':
			$recommend->displayForm($_REQUEST['theme_folder']);
			break;

		case 'recommend':
			$recommend->sendForm($_REQUEST['theme_folder']);
			break;
	}
}
?>