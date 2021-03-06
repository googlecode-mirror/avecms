<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Текущая страница
 *
 * @param string $type	тип постраничной навигации,
 * 						допустимые значения: page, apage, artpage
 * @return int			номер текущей страницы
 */
function get_current_page($type = 'page')
{
	if (!in_array($type, array('page', 'apage', 'artpage'))) return 1;

	$page = (isset($_REQUEST[$type]) && is_numeric($_REQUEST[$type])) ? $_REQUEST[$type] : 1;

	return (int)$page;
}

/**
 * Постраничная навигация для запросов и модулей
 *
 * @param int $total_pages			количество страниц в документе
 * @param string $type				тип постраничной навигации,
 * 									допустимые значения: page, apage, artpage
 * @param string $template_label	шаблон метки навигации
 * @param string $navi_box			контейнер постраничной навигации
 * @return string					HTML-код постраничной навигации
 */
function get_pagination($total_pages, $type, $template_label, $navi_box = '')
{
	$nav = '';

	if (!in_array($type, array('page', 'apage', 'artpage'))) $type = 'page';

	$curent_page = get_current_page($type);

	if     ($curent_page   == 1)			$seiten = array ($curent_page,   $curent_page+1, $curent_page+2, $curent_page+3, $curent_page+4);
	elseif ($curent_page   == 2)			$seiten = array ($curent_page-1, $curent_page,   $curent_page+1, $curent_page+2, $curent_page+3);
	elseif ($curent_page+1 == $total_pages)	$seiten = array ($curent_page-3, $curent_page-2, $curent_page-1, $curent_page,   $curent_page+1);
	elseif ($curent_page   == $total_pages)	$seiten = array ($curent_page-4, $curent_page-3, $curent_page-2, $curent_page-1, $curent_page);
	else									$seiten = array ($curent_page-2, $curent_page-1, $curent_page,   $curent_page+1, $curent_page+2);

	$seiten = array_unique($seiten);

	$total_label     = trim(get_settings('total_label'));
	$start_label     = trim(get_settings('start_label'));
	$end_label       = trim(get_settings('end_label'));
	$separator_label = trim(get_settings('separator_label'));
	$next_label      = trim(get_settings('next_label'));
	$prev_label      = trim(get_settings('prev_label'));

	if ($total_pages > 5 && $curent_page > 3)
	{
		$nav .= '<span class="hids">'.str_replace('{t}', $start_label, str_replace(array('&amp;'.$type.'={s}','&'.$type.'={s}','/'.$type.'-{s}'), '', $template_label)).'</span>';
		if ($separator_label != '') $nav .= '<span>' . $separator_label . '</span>';
	}

	if ($curent_page > 1)
	{
		if ($curent_page == 2)
		{
			//$nav .= str_replace('{t}', $prev_label, str_replace(array('&amp;'.$type.'={s}','&'.$type.'={s}'), '', $template_label));
			$nav .= '<!-- <span class="keypress">&larr; Ctrl</span> --><span class="page-back">'.str_replace('{t}', $prev_label, str_replace(array('&amp;'.$type.'={s}','&'.$type.'={s}','/'.$type.'-{s}'), '', $template_label)).'</span>';
		}
		else
		{
			//$nav .= str_replace('{t}', $prev_label, str_replace('{s}', ($curent_page - 1), $template_label));
			$nav .= '<!-- <span class="keypress">&larr; Ctrl</span> --><span class="page-back">'.str_replace('{t}', $prev_label, str_replace('{s}', ($curent_page - 1), $template_label)).'</span>';
		}	
	}

//	while (list(,$val) = each($seiten))
	foreach($seiten as $val)
	{
		if ($val >= 1 && $val <= $total_pages)
		{
			if ($curent_page == $val)
			{
				$nav .= str_replace(array('{s}', '{t}'), $val, '<span class="page">' . $curent_page . '</span>');
			}
			else
			{
				if ($val == 1)
				{
				
					$nav .= str_replace('{t}', $val, str_replace(array('&amp;'.$type.'={s}','&'.$type.'={s}','/'.$type.'-{s}'), '', $template_label));
				}
				else
				{
					$nav .= str_replace(array('{s}', '{t}'), $val, $template_label);
				}
			}
		}
	}

	if ($curent_page < $total_pages)
	{
		//$nav .= str_replace('{t}', $next_label, str_replace('{s}', ($curent_page + 1), $template_label));
		$nav .= '<span class="page-next">'.str_replace('{t}', $next_label, str_replace('{s}', ($curent_page + 1), $template_label)).'</span><!-- <span class="keypress">Ctrl &rarr;</span> -->';
	}

	if ($total_pages > 5 && ($curent_page < $total_pages-2))
	{
		if ($separator_label != '') $nav .= '<span>' . $separator_label . '</span>';
		$nav .= '<span class="hids">'.str_replace('{t}', $end_label, str_replace('{s}', $total_pages, $template_label)).'</span>';
	}

	if ($nav != '')
	{
		//if ($total_label != '') $nav = '<span class="pages">' . sprintf($total_label, $curent_page, $total_pages) . '</span> ' . $nav;
		if ($navi_box != '') $nav = sprintf($navi_box, $nav);
	}

	return $nav;
}

?>