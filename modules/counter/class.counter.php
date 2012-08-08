<?php

/**
 * Класс, включающий все свойства и методы для управления счетчиками статистики как в Публичной части сайта,
 * так и в Панели управления.
 *
 * @package AVE.cms
 * @subpackage module_Counter
 * @since 1.4
 * @filesource
 */
class Counter
{

/**
 *	Свойства класса
 */

	/**
	 * Количество строк при выводе информации о визитах
	 *
	 * @var int
	 */
	var $_limit = 25;

/**
 *	Внутренние методы класса
 */

	/**
	 * Метод, рпдназначенный для получния из БД статистики в различных форматах (всё, сегодня, вчера и т.д.)
	 *
	 * @param int $id - идентификатор счетчика
	 * @return array
	 * 	all   - общее количество визитов
	 * 	today - количество визитов за текущий день
	 * 	yestd - количество визитов за вчерашний день
	 * 	prevm - количество визитов за предыдущий месяц
	 * 	prevy - количество визитов за предыдущий год
	 */
	function _counterStatisticGet($id)
	{
		global $AVE_DB;

        // Выполняем сложный, составной запрос к БД на получение статистики за различные периоды времени
		$sql = $AVE_DB->Query("
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			UNION ALL
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			AND counter_expire_time = " . mktime(23,59,59) . "
			UNION ALL
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			AND counter_expire_time = " . mktime(0,0,-1) . "
			UNION ALL
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			AND (counter_expire_time
				BETWEEN " . mktime(0,0,0,date('m'),1) . "
				AND " . mktime(0,0,-1,date('m')+1,1) . ")
			UNION ALL
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			AND (counter_expire_time
				BETWEEN " . mktime(0,0,0,1,1) . "
				AND " . mktime(0,0,-1,1,1,date('Y')+1) . ")
		");

		// Формируем и возвращаем полученные данные
        $row['all']       = $sql->fetchRow()->visits;
		$row['today']     = $sql->fetchRow()->visits;
		$row['yesterday'] = $sql->fetchRow()->visits;
		$row['prevmonth'] = $sql->fetchRow()->visits;
		$row['prevyear']  = $sql->fetchRow()->visits;

		return $row;
	}

/**
 *	Внешние методы класса
 */

	/**
	 * Метод, предназначенный для получения информации о клиенте, создания COOKIE файла сроком на сутки и
     * записи в БД, если данного клиента еще нет.
	 *
	 * @param int $id - идентификатор счетчика
	 */
	function counterClientNew($id)
	{
		global $AVE_DB;

		// Определяем IP адрес клиента
        if (!empty($_SERVER['REMOTE_ADDR']))
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		else
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}

        // Получаем количестко записей из БД о данном клиенте
		$exist = $AVE_DB->Query("
			SELECT 1
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_client_ip = '" . addslashes($ip) . "'
			AND counter_id = '" . $id. "'
			AND counter_expire_time > '" . time() . "'
			LIMIT 1
		")->NumRows();

		// Устанавливаем срок жизни COOKIE файла
        $counter_expire_time  = mktime(23, 59, 59);
		setcookie('counter_' . $id, '1', $counter_expire_time);

		// Если информации о данном клиенте не найдено в БД
        if (! $exist)
		{
			$referer = '';
			// Опреляем реферал
            if (isset($_SERVER['HTTP_REFERER']))
			{
				$referer = urldecode(trim($_SERVER['HTTP_REFERER']));
			}

			// Подключаем классы, предназначенные для получения детальной информации о пользователе
            // (операционная система, браузер и т.д.)
            include_once(BASE_DIR . '/modules/counter/phpSniff.core.php');
			include_once(BASE_DIR . '/modules/counter/phpSniff.class.php');
			$settings = array(
				'check_cookies'=>'',
				'default_language'=>'',
				'allow_masquerading'=>''
			);
			$client = new phpSniff('', $settings);

            // Выполняем запрос к БД на запись полученной информации
			$AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_modul_counter_info
				SET
					counter_id             = '" . $id . "',
					counter_client_ip      = '" . addslashes($ip) . "',
					counter_client_os      = '" . $client->property('platform') . ' ' . $client->property('os') . "',
					counter_client_browser = '" . $client->property('long_name') . ' ' . $client->property('version') . "',
					counter_client_referer = '" . addslashes($referer) . "',
					counter_visit_time     = '" . time() . "',
					counter_expire_time    = '" . $counter_expire_time . "'
			");
		}
	}

	/**
	 * Метод, предназначенный для создания нового счетчика в Панели управления
	 *
	 */
	function counterNew()
	{
		global $AVE_DB;

		// Выполняем запрос к БД на добавление нового счетчика
        $AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_modul_counter
			SET
				id = '',
				counter_title = '" . htmlspecialchars($_POST['counter_title']) . "'
		");

		// Выполняем обновление страницы
        header('Location:index.php?do=modules&action=modedit&mod=counter&moduleaction=1&cp=' . SESSION);
		exit;
	}

	/**
	 * Метод, предназначенный для сохранения изменений у счетчиков (например мы его переименовали в Панели управления),
	 * либо для удаления счетчиков из системы.
	 */
	function counterSettingsSave()
	{
		global $AVE_DB;

		// Циклически обрабатываем все счетчики и обновляем информацию о них в БД
        foreach($_POST['counter_title'] as $id => $counter_title)
		{
			$AVE_DB->Query("
				UPDATE  " . PREFIX . "_modul_counter
				SET counter_title ='" . $counter_title . "'
				WHERE id = '" . $id . "'
			");
		}

        // Циклически обрабатываем все счетчики и удаляем те, которые были помечены на удаление.
        // Также, вместе с удалением счетчика, происходит удаление всей собранной им информации.
		foreach($_POST['del'] as $id => $del)
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_counter
				WHERE id = '" . $id . "'
			");

			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_counter_info
				WHERE counter_id = '" . $id . "'
			");
		}

        // Выполняем обновление страницы
		header('Location:index.php?do=modules&action=modedit&mod=counter&moduleaction=1&cp=' . SESSION);
		exit;
	}



    /**
	 * Меотд, предназначенный для вывода списка всех счетчиков в системе
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 * @param string $lang_file - путь к языковому файлу модуля
	 */
	function counterList($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		// Выполняем запрос к БД на получение всех счетчиков
        $sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_counter
			ORDER BY id ASC
		");

		// Формируем массив данных
        $items = array();
		while ($row = $sql->FetchRow())
		{
			$stat = $this->_counterStatisticGet($row->id);

			$row->all       = $stat['all'];
			$row->today     = $stat['today'];
			$row->yesterday = $stat['yesterday'];
			$row->prevmonth = $stat['prevmonth'];
			$row->prevyear  = $stat['prevyear'];

			array_push($items, $row);
		}

    	// Передаем данные в шаблон для вывода
        $AVE_Template->assign('items', $items);

		$AVE_Template->config_load($lang_file, 'admin');

		// Отображаем страницу с данными
        $AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_counter.tpl'));
	}


    /**
	 * Метод, предназначенный для просмотра подробной статистики по какому-либо счетчику
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 * @param string $lang_file - путь к языковому файлу модуля
	 */
	function counterRefererList($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		// Определяем метод сортировки данных
        $sort = ' ORDER BY counter_visit_time DESC';
		$sort_navi = '';

		// Формируем дополнительной условие для запроса к БД с учетом сортировки
        if (!empty($_REQUEST['sort']))
		{
			switch($_REQUEST['sort'])
			{
				case 'visit_desc' :
					$sort = ' ORDER BY counter_visit_time DESC';
					$sort_navi = '&amp;sort=visit_desc';
					break;

				case 'visit_asc' :
					$sort = ' ORDER BY counter_visit_time ASC';
					$sort_navi = '&amp;sort=visit_asc';
					break;

				case 'ip_desc' :
					$sort = ' ORDER BY counter_client_ip DESC';
					$sort_navi = '&amp;sort=ip_desc';
					break;

				case 'ip_asc' :
					$sort = ' ORDER BY counter_client_ip ASC';
					$sort_navi = '&amp;sort=ip_asc';
					break;

				case 'referer_desc' :
					$sort = ' ORDER BY counter_client_referer DESC';
					$sort_navi = '&amp;sort=referer_desc';
					break;

				case 'referer_asc' :
					$sort = ' ORDER BY counter_client_referer ASC';
					$sort_navi = '&amp;sort=referer_asc';
					break;

				case 'os_desc' :
					$sort = ' ORDER BY counter_client_os DESC';
					$sort_navi = '&amp;sort=os_desc';
					break;

				case 'os_asc' :
					$sort = ' ORDER BY counter_client_os ASC';
					$sort_navi = '&amp;sort=os_asc';
					break;

				case 'browser_desc' :
					$sort = ' ORDER BY counter_client_browser DESC';
					$sort_navi = '&amp;sort=browser_desc';
					break;

				case 'browser_asc' :
					$sort = ' ORDER BY counter_client_browser ASC';
					$sort_navi = '&amp;sort=browser_asc';
					break;
			}
		}

		// Определяем начало диапазона вывода данных
        $start = get_current_page() * $this->_limit - $this->_limit;

    	// Выполняем запрос к БД с учетом всех параметров и лимита записей для вывода на странице
        $sql = $AVE_DB->Query("
			SELECT SQL_CALC_FOUND_ROWS *
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . intval($_REQUEST['id']) . "'
			" . $sort . "
			LIMIT " . $start . "," . $this->_limit
		);

		// Формируем массив из полученных данных
        $items = array();
		while($row = $sql->FetchRow())
		{
			array_push($items, $row);
		}

		$num = $AVE_DB->Query("SELECT FOUND_ROWS()")->GetCell();

		// Если количество записей превышает допустимый размер на странице, формируем постраничную навигацию
        if($num > $this->_limit)
		{
			$seiten = ceil($num / $this->_limit);
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=counter&moduleaction=view_referer&cp=" . SESSION
				. '&id=' . intval($_REQUEST['id']) . '&pop=1&page={s}' . $sort_navi . "\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		// Передаем данные в шаблон для выволда
        $AVE_Template->assign('items', $items);

		$AVE_Template->config_load($lang_file, 'admin');

		// Отоборажаем окно с данными
        $AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_entries.tpl'));
	}




    /**
	 * Метод, предназначенный для вывода статистики у определенного счетчика в Публичной части сайта.
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 * @param string $lang_file - путь к языковому файлу модуля
	 * @param int $id - идентификатор счетчика
	 */
	function counterStatisticShow($tpl_dir, $lang_file, $id)
	{
		global $AVE_Template;

		// Если это новый клиент (в сессии нет информации и куки файл не существует)
        if (! (empty($_SERVER['REMOTE_ADDR']) && empty($_SERVER['HTTP_CLIENT_IP'])) &&
			! (isset($_COOKIE['counter_' . $id]) && $_COOKIE['counter_' . $id] == '1'))
		{
			// Добавляем информацию о клиента в БД и создаем COOKIE-файл
            $this->counterClientNew($id);
		}

		$AVE_Template->config_load($lang_file, 'user');

		// Получаем данные из БД
        $AVE_Template->assign($this->_counterStatisticGet($id));

		// Вызываем шаблон и отображаем данные в Публичной части
        $AVE_Template->display($tpl_dir . 'show_stat-' . $id . '.tpl');
	}
}

?>