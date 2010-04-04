<?php

/**
 * AVE.cms - Модуль Галерея
 *
 * @package AVE.cms
 * @subpackage module_Gallery
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Галерея';
    $modul['ModulPfad'] = 'gallery';
    $modul['ModulVersion'] = '2.1';
    $modul['Beschreibung'] = 'Gallery + Watermark + Lightbox + Lightview Внимание! У директории /modules/gallery/uploads/ должны быть права на запись!<br />Вы можете ограничить количество выводимых изображений, указав после Gallery-ID следующее: -3 (в этом случае количество будет ограничено тремя изображениями на страницу)';
    $modul['Autor'] = 'cron';
    $modul['MCopyright'] = '&copy; 2008 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = 'mod_gallery';
    $modul['CpEngineTagTpl'] = '[mod_gallery:XXX<em>-Лимит</em>]';
    $modul['CpEngineTag'] = '#\\\[mod_gallery:([\\\d-]+)]#';
    $modul['CpPHPTag'] = "<?php mod_gallery(''$1''); ?>";
}

/**
 * Функция вывода галереи
 *
 * @param string $id идентификатор галереи
 * и опционально количество изображений на странице
 */
function mod_gallery($id)
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/gallery/class.gallery.php');

	$own_lim = @explode('-', stripslashes($id));
	$lim = (empty($own_lim[1])) ? '' : $own_lim[1];
	$id = $own_lim[0];

	$tpl_dir = BASE_DIR . '/modules/gallery/templates/';
	$lang_file = BASE_DIR . '/modules/gallery/lang/' . DEFAULT_LANGUAGE . '.txt';

	$AVE_Template->config_load($lang_file);

	$gallery = new Gallery;
	$gallery->showGallery($tpl_dir, $id, $lim);
}

if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'gallery')
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/gallery/class.gallery.php');

	$tpl_dir = BASE_DIR . '/modules/gallery/templates/';
	$lang_file = BASE_DIR . '/modules/gallery/lang/' . DEFAULT_LANGUAGE . '.txt';

	$AVE_Template->config_load($lang_file);

	define('ONLYCONTENT', 1);

	$gallery = new Gallery;
	if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'allimages')
	{
		$gallery->showGallery($tpl_dir, (int)$_REQUEST['gallery'], '', 1);
	}
	else
	{
		$gallery->displayImage($tpl_dir, (int)$_REQUEST['image']);
	}
}

//=======================================================
// Действия в админ-панели
//=======================================================
if (defined('ACP') && !(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'))
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/gallery/sql.php');
	require_once(BASE_DIR . '/modules/gallery/class.gallery.php');

	$tpl_dir = BASE_DIR . '/modules/gallery/templates/';
	$lang_file = BASE_DIR . '/modules/gallery/lang/' . $_SESSION['admin_lang'] . '.txt';
	$gallery = new Gallery;

	$AVE_Template->config_load($lang_file, 'admin');

	if(!empty($_REQUEST['moduleaction']))
	{
		switch($_REQUEST['moduleaction'])
		{
			case '1': // Просмотр списка галерей
				$gallery->showGalleries($tpl_dir);
				break;

			case 'add': // Добавить изображения в галерею
				$gallery->uploadForm($tpl_dir, intval($_REQUEST['id']));
				break;

			case 'showimages': // Просмотр изображений галереи
				$gallery->showImages($tpl_dir, intval($_REQUEST['id']));
				break;

			case 'new': // Создать новую галерею
				$gallery->newGallery();
				break;

			case 'delgallery': // Удаление галереи
				$gallery->delGallery(intval($_REQUEST['id']));
				break;

			case 'editgallery': // Редактирование галереи
				$gallery->editGallery($tpl_dir, intval($_REQUEST['id']));
				break;
		}
	}
}

?>