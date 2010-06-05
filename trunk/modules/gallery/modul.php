<?php

/**
 * AVE.cms - ������ �������
 *
 * @package AVE.cms
 * @subpackage module_Gallery
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = '�������';
    $modul['ModulPfad'] = 'gallery';
    $modul['ModulVersion'] = '2.2';
    $modul['Beschreibung'] = 'Gallery + Watermark + Lightbox + Lightview ��������! � ���������� /modules/gallery/uploads/ ������ ���� ����� �� ������!<br />�� ������ ���������� ���������� ��������� �����������, ������ ����� Gallery-ID ���������: -3 (� ���� ������ ���������� ����� ���������� ����� ������������� �� ��������)';
    $modul['Autor'] = 'cron';
    $modul['MCopyright'] = '&copy; 2008 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = 'mod_gallery';
    $modul['CpEngineTagTpl'] = '[mod_gallery:XXX<em>-�����</em>]';
    $modul['CpEngineTag'] = '#\\\[mod_gallery:([\\\d-]+)]#';
    $modul['CpPHPTag'] = "<?php mod_gallery(''$1''); ?>";
}

/**
 * ������� ������ �������
 *
 * @param string $gallery_id ������������� �������
 * � ����������� ���������� ����������� �� ��������
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
	global $AVE_Template;

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
// �������� � �����-������
//=======================================================
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/gallery/class.gallery.php');
	$gallery = new Gallery;

	$tpl_dir = BASE_DIR . '/modules/gallery/templates/';
	$lang_file = BASE_DIR . '/modules/gallery/lang/' . $_SESSION['admin_language'] . '.txt';

	$AVE_Template->config_load($lang_file, 'admin');

	switch($_REQUEST['moduleaction'])
	{
		case '1': // �������� ������ �������
			$gallery->galleryListShow($tpl_dir);
			break;

		case 'add': // �������� ����������� � �������
			define('IMAGE_TOOLBOX_DEFAULT_JPEG_QUALITY', 75);
			include_once(BASE_DIR . '/class/class.thumbnail.php');
			$Image_Toolbox = new Image_Toolbox;
			$gallery->galleryImageUploadForm($tpl_dir, intval($_REQUEST['id']));
			break;

		case 'showimages': // �������� ����������� �������
			$gallery->galleryImageListShow($tpl_dir, intval($_REQUEST['id']));
			break;

		case 'new': // ������� ����� �������
			$gallery->galleryNew();
			break;

		case 'delgallery': // �������� �������
			$gallery->galleryDelete(intval($_REQUEST['id']));
			break;

		case 'editgallery': // �������������� �������
			$gallery->galleryEdit($tpl_dir, intval($_REQUEST['id']));
			break;
	}
}

?>