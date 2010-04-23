
<!-- comments_tree.tpl -->
{strip}

{if $display_comments==1}
<br />
<h6>{#COMMENT_SITE_TITLE#}{if $closed==1 && $smarty.const.UGROUP!=1} <small>{#COMMENT_SITE_CLOSED#}</small>{/if}</h6>

<a href="#end">{#COMMENT_LAST_COMMENT#}</a>

{if $smarty.const.UGROUP==1}
	&nbsp;|&nbsp;
	{if $closed==1}
		<a id="mod_comment_open" href="javascript:void(0);">{#COMMENT_SITE_OPEN#}</a>
	{else}
		<a id="mod_comment_close" href="javascript:void(0);">{#COMMENT_SITE_CLOSE#}</a>
	{/if}
{/if}<br />
<br />

{if $comments[0]}
	{include file="$subtpl" subcomments=$comments[0]}
{/if}

<a id="end"></a>

{if $closed==1 && $smarty.const.UGROUP!=1}
	<br /><h6><small>{#COMMENT_NEW_CLOSED#}</small></h6>
{elseif $cancomment!=1 && $smarty.const.UGROUP!=1}
	<br /><h6><small>{#COMMENT_NEW_FALSE#}</small></h6>
{else}
<form method="post" action="" id="mod_comment_new">
	<hr />
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
		{#COMMENT_CHARS_LEFT#} - <span class="charsLeft" id="charsLeft_new"></span>
        <div style="margin:10px 0;"><label>{#COMMENT_FORM_CODE#}</label></div>
		<div style="margin:10px 0;" id="captcha"><img src="{$BASE_PATH}inc/captcha.php" alt="" width="120" height="60" border="0" /></div>

		<div style="margin:10px 0;"><label for="securecode">{#COMMENT_FORM_CODE_ENTER#}</label></div>
		<div style="margin:10px 0;"><input name="securecode" type="text" id="securecode" style="width:120px" maxlength="10" /></div>
	{/if}

	<div class="control">
		<input type="submit" class="button" value="{#COMMENT_BUTTON_ADD#}" />
		&nbsp;<input type="reset" id="buttonReset" class="button" />
		{if !$im}&nbsp;{#COMMENT_CHARS_LEFT#} - <span class="charsLeft" id="charsLeft_new"></span>{/if}
	</div>
	<br />

	<input name="module" type="hidden" value="comment" />
	<input name="action" type="hidden" value="comment" />
	<input name="sub" type="hidden" value="send" />
	<input name="doc_id" type="hidden" value="{$smarty.request.id}" />
	<input name="parent_id" id="parent_id" type="hidden" value="" />
	<input name="page" type="hidden" value="{$page}" />
</form>

<script type="text/javascript">
function cAction(obj,action){ldelim}
	var cid = $(obj).parents('.mod_comment_box').attr('id');
	if (action=='answer'){ldelim}
		$('#parent_id').val(cid);
		$('#mod_comment_new').insertAfter('#'+cid);
		return;
	{rdelim}
{if $smarty.const.UGROUP==1}
	$.get('index.php',{ldelim}
		module: 'comment',
		action: action,
		docid: '{$doc_id}',
		Id: cid
	{rdelim},function(){ldelim}
		if (action=='delete'){ldelim}
			$(obj).parents('.mod_comment_comment').eq(0).remove();
		{rdelim}
		if (action=='open'){ldelim}
			$(obj).unbind('click')
				.click(function(){ldelim}cAction(obj,'close');{rdelim})
				.html('{#COMMENT_SITE_CLOSE#}');
		{rdelim}
		if (action=='close'){ldelim}
			$(obj).unbind('click')
				.click(function(){ldelim}cAction(obj,'open');{rdelim})
				.html('{#COMMENT_SITE_OPEN#}');
		{rdelim}
		if (action=='unlock'){ldelim}
			$(obj).unbind('click')
				.click(function(){ldelim}cAction(obj,'lock');{rdelim})
				.attr('title','{#COMMENT_LOCK_LINK#}')
				.find('img').attr('src','modules/comment/templates/images/lock.gif');
		{rdelim}
		if (action=='lock'){ldelim}
			$(obj).unbind('click')
				.click(function(){ldelim}cAction(obj,'unlock');{rdelim})
				.attr('title','{#COMMENT_UNLOCK_LINK#}')
				.find('img').attr('src','modules/comment/templates/images/unlock.gif');
		{rdelim}
	{rdelim});
{/if}
{rdelim};

function validate(formData,jqForm,options){ldelim}
	$('.error_message').remove();
	var form = jqForm[0];
	if (!form.author_name.value){ldelim}
		alert('{#COMMENT_ERROR_AUTHOR#}');
		$(form.author_name).focus();
		return false;
	{rdelim}
	if (!form.author_email.value){ldelim}
		alert('{#COMMENT_ERROR_EMAIL#}');
		$(form.author_email).focus();
		return false;
	{rdelim}
	if (!form.message.value){ldelim}
		alert('{#COMMENT_ERROR_TEXT#}');
		$(form.message).focus();
		return false;
	{rdelim}
	{if $im}if (!form.securecode.value){ldelim}
		alert('{#COMMENT_ERROR_CAPTCHA#}');
		$(form.securecode).focus();
		return false;
	{rdelim}
	{/if}return true;
{rdelim};

function setClickable(){ldelim}
	$('.editable_text').click(function(){ldelim}
		var cid = $(this).parents('.mod_comment_box').attr('id');
		var revert = $(this).html();
		var textarea = '<textarea rows="10" id="ta_'+cid+'" class="editable">'+revert+'</textarea>';
		var buttonSave = '<div class="control"><input type="button" value="{#COMMENT_BUTTON_EDIT#}" class="saveButton" /> ';
		var buttonReset = '<input type="button" value="{#COMMENT_BUTTON_CANCEL#}" class="cancelButton" /> ';
		var charsLeft = '{#COMMENT_CHARS_LEFT#} <span class="charsLeft" id="charsLeft_'+cid+'"></span></div>';
		$(this).after('<div>'+textarea+buttonSave+buttonReset+charsLeft+'</div>').remove();
		$('.saveButton').click(function(){ldelim}saveChanges(this,false,cid);{rdelim});
		$('.cancelButton').click(function(){ldelim}saveChanges(this,revert,cid);{rdelim});
		$('#ta_'+cid).limit('{$max_chars}','#charsLeft_'+cid);
	{rdelim})
	.addClass('tooltip')
	.attr('title','{#COMMENT_EDIT_LINK#}')
	.mouseover(function(){ldelim}$(this).addClass('editable');{rdelim})
	.mouseout(function(){ldelim}$(this).removeClass('editable');{rdelim});
	$('#in_message').limit('{$max_chars}','#charsLeft_new');
	$('.mod_comment_answer').click(function(){ldelim}cAction(this,'answer');{rdelim});
{if $smarty.const.UGROUP==1}
	$('.mod_comment_delete').click(function(){ldelim}cAction(this,'delete');{rdelim});
	$('.mod_comment_lock').click(function(){ldelim}cAction(this,'lock');{rdelim});
	$('.mod_comment_unlock').click(function(){ldelim}cAction(this,'unlock');{rdelim});
{/if}
{rdelim};

function saveChanges(obj,cancel,cid){ldelim}
	if (!cancel){ldelim}
		var t = $(obj).parent().siblings(0).val();
		$.post('index.php',{ldelim}
			module: 'comment',
			action: 'edit',
			Id: cid,
			text: t
		{rdelim},
		function(txt){ldelim}
			$(obj).parent().parent().after('<div class="mod_comment_text editable_text">'+txt+'</div>').remove();
			var now = new Date();
			var date = now.toLocaleFormat("{#COMMENT_DATE_TIME_FORMAT#}");
			$('#'+cid).find('.mod_comment_changed').html(' ({#COMMENT_TEXT_CHANGED#} '+date+')');
			setClickable();
		{rdelim});
	{rdelim}
	else {ldelim}
		$(obj).parent().parent().after('<div class="mod_comment_text editable_text">'+cancel+'</div>').remove();
		setClickable();
	{rdelim}
{rdelim};

function getCaptha(){ldelim}
	now = new Date();
	$('#captcha img').attr('src','{$BASE_PATH}inc/captcha.php?cd='+now);
{rdelim};

function displayNewComment(data){ldelim}
	if (data=='wrong_securecode'){ldelim}
		$('#captcha').after('<div class="error_message">{#COMMENT_WRONG_CODE#}</div>');
		$('#securecode').focus();
	{rdelim}
	else {ldelim}
		$('#end'+$('#parent_id').val()).before(data);
		$('#parent_id').val('');
		$('#mod_comment_new').insertAfter('#end').resetForm();
		setClickable();
	{rdelim}
	getCaptha();
{rdelim};

$(document).ready(function(){ldelim}
	setClickable();
	$('#mod_comment_new').submit(function(){ldelim}
		$(this).ajaxSubmit({ldelim}
			url: 'index.php?ajax=1',
			beforeSubmit: validate,
			success: displayNewComment,
			timeout: 3000
		{rdelim});
		return false;
	{rdelim});
	$('#buttonReset').click(function(){ldelim}
		$('#parent_id').val('');
		$('#mod_comment_new').insertAfter('#end').resetForm();
	{rdelim});
	$('#captcha img').click(function(){ldelim}getCaptha();{rdelim});
{if $smarty.const.UGROUP==1}
	$('#mod_comment_open').click(function(){ldelim}cAction(this,'open');{rdelim});
	$('#mod_comment_close').click(function(){ldelim}cAction(this,'close');{rdelim});
{/if}
{rdelim});
</script>
{/if}
{/if}

{/strip}
<!-- /comments_tree.tpl -->
