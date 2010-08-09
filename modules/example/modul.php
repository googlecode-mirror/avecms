<?php

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = "�������� ������";
    $modul['ModulPfad'] = "example";
    $modul['ModulVersion'] = "1.0";
    $modul['description'] = "������ ������ ������������ ��� ����, ����� �������� ��� ������� ������ � ������� ��� � �������. ��������� ������� ���������� ���������� Smarty.<BR /><BR />��� ������ ����������� ����������� ��������� ��� <strong>[mod_example]</strong>";
    $modul['Autor'] = "censored!";
    $modul['MCopyright'] = "&copy; 2008 Overdoze Team";
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 0;
    $modul['ModulFunktion'] = "mod_example";
    $modul['CpEngineTagTpl'] = "[mod_example]";
    $modul['CpEngineTag'] = "#\\\[mod_example]#";
    $modul['CpPHPTag'] = "<?php mod_example(); ?>";
}

function mod_example()
{
	global $AVE_DB, $AVE_Template;

	$tpl_dir = BASE_DIR . '/modules/example/templates/'; // ��������� ���� �� �������
	$AVE_Template->caching = true;
	$AVE_Template->cache_lifetime = 86400; // ����� ����� ���� (1 ����)
//	$AVE_Template->cache_dir = BASE_DIR . '/cache/example'; // ����� ��� �������� ����

	// ���� ���� � ����, �� ��������� ������
	if (!$AVE_Template->is_cached('example.tpl'))
	{
		// ���������, ���� �� ����� ��� ����, ���� ��� (������ ���) � �������
		if (!is_file($AVE_Template->cache_dir))
		{
			$oldumask = umask(0);
			@mkdir($AVE_Template->cache_dir, 0777);
			umask($oldumask);
		}

		$example = array();
		// ������ ���� ��������� ���������� (������ � ��������) �� ������� � ID 2 � � ����������� ID �� ��������
		$sql = $AVE_DB->Query("
			SELECT
				Id,
				document_title,
				document_alias
			FROM " . PREFIX . "_documents
			WHERE Id != 1
			AND Id != '" . PAGE_NOT_FOUND_ID . "'
			AND rubric_id = 2
			AND document_deleted != 1
			AND document_status != 0
			ORDER BY Id DESC
		");

		while($row = $sql->FetchRow())
		{
			$row->document_alias = rewrite_link('index.php?id=' . $row->Id . '&amp;doc=' . (empty($row->document_alias) ? prepare_url($row->document_title) : $row->document_alias));
			array_push($example, $row);
		}
		// ��������� ����������
		$sql->Close();

		// ��������� ���������� example ��� ������������� � �������
		$AVE_Template->assign('example', $example);
	}

	// ������� ������ example.tpl
	$AVE_Template->display($tpl_dir . 'example.tpl');
	$AVE_Template->caching = false;
}
?>