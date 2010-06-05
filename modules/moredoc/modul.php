<?php

/**
 * AVE.cms - ������ ������� ���������
 *
 * @package AVE.cms
 * @subpackage module_MoreDoc
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = '������ �� ����';
    $modul['ModulPfad'] = 'moredoc';
    $modul['ModulVersion'] = '1.0';
    $modul['Beschreibung'] = '������ ������ ������������ ��� ������ ������ ������� ���������� ������������ ��������. ��������� ��������� ���������� �������� ������ ����� �� ���� �������� �����. ��������� ������ ���������� ���������� Smarty.<BR /><BR />��� ������ ������ ������� ���������� ����������� ��������� ��� <strong>[mod_moredoc]</strong> (����� ������������ ��� � ���������� ��� � ������� �������).';
    $modul['Autor'] = 'censored!';
    $modul['MCopyright'] = '&copy; 2008 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 0;
    $modul['ModulFunktion'] = 'mod_moredoc';
    $modul['CpEngineTagTpl'] = '[mod_moredoc]';
    $modul['CpEngineTag'] = '#\\\[mod_moredoc]#';
    $modul['CpPHPTag'] = '<?php mod_moredoc(); ?>';
}

/**
 * ������� ��������� ���� ������
 *
 */
function mod_moredoc()
{
	global $AVE_DB, $AVE_Template;

	require_once(BASE_DIR . '/functions/func.modulglobals.php');
	set_modul_globals('moredoc');

	$limit = 5; // ���������� ������� ����������
	$flagrubric = 1; // ��������� ��� ��� ������� ��������� (0 - ���, 1 - ��)

	// ����� ����� ���� 1 ���� � ��������
	$AVE_Template->cache_lifetime = 60*60*24;

	$moredoc = '';
	$document_id = get_current_document_id(); // �������� ID ���������

	$AVE_Template->caching = true; // ������������� ���� ����������

	// ���� ���� � ����, �� �������� ������������
	if (!$AVE_Template->is_cached($AVE_Template->cache_dir . 'moredoc.tpl', $document_id))
	{
		$tpl_dir = BASE_DIR . '/modules/moredoc/templates/'; // ��������� ���� �� �������
		$AVE_Template->cache_dir = BASE_DIR . '/cache/moredoc/'; // ����� ��� �������� ����

		// ���������, ���� �� ����� ��� ����, ���� ��� (������ ���) � �������
		if (!is_file(BASE_DIR . '/cache/moredoc/'))
		{
			$oldumask = umask(0);
			@mkdir(BASE_DIR . '/cache/moredoc/', 0777);
			umask($oldumask);
		}

		// �������� �������� �����, �������, ����������� ������ �����
		$row = $AVE_DB->Query("
			SELECT
				RubrikId,
				MetaKeywords
			FROM " . PREFIX . "_documents
			WHERE Id = '" . $document_id . "'
			LIMIT 1
		")->FetchRow();

		$keywords = explode(',',$row->MetaKeywords);
		$keywords = trim($keywords[0]);

		if ($keywords != '')
		{
			$inrubric = $flagrubric ? ("AND RubrikId = '" . $row->RubrikId . "'") : '';
			$doctime  = get_settings('use_doctime') ? ("AND (DokEnde = 0 || DokEnde > '" . time() . "') AND DokStart < '" . time() . "'") : '';
			// ���� ��������� ��� ����������� �����-�� �����
			$sql = $AVE_DB->Query("
				SELECT
					Id,
					Titel,
					MetaDescription
				FROM " . PREFIX . "_documents
				WHERE MetaKeywords LIKE '" . $keywords . "%'
				AND Id != 1
				AND Id != '" . PAGE_NOT_FOUND_ID . "'
				AND DokStatus != '0'
				AND Geloescht != '1'
				AND Id != '" . $document_id . "'
				" . $inrubric . "
				" . $doctime . "
				ORDER BY Id DESC
				LIMIT " . $limit
			);

			$moredoc = array();
			while ($row = $sql->FetchRow())
			{
				$row->Url = rewrite_link('index.php?id=' . $row->Id . '&amp;doc=' . (empty($row->Url) ? prepare_url($row->Titel) : $row->curentdoc->Url));
				array_push($moredoc, $row);
			}
			// ��������� ����������
			$sql->Close();
		}
		// ��������� ���������� moreDoc ��� ������������� � �������
		$AVE_Template->assign('moredoc', $moredoc);
	}
	// ������� ������ moredoc.tpl
	$AVE_Template->display($tpl_dir . 'moredoc.tpl', $document_id);

	$AVE_Template->caching = false; // ������������� ���� �� ����������
}

?>
