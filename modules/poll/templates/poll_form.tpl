<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>{#POLL_ADD_COMMENT#}</title>
<link href="templates/{$theme_folder}/css/layout.css" rel="stylesheet" type="text/css" media="screen" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
<script src="templates/{$theme_folder}/js/common.js" type="text/javascript"></script>
</head>

<body id="body_popup">

<script type="text/javascript" language="JavaScript">
var aveabspath = '{$smarty.const.ABS_PATH}';
$(document).ready(function() {ldelim}
	$('#comment_text')
		.after('{#POLL_CHARSET_LEFT#} - <span class="charsLeft" id="charsLeft_new"></span>')
		.limit({$max_chars},'#charsLeft_new');
	$('#gpf').submit(function() {ldelim}
		if ($('comment_title').val() == '') {ldelim}
			alert("{#POLL_ENTER_TITLE#}");
			$('comment_title').focus();
			return false;
		{rdelim}
		if ($('comment_text').val() == '') {ldelim}
			alert("{#POLL_ENTER_TEXT#}");
			$('comment_text').focus();
			return false;
		{rdelim}
{if $anti_spam == 1}
		if ($('#gbf #securecode').val() == '') {ldelim}
			alert("{#POLL_ENTER_CODE#}");
			$('#gbf #securecode').focus();
			return false;
		{rdelim}{/if}
	{rdelim});
{rdelim});
</script>

<h5>{#POLL_ADD_COMMENT#}</h5>

<div id="module_content">
	{if $cancomment != 1}
		<p id="module_intro">{#POLL_COMMENT_ERROR#}</p>
		<p>&nbsp;</p>
		<p><input onclick="window.close();" type="button" class="button" value="{#POLL_CLOSE_W#}" /></p>
	{else}
		<form id="pf" method="post" action="index.php?module=poll&action=comment&pid={$smarty.request.pid|escape}">
			{if $errors}<ul>
				{foreach from=$errors item=error}<li>{$error|escape}</li>
				{/foreach}
			</ul>{/if}
			<fieldset>
				<legend><label for="l_Titel">{#POLL_COMMENT_T#}</label></legend>
				<input name="comment_title" type="text" id="comment_title" style="width:250px" value="{$title|escape}" />
			</fieldset><br />

			<fieldset>
				<legend><label for="l_Text">{#POLL_COMMENT_M#}</label></legend>
{*				<textarea onkeyup="javascript:textCounter(this.form.comment_text,this.form.charleft,{$max_chars});" onkeydown="javascript:textCounter(this.form.comment_text,this.form.charleft,{$max_chars});" style="width:98%; height:165px" name="comment_text" id="comment_text">{$text}</textarea>
				<input type="text" size="6" name="charleft" value="{$max_chars}" /> {#POLL_CHARSET_LEFT#}
*}
				<textarea id="comment_text" name="comment_text" cols="80" rows="15" style="width:98%; height:165px">{$text}</textarea>
			</fieldset>

			{if $anti_spam == 1}
				<fieldset>
{*
					<legend><label for="l_Text">{#POLL_SECURE_CODE#}</label></legend>
					<img src="inc/antispam.php?cp_secureimage={$im}" alt="" width="121" height="41" border="0" /><br />
					<br />
					<small><span id="S_secure_{$im}"></span></small>
					<input name="comment_code" type="text" id="comment_code" style="width:100px" maxlength="7" />
*}
					<p>
						<label>{#POLL_SECURE_CODE#}</label>
						<span id="captcha"><img src="{$ABS_PATH}inc/captcha.php" alt="" width="120" height="60" border="0" /></span><br />
						<label>{#POLL_ENTER_CODE#}</label><br />
						<input name="securecode" type="text" id="securecode" maxlength="10" /><br />
					</p>
				</fieldset>
			{/if}

			<p>
				<input type="submit" class="button" value="{#POLL_BUTTON_ADD_C#}" />&nbsp;
				<input type="reset" class="button" value="{#POLL_BUTTON_RESET#}" />
			</p>
		</form>
	{/if}
</div>

</body>
</html>
