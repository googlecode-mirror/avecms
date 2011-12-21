<?php

/**
 * AVE.cms - Модуль Галерея
 *
 * @package AVE.cms
 * @subpackage module_Gallery
 * @since 1.4
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Галерея';
    $modul['ModulPfad'] = 'gallery';
    $modul['ModulVersion'] = '2.2';
    $modul['description'] = 'Gallery + Watermark + Lightbox + Lightview Внимание! У директории /modules/gallery/uploads/ должны быть права на запись!<br />Вы можете ограничить количество выводимых изображений, указав после Gallery-ID следующее: -3 (в этом случае количество будет ограничено тремя изображениями на страницу)';
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
 * @param string $gallery_id идентификатор галереи
 * и опционально количество изображений на странице
 */
function mod_gallery($gallery_id)
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/gallery/class.gallery.php');
	$gallery = new Gallery;

	$own_lim = @explode('-', stripslashes($gallery_id));
	$lim = (empty($own_lim[1])) ? '' : $own_lim[1];
	$gallery_id = $own_lim[0];

	$tpl_dir = BASE_DIR . '/modules/gallery/templates/';
	$lang_file = BASE_DIR . '/modules/gallery/lang/' . $_SESSION['user_language'] . '.txt';

	$AVE_Template->config_load($lang_file);

	$gallery->galleryShow($tpl_dir, $gallery_id, $lim);
}

if (!defined('ACP') && isset($_REQUEST['module']) && $_REQUEST['module'] == 'gallery')
{
	require_once(BASE_DIR . '/modules/gallery/class.gallery.php');
	$gallery = new Gallery;

	$tpl_dir = BASE_DIR . '/modules/gallery/templates/';
	$lang_file = BASE_DIR . '/modules/gallery/lang/' . $_SESSION['user_language'] . '.txt';

	$AVE_Template->config_load($lang_file);

	define('ONLYCONTENT', 1);

	if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'allimages')
	{
		$AVE_Template->assign('tpl_dir', BASE_DIR . '/modules/gallery/templates');
		$AVE_Template->assign('theme_folder', (defined('THEME_FOLDER') ? THEME_FOLDER : DEFAULT_THEME_FOLDER));
		$gallery->galleryShow($tpl_dir, (int)$_REQUEST['gallery'], '', 1);
	}
	else
	{
		$gallery->galleryImageShow($tpl_dir, (int)$_REQUEST['image']);
	}
}

//=======================================================
// Действия в админ-панели
//=======================================================
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	require_once(BASE_DIR . '/modules/gallery/class.gallery.php');
	$gallery = new Gallery;

	$tpl_dir = BASE_DIR . '/modules/gallery/templates/';
	$lang_file = BASE_DIR . '/modules/gallery/lang/' . $_SESSION['admin_language'] . '.txt';

	$AVE_Template->config_load($lang_file, 'admin');

	switch($_REQUEST['moduleaction'])
	{
		case '1': // Просмотр списка галерей
			$gallery->galleryListShow($tpl_dir);
			break;

		case 'add': // Добавить изображения в галерею
			define('IMAGE_TOOLBOX_DEFAULT_JPEG_QUALITY', 75);
			include_once(BASE_DIR . '/class/class.thumbnail.php');
			$Image_Toolbox = new Image_Toolbox;
			$gallery->galleryImageUploadForm($tpl_dir, intval($_REQUEST['id']));
			break;

		case 'showimages': // Просмотр изображений галереи
			$gallery->galleryImageListShow($tpl_dir, intval($_REQUEST['id']));
			break;

		case 'new': // Создать новую галерею
			$gallery->galleryNew();
			break;

		case 'delgallery': // Удаление галереи
			$gallery->galleryDelete(intval($_REQUEST['id']));
			break;

		case 'editgallery': // Редактирование галереи
			$gallery->galleryEdit($tpl_dir, intval($_REQUEST['id']));
			break;
	}
}

?>