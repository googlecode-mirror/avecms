<?php

function DownloadRewrite($print_out)
{
	$print_out = preg_replace('/index.php([?])module=download&amp;action=showfile&amp;file_id=([0-9]*)&amp;categ=([0-9]*)/', 'download-\\2-\\3.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=download&amp;action=get_file&amp;file_id=([0-9]*)&amp;pop=1&amp;theme_folder=([_a-zA-Z0-9]*)/', 'download_file-\\2-\\3.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=download&amp;action=get_nopay_file&amp;file_id=([0-9]*)&amp;pop=1&amp;theme_folder=([_a-zA-Z0-9]*)/', 'nopay_file-\\2-\\3.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=download&amp;action=get_notmine_file&amp;file_id=([0-9]*)&amp;pop=1&amp;theme_folder=([_a-zA-Z0-9]*)/', 'notmine_file-\\2-\\3.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=download&amp;action=get_nouserpay_file&amp;diff=([0-9,]*)&amp;val=([0-9]*)&amp;file_id=([0-9]*)&amp;pop=1&amp;theme_folder=([_a-zA-Z0-9]*)/', 'nouserpay_file-\\2-\\3-\\4-\\5.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=download&amp;action=pay&amp;file_id=([0-9]*)&amp;pop=0&amp;theme_folder=([_a-zA-Z0-9]*)/', 'pay-\\2-\\3.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=download&amp;action=toreg&amp;file_id=([0-9]*)&amp;pop=1&amp;theme_folder=([_a-zA-Z0-9]*)/', 'toreg-\\2-\\3.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=download&amp;action=get_denied&amp;file_id=([0-9]*)&amp;pop=1&amp;theme_folder=([_a-zA-Z0-9]*)/', 'denied-\\2-\\3.html', $print_out);

	$print_out = preg_replace('/index.php([?])module=download&amp;categ=([0-9]*)&amp;parent=([0-9]*)&amp;navop=([0-9]*)&amp;c=([a-zA-Z0-9-]*)&amp;page=([}{s0-9]*)&amp;orderby=([_a-zA-Z0-9]*)/', 'download_kategorie-\\2-\\3-\\4-\\5-page\\6-order\\7.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=download&amp;categ=([0-9]*)&amp;parent=([0-9]*)&amp;navop=([0-9]*)&amp;c=([a-zA-Z0-9-]*)&amp;page=([}{s0-9]*)/', 'download_kategorie-\\2-\\3-\\4-\\5-page\\6.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=download&amp;categ=([0-9]*)&amp;parent=([0-9]*)&amp;navop=([0-9]*)&amp;c=([a-zA-Z0-9-]*)/', 'download_kategorie-\\2-\\3-\\4-\\5.html', $print_out);

	$print_out = preg_replace('/index.php([?])module=download&amp;manufacturer=([0-9]*)/', 'hersteller-\\2.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=download&amp;action=showbasket/', 'warenkorb.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=download&amp;action=checkout/', 'kasse.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=download&amp;action=myorders/', 'meine_bestellungen.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=download&amp;action=mydownloads/', 'meine_downloads.html', $print_out);

	$print_out = preg_replace('/index.php([?])module=download/', 'download.html', $print_out);
	$print_out = str_replace(".html&amp;print=1", "-print.html", $print_out);

	return $print_out;
}

?>