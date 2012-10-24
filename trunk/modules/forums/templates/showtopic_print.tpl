<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$topic->title|escape:'html'|stripslashes}</title>
<meta http-equiv="pragma" content="no-cache" />
<meta name="Keywords" content="" />
<meta name="robots" content="index,follow" />
<link href="templates/{$smarty.request.theme_folder}/css/print.css" rel="stylesheet" type="text/css" media="all" />
<script language="JavaScript" type="text/javascript">
<!--
window.resizeTo(680,600);
window.moveTo(1,1);
window.print();
//-->
</script>
</head>
<body id="body">
{$referer}
<br />
<br />
	{include file="$inc_path/showtopic.tpl"}

<p align="center">
<input type="button" class="button" value="{#FORUMS_BUTTON_CLOSE#}" onclick="window.close()" />
</p>
</body>
</html>
