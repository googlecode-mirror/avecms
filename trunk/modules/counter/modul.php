<?php

/**
 * AVE.cms - Модуль Статистика
 *
 * Основной, управляющий файл модуля "Статистика", через который происходит определение
 * базовых характеристик модуля, а также управление модулем как в публичной части сайта, так и в Панели управления.
 *
 * @package AVE.cms
 * @subpackage module_Counter
 * @since 1.4
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

// Определяем базовые характеристики модуля
if (defined('ACP'))
{
    $modul = array();
    $modul['ModulName'] = 'Статистика';  // Название модуля
    $modul['ModulPfad'] = 'counter';  // Название папки
    $modul['ModulVersion'] = '1.3';  // Версия
    // Краткое описание, которое будет показано в Панели управления
    $modul['description'] = 'Данный модуль предназначен для сбора статистики посещений страниц вашего сайта, а также дополнительных данных о посетителях. Для того, чтобы начать сбор статистики, разместите системный тег <strong>[mod_counter:XXX]</strong> на нужной вам странице или шаблоне сайта. ХХХ - это порядковый номер счетчика в системе. Для отображения статистики в публичной части, разместите системный тэг <strong>[mod_counter:show]</strong> в нужном месте Вашего шаблона.';
    $modul['Autor'] = 'Arcanum';  // Автор
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team';  // Копирайты
    $modul['Status'] = 1;  // Статус модуля по умолчанию (1-активен/0-неактивен)
    $modul['IstFunktion'] = 1;  // Имеет ли данный модуль функцию, на которую будет заменен системный тег (1-да,0-нет)
    $modul['AdminEdit'] = 1;  // Имеет ли данный модуль параметры, которыми можно управлять в Панели упраления (1-да,0-нет)
    $modul['ModulFunktion'] = 'mod_counter';  // Название функции, на которую будет заменен системный тег
    $modul['CpEngineTagTpl'] = '[mod_counter:XXX]';  // Название системного тега, которое будет отображено в Панели управления
    $modul['CpEngineTag'] = '#\\\[mod_counter:(\\\d+)(-show)*]#';  // Сам системный тег, который будет использоваться в шаблонах
    $modul['CpPHPTag'] = "<?php mod_counter(''$1'', ''$2''); ?>";  // PHP-код, который будет вызван вместо системного тега, при парсинге шаблона
}

/**
 * Функция, предназначенная для сбора различной информации о просмотренных страницах, пользователях,
 * ip-адресах и т.д., с возможностью отображения полученных данных как в Панли управления, так и в Публичной
 * части сайта.
 *
 * @access public
 * @param string $counter_id цифровой идентификатор счетчика
 * и опционально строка show для отображения статистики
 */
function mod_counter($counter_id, $action = '')
{
    $counter_id = preg_replace('/\D/', '', $counter_id);

	// Если для счетчика установлен id больше 0 и указан параметр show, тогда
    if ($counter_id > 0 && $action == '-show')
	{
		// Подключаем основной файл с классом, создаем объект, подключаем языковые переменные
        // и обращаемся к методу counterStatisticShow() для вывода информации
        require_once(BASE_DIR . '/modules/counter/class.counter.php');
		$counter = new Counter;

		$tpl_dir   = BASE_DIR . '/modules/counter/templates/';
		$lang_file = BASE_DIR . '/modules/counter/lang/' . $_SESSION['user_language'] . '.txt';

		$counter->counterStatisticShow($tpl_dir, $lang_file, $counter_id);
	}
	// в противном случае, если метод  show не указан, тогда
    elseif ($counter_id > 0 &&
		!(empty($_SERVER['REMOTE_ADDR']) && empty($_SERVER['HTTP_CLIENT_IP'])) &&
		!(isset($_COOKIE['counter_' . $counter_id]) && $_COOKIE['counter_' . $counter_id] == '1'))
	{
		// Подключаем основной файл с классом, создаем объект и добавляем нового пользователя в статистику
        require_once(BASE_DIR . '/modules/counter/class.counter.php');
		$counter = new Counter;

		$counter->counterClientNew($counter_id);
	}
}



/**
 * Следующий раздел описывает правила поведения модуля и его функциональные возможности
 * только при работе в Административной части сайта.
 */
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $AVE_Template;

    // Подключаем файл с классом, создаем объеккт, определяем директорию с шаблонами и подключаем языковой файл
    require_once(BASE_DIR . '/modules/counter/class.counter.php');
	$counter = new Counter;
    $tpl_dir   = BASE_DIR . '/modules/counter/templates/';
	$lang_file = BASE_DIR . '/modules/counter/lang/' . $_SESSION['admin_language'] . '.txt';

	// Определяем, какой параметр пришел из строки запроса браузера
    switch ($_REQUEST['moduleaction'])
	{
		// Если 1, тогда отображаем список счетчиков статистики
        case '1':
			$counter->counterList($tpl_dir, $lang_file);
			break;

		// Если view_referer, тогда открываем новое окно для просмотра статистики
        case 'view_referer':
			$counter->counterRefererList($tpl_dir, $lang_file);
			break;

		// Если quicksave, выполняем сохранение данных (например было изменено название счетчика)
        case 'quicksave':
			$counter->counterSettingsSave();
			break;

		// Если new_counter, тогда добавляем новый счетчик в систему
        case 'new_counter':
			$counter->counterNew();
			break;
	}
}

?>