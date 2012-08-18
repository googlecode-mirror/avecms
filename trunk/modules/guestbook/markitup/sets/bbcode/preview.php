<?php

if (!empty($_POST['data']) && require('markitup.bbcode-parser.php'))
{
	$data = get_magic_quotes_gpc()
		? stripslashes($_POST['data'])
		: $_POST['data'];
	$data = iconv('utf-8', 'cp1251', $data);
	$data = BBCode2Html($data);

	echo $data;
}

?>