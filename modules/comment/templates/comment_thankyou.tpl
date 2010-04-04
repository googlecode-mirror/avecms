{strip}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>{#COMMENT_THANKYOU_TITLE#}</title>
<link href="templates/{$smarty.request.theme}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<!-- comment_thankyou.tpl -->
<body id="body_popup">
	<div id="module_header"><h2>{#COMMENT_THANKYOU_TITLE#}</h2></div>
	<div id="module_content">
		<p id="module_intro">{$JsAfter}</p>
		<input onclick="window.close();" type="button" class="button" value="{#COMMENT_CLOSE_BUTTON#}" />
	</div>
</body>
<!-- /comment_thankyou.tpl -->
</html>

{/strip}