<?php

/**
 * AVE.cms - ������ ��������� �����
 *
 * @package AVE.cms
 * @subpackage module_SysBlock
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = '��������� �����';
    $modul['ModulPfad'] = 'sysblock';
    $modul['ModulVersion'] = '1.1';
    $modul['Beschreibung'] = '������ ������ ������������ ��� ������ ��������� ������ � ������������ ���������� � ������� ��� ���������.<br /><br />����� ������������ PHP � ���� �������<br /><br />��� ������ ����������� ����������� ��������� ���<br /><strong>[mod_sysblock:XXX]</strong>';
    $modul['Autor'] = 'Mad Den';
    $modul['MCopyright'] = '&copy; 2008 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulTemplate'] = 0;
    $modul['ModulFunktion'] = 'mod_sysblock';
    $modul['CpEngineTagTpl'] = '[mod_sysblock:XXX]';
    $modul['CpEngineTag'] = '#\\\[mod_sysblock:(\\\d+)]#';
    $modul['CpPHPTag'] = "<?php mod_sysblock(''$1''); ?>";
}

/**
 * ��������� ���� ������
 *
 * @param int $sysblock_id ������������� ���������� �����
 */
function mod_sysblock($sysblock_id)
{
	global $AVE_DB;

	if (is_numeric($sysblock_id))
	{
		$return = $AVE_DB->Query("
			SELECT sysblock_text
			FROM " . PREFIX . "_modul_sysblock
			WHERE id = '" . $sysblock_id . "'
			LIMIT 1
		")->GetCell();

		eval ('?>' . $return . '<?');
	}
}

/**
 * �����������������
 */
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	if (! @require_once(BASE_DIR . '/modules/sysblock/class.sysblock.php')) module_error();

	$tpl_dir   = BASE_DIR . '/modules/sysblock/templates/';
	$lang_file = BASE_DIR . '/modules/sysblock/lang/' . $_SESSION['user_language'] . '.txt';

	$AVE_Template->config_load($lang_file);

	switch ($_REQUEST['moduleaction'])
	{
		case '1':
			sysblock::sysblockList($tpl_dir);
			break;

		case 'del':
			sysblock::sysblockDelete($_REQUEST['id']);
			break;

		case 'edit':
			sysblock::sysblockEdit($_REQUEST['id'], $tpl_dir);
			break;

		case 'saveedit':
			sysblock::sysblockSave(isset($_REQUEST['id']) ? $_REQUEST['id'] : null);
			break;
	}
}

?>