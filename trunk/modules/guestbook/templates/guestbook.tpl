<link rel="stylesheet" type="text/css" href="modules/guestbook/markitup/skins/markitup/style.css" />
<link rel="stylesheet" type="text/css" href="modules/guestbook/markitup/sets/bbcode/style.css" />
{literal}
<style>
#gbf .gb_input {width:50%; float:left; margin-bottom:1em;}
	#gbf .gb_input label {float:left; width:20%; text-align:right; padding-right:.5em;}
	#gbf .gb_input input {width:65%;}

#gbf fieldset {text-align:center; border:#ccc solid 1px;}
	#gbf fieldset input {width:120px;}
</style>
{/literal}
<script type="text/javascript" src="modules/guestbook/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="modules/guestbook/markitup/sets/bbcode/set.js"></script>

<script language="javascript">
$(document).ready(function() {ldelim}
{if $use_bbcode == 1}
	$('#gbf #post').markItUp(myBbcodeSettings);
	$('#markItUpPost .markItUpHeader').append('{#GUEST_CHARSET_LEFT#} - <span class="charsLeft" id="charsLeft_new"></span>');
{else}
	$('#gbf #post').css('width','694px').after('{#GUEST_CHARSET_LEFT#} - <span class="charsLeft" id="charsLeft_new"></span>');
{/if}
	$('#gbf #post').limit({$post_max_length},'#charsLeft_new');
	$('#gbf').submit(function() {ldelim}
		if ($('#gbf #author').val() == '') {ldelim}
			alert('{#GUEST_SORRY_NOAUTOR#}');
			$('#gbf #author').focus();
			return false;
		{rdelim}
		var gbtext = $('#gbf textarea').val();
		if (gbtext.length < 10) {ldelim}
			alert("{#GUEST_SMALL_TEXT#}");
			$('#gbf textarea').focus();
			return false;
		{rdelim}
{if $use_code == 1}
		if ($('#gbf #securecode').val() == '') {ldelim}
			alert("{#GUEST_NO_SCODE_INPUT#}");
			$('#gbf #securecode').focus();
			return false;
		{rdelim}{/if}
	{rdelim});
{rdelim});
</script>

<br />

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td nowrap="nowrap">{#GUEST_PUB_NAME#} | {#GUEST_ALL_COMMENTS#} {$allcomments}</td>
		<td align="right">
			<form action="" method="post" name="pp">
				<select name="sort">
					<option value="desc"{if $descsel!=''} selected="selected"{/if}>{#GUEST_SORTBYDESC#}</option>
					<option value="asc"{if $ascsel!=''} selected="selected"{/if}>{#GUEST_SORTBYASC#}</option>
				</select>
				<select name="pp">
					{foreach from=$pps_array item=pps}
						<option value="{$pps.ps}" {$pps.pps_sel}>{#GUEST_ON#} {$pps.ps} {#GUEST_ONPAGE#}</option>
					{/foreach}
				</select>
				<input type="submit" class="button" value="{#GUEST_B_SORT#}" />
			</form>
		</td>
	</tr>
</table>

{if $pages}
<div class="page_navigation_box">{$pages}</div>
{/if}

{foreach from=$comments_array item=comments}
	<table border="0" width="98%" cellspacing="0" cellpadding="2" class="commBodyTable">
		<tr>
			<td class="commNumTd" width="1%" nowrap="nowrap">
				<strong>{$comments->guestbook_post_author_name|escape}</strong>
				<span class="mini">{if $comments->guestbook_post_author_sity!=''}({$comments->guestbook_post_author_sity|escape}){/if}</span>
			</td>
			<td class="commNameTd" width="79%">
				{if $comments->guestbook_post_author_email!=''}
					&nbsp;<a href="mailto:{$comments->guestbook_post_author_email|escape}"><img src="modules/guestbook/images/email.gif" border="0"></a>
				{/if}
				{if $comments->guestbook_post_author_web!=''}
					{if $comments->guestbook_post_author_email!=''}&nbsp;|{/if}
					&nbsp;<a href="{$comments->guestbook_post_author_web|escape}" target="_blank"><img src="modules/guestbook/images/web.gif" border="0"></a>
				{/if}
			</td>
			<td class="commDateTd" width="20%" align="right" nowrap>{$comments->guestbook_post_created|date_format:$TIME_FORMAT|pretty_date}</td>
		</tr>

		<tr>
			<td style="padding:10px" width="100%" colspan="3" >{$comments->guestbook_post_text}</td>
		</tr>
	</table>
{/foreach}

{if $pages}
<div class="page_navigation_box">{$pages}</div><br />
{/if}

<a name="new"></a>

<form id="gbf" action="index.php?module=guestbook&action=new" method="post">
	<input name="pim" type="hidden" value="{$pim}" />
	<input name="send" type="hidden" value="1" />
	<input name="document" type="hidden" value="{$document}" />

	{if $smarty.session.user_group == '2'}
		<div class="gb_input">
			<label>{#GUEST_YOUR_NAME#}</label>
			<input type="text" name="author" id="author" class="inputfield" size="40" value="{$smarty.request.author|escape|stripslashes}" />
		</div>
		<div class="gb_input">
			<label>{#GUEST_YOUR_EMAIL#}</label>
			<input type="text" name="email" class="inputfield" size="40" value="{$smarty.request.email|escape|stripslashes}" />
		</div>
		<div class="clear"></div>
	{else}
		<input type="hidden" name="author" id="author" value="{$smarty.session.user_name|escape|stripslashes}" />
		<input type="hidden" name="email" value="{$smarty.session.user_email|escape|stripslashes}" />
	{/if}

	<div class="gb_input">
		<label>{#GUEST_YOUR_SITE#}</label>
		<input name="web" type="text" class="inputfield" size="40" value="{$smarty.request.web|escape|stripslashes}" />
	</div>
	<div class="gb_input">
		<label>{#GUEST_YOUR_CITY#}</label>
		<input name="sity" type="text" class="inputfield" size="40" value="{$smarty.request.sity|escape|stripslashes}" />
	</div>
	<div class="clear"></div>

	<textarea id="post" name="text" cols="80" rows="15"></textarea>

	<fieldset>
		{if $use_code == 1}
			<p>
{*				<label>{#GUEST_SECURE_CODE#}</label>
*}				<span id="captcha"><img src="{$ABS_PATH}inc/captcha.php" alt="" width="120" height="60" border="0" /></span><br />
				<label>{#GUEST_SECURE_ENTERCODE#}</label><br />
				<input name="securecode" type="text" id="securecode" maxlength="10" /><br />
			</p>
		{/if}
		<input name="submit" type="submit" class="button" value="{#GUEST_B_ADDPOST#}" />
	</fieldset>
</form>