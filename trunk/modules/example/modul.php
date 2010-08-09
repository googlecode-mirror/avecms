<?php

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = "Тестовый модуль";
    $modul['ModulPfad'] = "example";
    $modul['ModulVersion'] = "1.0";
    $modul['description'] = "Данный модуль предназначен для того, чтобы показать как сделать запрос и вывести его в шаблоне. Результат запроса кешируются средствами Smarty.<BR /><BR />Для вывода результатов используйте системный тег <strong>[mod_example]</strong>";
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

	$tpl_dir = BASE_DIR . '/modules/example/templates/'; // Указываем путь до шаблона
	$AVE_Template->caching = true;
	$AVE_Template->cache_lifetime = 86400; // Время жизни кэша (1 день)
//	$AVE_Template->cache_dir = BASE_DIR . '/cache/example'; // Папка для создания кэша

	// Если нету в кэше, то выполняем запрос
	if (!$AVE_Template->is_cached('example.tpl'))
	{
		// Проверяем, есть ли папка для кэша, если нет (первый раз) — создаем
		if (!is_file($AVE_Template->cache_dir))
		{
			$oldumask = umask(0);
			@mkdir($AVE_Template->cache_dir, 0777);
			umask($oldumask);
		}

		$example = array();
		// Запрос трех последних документов (ссылка и название) из рубрики с ID 2 и с сортировкой ID по убыванию
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
		// Закрываем соединение
		$sql->Close();

		// Назначаем переменную example для использования в шаблоне
		$AVE_Template->assign('example', $example);
	}

	// Выводим шаблон example.tpl
	$AVE_Template->display($tpl_dir . 'example.tpl');
	$AVE_Template->caching = false;
}
?>