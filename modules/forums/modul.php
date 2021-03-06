<?php

/**
 * Форумы
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Форумы';
    $modul['ModulPfad'] = 'forums';
    $modul['ModulVersion'] = '1.2';
    $modul['description'] = 'Система форумов для cpengine, разработанная компанией dream4';
    $modul['Autor'] = 'Bj&ouml;rn Wunderlich';
    $modul['MCopyright'] = '&copy; 2006 dream4';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 0;
    $modul['ModulTemplate'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = null;
    $modul['CpEngineTagTpl'] = '<b>Ссылка:</b> <a target="_blank" href="../index.php?module=forums">index.php?module=forums</a>';
    $modul['CpEngineTag'] = null;
    $modul['CpPHPTag'] = null;
}

if( (isset($_REQUEST['module']) && $_REQUEST['module'] == 'forums') || (isset($_REQUEST['mod']) && $_REQUEST['mod'] == 'forums') )
{
	define ('GET_NO_DOC', 1);
	define ('FORUM_STATUS_OPEN', 0);
	define ('FORUM_STATUS_CLOSED', 1);
	define ('FORUM_STATUS_MOVED', 2);
	define ('FORUM_DEFAULT_TOPIC_LIMIT', 10);
	define ('FORUM_AGE_LIMIT', 10);
	define ('FORUM_PERMISSION_CAN_SEE', 0);
	define ('FORUM_PERMISSION_CAN_SEE_TOPIC', 1);
	define ('FORUM_PERMISSION_CAN_SEE_DELETE_MESSAGE', 2);
	define ('FORUM_PERMISSION_CAN_SEARCH_FORUM', 3);
	define ('FORUM_PERMISSION_CAN_DOWNLOAD_ATTACHMENT', 4);
	define ('FORUM_PERMISSION_CAN_CREATE_TOPIC', 5);
	define ('FORUM_PERMISSION_CAN_REPLY_OWN_TOPIC', 6);
	define ('FORUM_PERMISSION_CAN_REPLY_OTHER_TOPIC', 7);
	define ('FORUM_PERMISSION_CAN_UPLOAD_ATTACHMENT', 8);
	define ('FORUM_PERMISSION_CAN_RATE_TOPIC', 9);
	define ('FORUM_PERMISSION_CAN_EDIT_OWN_POST', 10);
	define ('FORUM_PERMISSION_CAN_DELETE_OWN_POST', 11);
	define ('FORUM_PERMISSION_CAN_MOVE_OWN_TOPIC', 12);
	define ('FORUM_PERMISSION_CAN_CLOSE_OPEN_OWN_TOPIC', 13);
	define ('FORUM_PERMISSION_CAN_DELETE_OWN_TOPIC', 14);
	define ('FORUM_PERMISSION_CAN_DELETE_OTHER_POST', 15);
	define ('FORUM_PERMISSION_CAN_EDIT_OTHER_POST', 16);
	define ('FORUM_PERMISSIONS_CAN_OPEN_TOPIC', 17);
	define ('FORUM_PERMISSIONS_CAN_CLOSE_TOPIC', 18);
	define ('FORUM_PERMISSIONS_CAN_CHANGE_TOPICTYPE', 19);
	define ('FORUM_PERMISSIONS_CAN_MOVE_TOPIC', 20);
	define ('FORUM_PERMISSIONS_CAN_DELETE_TOPIC', 21);

	if (empty($_REQUEST['show'])) $_REQUEST['show'] = 'showforums';

	/**
	 * Следующий раздел описывает правила поведения модуля и его функциональные возможности
	 * только при работе в Публичной части сайта.
	 */
	if (!defined('ACP') && isset($_REQUEST['module']) && $_REQUEST['module'] == 'forums')
	{
		require_once(BASE_DIR . '/modules/forums/class.forums.php');
		$forums = new Forum;

		$forums->AutoUpdatePerms();

		$row_set = $forums->forumSettings();

		$row_gs = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_forum_group_permissions
			WHERE user_group = '" . UGROUP . "'
			LIMIT 1
		")->FetchRow();

		define ('BOARD_NEWPOSTMAXAGE', '-4 weeks');
		define ('MAX_AVATAR_WIDTH', $row_gs->max_avatar_width);
		define ('MAX_AVATAR_HEIGHT', $row_gs->max_avatar_height);
		define ('MAX_AVATAR_BYTES', $row_gs->max_avatar_bytes);
		define ('SYSTEMAVATARS', $row_set['sys_avatars']);
		define ('UPLOADAVATAR', $row_gs->upload_avatar);
		define ('MAXPN', $row_gs->max_pn);
		define ('MAXPNLENTH', $row_gs->max_lenght_pn);
		define ('MISCIDSINC', 1);
		define ('FORUMEMAIL', $row_set['sender_mail']);
		define ('FORUMABSENDER', $row_set['sender_name']);
		define ('BBCODESITE', $row_set['bbcode']);
		define ('IMGCODE', $row_set['bbcode']);
		define ('SMILIES', $row_set['smilies']);
		define ('USEPOSTICONS', $row_set['posticons']);
		define ('COMMENTSBBCODE', $row_set['bbcode']);
		define ('MAXLENGTH_POST', $row_gs->max_lenght_post);
		define ('MAXATTACHMENTS', $row_gs->max_attachments);
		define ('forum_images', 'templates/'. THEME_FOLDER.'/modules/forums/');
		define ('TOPIC_TYPE_NONE', 0);
		define ('TOPIC_TYPE_STICKY', 1);
		define ('TOPIC_TYPE_ANNOUNCE', 100);
		define ('EXPIRE_MINUTE', time() + 60);
		define ('EXPIRE_HOURS',  time() + 60*60);
		define ('EXPIRE_DAY',    time() + 60*60*24);
		define ('EXPIRE_MONTH',  time() + 60*60*24*30);
		define ('EXPIRE_YEAR',   time() + 60*60*24*30*365);
		define ('MAX_EDIT_PERIOD', $row_gs->max_edit_period); // Zeit in Stunden, in der der ein Beitrag editiert werden kann 720 = 1 Monat

		require_once(BASE_DIR . '/functions/func.modulglobals.php');
		set_modul_globals('forums');

		if(defined('THEME_FOLDER')) $AVE_Template->assign('theme_folder', THEME_FOLDER);

		define ('USERNAME', (isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id'])) ? $forums->fetchusername($_SESSION['user_id']) : UNAME);
		$_SESSION['forum_user_name'] = (isset($_SESSION['user_id'])) ? $forums->fetchusername($_SESSION['user_id']) : $GLOBALS['mod']['config_vars']['FORUMS_GUEST'];
		$_SESSION['forum_user_email'] = (isset($_SESSION['user_id'])) ? $forums->getForumUserEmail($_SESSION['user_id']) : '';

		$forums->UserOnlineUpdate();

		$AVE_Template->register_function('cpencode', 'cpencode');
		$AVE_Template->register_function('cpdecode', 'cpdecode');
		$AVE_Template->register_function('get_post_icon', 'getPostIcon');

		$AVE_Template->assign('forum_images', 'templates/' . THEME_FOLDER . '/modules/forums/');
		$AVE_Template->assign('sys_avatars', SYSTEMAVATARS);
		$AVE_Template->assign('header', $row_set['pageheader']);
		$AVE_Template->assign('pageheader', $row_set['pageheader']);
		$AVE_Template->assign('inc_path', BASE_DIR . '/modules/forums/templates');
		$AVE_Template->assign('ugroup', UGROUP);
		$AVE_Template->assign('PNunreaded', $forums->pnUnreaded());
		$AVE_Template->assign('PNreaded', $forums->pnReaded());
		$AVE_Template->assign('SearchPop', $forums->popSearch());
		$AVE_Template->assign('get_mods', $forums->get_mods(@$_REQUEST['fid']));
		$AVE_Template->assign('stats_user', $forums->ForumStats());

		$AVE_Template->assign('maxlength_post', MAXLENGTH_POST);
		$AVE_Template->assign('maxattachment', MAXATTACHMENTS);
		$AVE_Template->assign('max_avatar_width', MAX_AVATAR_WIDTH);
		$AVE_Template->assign('max_avatar_height', MAX_AVATAR_HEIGHT);

		// Wenn Benutzergruppe keinen Zugriff hat
		if((!$forums->fperm('accessforums')))
		{
			$forums->msg($GLOBALS['mod']['config_vars']['FORUMS_FORUM_NO_ACCESS'], 'index.php?module=login&action=register');
		}

		switch($_REQUEST['show']) {
			case 'ignorelist':
				$forums->ignoreList();
				break;

			case 'userpop':
				$forums->userPopUp();
				break;

			case 'showforums':
				$forums->showForums();
				break;

			case 'showforum':
				$forums->showForum();
				break;

			case 'showtopic':
				$forums->showTopic();
				break;

			case 'getfile':
				$forums->getFile();
				break;

			case 'closetopic':
				$forums->openClose('close');
				break;

			case 'opentopic':
				$forums->openClose('open');
				break;

			case 'move':
				$forums->moveTopic();
				break;

			case 'deltopic':
				$forums->delTopic();
				break;

			case 'addtopic':
				$forums->addTopic();
				break;

			case 'newtopic':
				$forums->newTopic();
				break;

			case 'newpost':
				$forums->newPost();
				break;

			case 'addpost':
				$forums->addPost();
				break;

			case 'delpost':
				$forums->delPost();
				break;

			case 'addsubscription':
				$forums->setAbo('on');
				break;

			case 'unsubscription':
				$forums->setAbo('off');
				break;

			case 'forumlogin':
				$forums->forumsLogin();
				break;

			case 'change_type':
				$forums->changeType();
				break;

			case 'markread':
				$forums->markRead();
				break;

			case 'last24':
				if (!$forums->fperm('last24'))
				{
					$forums->msg($GLOBALS['mod']['config_vars']['FORUMS_ERROR_NO_PERM']);
				}
				$forums->last24();
				break;

			case 'myabos':
				$forums->myAbos();
				break;

			case 'userpostings':
				$forums->userPostings();
				break;

			case 'userprofile':
				if (!$forums->fperm('userprofile'))
				{
					$forums->msg($GLOBALS['mod']['config_vars']['FORUMS_ERROR_NO_PERM']);
				}
				$forums->showUserProfile();
				break;

			case 'showposter':
				$forums->showPoster();
				break;

			case 'rating':
				$forums->voteTopic();
				break;

			case 'attachfile':
				$forums->attachFile();
				break;

			case 'search_mask':
				if (!$forums->fperm('cansearch'))
				{
					$forums->msg($GLOBALS['mod']['config_vars']['FORUMS_ERROR_NO_PERM']);
				}
				$forums->searchMask();
				break;

			case 'search':
				if (!$forums->fperm('cansearch'))
				{
					$forums->msg($GLOBALS['mod']['config_vars']['FORUMS_ERROR_NO_PERM']);
				}
				$forums->doSearch();
				break;

			case 'publicprofile':
				$forums->myProfile();
				break;

			case 'pn':
				$forums->pMessages();
				break;

			case 'userlist':
				$forums->getUserlist();
/*
			case 'import':
				$forums->importfromkoobi();
				break;
*/		}
	}

	/**
	 * Следующий раздел описывает правила поведения модуля и его функциональные возможности
	 * только при работе в Административной части сайта.
	 */
	if(defined('ACP') && !empty($_REQUEST['moduleaction'])
		&& !(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'))
	{
		// Подключаем основной класс и создаем объект
		require_once(BASE_DIR . '/modules/forums/class.forums_admin.php');
		$forums = new Forum;
		
		// Определяем директори, где хранятся файлы с шаблонами модуля и подключаем языковые переменные
		$tpl_dir = BASE_DIR . '/modules/forums/templates_admin/';
		$tpl_dir_source = BASE_DIR . '/modules/forums/templates_admin';
		$lang_file = BASE_DIR . '/modules/forums/lang/' . $_SESSION['admin_language'] . '.txt';

		$AVE_Template->config_load($lang_file, 'admin');
		$AVE_Template->assign('source', $tpl_dir_source);

		$forums->AutoUpdatePerms();

		// Определяем, какой параметр пришел из строки запроса браузера	
		switch ($_REQUEST['moduleaction'])
		{
			case '1':
				$forums->forumAdmin($tpl_dir);
				break;
				// Редактирование категории
			case 'edit_category':
				$forums->editCategory($tpl_dir, $_GET['id']);
				break;
				// Редактирoвание форума
			case 'edit_forum':
				$forums->editForum($tpl_dir, $_GET['id']);
				break;

			case 'mods':
				$forums->addMods($tpl_dir, $_REQUEST['id']);
				break;
				// Удаление форума
			case 'delete_forum':
				$forums->deleteForum($_GET['id']);
				header('Location:index.php?do=modules&action=modedit&mod=forums&moduleaction=1&cp=' . SESSION);
				break;

			case 'delete_topics':
				$forums->delTopics($tpl_dir);
				break;
				// Закрыть форум
			case 'closeforum':
				$forums->forumOpenClose($tpl_dir, $_GET['id'],'close');
				break;
				// Открыть форум
			case 'openforum':
				$forums->forumOpenClose($tpl_dir, $_GET['id'],'open');
				break;
				// Права
			case 'permissions':
				$forums->editPermissions($tpl_dir);
				break;
				// Удаление категории
			case 'delcategory':
				$forums->deleteCat($tpl_dir, $_GET['id']);
				break;
				// Добавление форума
			case 'addforum':
				$forums->addForum($tpl_dir, $_GET['id']);
				break;
				// Добавление категории
			case 'addcategory':
				$forums->addCategory($tpl_dir);
				break;

			case 'attachment_manager':
				$forums->attachmentManager($tpl_dir);
				break;

			case 'show_attachments':
				$forums->showAttachments($tpl_dir);
				break;

			case 'user_ranks':
				$forums->userRanks($tpl_dir);
				break;
				// Смайлы
			case 'list_smilies':
				$forums->listSmilies($tpl_dir);
				break;
				// Иконки
			case 'list_icons':
				$forums->listIcons($tpl_dir);
				break;
				// Права гпупп
			case 'group_perms':
				$forums->groupPerms($tpl_dir);
				break;
				// Импорт
			case 'import':
				$forums->import($tpl_dir);
				break;
				// Основные настройки
			case 'settings':
				$forums->settings($tpl_dir);
				break;
		}
	}
}

?>