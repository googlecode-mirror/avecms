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
	global $AVE_Core, $AVE_DB, $AVE_Template;

	require_once(BASE_DIR . '/functions/func.modulglobals.php');
	set_modul_globals('moredoc');

	$AVE_Template->caching = true;            // �������� �����������
	$AVE_Template->cache_lifetime = 60*60*24; // ����� ����� ���� 1 ���� � ��������
//	$AVE_Template->cache_dir .= '/moredoc';   // ����� ��� ���� ������

	$tpl_dir = BASE_DIR . '/modules/moredoc/templates/'; // ��������� ���� � ������� ������

	// ���� ���� � ����, �� �������� ������������
	if (!$AVE_Template->is_cached($tpl_dir . 'moredoc.tpl', $AVE_Core->curentdoc->Id))
	{
		$limit      = 5; // ���������� ������� ����������
		$flagrubric = 1; // ��������� ��� ��� ������� ��������� (0 - ���, 1 - ��)

		$moredoc = array();

		// ���������, ���� �� ����� ��� ����, ���� ��� (������ ���) � �������
		if (!is_dir($AVE_Template->cache_dir))
		{
			$oldumask = umask(0);
			@mkdir($AVE_Template->cache_dir, 0777);
			umask($oldumask);
		}

		// �������� �������� �����, �������, ��������� ������ �������� �����
		$row = $AVE_DB->Query("
			SELECT
				rubric_id,
				document_meta_keywords
			FROM " . PREFIX . "_documents
			WHERE Id = '" . $AVE_Core->curentdoc->Id . "'
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
					document_expire,
					document_title,
					document_alias,
					document_meta_description
				FROM " . PREFIX . "_documents
				WHERE document_meta_keywords LIKE '" . $keywords . "%'
				AND Id != 1
				AND Id != '" . PAGE_NOT_FOUND_ID . "'
				AND Id != '" . $AVE_Core->curentdoc->Id . "'
				AND document_status != '0'
				AND document_deleted != '1'
				" . $inrubric . "
				" . $doctime . "
				ORDER BY document_count_view DESC
				LIMIT " . $limit
			);

			while ($row = $sql->FetchRow())
			{
				if ($doctime != '' && (time() + $AVE_Template->cache_lifetime) > $row->document_expire)
				{
					// �������� ����� ����� ���� ��� ���-�� ��� �� ���������
					// ����� ��������� ���������� �������� � ������� ����������
					$AVE_Template->cache_lifetime = $row->document_expire - time();
				}
				$row->document_link = rewrite_link('index.php?id=' . $row->Id . '&amp;doc=' . (empty($row->document_alias) ? prepare_url($row->document_title) : $row->document_alias));
				array_push($moredoc, $row);
			}
			// ��������� ����������
			$sql->Close();
		}
		// ������� ���������� moredoc � ������
		$AVE_Template->assign('moredoc', $moredoc);
	}
	// ������� ������ moredoc.tpl
	$AVE_Template->display($tpl_dir . 'moredoc.tpl', $AVE_Core->curentdoc->Id);

	$AVE_Template->caching = false; // ��������� �����������
}

?>
