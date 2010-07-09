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
    $modul['description'] = '������ ������ ������������ ��� ������ ������ ������� ���������� ������������ ��������. ��������� ��������� ���������� �������� ������ ����� �� ���� �������� �����. ��������� ������ ���������� ���������� Smarty.<BR /><BR />��� ������ ������ ������� ���������� ����������� ��������� ��� <strong>[mod_moredoc]</strong> (����� ������������ ��� � ���������� ��� � ������� �������).';
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
				rubric_id,
				document_meta_keywords
			FROM " . PREFIX . "_documents
			WHERE Id = '" . $document_id . "'
			LIMIT 1
		")->FetchRow();

		$keywords = explode(',',$row->document_meta_keywords);
		$keywords = trim($keywords[0]);

		if ($keywords != '')
		{
			$inrubric = $flagrubric ? ("AND rubric_id = '" . $row->rubric_id . "'") : '';
			$doctime  = get_settings('use_doctime') ? ("AND (document_expire = 0 || document_expire >= '" . time() . "') AND document_published <= '" . time() . "'") : '';
			// ���� ��������� ��� ����������� �����-�� �����
			$sql = $AVE_DB->Query("
				SELECT
					Id,
					document_title,
					document_alias,
					document_meta_description
				FROM " . PREFIX . "_documents
				WHERE document_meta_keywords LIKE '" . $keywords . "%'
				AND Id != 1
				AND Id != '" . PAGE_NOT_FOUND_ID . "'
				AND document_status != '0'
				AND document_deleted != '1'
				AND Id != '" . $document_id . "'
				" . $inrubric . "
				" . $doctime . "
				ORDER BY Id DESC
				LIMIT " . $limit
			);

			$moredoc = array();
			while ($row = $sql->FetchRow())
			{
				$row->document_alias = rewrite_link('index.php?id=' . $row->Id . '&amp;doc=' . (empty($row->document_alias) ? prepare_url($row->document_title) : $row->curentdoc->document_alias));
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
