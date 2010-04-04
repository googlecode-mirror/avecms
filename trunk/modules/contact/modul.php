<?php

/**
 * AVE.cms - Модуль Контакты
 *
 * @package AVE.cms
 * @subpackage module_Contact
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Контакты';
    $modul['ModulPfad'] = 'contact';
    $modul['ModulVersion'] = '2.2';
    $modul['Beschreibung'] = 'Данный модуль предназначен для создания различных веб-форм для контактов, которые могут состоять из различного набора полей. Создание контактной формы осуществляется в Панели управления, а для вывода в Публичной части сайта, Вам необходимо разместить системный тег <strong>[mod_contact:XXX]</strong> в нужном месте Вашего шаблона или содержимого документа. XXX - это порядковый номер формы в системе.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = 'mod_contact';
    $modul['CpEngineTagTpl'] = '[mod_contact:XXX]';
    $modul['CpEngineTag'] = '#\\\[mod_contact:(\\\d+)]#';
    $modul['CpPHPTag'] = "<?php mod_contact(''$1''); ?>";
}

/**
 * Обработка тэга модуля
 *
 * @param int $id - идентификатор контактной формы
 */
function mod_contact($id)
{
	global $AVE_DB, $AVE_Template;

	require_once(BASE_DIR . '/modules/contact/class.contact.php');

//	if (function_exists('imagettftext') && function_exists('imagepng'))
//	{
//		define('ANTI_SPAMIMAGE', 1);
//	}

    $id  = preg_replace('/(\D+)/', '', $id);
    
	$tpl_dir   = BASE_DIR . '/modules/contact/templates/';
	$lang_file = BASE_DIR . '/modules/contact/lang/' . DEFAULT_LANGUAGE . '.txt';
	
    $contact   = new Contact;

	if (! isset($_REQUEST['contact_action']))
	{
//		$AVE_Globals = new AVE_Globals;
//		$codeid  = $contact->secureCode();

//		$row = $AVE_DB->Query("
//			SELECT
//				form_antispam,
//				form_max_upload
//			FROM " . PREFIX . "_modul_contacts
//			WHERE Id = '" . $id . "'
//		")->FetchRow();

//		if (is_object($row))
//		{
//			$im = (defined('ANTI_SPAMIMAGE') && $row->form_antispam == 1) ? $codeid : '';
//            $contact->fetchForm($tpl_dir, $lang_file, $id, $im, $row->form_max_upload);
//			$contact->fetchForm($tpl_dir, $lang_file, $id, $row->form_antispam, $row->form_max_upload);
//		}
        $contact->fetchForm($tpl_dir, $lang_file, $id);
	}

	if (! empty($_REQUEST['modules']) && $_REQUEST['modules'] == 'contact')
	{
		if (! empty($_REQUEST['contact_action']))
		{
			switch ($_REQUEST['contact_action'])
			{
				case 'DoPost':
//					$row = $AVE_DB->Query("
//						SELECT
//							form_antispam,
//							form_max_upload
//						FROM " . PREFIX . "_modul_contacts
//						WHERE Id = '" . $id . "'
//					")->FetchRow();

                    $contact->sendSecure($tpl_dir, $lang_file, $id);
//                  $contact->sendSecure($tpl_dir, $lang_file, $id, $row->form_antispam, $row->form_max_upload);
//					if (defined('ANTI_SPAMIMAGE') && @$row->form_antispam == 1)
//					{
//						if (! defined('BLANC')) define('BLANC', 1);
//						$contact->sendSecure($tpl_dir, $lang_file, $id, 1, $row->form_max_upload);
//					}
//					else
//					{
//						if (! defined('BLANC')) define('BLANC', 1);
//						$contact->sendSecure($tpl_dir, $lang_file, $id, 0, @$row->form_max_upload);
//					}
					break;
			}
		}
	}
}

if (defined('ACP') && ! (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'))
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/contact/sql.php');
	require_once(BASE_DIR . '/modules/contact/class.contact.php');

	$tpl_dir   = BASE_DIR . '/modules/contact/templates/';
	$lang_file = BASE_DIR . '/modules/contact/lang/' . $_SESSION['admin_lang'] . '.txt';

	$contact = new Contact;

	$AVE_Template->config_load($lang_file, 'admin');
	$config_vars = $AVE_Template->get_config_vars();
	$AVE_Template->assign('config_vars', $config_vars);

	if(!empty($_REQUEST['moduleaction']))
	{
		switch($_REQUEST['moduleaction'])
		{
			case '1':
				$contact->showForms($tpl_dir);
				break;

			case 'edit':
				$contact->editForms($tpl_dir, $_REQUEST['id']);
				break;

			case 'save':
				$contact->saveForms($_REQUEST['id']);
				break;

			case 'save_new':
				$contact->saveFormsNew($_REQUEST['id']);
				break;

			case 'new':
				$contact->newForms($tpl_dir);
				break;

			case 'delete':
				$contact->deleteForms($_REQUEST['id']);
				break;

			case 'showmessages_new':
				$contact->showMessages($tpl_dir, $_REQUEST['id'], 'new');
				break;

			case 'showmessages_old':
				$contact->showMessages($tpl_dir, $_REQUEST['id'], 'old');
				break;

			case 'reply':
				$contact->replyMessage();
				break;

			case 'quicksave':
				$contact->quickSave();
				break;

			case 'get_attachment':
				$contact->getAttachment($_REQUEST['file']);
				break;
		}
	}
}

?>