<?php

/**
 * Класс работы с баннерами
 *
 * @package AVE.cms
 * @subpackage module_Banner
 * @since 1.4
 * @filesource
 */
class ModulBanner {

/**
 *	СВОЙСТВА
 */

	var $_limit = 15;
	var $_allowed_files =
		array(
			'image/jpg',
			'image/jpeg',
			'image/pjpeg',
			'image/x-png',
			'image/png',
			'image/gif',
			'application/x-shockwave-flash'
		);

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	function _bannerRandomGet()
	{
		return rand(1000, 99999);
	}

	function _bannerCategoryGet()
	{
		global $AVE_DB;

		$categories = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_banner_categories");
		while($row = $sql->FetchRow())
		{
			array_push($categories, $row);
		}

		return $categories;
	}

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	function bannerShow($banner_category_id)
	{
		global $AVE_DB;

		mt_rand();
		$output = '';

		$cur_hour = date('G');
		$and_time = "AND ((banner_show_start = '0' AND banner_show_end = '0') OR (banner_show_start <= '" . $cur_hour . "' AND banner_show_end > '" . $cur_hour . "') OR (banner_show_start > banner_show_end AND (banner_show_start BETWEEN banner_show_start AND '" . $cur_hour . "' OR banner_show_end BETWEEN '" . $cur_hour . "' AND banner_show_end)))";
		$and_category = is_numeric($banner_category_id) ? "AND banner_category_id = '" . $banner_category_id . "'" : '';

		$num = $AVE_DB->Query("
			SELECT 1
			FROM " . PREFIX . "_modul_banners
			WHERE banner_status = '1'
			AND (banner_max_clicks = '0' OR (banner_clicks < banner_max_clicks AND banner_max_clicks != '0'))
			AND (banner_max_views  = '0' OR (banner_views  < banner_max_views  AND banner_max_views  != '0'))
			" . $and_time . "
			" . $and_category . "
		")->NumRows();

		$zufall = ($num) ? rand(1,3) : 3;

		$sql = $AVE_DB->Query("
			SELECT
				Id,
				banner_file_name,
				banner_target,
				banner_name,
				banner_alt,
				banner_width,
				banner_height
			FROM " . PREFIX . "_modul_banners
			WHERE banner_status = '1'
			AND (banner_max_clicks = '0' OR (banner_clicks < banner_max_clicks AND banner_max_clicks != '0'))
			AND (banner_max_views  = '0' OR (banner_views  < banner_max_views  AND banner_max_views  != '0'))
			" . $and_time . "
			" . $and_category . "
			AND banner_priority <= '" . $zufall . "'
		");
		$num = $sql->NumRows();
		$banner_id = ($num == 1) ? 0 : rand(0, $num-1);
		$sql->DataSeek($banner_id);
		$banner = $sql->FetchAssocArray();

		if (!empty($banner['banner_file_name']))
		{
			if (stristr($banner['banner_file_name'], '.swf') === false)
			{
				$output = '<a target="' . $banner['banner_target'] . '" href="' . ABS_PATH . 'index.php?module=' . BANNER_DIR . '&amp;action=go&amp;id=' . $banner['Id'] . '"><img src="' . ABS_PATH . 'modules/' . BANNER_DIR . '/files/' . $banner['banner_file_name'] . '" alt="' . $banner['banner_name'] . ': ' . $banner['banner_alt'] . '" border="0" /></a>';
			}
			else
			{
				$output  = '<div style="position:relative;border:0px;width:' . $banner['banner_width'] . 'px;height:' . $banner['banner_height'] . 'px;"><a target="' . $banner['banner_target'] . '" href="' . ABS_PATH . 'index.php?module=' . BANNER_DIR . '&amp;action=go&amp;id=' . $banner['Id'] . '" style="position:absolute;z-index:2;width:' . $banner['banner_width'] . 'px;height:' . $banner['banner_height'] . 'px;_background:red;_filter:alpha(opacity=0);"></a>';
				$output .= '	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="' . $banner['banner_width'] . '" height="' . $banner['banner_height'] . '" id="reklama" align="middle">';
				$output .= '		<param name="allowScriptAccess" value="sameDomain" />';
				$output .= '		<param name="movie" value="' . ABS_PATH . 'modules/' . BANNER_DIR . '/files/' . $banner['banner_file_name'] . '" />';
				$output .= '		<param name="quality" value="high" />';
				$output .= '		<param name="wmode" value="opaque">';
				$output .= '		<embed src="' . ABS_PATH . 'modules/' . BANNER_DIR . '/files/' . $banner['banner_file_name'] . '" quality="high" wmode="opaque" width="' . $banner['banner_width'] . '" height="' . $banner['banner_height'] . '" name="reklama" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
				$output .= '	</object>';
				$output .= '</div>';
			}

			if (!empty($banner['Id']))
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_banners
					SET banner_views = banner_views + 1
					WHERE Id = '" . $banner['Id'] . "'
				");
			}
		}

		echo $output;
	}

	function bannerClickCount($banner_id)
	{
		global $AVE_DB;

		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'go')
		{
			$banner_url = $AVE_DB->Query("
				SELECT banner_url
				FROM " . PREFIX . "_modul_banners
				WHERE Id = '" . $banner_id . "'
				LIMIT 1
			")->GetCell();

			if (!empty($banner_url))
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_banners
					SET banner_clicks = banner_clicks + 1
					WHERE Id = '" . $banner_id . "'
				");

				header('Location:' . $banner_url);
				exit;
			}
		}

		header('Location:' . get_referer_link());
		exit;
	}

	function bannerList($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$limit = $this->_limit;
		$num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_modul_banners")->GetCell();

		$seiten = ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		$banners = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_banners
			LIMIT " . $start . "," . $limit
		);
		while($row = $sql->FetchRow())
		{
			array_push($banners, $row);
		}

		if($num > $limit)
		{
			$page_nav = ' <a class="pnav" href="index.php?do=modules&action=modedit&mod=' . BANNER_DIR . '&moduleaction=1&cp=' . SESSION . '&page={s}">{t}</a> ';
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('banners', $banners);
		$AVE_Template->assign('mod_path', BANNER_DIR);
		$AVE_Template->assign('categories', $this->_bannerCategoryGet());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'banners.tpl'));
	}

	function bannerNew($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		switch ($_REQUEST['sub'])
		{
			case '':
				if(!@is_writeable(BASE_DIR . '/modules/' . BANNER_DIR . '/files/')) {
					$AVE_Template->assign('folder_protected', 1);
				}
				$AVE_Template->assign('mod_path', BANNER_DIR);
				$AVE_Template->assign('categories', $this->_bannerCategoryGet());
				$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=' . BANNER_DIR . '&moduleaction=newbanner&sub=save&cp=' . SESSION . '&pop=1');
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'form.tpl'));
				break;

			case 'save':
				if (!empty($_POST['banner_name']))
				{
					$file = '';

					$d_name = strtolower($_FILES['New']['name']);
					$d_name = str_replace(' ', '', $d_name);
					$d_tmp = $_FILES['New']['tmp_name'];

					if (!empty($_FILES['New']['type']))
					{
						if (in_array($_FILES['New']['type'], $this->_allowed_files))
						{
							$d_name = preg_replace('/[^ ._a-z0-9-]/', '_', $d_name);
							if (file_exists(BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $d_name))
							{
								$d_name = $this->_bannerRandomGet() . '__' . $d_name;
							}

							if (@move_uploaded_file($d_tmp, BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $d_name))
							{
								@chmod(BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $d_name, 0777);
								echo "<script>alert('" . $AVE_Template->get_config_vars('BANNER_IS_UPLOADED') . ': ' . $d_name . "');</script>";
								reportLog($_SESSION['user_name'] . ' - добавил изображение баннера (' . $d_name . ')', 2, 2);
								$file = $d_name;
							}
							else
							{
								echo "<script>alert('" . $AVE_Template->get_config_vars('BANNER_NO_UPLOADED') . ': ' . $d_name . "');</script>";
							}
						}
						else
						{
							echo "<script>alert('" . $AVE_Template->get_config_vars('BANNER_WRONG_TYPE') . ': ' . $d_name . "');</script>";
						}
					}

					$AVE_DB->Query("
						INSERT
						INTO " . PREFIX . "_modul_banners
						SET
							banner_category_id      = '" . $_REQUEST['banner_category_id'] . "',
							banner_file_name = '" . $file . "',
							banner_url  = '" . $_REQUEST['banner_url'] . "',
							banner_priority    = '" . $_REQUEST['banner_priority'] . "',
							banner_name = '" . $_REQUEST['banner_name'] . "',
							banner_alt    = '" . $_REQUEST['banner_alt'] . "',
							banner_max_clicks  = '" . $_REQUEST['banner_max_clicks'] . "',
							banner_max_views   = '" . $_REQUEST['banner_max_views'] . "',
							banner_show_start     = '" . $_REQUEST['banner_show_start'] . "',
							banner_show_end      = '" . $_REQUEST['banner_show_end'] . "',
							banner_status      = '" . $_REQUEST['banner_status'] . "',
							banner_target     = '" . $_REQUEST['banner_target'] . "',
							banner_width      = '" . $_REQUEST['banner_width'] . "',
							banner_height     = '" . $_REQUEST['banner_height'] . "'
					");

					reportLog($_SESSION['user_name'] . ' - добавил новый баннер (' . stripslashes($_REQUEST['banner_name']) . ')', 2, 2);
				}

				echo '<script>window.opener.location.reload(); self.close();</script>';
				break;
		}
	}

	function bannerEdit($tpl_dir, $banner_id)
	{
		global $AVE_DB, $AVE_Template;

		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_banners
			WHERE Id = '" . $banner_id . "'
		")->FetchRow();

		$row->swf = (stristr(($row->banner_file_name),'.swf') === false) ? false : true;

		if (@!is_writeable(BASE_DIR . '/modules/' . BANNER_DIR . '/files/'))
		{
			$AVE_Template->assign('folder_protected', 1);
		}

		$AVE_Template->assign('item', $row);
		$AVE_Template->assign('mod_path', BANNER_DIR);
		$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=' . BANNER_DIR . '&moduleaction=quicksave&cp=' . SESSION . '&id=' . $_REQUEST['id'] . '&pop=1');
		$AVE_Template->assign('categories', $this->_bannerCategoryGet());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'form.tpl'));
	}

	function bannerSave($banner_id)
	{
		global $AVE_DB, $AVE_Template;

		if (!empty($_POST['del']))
		{
			$row = $AVE_DB->Query("
				SELECT banner_file_name
				FROM " . PREFIX . "_modul_banners
				WHERE Id = '" . $banner_id . "'
			")->FetchRow();

			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_banners
				SET banner_file_name = ''
				WHERE Id = '" . $banner_id . "'
			");

			@unlink(BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $row->banner_file_name);
		}

		if (!empty($_POST['banner_name']))
		{
			$d_name = strtolower($_FILES['New']['name']);
			$d_name = str_replace(' ','', $d_name);
			$d_tmp = $_FILES['New']['tmp_name'];

			if (!empty($_FILES['New']['type']))
			{
				if (in_array($_FILES['New']['type'], $this->_allowed_files))
				{
					$d_name = preg_replace('/[^ ._a-z0-9-]/', '_', $d_name);
					if (file_exists(BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $d_name))
					{
						$d_name = $this->_bannerRandomGet() . '__' . $d_name;
					}

					if (@move_uploaded_file($d_tmp, BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $d_name))
					{
						@chmod(BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $d_name, 0777);
						echo "<script>alert('" . $AVE_Template->get_config_vars('BANNER_IS_UPLOADED') . ': ' . $d_name . "');</script>";

						$AVE_DB->Query("
							UPDATE " . PREFIX . "_modul_banners
							SET banner_file_name = '" . $d_name . "'
							WHERE Id = '" . $banner_id . "'
						");

						reportLog($_SESSION['user_name'] . ' - заменил изображение баннера на (' . $d_name . ')', 2, 2);
					}
					else
					{
						echo "<script>alert('" . $AVE_Template->get_config_vars('BANNER_NO_UPLOADED') . ': ' . $d_name . "');</script>";
					}
				}
				else
				{
					echo "<script>alert('" . $AVE_Template->get_config_vars('BANNER_WRONG_TYPE') . ': ' . $d_name . "');</script>";
				}
			}

			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_banners
				SET
					banner_name        = '" . $_REQUEST['banner_name'] . "',
					banner_url         = '" . $_REQUEST['banner_url'] . "',
					banner_priority    = '" . $_REQUEST['banner_priority'] . "',
					banner_views       = '" . $_REQUEST['Anzeigen'] . "',
					banner_clicks      = '" . $_REQUEST['banner_clicks'] . "',
					banner_alt         = '" . $_REQUEST['banner_alt'] . "',
					banner_category_id = '" . $_REQUEST['banner_category_id'] . "',
					banner_max_clicks  = '" . $_REQUEST['banner_max_clicks'] . "',
					banner_max_views   = '" . $_REQUEST['banner_max_views'] . "',
					banner_show_start  = '" . $_REQUEST['banner_show_start'] . "',
					banner_show_end    = '" . $_REQUEST['banner_show_end'] . "',
					banner_status      = '" . $_REQUEST['banner_status'] . "',
					banner_target      = '" . $_REQUEST['banner_target'] . "',
					banner_width       = '" . $_REQUEST['banner_width'] . "',
					banner_height      = '" . $_REQUEST['banner_height'] . "'
				WHERE
					Id = '" . $banner_id . "'
			");

			reportLog($_SESSION['user_name'] . ' - изменил параметры баннера (' . stripslashes($_REQUEST['banner_name']) . ')', 2, 2);
		}

		echo '<script>window.opener.location.reload(); self.close();</script>';
	}

	function bannerDelete($banner_id)
	{
		global $AVE_DB;

		$row = $AVE_DB->Query("
			SELECT
				banner_file_name,
				banner_name
			FROM " . PREFIX . "_modul_banners
			WHERE Id = '" . $banner_id . "'
		")->FetchRow();

		@unlink(BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $row->banner_file_name);

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_banners
			WHERE Id = '" . $banner_id . "'
		");

		reportLog($_SESSION['user_name'] . ' - удалил баннер (' . $row->banner_name . ')', 2, 2);

		header('Location:index.php?do=modules&action=modedit&mod=' . BANNER_DIR . '&moduleaction=1&cp=' . SESSION);
		exit;
	}

	function bannerCategory($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		switch ($_REQUEST['sub'])
		{
			case '' :
				$AVE_Template->assign('mod_path', BANNER_DIR);
				$AVE_Template->assign('categories', $this->_bannerCategoryGet());
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'kategs.tpl'));
				break;

			case 'save' :
				foreach ($_POST['banner_category_name'] as $banner_category_id => $banner_category_name)
				{
					if (!empty($banner_category_name))
					{
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_modul_banner_categories
							SET banner_category_name = '" . $banner_category_name . "'
							WHERE Id = '" . $banner_category_id . "'
						");
					}
				}

				foreach ($_POST['del'] as $banner_category_id => $del)
				{
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_modul_banners
						WHERE banner_category_id = '" . $banner_category_id . "'
					");
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_modul_banner_categories
						WHERE Id = '" . $banner_category_id . "'
					");

					reportLog($_SESSION['user_name'] . ' - удалил категорию баннеров (' . $banner_category_id . ')', 2, 2);
				}

				header('Location:index.php?do=modules&action=modedit&mod=' . BANNER_DIR . '&moduleaction=category&cp=' . SESSION);
				exit;

			case 'new' :
				if (!empty($_REQUEST['banner_category_name']))
				{
					$sql = $AVE_DB->Query("
						INSERT
						INTO " . PREFIX . "_modul_banner_categories
						SET banner_category_name = '" . $_REQUEST['banner_category_name'] . "'
					");

					reportLog($_SESSION['user_name'] . ' - добавил новую категорию (' . stripslashes($_REQUEST['banner_category_name']) . ')', 2, 2);
				}

				header('Location:index.php?do=modules&action=modedit&mod=' . BANNER_DIR . '&moduleaction=category&cp=' . SESSION);
				exit;
		}
	}
}
?>