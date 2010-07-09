<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>{#COMMENT_NEW_TITLE#}</title>
<link href="templates/{$theme}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="templates/{$theme}/js/common.js" type="text/javascript"></script>
</head>

<body id="body_popup">

<div id="module_header"><h2>{#COMMENT_NEW_TITLE#}</h2></div>

<div id="module_content">
	{if $closed==1}
		{#COMMENT_NEW_CLOSED#}
		<p>&nbsp;</p>
		<p><input onclick="window.close();" type="button" class="button" value="{#COMMENT_CLOSE_BUTTON#}" /></p>
	{else}
		{if !$cancomment}
			<p id="module_intro">{#COMMENT_NEW_FALSE#}</p>
			<p>&nbsp;</p>
			<p><input onclick="window.close();" type="button" class="button" value="{#COMMENT_CLOSE_BUTTON#}" /></p>
		{else}
			<form method="post" action="index.php">
				{if $smarty.session.user_name != ''}
					<input name="comment_author_name" type="hidden" value="{$smarty.session.user_name|escape}" />
				{else}
					<fieldset>
						<legend><label for="in_author_name">{#COMMENT_YOUR_NAME#}</label></legend>
						<input name="comment_author_name" type="text" id="in_author_name" style="width:250px" value="{$smarty.session.user_name|escape}" />
					</fieldset>
					<br />
				{/if}

				{if $smarty.session.user_email != ''}
					<input name="comment_author_email" type="hidden" value="{$smarty.session.user_email|escape}" />
				{else}
					<fieldset>
						<legend><label for="in_author_email">{#COMMENT_YOUR_EMAIL#}</label></legend>
						<input name="comment_author_email" type="text" id="in_author_email" style="width:250px" value="" />
					</fieldset>
					<br />
				{/if}

				<fieldset>
					<legend><label for="in_author_website">{#COMMENT_YOUR_SITE#}</label></legend>
					<input name="comment_author_website" type="text" id="in_author_website" style="width:250px" />
				</fieldset>
				<br />

				<fieldset>
					<legend><label for="in_author_city">{#COMMENT_YOUR_FROM#}</label></legend>
					<input name="comment_author_city" type="text" id="in_author_city" style="width:250px" />
				</fieldset>
				<br />

				<fieldset>
					<legend><label for="in_message">{#COMMENT_YOUR_TEXT#}</label></legend>
					<textarea onkeyup="javascript:textCounter(this.form.comment_text,this.form.charleft,{$comment_max_chars});" onkeydown="javascript:textCounter(this.form.comment_text,this.form.charleft,{$comment_max_chars});" style="width:98%; height:165px" name="comment_text" id="in_message"></textarea>
					<input type="text" size="6" name="charleft" value="{$comment_max_chars}" /> {#COMMENT_CHARSET_LEFT#}
				</fieldset>

				<input name="theme" type="hidden" id="theme" value="{$smarty.request.theme|escape}" />
				<input name="module" type="hidden" value="comment" />
				<input name="action" type="hidden" value="comment" />
				<input name="pop" type="hidden" id="pop" value="1" />
				<input name="sub" type="hidden" id="sub" value="send" />
				<input name="page" type="hidden" value="{$smarty.request.page|escape}" />
				<input name="document_id" type="hidden" value="{$smarty.request.docid|escape}" />
				<input name="parent_id" type="hidden" value="{$smarty.request.parent|escape|default:0}" />

				<p>
					<input type="submit" class="button" value="{#COMMENT_BUTTON_ADD#}" />&nbsp;
					<input type="reset" class="button" />
				</p>
			</form>
		{/if}
	{/if}
</div>

</body>
</html>