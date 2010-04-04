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
    $modul['ModulVersion'] = '2.1';
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
 * @param string $id ������������� �������
 * � ����������� ���������� ����������� �� ��������
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
// �������� � �����-������
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
			case '1': // �������� ������ �������
				$gallery->showGalleries($tpl_dir);
				break;

			case 'add': // �������� ����������� � �������
				$gallery->uploadForm($tpl_dir, intval($_REQUEST['id']));
				break;

			case 'showimages': // �������� ����������� �������
				$gallery->showImages($tpl_dir, intval($_REQUEST['id']));
				break;

			case 'new': // ������� ����� �������
				$gallery->newGallery();
				break;

			case 'delgallery': // �������� �������
				$gallery->delGallery(intval($_REQUEST['id']));
				break;

			case 'editgallery': // �������������� �������
				$gallery->editGallery($tpl_dir, intval($_REQUEST['id']));
				break;
		}
	}
}

?>