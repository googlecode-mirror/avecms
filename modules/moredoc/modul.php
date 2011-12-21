<?php

/**
 * AVE.cms - Модуль Похожие документы
 *
 * @package AVE.cms
 * @subpackage module_MoreDoc
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Ссылки по теме';
    $modul['ModulPfad'] = 'moredoc';
    $modul['ModulVersion'] = '1.0';
    $modul['description'] = 'Данный модуль предназначен для вывода списка похожих документов относительно текущего. Связующим элементом документов является первое слово из поля Ключевые слова. Результат вывода кешируется средствами Smarty.<BR /><BR />Для вывода списка похожих документов используйте системный тег <strong>[mod_moredoc]</strong> (можно использовать как в документах так и шаблоне рубрики).';
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
 * Функция обработки тэга модуля
 *
 */
function mod_moredoc()
{
	global $AVE_Core, $AVE_DB, $AVE_Template;

	require_once(BASE_DIR . '/functions/func.modulglobals.php');
	set_modul_globals('moredoc');

	$AVE_Template->caching = true;            // Включаем кеширование
	$AVE_Template->cache_lifetime = 60*60*24; // Время жизни кеша 1 день в секундах
//	$AVE_Template->cache_dir .= '/moredoc';   // Папка для кеша модуля

	$tpl_dir = BASE_DIR . '/modules/moredoc/templates/'; // Указываем путь к шаблону модуля

	// Если нету в кеше, то начинаем обрабатывать
	if (!$AVE_Template->is_cached($tpl_dir . 'moredoc.tpl', $AVE_Core->curentdoc->Id))
	{
		$limit      = 5; // Количество связных документов
		$flagrubric = 1; // Учитывать или нет рубрику документа (0 - нет, 1 - да)

		$moredoc = array();

		// Проверяем, есть ли папка для кеша, если нет (первый раз) — создаем
		if (!is_dir($AVE_Template->cache_dir))
		{
			$oldumask = umask(0);
			@mkdir($AVE_Template->cache_dir, 0777);
			umask($oldumask);
		}

		// Получаем ключевые слова, рубрику, извлекаем первое ключевое слово
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
			$doctime  = get_settings('use_doctime')
				? ("AND document_published <= " . time() . " AND (document_expire = 0 OR document_expire >= " . time() . ")") : '';

			// Ищем документы где встречается такое-же слово
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
					// Изменяем время жизни кеша так что-бы оно не превышало
					// время окончания публикации попавших в выборку документов
					$AVE_Template->cache_lifetime = $row->document_expire - time();
				}
				$row->document_link = rewrite_link('index.php?id=' . $row->Id . '&amp;doc=' . (empty($row->document_alias) ? prepare_url($row->document_title) : $row->document_alias));
				array_push($moredoc, $row);
			}
			// Закрываем соединение
			$sql->Close();
		}
		// Передаём переменную moredoc в шаблон
		$AVE_Template->assign('moredoc', $moredoc);
	}
	// Выводим шаблон moredoc.tpl
	$AVE_Template->display($tpl_dir . 'moredoc.tpl', $AVE_Core->curentdoc->Id);

	$AVE_Template->caching = false; // Отключаем кеширование
}

?>
