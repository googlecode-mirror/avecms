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
    $modul['ModulName'] = 'Похожие документы';
    $modul['ModulPfad'] = 'moredoc';
    $modul['ModulVersion'] = '1.0';
    $modul['Beschreibung'] = 'Данный модуль предназначен для вывода списка похожих документов относительно текущего. Связующим элементом документов является первое слово из поля Ключевые слова. Результат вывода кешируется средствами Smarty.<BR /><BR />Для вывода списка похожих документов используйте системный тег <strong>[mod_moredoc]</strong> (можно использовать как в документах так и шаблоне рубрики).';
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
	global $AVE_DB, $AVE_Globals, $AVE_Template;

	require_once(BASE_DIR . '/functions/func.modulglobals.php');
	modulGlobals('moredoc');

	$limit = 5; // Количество связных документов
	$flagRubric = 1; // Учитывать или нет рубрику документа (0 - нет, 1 - да)

	// Время жизни кэша 1 день в секундах
	$AVE_Template->cache_lifetime = 60*60*24;

	$moreDoc = '';
	$docId = (int)$_REQUEST['id']; // Получаем ID документа

	$AVE_Template->caching = true; // Устанавливаем флаг кэшировать

	// Если нету в кэше, то начинаем обрабатывать
	if (!$AVE_Template->is_cached($AVE_Template->cache_dir . 'moredoc.tpl', $docId))
	{
		$tpl_dir = BASE_DIR . '/modules/moredoc/templates/'; // Указываем путь до шаблона
		$AVE_Template->cache_dir = BASE_DIR . '/cache/moredoc/'; // Папка для создания кэша

		// Проверяем, есть ли папка для кэша, если нет (первый раз) — создаем
		if (!is_file(BASE_DIR . '/cache/moredoc/'))
		{
			$oldumask = umask(0);
			@mkdir(BASE_DIR . '/cache/moredoc/', 0777);
			umask($oldumask);
		}

		// Получаем ключевые слова, рубрику, вытаскиваем первое слово
		$row = $AVE_DB->Query("
			SELECT
				RubrikId,
				MetaKeywords
			FROM " . PREFIX . "_documents
			WHERE Id = '" . $docId . "'
			LIMIT 1
		")
		->FetchRow();

		$keywords = explode(',',$row->MetaKeywords);
		$keywords = trim($keywords[0]);
		$rubric = $row->RubrikId;

		if ($keywords != '')
		{
			$inRubric = $flagRubric ? ("AND RubrikId = '" . $rubric . "'") : '';
			$doctime  = $AVE_Globals->mainSettings('use_doctime')
				? ("AND (DokEnde = 0 || DokEnde > '" . time() . "') AND (DokStart = 0 || DokStart < '" . time() . "')")
				: '';
			// Ищем документы где встречается такое-же слово
			$sql = $AVE_DB->Query("
				SELECT
					Id,
					Titel,
					MetaDescription
				FROM " . PREFIX . "_documents
				WHERE MetaKeywords LIKE '" . $keywords . "%'
				AND Id > 2
				AND DokStatus != 0
				AND Id != '" . $docId . "'
				" . $inRubric . "
				" . $doctime . "
				ORDER BY Id DESC
				LIMIT " . $limit
			);

			$moreDoc = array();
			while ($row = $sql->FetchRow())
			{
				$row->Url = (CP_REWRITE==1)
					? cpRewrite('index.php?id=' . $row->Id . '&amp;doc=' . cpParseLinkname($row->Titel))
					: 'index.php?id=' . $row->Id . '&amp;doc=' . cpParseLinkname($row->Titel);
				array_push($moreDoc, $row);
			}
			// Закрываем соединение
			$sql->Close();
		}
		// Назначаем переменную moreDoc для использования в шаблоне
		$AVE_Template->assign('moredoc', $moreDoc);
	}
	// Выводим шаблон moredoc.tpl
	$AVE_Template->display($tpl_dir . 'moredoc.tpl', $docId);

	$AVE_Template->caching = false; // Устанавливаем флаг не кэшировать
}

?>
