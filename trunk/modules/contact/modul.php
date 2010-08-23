<?php

/**
 * AVE.cms - Модуль Контактные формы
 *
 *
 * Основной, управляющий файл модуля "Контактные формы", через который происходит определение
 * базовых характеристик модуля, а также управление модулем как в публичной части сайта,
 * так и в Панели управления.
 *
 * @package AVE.cms
 * @subpackage module_Contact
 * @since 1.4
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

// Определяем базовые характеристики модуля
if (defined('ACP'))
{
    $modul['ModulName'] = 'Контакты'; // Название модуля
    $modul['ModulPfad'] = 'contact';  // Название папки
    $modul['ModulVersion'] = '2.4';  // Версия
    // Краткое описание, которое будет показано в Панели управления
    $modul['description'] = 'Данный модуль предназначен для создания различных веб-форм для контактов, которые могут состоять из различного набора полей. Создание контактной формы осуществляется в Панели управления, а для вывода в Публичной части сайта, Вам необходимо разместить системный тег <strong>[mod_contact:XXX]</strong> в нужном месте Вашего шаблона или содержимого документа. XXX - это порядковый номер формы в системе.';
    $modul['Autor'] = 'Arcanum'; // Автор
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team'; // Копирайты
    $modul['Status'] = 1; // Статус модуля по умолчанию (1-активен/0-неактивен)
    $modul['IstFunktion'] = 1;  // Имеет ли данный модуль функцию, на которую будет заменен системный тег (1-да,0-нет)
    $modul['AdminEdit'] = 1;  // Имеет ли данный модуль параметры, которыми можно управлять в Панели упраления (1-да,0-нет)
    $modul['ModulFunktion'] = 'mod_contact';  // Название функции, на которую будет заменен системный тег
    $modul['CpEngineTagTpl'] = '[mod_contact:XXX]';  // Название системного тега, которое будет отображено в Панели управления
    $modul['CpEngineTag'] = '#\\\[mod_contact:(\\\d+)]#';  // Сам системный тег, который будет использоваться в шаблонах
    $modul['CpPHPTag'] = "<?php mod_contact(''$1''); ?>";  // PHP-код, который будет вызван вместо системного тега, при парсинге шаблона
}

/**
 * Функция, предназначенная для вывода контактной формы.
 * Она будет выполнена при парсинге шаблона вместо системного тега [mod_contact:XXX],
 * где ХХХ - это внутренний номер контактной формы (их может быть несколько).
 *
 * @param int $contact_id - идентификатор контактной формы
 */
function mod_contact($contact_id)
{
	// Подключаем файл с классом, определяем директорию с шаблонами,
    // подключаем языковой файл и создаем объект класса.
    require_once(BASE_DIR . '/modules/contact/class.contact.php');

    $contact_id = preg_replace('/\D/', '', $contact_id);

	$tpl_dir   = BASE_DIR . '/modules/contact/templates/';
	$lang_file = BASE_DIR . '/modules/contact/lang/' . $_SESSION['user_language'] . '.txt';

    $contact = new Contact;

	// Если в запросе не пришел параметр на отправку формы, показываем пустую форму.
    if (! isset($_REQUEST['contact_action']))
	{
        $contact->contactFormShow($tpl_dir, $lang_file, $contact_id);
	}

    // Если в запросе пришел праметр на отправку формы (contact_action=DoPost), выполняем отправку.
    if (! empty($_REQUEST['modules']) && $_REQUEST['modules'] == 'contact')
	{
		if (! empty($_REQUEST['contact_action']))
		{
			switch ($_REQUEST['contact_action'])
			{
				case 'DoPost':
                    $contact->contactFormSend($tpl_dir, $lang_file, $contact_id);
					break;
			}
		}
	}
}

/**
 * Следующий раздел описывает правила поведения модуля и его функциональные возможности
 * только при работе в Административной части сайта.
 */
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $AVE_Template;

	// Подключаем файл с классом, определяем директорию с шаблонами,
    // подключаем языковой файл и создаем объект класса.
    require_once(BASE_DIR . '/modules/contact/class.contact.php');
	$tpl_dir   = BASE_DIR . '/modules/contact/templates/';
	$lang_file = BASE_DIR . '/modules/contact/lang/' . $_SESSION['admin_language'] . '.txt';
	$contact = new Contact;

	$AVE_Template->config_load($lang_file, 'admin');
	$config_vars = $AVE_Template->get_config_vars();
	$AVE_Template->assign('config_vars', $config_vars);

	// Определяем, какой параметр пришел из строки запроса браузера
    switch($_REQUEST['moduleaction'])
	{
		// Если 1, тогда отображаем список всех контактных форм
        case '1':
			$contact->contactFormList($tpl_dir);
			break;

		// Если edit, тогда открываем окно для редактирования текущей формы
        case 'edit':
			$contact->contactFormEdit($tpl_dir, $_REQUEST['id']);
			break;

		// Если save, тогда сохраняем результаты изменений для редактируемой формы
        case 'save':
			$contact->contactFormSave($_REQUEST['id']);
			break;

		// Если save_new, тогда добавляем в БД поля новой контактной формой
        case 'save_new':
			$contact->contactFormFieldSave($_REQUEST['id']);
			break;

		// Если new, тогда открываем окно для создания новой формы
        case 'new':
			$contact->contactFormNew($tpl_dir);
			break;

		// Если delete, тогда удаляем выбранную контактную форму
        case 'delete':
			$contact->contactFormDelete($_REQUEST['id']);
			break;

		// Если showmessages_new, тогда показываем список всех новых сообщений (непрочтенные)
        case 'showmessages_new':
			$contact->contactMessageShow($tpl_dir, $_REQUEST['id'], 'new');
			break;

		// Если showmessages_old, тогда показываем список всех старых сообщений (прочтенные)
        case 'showmessages_old':
			$contact->contactMessageShow($tpl_dir, $_REQUEST['id'], 'old');
			break;

		// Если reply, тогда показываем форму ввода ответа на данное сообщение
        case 'reply':
			$contact->contactMessageReply();
			break;

		// Если del_attachment, тогда удаляем прикрепленные к сообщению файлы
        case 'del_attachment':
			$contact->contactAttachmentDelete();
			break;

        // Если get_attachment, тогда скачиваем прикрепленные к сообщению файлы
        case 'get_attachment':
			$contact->contactAttachmentGet($_REQUEST['file']);
			break;
	}
}

?>