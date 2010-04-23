<?php

/**
 * Класс работы с галереями
 *
 * @package AVE.cms
 * @subpackage module_Gallery
 * @filesource
 */
class Gallery
{

/**
 *	СВОЙСТВА
 */

	/**
	 * Количество галерей в списке
	 *
	 * @var int
	 */
	var $_categ_limit = 10;

	/**
	 * Количество изображений при просмотре в админке
	 *
	 * @var int
	 */
	var $_adminlimit_images = 10;

	/**
	 * Разрешенные типы файлов
	 *
	 * @var array
	 */
	var $_allowed = array('.jpg','jpeg','.jpe','.gif','.png','.avi','.mov','.wmv','.wmf');

	/**
	 * Количество изображений по умолчанию при выводе галереи в публичной части
	 *
	 * @var int
	 */
	var $_default_limit = 15;

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * ФУНКЦИИ ПУБЛИЧНОЙ ЧАСТИ
	 */

	/**
	 * Вывод галереи
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 * @param int $id - идентификатор галереи
	 * @param int $lim - количество изображений на странице
	 * @param int $ext - признак вывода всех изображений галереи
	 */
	function showGallery($tpl_dir, $id, $lim, $ext = 0)
	{
		global $AVE_DB, $AVE_Globals, $AVE_Template, $AVE_Core;

		$images = array();

		$sql_gs = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_gallery
			WHERE id = '" . $id . "'
		");
		$row_gs = $sql_gs->FetchRow();

		$sql = $AVE_DB->Query("
			SELECT id
			FROM " . PREFIX . "_modul_gallery_images
			WHERE gallery_id = '" . $id . "'
		");
		$num = $sql->NumRows();

		$limit = (!empty($row_gs->image_on_page) && $row_gs->image_on_page > 0) ? $row_gs->image_on_page : $this->_default_limit;

		$limit = empty($lim) ? $limit : $lim;
		$limit = ($ext != 1) ? $limit : 10000;
		$seiten = ceil($num / $limit);
		$start = prepage('apage') * $limit - $limit;

		switch ($row_gs->orderby)
		{
			case 'position':
				$orderby = "ORDER BY image_position ASC";
				break;

			case 'dateasc':
				$orderby = "ORDER BY image_date ASC";
				break;

			case 'titleasc':
				$orderby = "ORDER BY image_title ASC";
				break;

			case 'titledesc':
				$orderby = "ORDER BY image_title DESC";
				break;

			default:
				$orderby = "ORDER BY image_date DESC";
				break;
		}

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_gallery_images
			WHERE gallery_id = '" . $id . "'
			" . $orderby . "
			LIMIT " . $start . "," . $limit . "
		");
		while($row = $sql->FetchAssocArray())
		{
			$row['image_type'] = $this->_fileType($row['image_file_ext']);
			$row['image_author'] = getUserById($row['image_author']);
			$row['image_filename'] = rawurlencode($row['image_filename']);

			if (file_exists(BASE_DIR . '/modules/gallery/uploads/' . (!empty($row_gs->gallery_folder) ? $row_gs->gallery_folder . '/' : '') . 'th__' . $row['image_filename']))
			{
				$row['thumbnail'] = BASE_PATH . 'modules/gallery/uploads/'
					. (!empty($row_gs->gallery_folder) ? $row_gs->gallery_folder . '/' : '') . 'th__' . $row['image_filename'];
			}
			else
			{
				$row['thumbnail'] = BASE_PATH . 'modules/gallery/thumb.php?file=' . $row['image_filename'] . '&amp;type=' . $row['image_type']
					. '&amp;xwidth=' . $row_gs->thumb_width . (!empty($row_gs->gallery_folder) ? '&amp;folder=' . $row_gs->gallery_folder : '');
			}

			if ($row_gs->show_size == 1)
			{
				$row['image_size'] = round(filesize(BASE_DIR . '/modules/gallery/uploads/'
					. (!empty($row_gs->gallery_folder) ? $row_gs->gallery_folder . '/' : '') . $row['image_filename']) / 1024, 0);
			}

			if ($row_gs->type_out == 7)
			{
				$search = array(
					'[img_id]',
					'[img_filename]',
					'[img_thumbnail]',
					'[img_title]',
					'[img_description]',
					'[gal_id]',
					'[gal_folder]'
				);
				$replace = array(
					$row['id'],
					$row['image_filename'],
					$row['thumbnail'],
					htmlspecialchars($row['image_title']),
					htmlspecialchars($row['image_description']),
					$row_gs->id,
					(!empty($row_gs->gallery_folder) ? $row_gs->gallery_folder . '/' : '')
				);
				$row['script_out'] = str_replace($search, $replace, $row_gs->script_out);
				$row['image_tpl'] = str_replace($search, $replace, $row_gs->image_tpl);
			}

			array_push($images, $row);
		}

		// Постраничная навигация
		if ($seiten > 1)
		{
			$art_page = (isset($_REQUEST['artpage']) && $_REQUEST['artpage'] > 1) ? '&amp;artpage=' . (int)$_REQUEST['artpage'] : '';
			$template_label = " <a class=\"pnav\" href=\"index.php?id=" . $AVE_Core->curentdoc->Id
				. "&amp;doc=" . (!empty($_REQUEST['doc']) ? $_REQUEST['doc'] : $AVE_Core->curentdoc->Url)
				. $art_page . "&amp;apage={s}\">{t}</a> ";
			$page_nav = pagenav($seiten, 'apage', $template_label, $AVE_Globals->mainSettings('navi_box'));
			$page_nav = (CP_REWRITE == 1) ? cpRewrite($page_nav) : $page_nav;
			$AVE_Template->assign('page_nav', $page_nav);
		}

		if (!empty($lim) && $lim < $num)
		{
			$AVE_Template->assign('more_images', 1);
		}
		else
		{
			$AVE_Template->assign('more_images', 0);
		}

		$AVE_Template->assign('theme_folder', defined(THEME_FOLDER) ? THEME_FOLDER : DEFAULT_THEME_FOLDER);
		$AVE_Template->assign('gallery', $row_gs);
		$AVE_Template->assign('images', $images);

		if ($ext == 1)
		{
			$AVE_Template->assign('path', BASE_DIR . '/modules/gallery/templates');
			$AVE_Template->display($tpl_dir . 'gallery_popup.tpl');
		}
		else
		{
			$AVE_Template->display($tpl_dir . 'gallery.tpl');
		}
	}

	/**
	 * Вывод одиночного изображения
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 * @param int $image_id - идентификатор изображения
	 */
	function displayImage($tpl_dir, $image_id)
	{
		global $AVE_DB, $AVE_Template;

		$sql = $AVE_DB->Query("
			SELECT
				image_filename,
				image_file_ext,
				image_title,
				gallery_folder
			FROM
				" . PREFIX . "_modul_gallery_images AS img
			LEFT JOIN
				" . PREFIX . "_modul_gallery AS gal
					ON gal.id = gallery_id
			WHERE
				img.id = '" . $image_id . "'
		");
		$row = $sql->FetchRow();

		switch ($this->_fileType($row->image_file_ext))
		{
			case 'gif':
			case 'jpg':
			case 'png':
				$file_info = getimagesize(BASE_DIR . '/modules/gallery/uploads/' . (!empty($row->gallery_folder) ? $row->gallery_folder . '/' : '') . $row->image_filename);
				$AVE_Template->assign('w', ($file_info[0] < 350 ? 350 : ($file_info[0] > 950 ? 950 : $file_info[0]+10) ));
				$AVE_Template->assign('h', ($file_info[1] < 350 ? 350 : ($file_info[1] > 700 ? 700 : $file_info[1]+50) ));
				$AVE_Template->assign('scrollbars', ($file_info[0] > 950 || $file_info[1] > 700 ? 1 : '') );
				$AVE_Template->assign('image_filename', BASE_PATH . 'modules/gallery/uploads/' . (!empty($row->gallery_folder) ? $row->gallery_folder . '/' : '') . rawurlencode($row->image_filename));
				$AVE_Template->assign('image_title', $row->image_title);
				break;

			case 'video':
				$AVE_Template->assign('w', 350);
				$AVE_Template->assign('notresizable', 1);
				$AVE_Template->assign('h', 400);
				$AVE_Template->assign('image_filename', BASE_PATH . 'modules/gallery/uploads/' . (!empty($row->gallery_folder) ? $row->gallery_folder . '/' : '') . rawurlencode($row->image_filename));
				$AVE_Template->assign('mediatype', $this->_videoType($row->image_file_ext));
				break;
		}

		$AVE_Template->display($tpl_dir . 'image.tpl');
	}

	/**
	 * ФУНКЦИИ АДМИНИСТРАТИВНОЙ ЧАСТИ
	 */

	/**
	 * Просмотр изображений галереи в админке
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 * @param int $id - идентификатор галереи
	 */
	function showImages($tpl_dir, $id)
	{
		global $AVE_DB, $AVE_Template;

		$sql = $AVE_DB->Query("
			SELECT
				thumb_width,
				gallery_folder
			FROM " . PREFIX . "_modul_gallery
			WHERE id = '" . $id . "'
		");
		$row_gs = $sql->FetchRow();

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			if (isset($_POST['del']) && sizeof($_POST['del']) > 0)
			{
				foreach ($_POST['del'] as $key => $del)
				{
					@unlink(BASE_DIR . '/modules/gallery/uploads/' . (!empty($row_gs->gallery_folder) ? $row_gs->gallery_folder . '/' : '') . $_POST['datei'][$key]);
					@unlink(BASE_DIR . '/modules/gallery/uploads/'. (!empty($row_gs->gallery_folder) ? $row_gs->gallery_folder . '/' : '') . 'th__' . $_POST['datei'][$key]);
					$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_gallery_images WHERE id = '" . (int)$key . "'");
				}
			}

			foreach ($_POST['gimg'] as $image_id)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_gallery_images
					SET
						image_title = '" . $_POST['image_title'][$image_id] . "',
						image_description = '" . $_POST['image_description'][$image_id] . "',
						image_position = '" . intval($_POST['image_position'][$image_id]) . "'
					WHERE
						id = '" . (int)$image_id . "'
					AND
						gallery_id = '" . $id . "'
				");
			}
		}

		$num = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_modul_gallery_images
			WHERE gallery_id = '" . $id . "'
		")->GetCell();

		if ($num < 1)
		{
			header('Location:index.php?do=modules&action=modedit&mod=gallery&moduleaction=1&cp=' . SESSION);
			exit;
		}

		$limit = $this->_adminlimit_images;
		$seiten = ceil($num / $limit);
		$start = prepage() * $limit - $limit;

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_gallery_images
			WHERE gallery_id = '" . $id . "'
			ORDER BY id DESC
			LIMIT " . $start . "," . $limit . "
		");

		$images = array();
		while ($row = $sql->FetchAssocArray())
		{
			$row['image_type'] = $this->_fileType($row['image_file_ext']);
			$row['image_author'] = getUserById($row['image_author']);
			$row['image_size'] = @filesize(BASE_DIR . '/modules/gallery/uploads/'
				. (!empty($row_gs->gallery_folder) ? $row_gs->gallery_folder . '/' : '')
				. $row['image_filename']);
			$row['image_size'] = @round($row['image_size'] / 1024, 2);
			array_push($images, $row);
		}

		if ($seiten > 1)
		{
			$page_nav = pagenav($seiten, 'page',
				' <a class="pnav" href="index.php?do=modules&action=modedit&mod=gallery&moduleaction=showimages&id=' . $id . '&cp=' . SESSION . '&pop=1&page={s}">{t}</a> ');
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('thumb_width', $row_gs->thumb_width);
		$AVE_Template->assign('gallery_folder', $row_gs->gallery_folder);
		$AVE_Template->assign('images', $images);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_gallery_image.tpl'));
	}

	/**
	 * Загрузка изображений в галерею
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 * @param int $id - идентификатор галереи
	 */
	function uploadForm($tpl_dir, $id)
	{
		global $AVE_DB, $AVE_Template;

		$sql = $AVE_DB->Query("
			SELECT
				watermark,
				thumb_width,
				gallery_folder
			FROM " . PREFIX . "_modul_gallery
			WHERE id = '" . $id . "'
		");
		$row = $sql->FetchRow();

		$upload_dir = BASE_DIR . '/modules/gallery/uploads/' . (!empty($row->gallery_folder) ? $row->gallery_folder . '/' : '');

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$arr = array();

			if (!empty($_REQUEST['fromfolder']) && $_REQUEST['fromfolder'] == 1)
			{
				$temp_dir = BASE_DIR . '/modules/gallery/uploads/temp/';
				if (!file_exists($temp_dir))
				{
					$oldumask = umask(0);
					@mkdir($temp_dir, 0777);
					umask($oldumask);
				}

				$htaccess_file = $temp_dir . '.htaccess';
				if (!file_exists($htaccess_file))
				{
					$fp = @fopen($htaccess_file, 'w+');
					if ($fp)
					{
						fputs($fp, 'Deny from all');
						fclose($fp);
					}
				}

				if ($handle = opendir($temp_dir))
				{
					while (false !== ($file = readdir($handle)))
					{
						if ($file != '.' && $file != '..')
						{
							$image_title = substr($file, 0, -4);
							$upload_file_ext = strtolower(substr($file, -4));
							$upload_filename = cpParseLinkname($image_title) . $upload_file_ext;

							while (file_exists($upload_dir . $upload_filename))
							{
								$upload_filename = $this->_renameFile($upload_filename);
							}

							if (!empty($upload_filename) && in_array($upload_file_ext, $this->_allowed))
							{
								@copy($temp_dir . $file, $upload_dir . $upload_filename);
								@unlink($temp_dir . $file);
								@chmod($upload_dir . $upload_filename, 0777);

								if ($upload_file_ext != 'video')
								{
									$this->_rebuildImage($upload_dir, $upload_filename, $row->watermark);
								}

								$arr[] = '<img src="../modules/gallery/thumb.php?file=' . $upload_filename
									. '&xwidth=' . $row->thumb_width
									. '&type=' . $this->_fileType($upload_file_ext)
									. (!empty($row->gallery_folder) ? '&folder=' . $row->gallery_folder : '') . '" />';

								$AVE_DB->Query("
									INSERT
									INTO " . PREFIX . "_modul_gallery_images
									SET
										id = '',
										gallery_id = '" . $id . "',
										image_filename = '" . addslashes($upload_filename) . "',
										image_author = '" . (int)$_SESSION['user_id'] . "',
										image_title = '" . addslashes($image_title) . "',
										image_file_ext = '" . addslashes($upload_file_ext) . "',
										image_description = '',
										image_date = '" . time() . "'
								");
							}
						}
					}
					closedir($handle);
				}
			}

			$count_files = sizeof(@$_FILES['file']['tmp_name']);
			for ($i=0;$i<$count_files;$i++)
			{
				$upload_file_ext = strtolower(substr($_FILES['file']['name'][$i], -4));
				$upload_filename = cpParseLinkname(substr($_FILES['file']['name'][$i], 0, -4)) . $upload_file_ext;

				if (!empty($upload_filename))
				{
					while (file_exists($upload_dir . $upload_filename))
					{
						$upload_filename = $this->_renameFile($upload_filename);
					}

					if (in_array($upload_file_ext, $this->_allowed) )
					{
						move_uploaded_file($_FILES['file']['tmp_name'][$i], $upload_dir . $upload_filename);
						@chmod($upload_dir . $upload_filename, 0777);

						if ($upload_file_ext != 'video')
						{
							$this->_rebuildImage($upload_dir, $upload_filename, $row->watermark);
						}

						$arr[] = '<img src="../modules/gallery/thumb.php?file=' . $upload_filename
							. '&xwidth=' . $row->thumb_width
							. '&type=' . $this->_fileType($upload_file_ext)
							. (!empty($row->gallery_folder) ? '&folder=' . $row->gallery_folder : '') . '" />';

						$AVE_DB->Query("
							INSERT
							INTO " . PREFIX . "_modul_gallery_images
							SET
								id = '',
								gallery_id = '" . $id . "',
								image_filename = '" . addslashes($upload_filename) . "',
								image_author = '" . (int)$_SESSION['user_id'] . "',
								image_title = '" . (empty($_POST['image_title'][$i]) ? '' : $_POST['image_title'][$i]) . "',
								image_file_ext = '" . addslashes($upload_file_ext) . "',
								image_description = '" . (empty($_POST['image_description'][$i]) ? '' : $_POST['image_description'][$i]) . "',
								image_date = '" . time() . "'
						");
					}
				}
			}
			$AVE_Template->assign('arr', $arr);
			$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_gallery_upload_form_finish.tpl'));
		}
		else
		{
			if (!is_writable($upload_dir))
			{
				$AVE_Template->assign('not_writeable', 1);
				$AVE_Template->assign('upload_dir', '/modules/gallery/uploads/' . (!empty($row->gallery_folder) ? $row->gallery_folder . '/' : ''));
			}
			$AVE_Template->assign('allowed', $this->_allowed);
			$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=gallery&moduleaction=add&sub=save&id=' . (int)$_REQUEST['id'] . '&cp=' . SESSION);
			$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_gallery_upload_form.tpl'));
		}
	}

	/**
	 * Вывод списка галерей
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 */
	function showGalleries($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (!empty($_POST['create']))
		{
			foreach ($_POST['create'] as $id)
			{
				$this->_moveGalleryImage((int)$id);
			}
		}

		$num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_modul_gallery")->GetCell();

		$limit = $this->_categ_limit;
		$seiten = ceil($num / $limit);
		$start = prepage() * $limit - $limit;
		$galleries = array();

		$sql = $AVE_DB->Query("
			SELECT
				gal.*,
				COUNT(img.id) AS image_count
			FROM
				" . PREFIX . "_modul_gallery AS gal
			LEFT JOIN
				" . PREFIX . "_modul_gallery_images AS img
					ON img.gallery_id = gal.id
			GROUP BY gal.id
			ORDER BY gal.gallery_date DESC
			LIMIT " . $start . "," . $limit . "
		");
		while($row = $sql->FetchAssocArray())
		{
			$row['username'] = getUserById($row['gallery_author']);
			array_push($galleries, $row);
		}

		if ($seiten > 1)
		{
			$page_nav = pagenav($seiten, 'page',
				' <a class="pnav" href="index.php?do=modules&action=modedit&mod=gallery&moduleaction=1&cp=' . SESSION . '&page={s}">{t}</a> ');
			$AVE_Template->assign('page_nav', $page_nav);
		}

		if (!empty($_REQUEST['alert']))
		{
			$AVE_Template->assign('alert', htmlspecialchars(htmlspecialchars_decode($_REQUEST['alert'])));
		}
		$AVE_Template->assign('galleries', $galleries);
		$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=gallery&moduleaction=new&sub=save&cp=' . SESSION);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_gallery_list.tpl'));
	}

	/**
	 * Создание галереи
	 *
	 */
	function newGallery()
	{
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			global $AVE_DB;

			$cont = true;
			$alert = '';

			$gallery_title = htmlspecialchars(htmlspecialchars_decode(trim($_POST['gallery_title'])));
			if (empty($gallery_title))
			{
				$alert = '&alert=empty_gallery_title';
				$cont = false;
			}
			else
			{
				$gallery_folder = cpParseLinkname(str_replace('/', '', $_POST['gallery_folder']));

				if (!empty($gallery_folder))
				{
					$folder_exists = $AVE_DB->Query("
						SELECT COUNT(*)
						FROM " . PREFIX . "_modul_gallery
						WHERE gallery_folder = '" . $gallery_folder . "'
					")->GetCell();
					if ($folder_exists)
					{
						$alert = '&alert=folder_exists';
						$cont = false;
					}
				}
			}

			if ($cont)
			{
				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_gallery
					SET
						id = '',
						gallery_folder = '" . $gallery_folder . "',
						gallery_title = '" . $gallery_title . "',
						gallery_description = '" . $_POST['gallery_description'] . "',
						gallery_author = '" . (int)$_SESSION['user_id'] . "',
						gallery_date = '" . time() . "'
				");

				if (!empty($gallery_folder))
				{
					$oldumask = umask(0);
					@mkdir(BASE_DIR . '/modules/gallery/uploads/' . $gallery_folder . '/', 0777);
					umask($oldumask);
				}
			}

			header('Location:index.php?do=modules&action=modedit&mod=gallery&moduleaction=1&cp=' . SESSION . $alert);
			exit;
		}
	}

	/**
	 * Редактирование галереи
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 * @param int $id - идентификатор галереи
	 */
	function editGallery($tpl_dir, $id)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$gallery_folder_old = cpParseLinkname(str_replace('/', '', $_REQUEST['gallery_folder_old']));
			$gallery_folder = cpParseLinkname(str_replace('/', '', $_REQUEST['gallery_folder']));

			if (empty($_REQUEST['gallery_title']))
			{ // не указано имя галереи
				$AVE_Template->assign('empty_gallery_title', 1);
				$_REQUEST['gallery_title'] = $_REQUEST['gallery_title_old'];
			}

			if ($_REQUEST['thumb_width_old'] != $_REQUEST['thumb_width'])
			{ // изменён размер миниатюр - удаляем миниатюры
				$sql = $AVE_DB->Query("
					SELECT image_filename
					FROM " . PREFIX . "_modul_gallery_images
					WHERE gallery_id = '" . $id . "'
				");
				while ($row = $sql->FetchRow())
				{
					@unlink(BASE_DIR . '/modules/gallery/uploads/' . (!empty($gallery_folder_old) ? $gallery_folder_old . '/' : '') . 'th__' . $row->image_filename);
				}
			}

			if ($gallery_folder_old != $gallery_folder)
			{ // изменен путь к файлам галереи - перемещаем в новое место
				$this->_moveGalleryImage($id, $gallery_folder_old, $gallery_folder);
			}

			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_gallery
				SET
					gallery_title = '" . $_REQUEST['gallery_title'] . "',
					gallery_description = '" . $_REQUEST['gallery_description'] . "',
					show_size = '" . ((!empty($_REQUEST['show_size']) && is_numeric($_REQUEST['show_size'])) ? $_REQUEST['show_size'] : '') . "',
					show_description = '" . ((!empty($_REQUEST['show_description']) && is_numeric($_REQUEST['show_description'])) ? $_REQUEST['show_description'] : '') . "',
					show_title = '" . ((!empty($_REQUEST['show_title']) && is_numeric($_REQUEST['show_title'])) ? $_REQUEST['show_title'] : '') . "',
					thumb_width = '" . ((!empty($_REQUEST['thumb_width']) && is_numeric($_REQUEST['thumb_width'])) ? $_REQUEST['thumb_width'] : 120) . "',
					image_on_line = '" . ((!empty($_REQUEST['image_on_line']) && is_numeric($_REQUEST['image_on_line'])) ? $_REQUEST['image_on_line'] : 4) . "',
					image_on_page = '" . (int)$_REQUEST['image_on_page'] . "',
					type_out = '" . (int)$_REQUEST['type_out'] . "',
					watermark = '" . $_REQUEST['watermark'] . "',
					gallery_folder = '" . $gallery_folder . "',
					orderby = '" . $_REQUEST['orderby'] . "',
					script_out = '" . $_REQUEST['script_out'] . "',
					image_tpl = '" . $_REQUEST['image_tpl'] . "'
				WHERE
					id = '" . (int)$_REQUEST['id'] . "'
			");

			echo '<script>window.opener.location.reload(); window.close();</script>';
		}

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_gallery
			WHERE id = '" . $id . "'
		");
		$row = $sql->FetchAssocArray();

		$AVE_Template->assign('gallery', $row);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_gallery_edit.tpl'));
	}

	/**
	 * Удаление галереи
	 *
	 * @param int $id - идентификатор галереи
	 */
	function delGallery($id)
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT gallery_folder
			FROM " . PREFIX . "_modul_gallery
			WHERE id = '" . $id . "'
		");
		$row = $sql->FetchAssocArray();

		if (!empty($row['gallery_folder']))
		{
			if ($handle = opendir(BASE_DIR . '/modules/gallery/uploads/' . $row['gallery_folder'] . '/'))
			{
				while (false !== ($file = readdir($handle)))
				{
					if ($file != '.' && $file != '..')
					{
						@unlink(BASE_DIR . '/modules/gallery/uploads/' . $row['gallery_folder'] . '/' . $file);
					}
				}
				closedir($handle);
				rmdir(BASE_DIR . '/modules/gallery/uploads/' . $row['gallery_folder']);
			}
		}
		else
		{
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_gallery_images
				WHERE gallery_id = '" . $id . "'
			");
			while ($row = $sql->FetchRow())
			{
				@unlink(BASE_DIR . '/modules/gallery/uploads/' . $row->image_filename);
				@unlink(BASE_DIR . '/modules/gallery/uploads/th__' . $row->image_filename);
			}
		}
		$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_gallery WHERE id = '" . $id . "'");
		$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_gallery_images WHERE gallery_id = '" . $id . "'");

		header('Location:index.php?do=modules&action=modedit&mod=gallery&moduleaction=1&cp=' . SESSION);
		exit;
	}

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	/**
	 * тип видео-файла по расширению
	 *
	 * @param string $ext
	 * @return string
	 */
	function _videoType($ext)
	{
		switch($ext)
		{
			case '.avi':
			case '.wmv':
			case '.wmf':
			case '.mpg': $type = 'avi'; break;
			case '.mov': $type = 'mov'; break;
		}

		return $type;
	}

	/**
	 * тип файла по расширению
	 *
	 * @param string $ext
	 * @return string
	 */
	function _fileType($ext)
	{
		switch($ext)
		{
			case '.avi':
			case '.mov':
			case '.wmv':
			case '.wmf':
			case '.mpg': $type = 'video'; break;
			case '.jpg':
			case 'jpeg':
			case '.jpe': $type = 'jpg'; break;
			case '.png': $type = 'png'; break;
			case '.gif': $type = 'gif'; break;
		}

		return $type;
	}

	/**
	 * Формирование уникального имени файла
	 *
	 * @param string $file_name - имя файла
	 * @return string
	 */
	function _renameFile($file_name)
	{
		mt_rand();
		$pref = rand(1, 999);

		return $pref . '_' . $file_name;
	}

	/**
	 * Изменение размеров и наложение водяного знака при загрузке изображений
	 *
	 * @param string $upload_dir - путь к папке для загрузки
	 * @param string $upload_filename - имя загружаемого файла
	 * @param string $watermark_file_name - имя файла водяного знака
	 */
	function _rebuildImage($upload_dir, $upload_filename, $watermark_file_name = '')
	{
		if (!$file_info = getimagesize($upload_dir . $upload_filename))
		{
//			@unlink($upload_dir . $upload_filename);
			return;
		}
		$source_width = $file_info[0];
		$source_height = $file_info[1];

		$resize = false;

		switch($file_info[2])
		{
			case '1':
				$method = 'imagecreatefromgif';
				break;

			case '2':
				$method = 'imagecreatefromjpeg';
				break;

			case '3':
				$method = 'imagecreatefrompng';
				break;

			default:
				return;
				break;
		}

		if (!empty($_REQUEST['shrink']) && is_numeric($_REQUEST['shrink']) && $_REQUEST['shrink'] < 100)
		{
			$file_info[0] = round($file_info[0] * $_REQUEST['shrink'] / 100);
			$file_info[1] = round($file_info[1] * $_REQUEST['shrink'] / 100);

			$resize = true;
		}

		if (!empty($_REQUEST['maxsize']) && is_numeric($_REQUEST['maxsize']) && $_REQUEST['maxsize'] > 10 &&
			max(array($file_info[0], $file_info[1])) > $_REQUEST['maxsize'])
		{
				if ($file_info[0] > $file_info[1])
				{
					$file_info[1] = round($_REQUEST['maxsize'] / $file_info[0] * $file_info[1]);
					$file_info[0] = round($_REQUEST['maxsize']);
				}
				else
				{
					$file_info[0] = round($_REQUEST['maxsize'] / $file_info[1] * $file_info[0]);
					$file_info[1] = round($_REQUEST['maxsize']);
				}

				$resize = true;
		}

		// Изменяем размер
		if ($resize)
		{
			if (! $new_image = @imagecreatetruecolor($file_info[0], $file_info[1])) return;
			if (! $source_image = @$method($upload_dir . $upload_filename)) return;
			imagecopyresampled($new_image, $source_image,
				0, 0, 0, 0,
				$file_info[0], $file_info[1],
				$source_width, $source_height
			);
			@unlink($upload_dir . $upload_filename);
			switch($file_info[2])
			{
				case '1':
					@imagegif($new_image, $upload_dir . $upload_filename);
					break;

				case '2':
					@imagejpeg($new_image, $upload_dir . $upload_filename, 90);
					break;

				case '3':
					@imagepng($new_image, $upload_dir . $upload_filename, 9);
					break;
			}
			@chmod($upload_dir . $upload_filename, 0777);
			imagedestroy($new_image);
			imagedestroy($source_image);
		}

		// Добавляем водяной знак
		if (!empty($watermark_file_name))
		{
			$watermark_file = dirname(__FILE__) . '/' . $watermark_file_name;
			if (is_file($watermark_file))
			{
				$watermark_info = getimagesize($watermark_file);

				switch($watermark_info[2])
				{
					case '1':
						$watermark = @imagecreatefromgif($watermark_file);
						break;

					case '2':
						$watermark = @imagecreatefromjpeg($watermark_file);
						break;

					case '3':
						$watermark = @imagecreatefrompng($watermark_file);
						break;

					default:
						return;
						break;
				}

				$overlapX = $file_info[0] - $watermark_info[0] - 5;
				$overlapY = $file_info[1] - $watermark_info[1] - 5;

				if (min(array($overlapX, $overlapY)) < 0) {
					imagedestroy($watermark);
					return;
				}

				$source_image = $method($upload_dir . $upload_filename);
				imagecopymerge($source_image, $watermark, $overlapX, $overlapY, 0, 0, $watermark_info[0], $watermark_info[1], 70);

				unlink($upload_dir . $upload_filename);
				switch($file_info[2])
				{
					case '1':
						imagegif($source_image, $upload_dir . $upload_filename);
						break;

					case '2':
						imagejpeg($source_image, $upload_dir . $upload_filename, 90);
						break;

					case '3':
						imagepng($source_image, $upload_dir . $upload_filename, 9);
						break;
				}
				@chmod($upload_dir . $upload_filename, 0777);
				imagedestroy($source_image);
				imagedestroy($watermark);
			}
		}
	}

	/**
	 * Перемещение изображений галереи
	 *
	 * @param int $id - идентификатор галереи
	 * @param string $source_folder - директория источник
	 * @param string $destination_folder - директория назначения
	 */
	function _moveGalleryImage($id, $source_folder = '', $destination_folder = '')
	{
		global $AVE_DB;

		if (empty($source_folder) && empty($destination_folder))
		{
			$sql = $AVE_DB->Query("
				SELECT
					gallery_title,
					gallery_folder
				FROM " . PREFIX . "_modul_gallery
				WHERE id = '" . $id . "'
			");
			if ($row = $sql->FetchRow())
			{
				$source_folder = cpParseLinkname(str_replace('/', '', $row->gallery_folder));
				$destination_folder = cpParseLinkname($row->gallery_title == '' ? 'gal_' . $id : str_replace('/', '', $row->gallery_title));
			}
			else
			{
				return;
			}
		}

		$source_path = BASE_DIR . '/modules/gallery/uploads/' . (!empty($source_folder) ? $source_folder . '/' : '');
		if (!file_exists($source_path))
		{
			return;
		}

		$destination_path = BASE_DIR . '/modules/gallery/uploads/' . (!empty($destination_folder) ? $destination_folder . '/' : '');
		if (!file_exists($destination_path))
		{
			$oldumask = umask(0);
			@mkdir($destination_path, 0777);
			umask($oldumask);
		}

		if (is_writable($destination_path))
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_gallery
				SET gallery_folder = '" . addslashes($destination_folder) . "'
				WHERE id = '" . $id . "'
			");

			$sql = $AVE_DB->Query("
				SELECT image_filename
				FROM " . PREFIX . "_modul_gallery_images
				WHERE gallery_id = '" . $id . "'
			");
			while ($row = $sql->FetchRow())
			{
				@copy($source_path . $row->image_filename, $destination_path . $row->image_filename);
				@unlink($source_path . $row->image_filename);
				@unlink($source_path . 'th__' . $row->image_filename);
			}

			if ($handle = opendir($source_path))
			{
				$source_path_empty = true;
				while (false !== ($file = readdir($handle)))
				{
					if ($file != '.' && $file != '..')
					{
						$source_path_empty = false;
						break;
					}
				}
				closedir($handle);

				if ($source_path_empty)
				{
					@rmdir($source_path);
				}
			}
		}
	}
}

?>