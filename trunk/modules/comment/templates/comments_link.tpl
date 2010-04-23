
<!-- comments_link.tpl -->
{strip}

{if $display_comments==1}<br />

<h6>{#COMMENT_SITE_TITLE#}{if $closed==1} {#COMMENT_SITE_CLOSED#}{/if}</h6>

{if $cancomment==1 && $closed!=1}
	<a href="javascript:void(0);" onclick="popup('index.php?docid={$smarty.request.id}&module=comment&action=form&pop=1&theme={$theme}&page={$page}','comment','500','600','1')">{#COMMENT_SITE_ADD#}</a>&nbsp;|&nbsp;
{/if}

<a href="#end">{#COMMENT_LAST_COMMENT#}</a>

{if $smarty.const.UGROUP==1}
	&nbsp;|&nbsp;
	{if $closed==1}
		<a href="javascript:void(0);" onclick="popup('index.php?document_id={$smarty.request.id}&module=comment&action=open&pop=1','comment','1','1','1');">{#COMMENT_SITE_OPEN#}</a>
	{else}
		<a href="javascript:void(0);" onclick="popup('index.php?document_id={$smarty.request.id}&module=comment&action=close&pop=1','comment','1','1','1');">{#COMMENT_SITE_CLOSE#}</a>
	{/if}
{/if}<br />
<br />

{foreach from=$comments[0] item=c name=co}
	<a name="{$c.Id}"></a>
	{if $smarty.request.subaction=='showonly' && $smarty.request.comment_id==$c.Id}
		<div class="mod_comment_highlight">
	{/if}

	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mod_comment_box">
		<tr>
			<td class="mod_comment_header">
				<div class="mod_comment_author">
					{#COMMENT_USER_ADD#} <a title="{#COMMENT_INFO#}" href="javascript:void(0);" onclick="popup('index.php?module=comment&action=postinfo&pop=1&Id={$c.Id}&theme={$theme}','comment','500','300','1');">{$c.author_name}{*|stripslashes|escape:html*}</a> • {$c.published}{if $smarty.const.UGROUP==1} • IP:{$c.author_ip}{/if}
				</div>

				{if $smarty.const.UGROUP==1}
					<div class="mod_comment_icons">
						&nbsp;<a class="tooltip" title="{#COMMENT_DELETE_LINK#}" href="javascript:void(0);" onclick="cAction(this, 'delete', {$c.Id});"><img src="modules/comment/templates/images/trash.gif" alt="" border="0" /></a>
						{if $c.status!=1}
							&nbsp;<a class="tooltip" title="{#COMMENT_UNLOCK_LINK#}" href="javascript:void(0);" onclick="cAction(this, 'unlock', {$c.Id});"><img src="modules/comment/templates/images/unlock.gif" alt="" border="0" /></a>
						{else}
							&nbsp;<a class="tooltip" title="{#COMMENT_LOCK_LINK#}" href="javascript:void(0);" onclick="cAction(this, 'lock', {$c.Id});"><img src="modules/comment/templates/images/lock.gif" alt="" border="0" /></a>
						{/if}
					</div>
				{/if}
			</td>
		</tr>

		<tr>
			<td id="id_{$c.Id}" class="mod_comment_text{if $smarty.const.UGROUP==1 || $c.author_id==$smarty.session.user_id} editable_text{/if}">
				{$c.message}
			</td>
		</tr>
	</table>

	{if $smarty.request.subaction=='showonly' && $smarty.request.comment_id==$c.Id}
		</div>
	{/if}

	{* +++ SubComments +++ *}
	{foreach from=$comments[$c.Id] item=sc name=sco}
		<a name="{$sc.Id}"></a>
		<div class="mod_comment_ans_box">
			{if $smarty.request.subaction=='showonly' && $smarty.request.comment_id==$sc.Id}
				<div class="mod_comment_highlight">
			{/if}

			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mod_comment_box">
				<tr>
					<td class="mod_comment_header">
						<div class="mod_comment_author">
							{#COMMENT_USER_ADD#} <a title="{#COMMENT_INFO#}" href="javascript:void(0);" onclick="popup('index.php?module=comment&action=postinfo&pop=1&Id={$sc.Id}&theme={$theme}','comment','500','300','1');">{$sc.author_name}{*|stripslashes|escape:html*}</a> • {$sc.published}{if $smarty.const.UGROUP==1} • IP:{$sc.author_ip}{/if}
						</div>

						{if $smarty.const.UGROUP==1}
							<div class="mod_comment_icons">
								&nbsp;<a class="tooltip" title="{#COMMENT_DELETE_LINK#}" href="javascript:void(0);" onclick="cAction(this, 'delete', {$sc.Id});"><img src="modules/comment/templates/images/trash.gif" alt="" border="0" /></a>
								{if $sc.status!=1}
									&nbsp;<a class="tooltip" title="{#COMMENT_UNLOCK_LINK#}" href="javascript:void(0);" onclick="cAction(this, 'unlock', {$sc.Id});"><img src="modules/comment/templates/images/unlock.gif" alt="" border="0" /></a>
								{else}
									&nbsp;<a class="tooltip" title="{#COMMENT_LOCK_LINK#}" href="javascript:void(0);" onclick="cAction(this, 'lock', {$sc.Id});"><img src="modules/comment/templates/images/lock.gif" alt="" border="0" /></a>
								{/if}
							</div>
						{/if}
					</td>
				</tr>

				<tr>
					<td id="id_{$sc.Id}" class="mod_comment_text{if $smarty.const.UGROUP==1 || $sc.author_id==$smarty.session.user_id} editable_text{/if}">
						{$sc.message}
					</td>
				</tr>
			</table>

			{if $smarty.request.subaction=='showonly' && $smarty.request.comment_id==$sc.Id}
				</div>
			{/if}
		</div>
	{/foreach}
	{* --- SubComments --- *}
{/foreach}

<a id="end"></a>

{if $cancomment!=1 || $closed==1}
	<p id="module_intro">{#COMMENT_NEW_FALSE#}</p>
{else}
	<br />
	<form method="post" action="" id="newComment">
		{if $smarty.session.user_name != ''}
			<input name="author_name" type="hidden" id="in_author_name" value="{$smarty.session.user_name}" />
		{else}
			<div style="margin:10px 0;">
				<input name="author_name" type="text" id="in_author_name" style="width:250px" value="{$smarty.session.user_name}" />&nbsp;
				{#COMMENT_YOUR_NAME#}
			</div>
		{/if}

		{if $smarty.session.user_email != ''}
			<input name="author_email" type="hidden" id="in_author_email" value="{$smarty.session.user_email}" />
		{else}
			<div style="margin:10px 0;">
				<input name="author_email" type="text" id="in_author_email" style="width:250px" />&nbsp;
				{#COMMENT_YOUR_EMAIL#}
			</div>
		{/if}

		<div style="margin:10px 0;">
			<input name="author_website" type="text" id="in_author_website" style="width:250px" />&nbsp;
			{#COMMENT_YOUR_SITE#}
		</div>

		<div style="margin:10px 0;">
			<input name="author_city" type="text" id="in_author_city" style="width:250px" />&nbsp;
			{#COMMENT_YOUR_FROM#}
		</div>

		<textarea rows="10" style="width:99%;" name="message" id="in_message"></textarea>

		{if $im}
            <div style="margin:10px 0;"><label>{#COMMENT_FORM_CODE#}</label></div>
			<div style="margin:10px 0;" id="captcha"><img src="{$BASE_PATH}inc/captcha.php" alt="" width="120" height="60" border="0" /></div>

			<div style="margin:10px 0;"><label for="securecode">{#COMMENT_FORM_CODE_ENTER#}</label></div>
			<div style="margin:10px 0;"><input name="securecode" type="text" id="securecode" style="width:120px" maxlength="10" /></div>
		{/if}

		<div class="control">
			<input type="submit" class="button" value="{#COMMENT_BUTTON_ADD#}" />
			&nbsp;<input type="reset" class="button" />
			&nbsp;{#COMMENT_CHARS_LEFT#} - <span class="charsLeft" id="charsLeft_new"></span>
		</div>
		<br />

		<input name="module" type="hidden" value="comment" />
		<input name="action" type="hidden" value="comment" />
		<input name="sub" type="hidden" value="send" />
		<input name="doc_id" type="hidden" value="{$smarty.request.id}" />
		<input name="page" type="hidden" value="{$page}" />
	</form>
{/if}

{/if}
{/strip}

{if $cancomment==1 && $closed!=1}
<script type="text/javascript">
function cAction(obj, action, cid) {ldelim}
	$.get('index.php',{ldelim}
		module: 'comment',
		action: action,
		docid: '{$doc_id}',
		Id: cid
	{rdelim},function() {ldelim}
		if (action=='delete') {ldelim}
			$('#id_'+cid).parent().parent().parent().remove();
		{rdelim}
		if (action=='unlock') {ldelim}
			$(obj).unbind('click')
				.click(function(){ldelim}cAction(this, 'lock', cid);{rdelim})
				.attr({ldelim}onclick: '', title: '{#COMMENT_LOCK_LINK#}'{rdelim})
				.find('img').attr('src', 'modules/comment/templates/images/lock.gif');
		{rdelim}
		if (action=='lock') {ldelim}
			$(obj).unbind('click')
				.click(function(){ldelim}cAction(this, 'unlock', cid);{rdelim})
				.attr({ldelim}onclick: '', title: '{#COMMENT_UNLOCK_LINK#}'{rdelim})
				.find('img').attr('src', 'modules/comment/templates/images/unlock.gif');
		{rdelim}
	{rdelim});
//	return false;
{rdelim};

function validate(formData, jqForm, options) {ldelim}
	$('.error_message').remove();
	var form = jqForm[0];
	if (!form.author_name.value) {ldelim}
		alert('{#COMMENT_ERROR_AUTHOR#}');
		$(form.author_name).focus();
		return false;
	{rdelim}
	if (!form.author_email.value) {ldelim}
		alert('{#COMMENT_ERROR_EMAIL#}');
		$(form.author_email).focus();
		return false;
	{rdelim}
	if (!form.message.value) {ldelim}
		alert('{#COMMENT_ERROR_TEXT#}');
		$(form.message).focus();
		return false;
	{rdelim}
	{if $im}if (!form.securecode.value) {ldelim}
		alert('{#COMMENT_ERROR_CAPTCHA#}');
		$(form.securecode).focus();
		return false;
	{rdelim}
	{/if}return true;
{rdelim};

function setClickable() {ldelim}
	$('.editable_text').click(function() {ldelim}
		var cid = $(this).attr('id');
		var revert = $(this).html();
		var textarea = '<td><textarea rows="10" id="ta_'+cid+'" class="editable">'+revert+'</textarea>';
		var buttonSave = '<div class="control"><input type="button" value="{#COMMENT_BUTTON_EDIT#}" class="saveButton" /> ';
		var buttonReset = '<input type="button" value="{#COMMENT_BUTTON_CANCEL#}" class="cancelButton" /> ';
		var charsLeft = '{#COMMENT_CHARS_LEFT#} <span class="charsLeft" id="charsLeft_'+cid+'"></span></div></td>';
		$(this).after(textarea+buttonSave+buttonReset+charsLeft).remove();
		$('.saveButton').click(function(){ldelim}saveChanges(this, false, cid);{rdelim});
		$('.cancelButton').click(function(){ldelim}saveChanges(this, revert, cid);{rdelim});
		$('textarea#ta_'+cid).limit('{$max_chars}','#charsLeft_'+cid);
	{rdelim})
	.addClass('tooltip')
	.attr('title', '{#COMMENT_EDIT_LINK#}')
	.mouseover(function(){ldelim}$(this).addClass('editable');{rdelim})
	.mouseout(function(){ldelim}$(this).removeClass('editable');{rdelim});
	$('#in_message').limit('{$max_chars}','#charsLeft_new');
{rdelim};

function saveChanges(obj, cancel, cid) {ldelim}
	if(!cancel) {ldelim}
		var t = $(obj).parent().siblings(0).val();
		$.post('index.php',{ldelim}
			module: 'comment',
			action: 'edit',
			Id: cid,
			text: t
		{rdelim},function(txt) {ldelim}
			$(obj).parent().parent().after('<td id="'+cid+'" class="mod_comment_text editable_text">'+txt+'</td>').remove();
			setClickable();
		{rdelim});
	{rdelim}
	else {ldelim}
		$(obj).parent().parent().after('<td id="'+cid+'" class="mod_comment_text editable_text">'+cancel+'</td>').remove();
		setClickable();
	{rdelim}
{rdelim}

function rewriteCaptha() {ldelim}
	now = new Date();
	$('#captcha img').attr('src', '{$BASE_PATH}inc/captcha.php?cd='+now);
{rdelim};

function displayNewComment(data) {ldelim}
	if (data=='wrong_securecode') {ldelim}
		$('#captcha').after('<div class="error_message">{#COMMENT_WRONG_CODE#}</div>');
		$('#securecode').focus();
	{rdelim}
	else {ldelim}
		$('#end').before(data);
		$('#newComment').resetForm();
		setClickable();
	{rdelim}
	rewriteCaptha();
{rdelim};

$(document).ready(function() {ldelim}
	setClickable();
	$('#newComment').submit(function() {ldelim}
		$(this).ajaxSubmit({ldelim}
			url: 'index.php?ajax=1',
			beforeSubmit: validate,
			success: displayNewComment,
			timeout: 3000
		{rdelim});
		return false;
	{rdelim});
	$('#captcha img').click(function(){ldelim}rewriteCaptha();{rdelim});
//	$('#in_message').limit('{$max_chars}','#charsLeft_new');
{rdelim});
</script>
{/if}
<!-- /comments_link.tpl -->
