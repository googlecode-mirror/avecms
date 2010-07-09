<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>{#COMMENT_EDIT_TITLE#}</title>
<link href="templates/{$theme}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="templates/{$theme}/js/common.js" type="text/javascript"></script>
</head>

<body id="body_popup">
	<div id="module_header"><h2>{#COMMENT_EDIT_TITLE#}</h2></div>

	<div id="module_content">
		{if $closed == 1 && $smarty.const.UGROUP != 1}
			{#COMMENT_IS_CLOSED#}
			<p>&nbsp;</p>
			<p><input onclick="window.close();" type="button" class="button" value="{#COMMENT_CLOSE_BUTTON#}" /></p>
		{else}
			{if $editfalse==1}
				{#COMMENT_EDIT_FALSE#}
			{else}
				<form method="post" action="index.php">
					{if $smarty.const.UGROUP==1}
						<fieldset>
							<legend><label for="in_author_name">{#COMMENT_YOUR_NAME#}</label></legend>
							<input name="comment_author_name" type="text" id="in_author_name" style="width:250px" value="{$row.comment_author_name|stripslashes|escape}" />
						</fieldset>

						<fieldset>
							<legend><label for="in_author_email">{#COMMENT_YOUR_EMAIL#}</label></legend>
							<input name="comment_author_email" type="text" id="in_author_email" style="width:250px" value="{$row.comment_author_email|stripslashes|escape}" />
						</fieldset>
					{else}
						<input name="comment_author_name" type="hidden" id="in_author_name" value="{$row.comment_author_name|stripslashes|escape}" />
						<input name="comment_author_email" type="hidden" id="in_author_email" value="{$row.comment_author_email|stripslashes|escape}" />
					{/if}

					<fieldset>
						<legend><label for="in_author_website">{#COMMENT_YOUR_SITE#}</label></legend>
						<input name="comment_author_website" type="text" id="in_author_website" style="width:250px" value="{$row.comment_author_website|stripslashes|escape}" />
					</fieldset>

					<fieldset>
						<legend><label for="in_author_city">{#COMMENT_YOUR_FROM#}</label></legend>
						<input name="comment_author_city" type="text" id="in_author_city" style="width:250px" value="{$row.comment_author_city|stripslashes|escape}" />
					</fieldset>

					<fieldset>
						<legend><label for="in_message">{#COMMENT_YOUR_TEXT#}</label></legend>
						<textarea onkeyup="javascript:textCounter(this.form.comment_text,this.form.charleft,{$row.comment_max_chars});" onkeydown="javascript:textCounter(this.form.comment_text,this.form.charleft,{$row.comment_max_chars});" style="width:98%; height:170px" name="comment_text" id="in_message">{$row.comment_text}</textarea>
						<input type="text" size="6" name="charleft" value="{$row.comment_max_chars}" /> {#COMMENT_CHARS_LEFT#}
					</fieldset>

					<input name="theme" type="hidden" id="theme" value="{$smarty.request.theme|escape}" />
					<input name="module" type="hidden" value="comment" />
					<input name="action" type="hidden" value="edit" />
					<input name="pop" type="hidden" value="1" />
					<input name="sub" type="hidden" value="send" />
					<input name="Id" type="hidden" value="{$smarty.request.Id|escape}" />

					<p>
						<input type="submit" class="button" value="{#COMMENT_BUTTON_EDIT#}" />&nbsp;
						<input type="reset" class="button" />
					</p>
				</form>
			{/if}
		{/if}
	</div>
</body>
</html>