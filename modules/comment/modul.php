<?php

/**
 * AVE.cms - Модуль Комментарии
 * 
 * Основной, управляющий файл модуля "Комментарии", через который происходит определение
 * базовых характеристик модуля, а также управление модулем как в публичной части сайта,
 * так и в Панели управления.
 *
 * @package AVE.cms
 * @subpackage module_Comment
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

// Определяем базовые характеристики модуля
if (defined('ACP'))
{
    $modul['ModulName'] = 'Комментарии'; // Название модуля
    $modul['ModulPfad'] = 'comment'; // Название папки
    $modul['ModulVersion'] = '1.2'; // Версия
    // Краткое описание, которое будет показано в Панели управления
    $modul['Beschreibung'] = 'Данный модуль предназначен для организации системы комментариев для документов на сайте. Для того, чтобы использовать данный модуль, разместите системный тег <strong>[mod_comment]</strong> в нужном месте шаблона рубрики.';
    $modul['Autor'] = 'Arcanum'; // Автор
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team'; // Копирайты
    $modul['Status'] = 1; // Статус модуля по умолчанию (1-активен/0-неактивен)
    $modul['IstFunktion'] = 1; // Имеет ли данный модуль функцию, на которую будет заменен системный тег (1-да,0-нет)
    $modul['ModulTemplate'] = 0; // Можно ли данному модулю в Панели управления назначать шаблон вывода (1-да,0-нет)
    $modul['AdminEdit'] = 1; // Имеет ли данный модуль параметры, которыми можно управлять в Панели упраления (1-да,0-нет)
    $modul['ModulFunktion'] = 'mod_comment'; // Название функции, на которую юудет заменен системный тег
    $modul['CpEngineTagTpl'] = '[mod_comment]'; // Название системного тега, которое будет отображено в Панели управления
    $modul['CpEngineTag'] = '#\\\[mod_comment]#'; // Сам системный тег, который будет использоваться в шаблонах
    $modul['CpPHPTag'] = '<?php mod_comment(); ?>';  // PHP-код, который будет вызван вместо системного тега, при парсинге шаблона
}

global $AVE_Template;

/**
 * Функция, предназначенная для вывода списка комментариев к данному документу.
 * Она будет выполнена при парсинге шаблона вместо системного тега [mod_comment].
 */
function mod_comment()
{
	global $AVE_Template;

    // Подключаем класс и создаем объект дял работы
	require_once(BASE_DIR . '/modules/comment/class.comment.php');
	$comment = new Comment;

    // Подключаем языковые файлы
	$tpl_dir = BASE_DIR . '/modules/comment/templates/';
	$lang_file = BASE_DIR . '/modules/comment/lang/' . $_SESSION['user_language'] . '.txt';
	$AVE_Template->config_load($lang_file);

    // Обращаемся к методу commentListShow() и отображаем список комментариев
	$comment->commentListShow($tpl_dir);
}

/**
 * Следующий раздел описывает правила поведения модуля и его функциональные возможности
 * только при работе в Публичной части сайта.
 */


// Определяем, что мы не находимся в Панели управления и в строке запроса происходит обращение именно к данному модулю
if (!defined('ACP') && isset($_REQUEST['module']) && $_REQUEST['module'] == 'comment' && isset($_REQUEST['action']))
{
	// Подключаем основной класс и создаем объект
    require_once(BASE_DIR . '/modules/comment/class.comment.php');
	$comment = new Comment;

    // Определяем директори, где хранятся файлы с шаблонами модуля и подключаем языковые переменные
    $tpl_dir = BASE_DIR . '/modules/comment/templates/';
    $lang_file = BASE_DIR . '/modules/comment/lang/' . $_SESSION['user_language'] . '.txt';
    $AVE_Template->config_load($lang_file);

    // Определяем, какой параметр пришел из строки запроса браузера
	switch($_REQUEST['action'])
	{
		// Если form, тогда отображаем форму для добавления нового комментария
        case 'form':
			$comment->commentPostFormShow($tpl_dir);
			break;

		// Если comment, тогда производим запись нового комментария в БД
        case 'comment':
			$comment->commentPostNew($tpl_dir);
			break;

		// Если edit, тогда открываем форму для редактирования текста комментария
        case 'edit':
			$comment->commentPostEdit((int)$_REQUEST['Id']);
			break;


        // Если delete, тогда удаляем комментарий
        case 'delete':
			if (UGROUP==1)
			{
				$comment->commentPostDelete((int)$_REQUEST['Id']);
			}
			break;

		// Если postinfo, тогда отображаем окно с информацией об авторе комментария
        case 'postinfo':
			$comment->commentPostInfoShow($tpl_dir);
			break;

		// Если lock или unlock, тогда запрещаем или разрешаем оставлять ответы для имеющихся комментариев
        case 'lock':
		case 'unlock':
			if (UGROUP==1)
			{
				$comment->commentReplyStatusSet((int)$_REQUEST['Id'], $_REQUEST['action']);
			}
			break;

		
        // Если open или close, тогда разрешаем или запрещаем полное комментирование документа
        case 'open':
		case 'close':
			if (UGROUP==1)
			{
				$comment->commentStatusSet((int)$_REQUEST['docid'], $_REQUEST['action']);
			}
			break;
	}
}

/**
 * Следующий раздел описывает правила поведения модуля и его функциональные возможности
 * только при работе в Административной части сайта.
 */
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $AVE_User;

    // Подключаем основной класс и создаем объект
    require_once(BASE_DIR . '/modules/comment/class.comment.php');
	$comment = new Comment;

    // Определяем директори, где хранятся файлы с шаблонами модуля и подключаем языковые переменные
    $tpl_dir   = BASE_DIR . '/modules/comment/templates/';
    $lang_file = BASE_DIR . '/modules/comment/lang/' . $_SESSION['admin_language'] . '.txt';
    $AVE_Template->config_load($lang_file, 'admin');


    // Определяем, какой параметр пришел из строки запроса браузера
    switch ($_REQUEST['moduleaction'])
	{

        // Если 1, тогда отображаем список всех комментариев с постраничной навигацией
        case '1':
			$comment->commentAdminListShow($tpl_dir);
			break;

        // Если admin_edit, тогда открываем форму для редактирования выбранного комментария
        case 'admin_edit':
            $comment->commentAdminPostEdit($tpl_dir);
            break;

		// Если settings, тогда открываем страницу с настройками данного модуля
        case 'settings':
			// Подключаем файл класса для работы с пользователями, создаем объект и получаем список 
            // всех групп пользователей, имеющихся в системе.
            require_once(BASE_DIR . '/class/class.user.php');
			$AVE_User = new AVE_User;
			$AVE_Template->assign('groups', $AVE_User->userGroupListGet());

			$comment->commentAdminSettingsEdit($tpl_dir);
			break;
	}
}

?>