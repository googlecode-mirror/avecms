<?php

/**
 * Класс работы с баннерами
 *
 * @package AVE.cms
 * @subpackage module_Banner
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
 *	ВНЕШНИЕ МЕТОДЫ
 */

	function displayBanner($id) {
		global $AVE_DB;

		mt_rand();
		$zufall = rand(1,3);
		$num = '';
		$banner_id = '';
		$output = '';

		$zeitspanne = "AND (((`ZStart` <= '" . date('H') . "' AND `ZEnde` > '" . date('H') . "') OR (`ZStart` = 0 AND `ZEnde` = 0)) OR ((`ZStart` > `ZEnde`) AND ((`ZStart` BETWEEN  `ZStart` AND '" . date('H') . "') OR (`ZEnde` BETWEEN '" . date('H') . "' AND `ZEnde`))))";

		$and_kat = (!empty($id) && is_numeric($id)) ? " AND `KatId` = '" . $id . "'" : '';

		$sql = $AVE_DB->Query("
			SELECT `Id`
			FROM `" . PREFIX . "_modul_banners`
			WHERE `Aktiv` = 1
			" . $zeitspanne . "
			AND (((`MaxKlicks` = 0) OR (`Klicks` < `MaxKlicks` AND `MaxKlicks` != 0)) AND ((`MaxViews` = 0) OR (`Views` < `MaxViews` AND `MaxViews` != 0)))
			" . $and_kat . "
		");
		$num = $sql->NumRows();

		if($num <= 1) {
			$zufall = 4;
		}

		$sql = $AVE_DB->Query("
			SELECT *
			FROM `" . PREFIX . "_modul_banners`
			WHERE `Aktiv` = 1
			" . $zeitspanne . "
			AND `Gewicht` <= '" . $zufall . "'
			AND (((`MaxKlicks` = 0) OR (`Klicks` < `MaxKlicks` AND `MaxKlicks` != 0)) AND ((`MaxViews` = 0) OR (`Views` < `MaxViews` AND `MaxViews` != 0)))
			" . $and_kat . "
		");
		$num = $sql->NumRows();

		$banner_id = ($num == 1) ? 0 : rand(0, $num-1);

		$sql->DataSeek($banner_id);
		$banner = $sql->FetchArray();

		if(!empty($banner['Bannertags'])) {
			if (stristr($banner['Bannertags'], '.swf') === false) {
				$output = '<a target="' . $banner['Target'] . '" href="index.php?module=' . BANNER_DIR . '&amp;id=' . $banner['Id'] . '"><img src="modules/' . BANNER_DIR . '/files/' . $banner['Bannertags'] . '" alt="' . $banner['Bannername'] . ': ' . $banner['BildAlt'] . '" border="0" /></a>';
			}
			else {
				$output  = '<div style="position:relative;border:0px;width:' . $banner['Width'] . 'px;height:' . $banner['Height'] . 'px;"><a target="' . $banner['Target'] . '" href="index.php?module=' . BANNER_DIR . '&amp;id=' . $banner['Id'] . '" style="position:absolute;z-index:2;width:' . $banner['Width'] . 'px;height:' . $banner['Height'] . 'px;_background:red;_filter:alpha(opacity=0);"></a>';
				$output .= '	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="' . $banner['Width'] . '" height="' . $banner['Height'] . '" id="reklama" align="middle">';
				$output .= '		<param name="allowScriptAccess" value="sameDomain" />';
				$output .= '		<param name="movie" value="modules/' . BANNER_DIR . '/files/' . $banner['Bannertags'] . '" />';
				$output .= '		<param name="quality" value="high" />';
				$output .= '		<param name="wmode" value="opaque">';
				$output .= '		<embed src="modules/' . BANNER_DIR . '/files/' . $banner['Bannertags'] . '" quality="high" wmode="opaque" width="' . $banner['Width'] . '" height="' . $banner['Height'] . '" name="reklama" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
				$output .= '	</object>';
				$output .= '</div>';
			}

			if(!empty($banner['Id'])) {
				$AVE_DB->Query("
					UPDATE `" . PREFIX . "_modul_banners`
					SET `Views` = `Views` + 1
					WHERE `Id` = '" . $banner['Id'] . "'
				");
			}
		}

		echo $output;
	}

	function fetch_addclick($id) {
		global $AVE_DB;

		switch($_REQUEST['action']) {
			case '':
			case 'addclick':
				$sql = $AVE_DB->Query("
					SELECT `BannerUrl`
					FROM `" . PREFIX . "_modul_banners`
					WHERE `Id` = '" . $id . "'
					LIMIT 1
				");
				$banner_url = $sql->GetCell();
				if(!empty($banner_url)) {
					$AVE_DB->Query("
						UPDATE `" . PREFIX . "_modul_banners`
						SET `Klicks` = `Klicks` + 1
						WHERE `Id` = '" . $id . "'
					");
					header('Location:' . $banner_url);
				}

				exit;
				break;
		}
	}

	function showBanner($tpl_dir) {
		global $AVE_DB, $AVE_Template;

		$limit = $this->_limit;
		$sql = $AVE_DB->Query("SELECT `Id` FROM `" . PREFIX . "_modul_banners`");
		$num = $sql->NumRows();

		$seiten = ceil($num / $limit);
		$start = prepage() * $limit - $limit;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM `" . PREFIX . "_modul_banners`
			LIMIT " . $start . "," . $limit
		);
		while($row = $sql->FetchRow()) {
			array_push($items, $row);
		}

		if($num > $limit) {
			$page_nav = pagenav($seiten, 'page',
				' <a class="pnav" href="index.php?do=modules&action=modedit&mod=' . BANNER_DIR . '&moduleaction=1&cp=' . SESSION . '&page={s}">{t}</a> ');
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('mod_path', BANNER_DIR);
		$AVE_Template->assign('kategs', $this->_showKategs());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'banners.tpl'));
	}

	function editBanner($tpl_dir,$id) {
		global $AVE_DB, $AVE_Template;

		$sql = $AVE_DB->Query("
			SELECT *
			FROM `" . PREFIX . "_modul_banners`
			WHERE `Id` = '" . $id . "'
		");
		$row = $sql->FetchRow();

		if (stristr(($row->Bannertags),'.swf') === false) $row->swf = false; else $row->swf = true;

		if(@!is_writeable(BASE_DIR . '/modules/' . BANNER_DIR . '/files/')) {
			$AVE_Template->assign('folder_protected', 1);
		}

		$AVE_Template->assign('item', $row);
		$AVE_Template->assign('mod_path', BANNER_DIR);
		$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=' . BANNER_DIR . '&moduleaction=quicksave&cp=' . SESSION . '&id=' . $_REQUEST['id'] . '&pop=1');
		$AVE_Template->assign('kategs', $this->_showKategs());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'form.tpl'));
	}

	function deleteBanner($id) {
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT
				`Bannertags`,
				`Bannername`
			FROM `" . PREFIX . "_modul_banners`
			WHERE `Id` = '" . $id . "'
		");
		$row = $sql->FetchRow();

		@unlink(BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $row->Bannertags);
		$AVE_DB->Query("
			DELETE
			FROM `" . PREFIX . "_modul_banners`
			WHERE `Id` = '" . $id . "'
		");

		reportLog($_SESSION['user_name'] . ' - удалил баннер (' . $row->Bannername . ')', 2, 2);

		header('Location:index.php?do=modules&action=modedit&mod=' . BANNER_DIR . '&moduleaction=1&cp=' . SESSION);
		exit;
	}

	function quickSave($id) {
		global $AVE_DB, $config_vars;

		if(!empty($_POST['del'])) {
			$sql = $AVE_DB->Query("
				SELECT `Bannertags`
				FROM `" . PREFIX . "_modul_banners`
				WHERE `Id` = '" . $id . "'
			");
			$row = $sql->FetchRow();

			$AVE_DB->Query("
				UPDATE `" . PREFIX . "_modul_banners`
				SET `Bannertags` = ''
				WHERE `Id` = '" . $id . "'
			");

			@unlink(BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $row->Bannertags);
		}

		if(!empty($_POST['Bannername'])) {
			$d_name = strtolower($_FILES['New']['name']);
			$d_name = str_replace(' ','', $d_name);
			$d_tmp = $_FILES['New']['tmp_name'];

			if(!empty($_FILES['New']['type'])) {
				if(in_array($_FILES['New']['type'], $this->_allowed_files)) {
					$d_name = ereg_replace('([^ ._a-z0-9-])', '_', $d_name);
					if(file_exists(BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $d_name)) $d_name = $this->_Zufall() . '__' . $d_name;

					if(@move_uploaded_file($d_tmp, BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $d_name)) {
						@chmod(BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $d_name, 0777);
						echo "<script>alert('" . $config_vars['BANNER_IS_UPLOADED'] . ': ' . $d_name . "');</script>";

						$AVE_DB->Query("
							UPDATE `" . PREFIX . "_modul_banners`
							SET `Bannertags` = '" . $d_name . "'
							WHERE `Id` = '" . $id . "'
						");

						reportLog($_SESSION['user_name'] . ' - заменил изображение баннера на (' . $d_name . ')', 2, 2);

					} else {
						echo "<script>alert('" . $config_vars['BANNER_NO_UPLOADED'] . ': ' . $d_name . "');</script>";
					}

				} else {
					echo "<script>alert('" . $config_vars['BANNER_WRONG_TYPE'] . ': ' . $d_name . "');</script>";
				}
			}

			$AVE_DB->Query("
				UPDATE `" . PREFIX . "_modul_banners`
				SET
					`Bannername` = '" . $_REQUEST['Bannername'] . "',
					`BannerUrl`  = '" . $_REQUEST['BannerUrl'] . "',
					`Gewicht`    = '" . $_REQUEST['Gewicht'] . "',
					`Views`      = '" . $_REQUEST['Anzeigen'] . "',
					`Klicks`     = '" . $_REQUEST['Klicks'] . "',
					`BildAlt`    = '" . $_REQUEST['BildAlt'] . "',
					`KatId`      = '" . $_REQUEST['KatId'] . "',
					`MaxKlicks`  = '" . $_REQUEST['MaxKlicks'] . "',
					`MaxViews`   = '" . $_REQUEST['MaxViews'] . "',
					`ZStart`     = '" . $_REQUEST['ZStart'] . "',
					`ZEnde`      = '" . $_REQUEST['ZEnde'] . "',
					`Aktiv`      = '" . $_REQUEST['Aktiv'] . "',
					`Target`     = '" . $_REQUEST['Target'] . "',
					`Width`      = '" . $_REQUEST['Width'] . "',
					`Height`     = '" . $_REQUEST['Height'] . "'
				WHERE
					`Id` = '" . $id . "'
			");
			reportLog($_SESSION['user_name'] . ' - изменил параметры баннера (' . $_REQUEST['Bannername'] . ')', 2, 2);
		}

		echo '<script>window.opener.location.reload(); self.close();</script>';
	}

	function newBanner($tpl_dir) {
		global $AVE_DB, $AVE_Template, $config_vars;

		switch($_REQUEST['sub']) {
			case '':
				if(!@is_writeable(BASE_DIR . '/modules/' . BANNER_DIR . '/files/')) {
					$AVE_Template->assign('folder_protected', 1);
				}
				$AVE_Template->assign('mod_path', BANNER_DIR);
				$AVE_Template->assign('kategs', $this->_showKategs());
				$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=' . BANNER_DIR . '&moduleaction=newbanner&sub=save&cp=' . SESSION . '&pop=1');
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'form.tpl'));
				break;

			case 'save':
				if(!empty($_POST['Bannername'])) {
					$file = '';

					$d_name = strtolower($_FILES['New']['name']);
					$d_name = str_replace(' ', '', $d_name);
					$d_tmp = $_FILES['New']['tmp_name'];

					if(!empty($_FILES['New']['type'])) {
						if(in_array($_FILES['New']['type'], $this->_allowed_files)) {
							$d_name = ereg_replace('([^ ._a-z0-9-])', '_', $d_name);
							if(file_exists(BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $d_name)) $d_name = $this->_Zufall() . '__' . $d_name;

							if(@move_uploaded_file($d_tmp, BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $d_name)) {
								@chmod(BASE_DIR . '/modules/' . BANNER_DIR . '/files/' . $d_name, 0777);
								echo "<script>alert('" . $config_vars['BANNER_IS_UPLOADED'] . ': ' . $d_name . "');</script>";
								reportLog($_SESSION['user_name'] . ' - добавил изображение баннера (' . $d_name . ')', 2, 2);
								$file = $d_name;
							} else {
								echo "<script>alert('" . $config_vars['BANNER_NO_UPLOADED'] . ': ' . $d_name . "');</script>";
							}
						} else {
							echo "<script>alert('" . $config_vars['BANNER_WRONG_TYPE'] . ': ' . $d_name . "');</script>";
						}
					}

					$AVE_DB->Query("
						INSERT
						INTO `" . PREFIX . "_modul_banners`
						SET
							`KatId`      = '" . $_REQUEST['KatId'] . "',
							`Bannertags` = '" . $file . "',
							`BannerUrl`  = '" . $_REQUEST['BannerUrl'] . "',
							`Gewicht`    = '" . $_REQUEST['Gewicht'] . "',
							`Bannername` = '" . $_REQUEST['Bannername'] . "',
							`BildAlt`    = '" . $_REQUEST['BildAlt'] . "',
							`MaxKlicks`  = '" . $_REQUEST['MaxKlicks'] . "',
							`MaxViews`   = '" . $_REQUEST['MaxViews'] . "',
							`ZStart`     = '" . $_REQUEST['ZStart'] . "',
							`ZEnde`      = '" . $_REQUEST['ZEnde'] . "',
							`Aktiv`      = '" . $_REQUEST['Aktiv'] . "',
							`Target`     = '" . $_REQUEST['Target'] . "',
							`Width`      = '" . $_REQUEST['Width'] . "',
							`Height`     = '" . $_REQUEST['Height'] . "'
					");

					reportLog($_SESSION['user_name'] . ' - добавил новый баннер (' . $_REQUEST['Bannername'] . ')', 2, 2);
				}
				echo '<script>window.opener.location.reload(); self.close();</script>';
				break;
		}
	}

	function bannerKategs($tpl_dir) {
		global $AVE_DB, $AVE_Template;

		switch($_REQUEST['sub']) {
			case '' :
				$items = array();
				$sql = $AVE_DB->Query("SELECT * FROM `" . PREFIX . "_modul_banner_categories`");
				while($row = $sql->FetchRow()) {
					array_push($items, $row);
				}
				$AVE_Template->assign('items', $items);
				$AVE_Template->assign('mod_path', BANNER_DIR);
				$AVE_Template->assign('kategs', $this->_showKategs());
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'kategs.tpl'));
				break;

			case 'save' :
				foreach($_POST['KatName'] as $id => $kateg) {
					if(!empty($kateg)) {
						$AVE_DB->Query("
							UPDATE `" . PREFIX . "_modul_banner_categories`
							SET `KatName` = '" . $kateg . "'
							WHERE `Id` = '" . $id . "'
						");
					}
				}

				foreach($_POST['del'] as $id => $kateg) {
					$AVE_DB->Query("
						DELETE
						FROM `" . PREFIX . "_modul_banners`
						WHERE `KatId` = '" . $id . "'
					");
					$AVE_DB->Query("
						DELETE
						FROM `" . PREFIX . "_modul_banner_categories`
						WHERE `Id` = '" . $id . "'
					");

					reportLog($_SESSION['user_name'] . ' - удалил категорию баннеров (' . $id . ')', 2, 2);
				}

				header('Location:index.php?do=modules&action=modedit&mod=' . BANNER_DIR . '&moduleaction=kategs&cp=' . SESSION);
				break;

			case 'new' :
				if(!empty($_REQUEST['KatName'])) {
					$sql = $AVE_DB->Query("
						INSERT
						INTO `" . PREFIX . "_modul_banner_categories`
						SET `KatName` = '" . $_REQUEST['KatName'] . "'
					");

					reportLog($_SESSION['user_name'] . ' - добавил новую категорию (' . $_REQUEST['KatName'] . ')', 2, 2);
				}

				header('Location:index.php?do=modules&action=modedit&mod=' . BANNER_DIR . '&moduleaction=kategs&cp=' . SESSION);
				break;
		}
	}

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	function _Zufall() {
		$zufall = rand(1000, 99999);
		return $zufall;
	}

	function _showKategs() {
		global $AVE_DB;

		$kategs = array();
		$sql = $AVE_DB->Query("SELECT * FROM `" . PREFIX . "_modul_banner_categories`");
		while($row = $sql->FetchRow()) {
			array_push($kategs, $row);
		}

		return $kategs;
	}
}
?>