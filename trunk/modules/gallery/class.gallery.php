<?php

/**
 * Класс работы с галереями
 *
 * @package AVE.cms
 * @subpackage module_Gallery
 * @since 1.4
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
	var $_limit_galleries = 10;

	/**
	 * Количество изображений при просмотре в админке
	 *
	 * @var int
	 */
	var $_admin_limit_images = 10;

	/**
	 * Количество изображений по умолчанию при выводе галереи в публичной части
	 *
	 * @var int
	 */
	var $_default_limit_images = 15;

	/**
	 * Разрешенные типы файлов
	 *
	 * @var array
	 */
	var $_allowed_type = array('.jpg','jpeg','.jpe','.gif','.png','.avi','.mov','.wmv','.wmf');

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
	 * @param int $gallery_id - идентификатор галереи
	 * @param int $lim - количество изображений на странице
	 * @param int $ext - признак вывода всех изображений галереи
	 */
	function galleryShow($tpl_dir, $gallery_id, $lim, $ext = 0)
	{
		global $AVE_DB, $AVE_Template, $AVE_Core;

		$assign = $images = array();

		$row_gs = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_gallery
			WHERE id = '" . $gallery_id . "'
		")->FetchRow();

		$limit = ($row_gs->gallery_image_on_page > 0)
			? $row_gs->gallery_image_on_page
			: $this->_default_limit_images;
		$limit = empty($lim) ? $limit : $lim;
		$limit = ($ext != 1) ? $limit : 10000;
		$start = get_current_page() * $limit - $limit;

		switch ($row_gs->gallery_orderby)
		{
			case 'position':  $order_by = "image_position ASC"; break;
			case 'titleasc':  $order_by = "image_title ASC";    break;
			case 'titledesc': $order_by = "image_title DESC";   break;
			case 'dateasc':   $order_by = "image_date ASC";     break;
			default:          $order_by = "image_date DESC";    break;
		}

		$num = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_modul_gallery_images
			WHERE gallery_id = '" . $gallery_id . "'
		")->GetCell();

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_gallery_images
			WHERE gallery_id = '" . $gallery_id . "'
			ORDER BY " . $order_by . "
			LIMIT " . $start . "," . $limit . "
		");

//		$num = $AVE_DB->Query("SELECT FOUND_ROWS()")->GetCell();

		$folder = rtrim('modules/gallery/uploads/' . $row_gs->gallery_folder, '/') . '/';

		while($row = $sql->FetchAssocArray())
		{
			$row['image_type'] = $this->_galleryFileTypeGet($row['image_file_ext']);
			$row['image_author'] = get_username_by_id($row['image_author_id']);
			$row['image_filename'] = rawurlencode($row['image_filename']);

			if (file_exists(BASE_DIR . '/' . $folder . 'th__' . $row['image_filename']))
			{
				$row['thumbnail'] = ABS_PATH . $folder . 'th__' . $row['image_filename'];
			}
			else
			{
				$row['thumbnail'] = sprintf(
					"%smodules/gallery/thumb.php?file=%s&amp;type=%s&amp;xwidth=%u&amp;folder=%s",
					ABS_PATH,
					$row['image_filename'],
					$row['image_type'],
					$row_gs->gallery_thumb_width,
					$row_gs->gallery_folder
				);
			}

			if ($row_gs->gallery_image_size_show == 1)
			{
				$fs = filesize(BASE_DIR . '/' . $folder . $row['image_filename']);
				$row['image_size'] = round($fs / 1024, 0);
			}

			if ($row_gs->gallery_type == 7)
			{
				$search = array(
					'[tag:img:id]',
					'[tag:img:filename]',
					'[tag:img:thumbnail]',
					'[tag:img:title]',
					'[tag:img:description]',
					'[tag:gal:id]',
					'[tag:gal:folder]'
				);
				$replace = array(
					$row['id'],
					$row['image_filename'],
					$row['thumbnail'],
					htmlspecialchars(empty($row['image_title'])? $AVE_Template->get_config_vars('NoTitle') : $row['image_title'], ENT_QUOTES),
					htmlspecialchars(empty($row['image_description']) ? $AVE_Template->get_config_vars('NoDescr') : $row['image_description'], ENT_QUOTES),
					$row_gs->id,
					ltrim($row_gs->gallery_folder . '/', '/')
				);
				$row['gallery_script'] = str_replace($search, $replace, $row_gs->gallery_script);
				$row['gallery_image_template'] = str_replace($search, $replace, $row_gs->gallery_image_template);
			}

			array_push($images, $row);
		}

		// Постраничная навигация
		if ($num > $limit)
		{
			$page_nav = ' <a class="pnav" href="index.php?id=' . $AVE_Core->curentdoc->Id
				. '&amp;doc=' . (empty($AVE_Core->curentdoc->document_alias) ? prepare_url($AVE_Core->curentdoc->document_title) : $AVE_Core->curentdoc->document_alias)
				. ((isset($_REQUEST['artpage']) && is_numeric($_REQUEST['artpage'])) ? '&amp;artpage=' . $_REQUEST['artpage'] : '')
				. ((isset($_REQUEST['apage']) && is_numeric($_REQUEST['apage'])) ? '&amp;apage=' . $_REQUEST['apage'] : '')
				. '&amp;page={s}'
				. '">{t}</a> ';
			$page_nav = get_pagination(ceil($num / $limit), 'page', $page_nav, get_settings('navi_box'));
			$assign['page_nav'] = rewrite_link($page_nav);
		}

		$assign['more_images'] = intval(!empty($lim) && $num > $lim);
		$assign['gallery'] = $row_gs;
		$assign['images'] = $images;

		$AVE_Template->assign($assign);
		$AVE_Template->display($tpl_dir . ($ext == 1 ? 'gallery_popup.tpl' : 'gallery.tpl'));
	}

	/**
	 * Вывод одиночного изображения
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 * @param int $image_id - идентификатор изображения
	 */
	function galleryImageShow($tpl_dir, $image_id)
	{
		global $AVE_DB, $AVE_Template;

		$row = $AVE_DB->Query("
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
		")->FetchRow();

		$file_name = rtrim(BASE_DIR . '/modules/gallery/uploads/' . $row->gallery_folder, '/') . '/' . $row->image_filename;
		$image_filename = rtrim(ABS_PATH . 'modules/gallery/uploads/' . $row->gallery_folder, '/') . '/' . $row->image_filename;

		switch ($this->_galleryFileTypeGet($row->image_file_ext))
		{
			case 'gif':
			case 'jpg':
			case 'png':
				list($width, $height) = getimagesize($file_name);
				$AVE_Template->assign('w', ($width < 10 ? 10 : ($width > 800 ? 800 : $width+10)));
				$AVE_Template->assign('h', ($height < 10 ? 10 : ($height > 600 ? 600 : $height+50)));
				$AVE_Template->assign('scrollbars', ($width > 800 || $height > 600 ? 1 : '') );
				$AVE_Template->assign('image_filename', $image_filename);
				$AVE_Template->assign('image_title', $row->image_title);
				break;

			case 'video':
				$AVE_Template->assign('w', 350);
				$AVE_Template->assign('notresizable', 1);
				$AVE_Template->assign('h', 400);
				$AVE_Template->assign('image_filename', $image_filename);
				$AVE_Template->assign('mediatype', $this->_galleryMediaTypeGet($row->image_file_ext));
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
	 * @param int $gallery_id - идентификатор галереи
	 */
	function galleryImageListShow($tpl_dir, $gallery_id)
	{
		global $AVE_DB, $AVE_Template;

		$row_gs = $AVE_DB->Query("
			SELECT
				gallery_thumb_width,
				gallery_folder
			FROM " . PREFIX . "_modul_gallery
			WHERE id = '" . $gallery_id . "'
		")->FetchRow();

		$folder = rtrim(BASE_DIR . '/modules/gallery/uploads/' . $row_gs->gallery_folder, '/') . '/';

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			if (isset($_POST['del']) && sizeof($_POST['del']) > 0)
			{

				while (list($image_id) = each($_POST['del']))
				{
					@unlink($folder . $_POST['datei'][$image_id]);
					@unlink($folder . 'th__' . $_POST['datei'][$image_id]);

					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_modul_gallery_images
						WHERE id = '" . (int)$image_id . "'
					");
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
						gallery_id = '" . $gallery_id . "'
				");
			}
		}

		$limit = $this->_admin_limit_images;
		$start = get_current_page() * $limit - $limit;

		$sql = $AVE_DB->Query("
			SELECT SQL_CALC_FOUND_ROWS *
			FROM " . PREFIX . "_modul_gallery_images
			WHERE gallery_id = '" . $gallery_id . "'
			ORDER BY id DESC
			LIMIT " . $start . "," . $limit . "
		");

		$num = $AVE_DB->Query("SELECT FOUND_ROWS()")->GetCell();

		if (!$num)
		{
			header('Location:index.php?do=modules&action=modedit&mod=gallery&moduleaction=1&cp=' . SESSION);
			exit;
		}

		$images = array();
		while ($row = $sql->FetchAssocArray())
		{
			$row['image_type'] = $this->_galleryFileTypeGet($row['image_file_ext']);
			$row['image_author'] = get_username_by_id($row['image_author_id']);
			$row['image_size'] = @filesize($folder . $row['image_filename']);
			$row['image_size'] = @round($row['image_size'] / 1024, 2);
			array_push($images, $row);
		}

		if ($num > $limit)
		{
			$page_nav = ' <a class="pnav" href="index.php?do=modules&action=modedit&mod=gallery&moduleaction=showimages&cp=' . SESSION
				. '&id=' . $gallery_id . '&pop=1&page={s}">{t}</a> ';
			$page_nav = get_pagination(ceil($num / $limit), 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('gallery_thumb_width', $row_gs->gallery_thumb_width);
		$AVE_Template->assign('gallery_folder', $row_gs->gallery_folder);
		$AVE_Template->assign('images', $images);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_gallery_image.tpl'));
	}

	/**
	 * Загрузка изображений в галерею
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 * @param int $gallery_id - идентификатор галереи
	 */
	function galleryImageUploadForm($tpl_dir, $gallery_id)
	{
		global $AVE_DB, $AVE_Template;

		$sql = $AVE_DB->Query("
			SELECT
				gallery_watermark,
				gallery_thumb_width,
				gallery_folder
			FROM " . PREFIX . "_modul_gallery
			WHERE id = '" . $gallery_id . "'
		");
		$row = $sql->FetchRow();

		$upload_dir = rtrim(BASE_DIR . '/modules/gallery/uploads/' . $row->gallery_folder, '/') . '/';

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
							$image_title = mb_substr($file, 0, -4);
							$upload_file_ext = mb_strtolower(mb_substr($file, -4));
							$upload_filename = prepare_fname($image_title) . $upload_file_ext;

							while (file_exists($upload_dir . $upload_filename))
							{
								$upload_filename = $this->_galleryImageRename($upload_filename);
							}

							if (!empty($upload_filename) && in_array($upload_file_ext, $this->_allowed_type))
							{
								@copy($temp_dir . $file, $upload_dir . $upload_filename);
								@unlink($temp_dir . $file);

								$oldumask = umask(0);
								@chmod($upload_dir . $upload_filename, 0777);
								umask($oldumask);

								if ($upload_file_ext != 'video')
								{
									$this->_galleryImageRebuild($upload_dir, $upload_filename, $row->gallery_watermark);
								}

								$arr[] = '<img src="../modules/gallery/thumb.php?file=' . $upload_filename
									. '&xwidth=' . $row->gallery_thumb_width
									. '&type=' . $this->_galleryFileTypeGet($upload_file_ext)
									. '&folder=' . $row->gallery_folder . '" />';

								$AVE_DB->Query("
									INSERT
									INTO " . PREFIX . "_modul_gallery_images
									SET
										id = '',
										gallery_id = '" . $gallery_id . "',
										image_filename = '" . addslashes($upload_filename) . "',
										image_author_id = '" . (int)$_SESSION['user_id'] . "',
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
				$upload_file_ext = mb_strtolower(mb_substr($_FILES['file']['name'][$i], -4));
				$upload_filename = prepare_fname(mb_substr($_FILES['file']['name'][$i], 0, -4)) . $upload_file_ext;

				if (!empty($upload_filename))
				{
					while (file_exists($upload_dir . $upload_filename))
					{
						$upload_filename = $this->_galleryImageRename($upload_filename);
					}

					if (in_array($upload_file_ext, $this->_allowed_type) )
					{
						move_uploaded_file($_FILES['file']['tmp_name'][$i], $upload_dir . $upload_filename);

						$oldumask = umask(0);
						@chmod($upload_dir . $upload_filename, 0777);
						umask($oldumask);

						if ($upload_file_ext != 'video')
						{
							$this->_galleryImageRebuild($upload_dir, $upload_filename, $row->gallery_watermark);
						}

						$arr[] = '<img src="../modules/gallery/thumb.php?file=' . $upload_filename
							. '&xwidth=' . $row->gallery_thumb_width
							. '&type=' . $this->_galleryFileTypeGet($upload_file_ext)
							. '&folder=' . $row->gallery_folder . '" />';

						$AVE_DB->Query("
							INSERT
							INTO " . PREFIX . "_modul_gallery_images
							SET
								id = '',
								gallery_id = '" . $gallery_id . "',
								image_filename = '" . addslashes($upload_filename) . "',
								image_author_id = '" . (int)$_SESSION['user_id'] . "',
								image_title = '" . (isset($_POST['image_title'][$i]) ? $_POST['image_title'][$i] : '') . "',
								image_file_ext = '" . addslashes($upload_file_ext) . "',
								image_description = '" . (isset($_POST['image_description'][$i]) ? $_POST['image_description'][$i] : '') . "',
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
				$AVE_Template->assign('upload_dir', rtrim('/modules/gallery/uploads/' . $row->gallery_folder, '/') . '/');
			}
			$AVE_Template->assign('allowed', $this->_allowed_type);
			$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=gallery&moduleaction=add&sub=save&id=' . $gallery_id . '&cp=' . SESSION);
			$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_gallery_upload_form.tpl'));
		}
	}

	/**
	 * Вывод списка галерей
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 */
	function galleryListShow($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (!empty($_POST['create']))
		{
			foreach ($_POST['create'] as $gallery_id)
			{
				$this->_galleryImageMove((int)$gallery_id);
			}
		}

		$limit = $this->_limit_galleries;
		$start = get_current_page() * $limit - $limit;
		$galleries = array();

		$sql = $AVE_DB->Query("
			SELECT SQL_CALC_FOUND_ROWS
				gal.*,
				COUNT(img.id) AS image_count
			FROM
				" . PREFIX . "_modul_gallery AS gal
			LEFT JOIN
				" . PREFIX . "_modul_gallery_images AS img
					ON img.gallery_id = gal.id
			GROUP BY gal.id
			ORDER BY gal.gallery_created DESC
			LIMIT " . $start . "," . $limit . "
		");

		$num = $AVE_DB->Query("SELECT FOUND_ROWS()")->GetCell();

		while($row = $sql->FetchAssocArray())
		{
			$row['username'] = get_username_by_id($row['gallery_author_id']);
			array_push($galleries, $row);
		}

		if ($num > $limit)
		{
			$page_nav = ' <a class="pnav" href="index.php?do=modules&action=modedit&mod=gallery&moduleaction=1&cp=' . SESSION . '&page={s}">{t}</a> ';
			$page_nav = get_pagination(ceil($num / $limit), 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		if (!empty($_REQUEST['alert']))
		{
			$AVE_Template->assign('alert', htmlspecialchars(stripslashes($_REQUEST['alert'])));
		}
		$AVE_Template->assign('galleries', $galleries);
		$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=gallery&moduleaction=new&sub=save&cp=' . SESSION);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_gallery_list.tpl'));
	}

	/**
	 * Создание галереи
	 *
	 */
	function galleryNew()
	{
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			global $AVE_DB;

			$cont = true;
			$alert = '';

			if (empty($_POST['gallery_title']))
			{
				$alert = '&alert=empty_gallery_title';
				$cont = false;
			}
			else
			{
				$gallery_folder = prepare_fname(stripslashes($_POST['gallery_folder']));

				if (!empty($gallery_folder))
				{
					$folder_exists = $AVE_DB->Query("
						SELECT 1
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
						gallery_title = '" . $_POST['gallery_title'] . "',
						gallery_description = '" . $_POST['gallery_description'] . "',
						gallery_author_id = '" . (int)$_SESSION['user_id'] . "',
						gallery_created = '" . time() . "'
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
	 * @param int $gallery_id - идентификатор галереи
	 */
	function galleryEdit($tpl_dir, $gallery_id)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$gallery_folder_old = prepare_fname(stripslashes($_REQUEST['gallery_folder_old']));
			$gallery_folder = prepare_fname(stripslashes($_REQUEST['gallery_folder']));

			if (empty($_REQUEST['gallery_title']))
			{ // не указано имя галереи
				$AVE_Template->assign('empty_gallery_title', 1);
				$_REQUEST['gallery_title'] = $_REQUEST['gallery_title_old'];
			}

			if ($_REQUEST['thumb_width_old'] != $_REQUEST['gallery_thumb_width'])
			{ // изменён размер миниатюр - удаляем миниатюры
				$folder = rtrim(BASE_DIR . '/modules/gallery/uploads/' . $gallery_folder_old, '/') . '/';
				$sql = $AVE_DB->Query("
					SELECT image_filename
					FROM " . PREFIX . "_modul_gallery_images
					WHERE gallery_id = '" . $gallery_id . "'
				");
				while ($row = $sql->FetchRow())
				{
					@unlink($folder . 'th__' . $row->image_filename);
				}
			}

			if ($gallery_folder_old != $gallery_folder)
			{ // изменен путь к файлам галереи - перемещаем в новое место
				$this->_galleryImageMove($gallery_id, $gallery_folder_old, $gallery_folder);
			}

			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_gallery
				SET
					gallery_title = '" . $_REQUEST['gallery_title'] . "',
					gallery_description = '" . $_REQUEST['gallery_description'] . "',
					gallery_image_size_show = '" . ((!empty($_REQUEST['gallery_image_size_show']) && is_numeric($_REQUEST['gallery_image_size_show'])) ? $_REQUEST['gallery_image_size_show'] : '') . "',
					gallery_description_show = '" . ((!empty($_REQUEST['gallery_description_show']) && is_numeric($_REQUEST['gallery_description_show'])) ? $_REQUEST['gallery_description_show'] : '') . "',
					gallery_title_show = '" . ((!empty($_REQUEST['gallery_title_show']) && is_numeric($_REQUEST['gallery_title_show'])) ? $_REQUEST['gallery_title_show'] : '') . "',
					gallery_thumb_width = '" . ((!empty($_REQUEST['gallery_thumb_width']) && is_numeric($_REQUEST['gallery_thumb_width'])) ? $_REQUEST['gallery_thumb_width'] : 120) . "',
					gallery_image_on_line = '" . ((!empty($_REQUEST['gallery_image_on_line']) && is_numeric($_REQUEST['gallery_image_on_line'])) ? $_REQUEST['gallery_image_on_line'] : 4) . "',
					gallery_image_on_page = '" . (int)$_REQUEST['gallery_image_on_page'] . "',
					gallery_type = '" . (int)$_REQUEST['gallery_type'] . "',
					gallery_watermark = '" . $_REQUEST['gallery_watermark'] . "',
					gallery_folder = '" . $gallery_folder . "',
					gallery_orderby = '" . $_REQUEST['gallery_orderby'] . "',
					gallery_script = '" . $_REQUEST['gallery_script'] . "',
					gallery_image_template = '" . $_REQUEST['gallery_image_template'] . "'
				WHERE
					id = '" . $gallery_id . "'
			");
		}

		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_gallery
			WHERE id = '" . $gallery_id . "'
		")->FetchAssocArray();

		$AVE_Template->assign('gallery', $row);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_gallery_edit.tpl'));
	}

	/**
	 * Удаление галереи
	 *
	 * @param int $gallery_id - идентификатор галереи
	 */
	function galleryDelete($gallery_id)
	{
		global $AVE_DB;

		$folder = $AVE_DB->Query("
			SELECT gallery_folder
			FROM " . PREFIX . "_modul_gallery
			WHERE id = '" . $gallery_id . "'
		")->GetCell();

		if (!empty($folder))
		{
			$folder = BASE_DIR . '/modules/gallery/uploads/' . $folder . '/';

			if ($handle = opendir($folder))
			{
				while (false !== ($file = readdir($handle)))
				{
					if ($file != '.' && $file != '..')
					{
						@unlink($folder . $file);
					}
				}
				closedir($handle);
				rmdir($folder);
			}
		}
		else
		{
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_gallery_images
				WHERE gallery_id = '" . $gallery_id . "'
			");
			while ($row = $sql->FetchRow())
			{
				@unlink(BASE_DIR . '/modules/gallery/uploads/' . $row->image_filename);
				@unlink(BASE_DIR . '/modules/gallery/uploads/th__' . $row->image_filename);
			}
		}
		$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_gallery WHERE id = '" . $gallery_id . "'");
		$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_gallery_images WHERE gallery_id = '" . $gallery_id . "'");

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
	function _galleryMediaTypeGet($ext)
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
	function _galleryFileTypeGet($ext)
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
	function _galleryImageRename($file_name)
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
	function _galleryImageRebuild($upload_dir, $upload_filename, $watermark_file_name = '')
	{
		global $Image_Toolbox;

		if (!list($width, $height) = getimagesize($upload_dir . $upload_filename)) return;

		$need_resize = false;
		$need_save = false;

		if (isset($_REQUEST['shrink']) && is_numeric($_REQUEST['shrink']) && $_REQUEST['shrink'] < 100)
		{
			$width = round($width * $_REQUEST['shrink'] / 100);
			$height = round($height * $_REQUEST['shrink'] / 100);

			$need_resize = true;
		}

		if (isset($_REQUEST['maxsize']) && is_numeric($_REQUEST['maxsize']) && $_REQUEST['maxsize'] > 10
			&& max(array($width, $height)) > $_REQUEST['maxsize'])
		{
			$width = ($width > $height) ? round($_REQUEST['maxsize']) : 0;
			$height = ($width > $height) ? 0 : round($_REQUEST['maxsize']);

			$need_resize = true;
		}

		$Image_Toolbox->newImage($upload_dir . $upload_filename);

		// Изменяем размер
		if ($need_resize)
		{
			$Image_Toolbox->newOutputSize((int)$width, (int)$height);
			$need_save = true;
		}

		// Добавляем водяной знак
		if (!empty($watermark_file_name))
		{
			$watermark_file = dirname(__FILE__) . '/' . $watermark_file_name;
			if (is_file($watermark_file))
			{
				$Image_Toolbox->addImage($watermark_file);
				$Image_Toolbox->blend('right -10', 'bottom -10', IMAGE_TOOLBOX_BLEND_COPY, 70);
				$need_save = true;
			}
			else
			{
				$Image_Toolbox->addText($watermark_file_name, BASE_DIR . '/inc/fonts/ft16.ttf', 16, '#709536', 'right -10', 'bottom -10');
				$need_save = true;
			}
		}

		if ($need_save) $Image_Toolbox->save($upload_dir . $upload_filename);

	    $oldumask = umask(0);
		chmod($upload_dir . $upload_filename, 0644);
	    umask($oldumask);
	}

	/**
	 * Перемещение изображений галереи
	 *
	 * @param int $gallery_id - идентификатор галереи
	 * @param string $source_folder - директория источник
	 * @param string $destination_folder - директория назначения
	 */
	function _galleryImageMove($gallery_id, $source_folder = '', $destination_folder = '')
	{
		global $AVE_DB;

		if (empty($source_folder) && empty($destination_folder))
		{
			$sql = $AVE_DB->Query("
				SELECT
					gallery_title,
					gallery_folder
				FROM " . PREFIX . "_modul_gallery
				WHERE id = '" . $gallery_id . "'
			");
			if ($row = $sql->FetchRow())
			{
				$source_folder = prepare_fname($row->gallery_folder);
				$destination_folder = $row->gallery_title == '' ? 'gal_' . $gallery_id : prepare_fname($row->gallery_title);
			}
			else
			{
				return;
			}
		}

		$source_path = rtrim(BASE_DIR . '/modules/gallery/uploads/' . $source_folder, '/') . '/';

		if (!file_exists($source_path)) return;

		$destination_path = rtrim(BASE_DIR . '/modules/gallery/uploads/' . $destination_folder, '/') . '/';

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
				WHERE id = '" . $gallery_id . "'
			");

			$sql = $AVE_DB->Query("
				SELECT image_filename
				FROM " . PREFIX . "_modul_gallery_images
				WHERE gallery_id = '" . $gallery_id . "'
			");
			while ($row = $sql->FetchRow())
			{
				@copy($source_path . $row->image_filename, $destination_path . $row->image_filename);

				$oldumask = umask(0);
				chmod($upload_dir . $upload_filename, 0644);
			    umask($oldumask);

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