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

// Определяем базоые характеристики модуля
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
 *
 * Сначала происходит подключение класса class.comment.php, в котором содержаться все
 * методы для работы с данным модулем. Далее создается объект класса для дальнейшей
 * работы и подключаются файлы с языковыми переменными. Последней строкой происходит
 * вызов метода commentListShow(), который и отображает список всех комментариев к данному
 * документу.
 *
 */
function mod_comment()
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/comment/class.comment.php');
	$comment = new Comment;

	$tpl_dir = BASE_DIR . '/modules/comment/templates/';
	$lang_file = BASE_DIR . '/modules/comment/lang/' . $_SESSION['user_language'] . '.txt';
	$AVE_Template->config_load($lang_file);

	$comment->commentListShow($tpl_dir);
}

/**
 * Следующий раздел описывает правила поведения модуля и его функциональные возможности
 * только при работе в Публичной части сайта.
 *
 * Сначала происходит определение того, что мы не находимся в Панели управления, а также
 * получаем строку запроса, разбирая которую, определяем, что произошел вызов именно этого
 * модуля ($_REQUEST['module'] == 'comment') с каким-либо опеределенный действием (isset($_REQUEST['action'])).
 *
 * Далее подключаем файл с классом, в котором содержатся все методы по работе с модулем.
 * Создаем объект класса. Подключаем файл с языковыми переменными и запускаем управляющую
 * конструкцию switch, которая, в зависимости от переданного параметра в строке запроса (action),
 * будет выполнять те или иные методы, определенные в файле класса.
 * 
 * Если передан параметр:
 * 
 * form    - вызываем метод commentPostFormShow(), который отображает форму для ввода комментария
 * comment - вызываем метод commentPostNew(), который выполняет добавление нового комментария в базу данных
 * edit    - вызываем метод commentPostEdit(), который отображает форму для редактирования комментария
 * delete  - проверяем, чтобы пользователь, вызвавший данный метод относился к группе Администраторы и удаляем комментарий
 * postinfo - вызываем метод commentPostInfoShow(), который отображает информацию об авторе комментария
 * lock/unlock - вызываем метод commentReplyStatusSet(), который разрешает, либо запрещает оставлять ответы для уже имеющихся комментариев
 * open/close - вызываем метод commentStatusSet(), который разрешает, либо запрещает оставлять комментарии к документу
 * 
 */
if (!defined('ACP') &&
	isset($_REQUEST['module']) && $_REQUEST['module'] == 'comment' &&
	isset($_REQUEST['action']))
{
	require_once(BASE_DIR . '/modules/comment/class.comment.php');
	$comment = new Comment;

    $tpl_dir = BASE_DIR . '/modules/comment/templates/';
    $lang_file = BASE_DIR . '/modules/comment/lang/' . $_SESSION['user_language'] . '.txt';
    $AVE_Template->config_load($lang_file);

	switch($_REQUEST['action'])
	{
		case 'form':
			$comment->commentPostFormShow($tpl_dir);
			break;

		case 'comment':
			$comment->commentPostNew($tpl_dir);
			break;

		case 'edit':
			$comment->commentPostEdit((int)$_REQUEST['Id']);
			break;

		case 'delete':
			if (UGROUP==1)
			{
				$comment->commentPostDelete((int)$_REQUEST['Id']);
			}
			break;

		case 'postinfo':
			$comment->commentPostInfoShow($tpl_dir);
			break;

		case 'lock':
		case 'unlock':
			if (UGROUP==1)
			{
				$comment->commentReplyStatusSet((int)$_REQUEST['Id'], $_REQUEST['action']);
			}
			break;

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
 *
 * Сначала происходит определение того, что мы находимся в Панели управления (defined('ACP')) и
 * существует какое-либо значение для параметра действия !empty($_REQUEST['moduleaction']).
 *
 * Далее подключаем файл с классом, создаем объект класса и подключаем файл с языковыми переменными.
 * После этого запускаем управляющую конструкцию switch, которая, в зависимости от переданного
 * параметра в строке запроса (action), будет выполнять те или иные методы, определенные в
 * файле класса.
 *
 * Если передан параметр:
 *
 * 1          - вызываем метод commentAdminListShow(), который выводит список всех комментариев к документам
 * admin_edit - вызываем метод commentAdminPostEdit(), который отображает форму для редактирования комментария
 * settings   - вызываем метод commentAdminSettingsEdit(), который отображает раздел с настройками модуля.
 *
 * Также при передаче параметра settings происходит подключение класса для работы с пользователями.
 * Создается объект по работе с пользователями и происходит обращение к методу userGroupListGet(),
 * с целью получения списка всех групп пользователей, определенных в разделе Управление группами.
 */
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $AVE_User;

	require_once(BASE_DIR . '/modules/comment/class.comment.php');
	$comment = new Comment;

    $tpl_dir   = BASE_DIR . '/modules/comment/templates/';
    $lang_file = BASE_DIR . '/modules/comment/lang/' . $_SESSION['admin_language'] . '.txt';
    $AVE_Template->config_load($lang_file, 'admin');

	switch ($_REQUEST['moduleaction'])
	{
		case '1':
			$comment->commentAdminListShow($tpl_dir);
			break;

        case 'admin_edit':
            $comment->commentAdminPostEdit($tpl_dir);
            break;

		case 'settings':
			require_once(BASE_DIR . '/class/class.user.php');
			$AVE_User = new AVE_User;
			$AVE_Template->assign('groups', $AVE_User->userGroupListGet());

			$comment->commentAdminSettingsEdit($tpl_dir);
			break;
	}
}

?>