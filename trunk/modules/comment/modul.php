<?php

/**
 * AVE.cms - ������ �����������
 * 
 * ��������, ����������� ���� ������ "�����������", ����� ������� ���������� �����������
 * ������� ������������� ������, � ����� ���������� ������� ��� � ��������� ����� �����,
 * ��� � � ������ ����������.
 *
 * @package AVE.cms
 * @subpackage module_Comment
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

// ���������� ������� �������������� ������
if (defined('ACP'))
{
    $modul['ModulName'] = '�����������'; // �������� ������
    $modul['ModulPfad'] = 'comment'; // �������� �����
    $modul['ModulVersion'] = '1.2'; // ������
    // ������� ��������, ������� ����� �������� � ������ ����������
    $modul['Beschreibung'] = '������ ������ ������������ ��� ����������� ������� ������������ ��� ���������� �� �����. ��� ����, ����� ������������ ������ ������, ���������� ��������� ��� <strong>[mod_comment]</strong> � ������ ����� ������� �������.';
    $modul['Autor'] = 'Arcanum'; // �����
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team'; // ���������
    $modul['Status'] = 1; // ������ ������ �� ��������� (1-�������/0-���������)
    $modul['IstFunktion'] = 1; // ����� �� ������ ������ �������, �� ������� ����� ������� ��������� ��� (1-��,0-���)
    $modul['ModulTemplate'] = 0; // ����� �� ������� ������ � ������ ���������� ��������� ������ ������ (1-��,0-���)
    $modul['AdminEdit'] = 1; // ����� �� ������ ������ ���������, �������� ����� ��������� � ������ ��������� (1-��,0-���)
    $modul['ModulFunktion'] = 'mod_comment'; // �������� �������, �� ������� ����� ������� ��������� ���
    $modul['CpEngineTagTpl'] = '[mod_comment]'; // �������� ���������� ����, ������� ����� ���������� � ������ ����������
    $modul['CpEngineTag'] = '#\\\[mod_comment]#'; // ��� ��������� ���, ������� ����� �������������� � ��������
    $modul['CpPHPTag'] = '<?php mod_comment(); ?>';  // PHP-���, ������� ����� ������ ������ ���������� ����, ��� �������� �������
}

global $AVE_Template;

/**
 * �������, ��������������� ��� ������ ������ ������������ � ������� ���������.
 * ��� ����� ��������� ��� �������� ������� ������ ���������� ���� [mod_comment].
 */
function mod_comment()
{
	global $AVE_Template;

    // ���������� ����� � ������� ������ ��� ������
	require_once(BASE_DIR . '/modules/comment/class.comment.php');
	$comment = new Comment;

    // ���������� �������� �����
	$tpl_dir = BASE_DIR . '/modules/comment/templates/';
	$lang_file = BASE_DIR . '/modules/comment/lang/' . $_SESSION['user_language'] . '.txt';
	$AVE_Template->config_load($lang_file);

    // ���������� � ������ commentListShow() � ���������� ������ ������������
	$comment->commentListShow($tpl_dir);
}

/**
 * ��������� ������ ��������� ������� ��������� ������ � ��� �������������� �����������
 * ������ ��� ������ � ��������� ����� �����.
 */


// ����������, ��� �� �� ��������� � ������ ���������� � � ������ ������� ���������� ��������� ������ � ������� ������
if (!defined('ACP') && isset($_REQUEST['module']) && $_REQUEST['module'] == 'comment' && isset($_REQUEST['action']))
{
	// ���������� �������� ����� � ������� ������
    require_once(BASE_DIR . '/modules/comment/class.comment.php');
	$comment = new Comment;

    // ���������� ���������, ��� �������� ����� � ��������� ������ � ���������� �������� ����������
    $tpl_dir = BASE_DIR . '/modules/comment/templates/';
    $lang_file = BASE_DIR . '/modules/comment/lang/' . $_SESSION['user_language'] . '.txt';
    $AVE_Template->config_load($lang_file);

    // ����������, ����� �������� ������ �� ������ ������� ��������
	switch($_REQUEST['action'])
	{
		// ���� form, ����� ���������� ����� ��� ���������� ������ �����������
        case 'form':
			$comment->commentPostFormShow($tpl_dir);
			break;

		// ���� comment, ����� ���������� ������ ������ ����������� � ��
        case 'comment':
			$comment->commentPostNew($tpl_dir);
			break;

		// ���� edit, ����� ��������� ����� ��� �������������� ������ �����������
        case 'edit':
			$comment->commentPostEdit((int)$_REQUEST['Id']);
			break;


        // ���� delete, ����� ������� �����������
        case 'delete':
			if (UGROUP==1)
			{
				$comment->commentPostDelete((int)$_REQUEST['Id']);
			}
			break;

		// ���� postinfo, ����� ���������� ���� � ����������� �� ������ �����������
        case 'postinfo':
			$comment->commentPostInfoShow($tpl_dir);
			break;

		// ���� lock ��� unlock, ����� ��������� ��� ��������� ��������� ������ ��� ��������� ������������
        case 'lock':
		case 'unlock':
			if (UGROUP==1)
			{
				$comment->commentReplyStatusSet((int)$_REQUEST['Id'], $_REQUEST['action']);
			}
			break;

		
        // ���� open ��� close, ����� ��������� ��� ��������� ������ ��������������� ���������
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
 * ��������� ������ ��������� ������� ��������� ������ � ��� �������������� �����������
 * ������ ��� ������ � ���������������� ����� �����.
 */
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $AVE_User;

    // ���������� �������� ����� � ������� ������
    require_once(BASE_DIR . '/modules/comment/class.comment.php');
	$comment = new Comment;

    // ���������� ���������, ��� �������� ����� � ��������� ������ � ���������� �������� ����������
    $tpl_dir   = BASE_DIR . '/modules/comment/templates/';
    $lang_file = BASE_DIR . '/modules/comment/lang/' . $_SESSION['admin_language'] . '.txt';
    $AVE_Template->config_load($lang_file, 'admin');


    // ����������, ����� �������� ������ �� ������ ������� ��������
    switch ($_REQUEST['moduleaction'])
	{

        // ���� 1, ����� ���������� ������ ���� ������������ � ������������ ����������
        case '1':
			$comment->commentAdminListShow($tpl_dir);
			break;

        // ���� admin_edit, ����� ��������� ����� ��� �������������� ���������� �����������
        case 'admin_edit':
            $comment->commentAdminPostEdit($tpl_dir);
            break;

		// ���� settings, ����� ��������� �������� � ����������� ������� ������
        case 'settings':
			// ���������� ���� ������ ��� ������ � ��������������, ������� ������ � �������� ������ 
            // ���� ����� �������������, ��������� � �������.
            require_once(BASE_DIR . '/class/class.user.php');
			$AVE_User = new AVE_User;
			$AVE_Template->assign('groups', $AVE_User->userGroupListGet());

			$comment->commentAdminSettingsEdit($tpl_dir);
			break;
	}
}

?>