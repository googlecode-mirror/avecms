<?php

/**
 * AVE.cms - ������ ��������
 *
 * @package AVE.cms
 * @subpackage module_Contact
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = '��������';
    $modul['ModulPfad'] = 'contact';
    $modul['ModulVersion'] = '2.3';
    $modul['Beschreibung'] = '������ ������ ������������ ��� �������� ��������� ���-���� ��� ���������, ������� ����� �������� �� ���������� ������ �����. �������� ���������� ����� �������������� � ������ ����������, � ��� ������ � ��������� ����� �����, ��� ���������� ���������� ��������� ��� <strong>[mod_contact:XXX]</strong> � ������ ����� ������ ������� ��� ����������� ���������. XXX - ��� ���������� ����� ����� � �������.';
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
 * ��������� ���� ������
 *
 * @param int $contact_id - ������������� ���������� �����
 */
function mod_contact($contact_id)
{
	global $AVE_DB, $AVE_Template;

	require_once(BASE_DIR . '/modules/contact/class.contact.php');

    $contact_id = preg_replace('/\D/', '', $contact_id);

	$tpl_dir   = BASE_DIR . '/modules/contact/templates/';
	$lang_file = BASE_DIR . '/modules/contact/lang/' . $_SESSION['user_language'] . '.txt';

    $contact = new Contact;

	if (! isset($_REQUEST['contact_action']))
	{
        $contact->fetchForm($tpl_dir, $lang_file, $contact_id);
	}

	if (! empty($_REQUEST['modules']) && $_REQUEST['modules'] == 'contact')
	{
		if (! empty($_REQUEST['contact_action']))
		{
			switch ($_REQUEST['contact_action'])
			{
				case 'DoPost':
                    $contact->sendSecure($tpl_dir, $lang_file, $contact_id);
					break;
			}
		}
	}
}

if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/contact/class.contact.php');

	$tpl_dir   = BASE_DIR . '/modules/contact/templates/';
	$lang_file = BASE_DIR . '/modules/contact/lang/' . $_SESSION['admin_language'] . '.txt';

	$contact = new Contact;

	$AVE_Template->config_load($lang_file, 'admin');
	$config_vars = $AVE_Template->get_config_vars();
	$AVE_Template->assign('config_vars', $config_vars);

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

?>