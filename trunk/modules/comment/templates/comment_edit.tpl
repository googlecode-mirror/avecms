{strip}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>{#COMMENT_EDIT_TITLE#}</title>
<link href="templates/{$theme}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="templates/{$theme}/js/common.js" type="text/javascript"></script>
</head>
<!-- comment_edit.tpl -->
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
							<input name="author_name" type="text" id="in_author_name" style="width:250px" value="{$row.author_name|stripslashes|escape:html}" />
						</fieldset>

						<fieldset>
							<legend><label for="in_author_email">{#COMMENT_YOUR_EMAIL#}</label></legend>
							<input name="author_email" type="text" id="in_author_email" style="width:250px" value="{$row.author_email|stripslashes|escape:html}" />
						</fieldset>
					{else}
						<input name="author_name" type="hidden" id="in_author_name" value="{$row.author_name|stripslashes|escape:html}" />
						<input name="author_email" type="hidden" id="in_author_email" value="{$row.author_email|stripslashes|escape:html}" />
					{/if}

					<fieldset>
						<legend><label for="in_author_website">{#COMMENT_YOUR_SITE#}</label></legend>
						<input name="author_website" type="text" id="in_author_website" style="width:250px" value="{$row.author_website|stripslashes|escape:html}" />
					</fieldset>

					<fieldset>
						<legend><label for="in_author_city">{#COMMENT_YOUR_FROM#}</label></legend>
						<input name="author_city" type="text" id="in_author_city" style="width:250px" value="{$row.author_city|stripslashes|escape:html}" />
					</fieldset>

					<fieldset>
						<legend><label for="in_message">{#COMMENT_YOUR_TEXT#}</label></legend>
						<textarea onkeyup="javascript:textCounter(this.form.message,this.form.charleft,{$row.max_chars});" onkeydown="javascript:textCounter(this.form.message,this.form.charleft,{$row.max_chars});" style="width:98%; height:170px" name="message" id="in_message">{$row.message}</textarea>
						<input type="text" size="6" name="charleft" value="{$row.max_chars}" /> {#COMMENT_CHARS_LEFT#}
					</fieldset>

					<input name="theme" type="hidden" id="theme" value="{$smarty.request.theme}" />
					<input name="module" type="hidden" value="comment" />
					<input name="action" type="hidden" value="edit" />
					<input name="pop" type="hidden" value="1" />
					<input name="sub" type="hidden" value="send" />
					<input name="Id" type="hidden" value="{$smarty.request.Id}" />

					<p>
						<input type="submit" class="button" value="{#COMMENT_BUTTON_EDIT#}" />&nbsp;
						<input type="reset" class="button" />
					</p>
				</form>
			{/if}
		{/if}
	</div>
</body>
<!-- /comment_edit.tpl -->
</html>

{/strip}