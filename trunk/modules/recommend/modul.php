<?php

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = '�������������';
    $modul['ModulPfad'] = 'recommend';
    $modul['ModulVersion'] = '1.0';
    $modul['Beschreibung'] = '������ ������ ��������� ����������� ��������� �������� ��������� � ������, ���� ������������ ������� ������ ���� ��� �������� ���������� � ��������. ����� ������������ ������ ������, ���������� �������� ��� <strong>[mod_recommend]</strong> � ������ ����� ������ ������� ����� ��� �� �����-���� ��������. ������ ������ ����� ����������� � ���� ������, �� ������� �� ������� ��������� �������������� ���� ��� ����� ����������.';
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
//	modulGlobals('recommend');
//	$recommend = new Recommend;
//	$recommend->displayLink();
	echo "<a href=\"javascript:void(0);\" onclick=\"popup('index.php?module=recommend&amp;action=form&amp;pop=1&amp;theme_folder=ave&amp;page=",
		base64_encode(redirectLink()), "','recommend','500','380','1')\">������������� ����</a>";
}

if(isset($_REQUEST['module']) && $_REQUEST['module'] == 'recommend' && isset($_REQUEST['action'])) {
	require_once(BASE_DIR . '/modules/recommend/class.recommend.php');
	require_once(BASE_DIR . '/functions/func.modulglobals.php');

	switch($_REQUEST['action']) {
		case 'form':
			modulGlobals('recommend');
			$recommend = new Recommend;
			$recommend->displayForm($_REQUEST['theme_folder']);
			break;

		case 'recommend':
			modulGlobals('recommend');
			$recommend = new Recommend;
			$recommend->sendForm($_REQUEST['theme_folder']);
			break;
	}
}
?>