<?php

/**
 * AVE.cms - ������ ���������� �����
 *
 *
 * ��������, ����������� ���� ������ "���������� �����", ����� ������� ���������� �����������
 * ������� ������������� ������, � ����� ���������� ������� ��� � ��������� ����� �����,
 * ��� � � ������ ����������.
 *
 * @package AVE.cms
 * @subpackage module_Contact
 * @since 1.4
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

// ���������� ������� �������������� ������
if (defined('ACP'))
{
    $modul['ModulName'] = '��������'; // �������� ������
    $modul['ModulPfad'] = 'contact';  // �������� �����
    $modul['ModulVersion'] = '2.4';  // ������
    // ������� ��������, ������� ����� �������� � ������ ����������
    $modul['description'] = '������ ������ ������������ ��� �������� ��������� ���-���� ��� ���������, ������� ����� �������� �� ���������� ������ �����. �������� ���������� ����� �������������� � ������ ����������, � ��� ������ � ��������� ����� �����, ��� ���������� ���������� ��������� ��� <strong>[mod_contact:XXX]</strong> � ������ ����� ������ ������� ��� ����������� ���������. XXX - ��� ���������� ����� ����� � �������.';
    $modul['Autor'] = 'Arcanum'; // �����
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team'; // ���������
    $modul['Status'] = 1; // ������ ������ �� ��������� (1-�������/0-���������)
    $modul['IstFunktion'] = 1;  // ����� �� ������ ������ �������, �� ������� ����� ������� ��������� ��� (1-��,0-���)
    $modul['AdminEdit'] = 1;  // ����� �� ������ ������ ���������, �������� ����� ��������� � ������ ��������� (1-��,0-���)
    $modul['ModulFunktion'] = 'mod_contact';  // �������� �������, �� ������� ����� ������� ��������� ���
    $modul['CpEngineTagTpl'] = '[mod_contact:XXX]';  // �������� ���������� ����, ������� ����� ���������� � ������ ����������
    $modul['CpEngineTag'] = '#\\\[mod_contact:(\\\d+)]#';  // ��� ��������� ���, ������� ����� �������������� � ��������
    $modul['CpPHPTag'] = "<?php mod_contact(''$1''); ?>";  // PHP-���, ������� ����� ������ ������ ���������� ����, ��� �������� �������
}

/**
 * �������, ��������������� ��� ������ ���������� �����.
 * ��� ����� ��������� ��� �������� ������� ������ ���������� ���� [mod_contact:XXX],
 * ��� ��� - ��� ���������� ����� ���������� ����� (�� ����� ���� ���������).
 *
 * @param int $contact_id - ������������� ���������� �����
 */
function mod_contact($contact_id)
{
	// ���������� ���� � �������, ���������� ���������� � ���������,
    // ���������� �������� ���� � ������� ������ ������.
    require_once(BASE_DIR . '/modules/contact/class.contact.php');

    $contact_id = preg_replace('/\D/', '', $contact_id);

	$tpl_dir   = BASE_DIR . '/modules/contact/templates/';
	$lang_file = BASE_DIR . '/modules/contact/lang/' . $_SESSION['user_language'] . '.txt';

    $contact = new Contact;

	// ���� � ������� �� ������ �������� �� �������� �����, ���������� ������ �����.
    if (! isset($_REQUEST['contact_action']))
	{
        $contact->contactFormShow($tpl_dir, $lang_file, $contact_id);
	}

    // ���� � ������� ������ ������� �� �������� ����� (contact_action=DoPost), ��������� ��������.
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
 * ��������� ������ ��������� ������� ��������� ������ � ��� �������������� �����������
 * ������ ��� ������ � ���������������� ����� �����.
 */
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $AVE_Template;

	// ���������� ���� � �������, ���������� ���������� � ���������,
    // ���������� �������� ���� � ������� ������ ������.
    require_once(BASE_DIR . '/modules/contact/class.contact.php');
	$tpl_dir   = BASE_DIR . '/modules/contact/templates/';
	$lang_file = BASE_DIR . '/modules/contact/lang/' . $_SESSION['admin_language'] . '.txt';
	$contact = new Contact;

	$AVE_Template->config_load($lang_file, 'admin');
	$config_vars = $AVE_Template->get_config_vars();
	$AVE_Template->assign('config_vars', $config_vars);

	// ����������, ����� �������� ������ �� ������ ������� ��������
    switch($_REQUEST['moduleaction'])
	{
		// ���� 1, ����� ���������� ������ ���� ���������� ����
        case '1':
			$contact->contactFormList($tpl_dir);
			break;

		// ���� edit, ����� ��������� ���� ��� �������������� ������� �����
        case 'edit':
			$contact->contactFormEdit($tpl_dir, $_REQUEST['id']);
			break;

		// ���� save, ����� ��������� ���������� ��������� ��� ������������� �����
        case 'save':
			$contact->contactFormSave($_REQUEST['id']);
			break;

		// ���� save_new, ����� ��������� � �� ���� ����� ���������� ������
        case 'save_new':
			$contact->contactFormFieldSave($_REQUEST['id']);
			break;

		// ���� new, ����� ��������� ���� ��� �������� ����� �����
        case 'new':
			$contact->contactFormNew($tpl_dir);
			break;

		// ���� delete, ����� ������� ��������� ���������� �����
        case 'delete':
			$contact->contactFormDelete($_REQUEST['id']);
			break;

		// ���� showmessages_new, ����� ���������� ������ ���� ����� ��������� (������������)
        case 'showmessages_new':
			$contact->contactMessageShow($tpl_dir, $_REQUEST['id'], 'new');
			break;

		// ���� showmessages_old, ����� ���������� ������ ���� ������ ��������� (����������)
        case 'showmessages_old':
			$contact->contactMessageShow($tpl_dir, $_REQUEST['id'], 'old');
			break;

		// ���� reply, ����� ���������� ����� ����� ������ �� ������ ���������
        case 'reply':
			$contact->contactMessageReply();
			break;

		// ���� del_attachment, ����� ������� ������������� � ��������� �����
        case 'del_attachment':
			$contact->contactAttachmentDelete();
			break;

        // ���� get_attachment, ����� ��������� ������������� � ��������� �����
        case 'get_attachment':
			$contact->contactAttachmentGet($_REQUEST['file']);
			break;
	}
}

?>