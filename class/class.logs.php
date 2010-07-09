<?php

/**
 * AVE.cms
 *
 * Класс, предназначенный для управления журналом системных сообщений
 *
 * @package AVE.cms
 * @filesource
 */

class AVE_Logs
{

/**
 *	Свойства класса
 */

	/**
	 * Количество записей на странице
	 *
	 * @var int
	 */
	var $_limit = 15;

/**
 *	Внутренние методы класса
 */


/**
 *	Внешние методы класса
 */

	/**
	 * Метод, предназначенный для отображения всех записей Журнала событий
	 *
	 */
	function logList()
	{
		global $AVE_DB, $AVE_Template;

		$logs = array();
		// Выполняем запрос к БД на получение списка всех системных сообщений в журнале
        $sql = $AVE_DB->Query("SELECT *
			FROM " . PREFIX . "_log
			ORDER BY Id DESC
		");

		while ($row = $sql->FetchRow())
		{
			array_push($logs, $row);
		}

		// Передаем данные в шаблон для вывода и отображаем страницу
        $AVE_Template->assign('logs', $logs);
		$AVE_Template->assign('content', $AVE_Template->fetch('logs/logs.tpl'));
	}

	/**
	 * Метод, предназначенный для удаление записей Журнала событий
	 *
	 */
	function logDelete()
	{
		global $AVE_DB;

    	// Выполняем запрос к БД на удаление системных сообщений из журнала
        $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_log
		");

        // Выполняем запрос к БД на обновление структуры таблицы и обнулям все значения
        $AVE_DB->Query("
			ALTER
			TABLE " . PREFIX . "_log
			PACK_KEYS = 0
			CHECKSUM = 0
			DELAY_KEY_WRITE = 0
			AUTO_INCREMENT = 1
		");


        // Сохраняем системное сообщение в журнал
        reportLog($_SESSION['user_name'] . ' - очистил Журнал событий', 2, 2);

		// Выполняем обновление страницы
        header('Location:index.php?do=logs&cp=' . SESSION);
	}

	/**
	 * Метод, предназначенный для экспорта системных сообщений
	 *
	 */
	function logExport()
	{
		global $AVE_DB;

		// Определяем тип файла (CSV), формат имени файла, разделители и т.д.
        $datstring = '';
		$dattype = 'text/csv';
		$datname = 'system_log_' . date('dmyhis', time()) . '.csv';

		$separator = ';';
		$enclosed = '"';

        // Выполняем запрос к БД на получение списка всех системных сообщений
        $sql = $AVE_DB->Query("SELECT *
			FROM " . PREFIX . "_log
			ORDER BY Id DESC
		");
		$fieldcount = $sql->NumFields();

		for ($it=0; $it<$fieldcount; $it++)
		{
			$datstring .= $enclosed . $sql->FieldName($it) . $enclosed . $separator;
		}
		$datstring .= PHP_EOL;

		// Циклически обрабатываем данные и формируем CSV файл с учетом указаны выше параметров
        while ($row = $sql->FetchRow())
		{
			foreach ($row as $key => $val)
			{
				$val = ($key=='log_time') ? date('d-m-Y, H:i:s', $row->log_time) : $val;
				$datstring .= ($val == '') ? $separator : $enclosed . stripslashes($val) . $enclosed . $separator;
			}
			$datstring .= PHP_EOL;
		}

		// Определяем заголовки документа
        header('Content-Type: text/csv' . $dattype);
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Content-Disposition: attachment; filename="' . $datname . '"');
		header('Content-Length: ' . strlen($datstring));
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		// Выводим данные
        echo $datstring;

		// Сохраняем системное сообщение в журнал
        reportLog($_SESSION['user_name'] . ' - экспортировал Журнал событий', 2, 2);

		exit;
	}
}

?>