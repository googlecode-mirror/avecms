<link rel="stylesheet" type="text/css" href="lib/markitup/skins/markitup/style.css" />
<link rel="stylesheet" type="text/css" href="lib/markitup/sets/bbcode/style.css" />
{literal}
<style>
#new fieldset {text-align:center; border:#ccc solid 1px;}
#new fieldset input {width:120px;}
#new .p_input label {float:left; width:10%; text-align:right; padding-right:.5em;}
#new .p_input input {width:40%;}
</style>
{/literal}
<script type="text/javascript" src="lib/markitup/jquery.markitup.pack.js"></script>
<script type="text/javascript" src="lib/markitup/sets/bbcode/set.js"></script>

<script language="javascript">
$(document).ready(function() {ldelim}
	$('#post').markItUp(myBbcodeSettings);
	$('#markItUpPost .markItUpHeader').append('{#POLL_CHARSET_LEFT#} - <span class="charsLeft" id="charsLeft_new"></span>');
	$('#post').limit({$poll->comment_max_chars},'#charsLeft_new');
	$('#new').submit(function() {ldelim}
		if ($('#post_title').val() == '') {ldelim}
			alert('{#POLL_ERROR_NO_TITLE#}');
			$('#post_title').focus();
			return false;
		{rdelim}
		var pftext = $('#new textarea').val();
		if (pftext.length < 10) {ldelim}
			alert("{#POLL_ERROR_SMALL_TEXT#}");
			$('#new textarea').focus();
			return false;
		{rdelim}
{if $poll->anti_spam == 1}
		if ($('#securecode').val() == '') {ldelim}
			alert("{#POLL_ERROR_NO_SCODE#}");
			$('#securecode').focus();
			return false;
		{rdelim}{/if}
	{rdelim});
{rdelim});
</script>

<h2 id="page-heading">{$poll->poll_title|escape}</h2>

<div class="tablebox">
	<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
		<col width="50%">
		<col width="5%">
		<col width="40%">
		<col width="5%">
		<thead>
			<tr>
				<th>{#POLL_QUESTION_LIST#}</th>
				<th  colspan="3">{#POLL_RESULT_INFO#}</th>
			</tr>
		</thead>
		{foreach from=$poll->items item=item}
			<tr class="{cycle name="1" values=",odd"}">
				<td>{$item->poll_item_title|escape}</td>
				<td><div align="center"> {$item->poll_item_hits} </div></td>
				<td >
					<div style="width:100%;height:12px;padding:0">
						<div style="width:{if $item->sum!=""}{$item->sum}%{else}1%{/if};height:12px;background-color:{$item->poll_item_color}">
							<img height="1" width="1" src="{$img_folder}/pixel.gif" alt="" />
						</div>
					</div>
				</td>
				<td  class="{cycle name="pollerg4" values="mod_poll_first,mod_poll_second"}" width="5%" nowrap="nowrap"><div align="center"> {$item->sum} %</div></td>
			</tr>
		{/foreach}
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
		<col width="170">
		<thead>
			<tr>
				<th colspan="2">{#POLL_INFOS#}</th>
			</tr>
		</thead>
		<tr class="odd">
			<td>{#POLL_ALL_HITS#}</td>
			<td>{$poll->votes}</td>
		</tr>

		<tr >
			<td>{#POLL_PUB_STATUS#}</td>
			<td>{if $poll->poll_end > $smarty.now}{#POLL_ACTIVE_INFO#}{else}{#POLL_INACTIVE_INFO#}{/if}</td>
		</tr>

		<tr class="odd">
			<td>{#POLL_STARTED#}</td>
			<td>{$poll->poll_start|date_format:$TIME_FORMAT|pretty_date}</td>
		</tr>

		<tr >
			<td>{#POLL_ENDED#}</td>
			<td>{$poll->poll_end|date_format:$TIME_FORMAT|pretty_date}</td>
		</tr>

		<tr class="odd">
			<td>{#POLL_GROUPS_PERM#}</td>
			<td>{$poll->groups|escape}</td>
		</tr>
	</table>

	{if $poll->can_vote == 1}
		<br />
		<div style="padding:5px"><strong>{$poll->poll_title|escape}</strong></div>
		<form method="post" action="{$poll->formaction}">
			{foreach from=$poll->items item=item}
				<div style="margin-left:5px"><input type="radio" name="p_item" value="{$item->id}" /> {$item->poll_item_title|escape}</div>
			{/foreach}
			<div style="padding:5px"><input type="submit" class="button" value="{#POLL_BUTTON_VOTE#}" /></div>
		</form>
	{/if}
</div>

{if $poll->poll_can_comment == 1}
	<br />
	<h6>{#POLL_PUB_COMMENTS#}</h6>

	<a href="{$poll->link_result}#new">{#POLL_PUB_ADD_COMMENT#}</a> | {#POLL_ALL_COMMENTS#} {$poll->count_comments}<br />
	<br />

	{foreach from=$poll->comments item=comment}
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mod_comment_box" id="{$comment->id}">
			<tr>
				<td class="mod_comment_header">
					<div class="mod_comment_author">
						{*#POLL_ADDED#*} <a href="#">{$comment->lastname|escape} {$comment->firstname|escape}</a> {$comment->poll_comment_time|date_format:$TIME_FORMAT|pretty_date}
					</div>
				</td>
			</tr>
			<tr>
				<td class="mod_comment_text">
					<strong>{$comment->poll_comment_title|escape}</strong><br />
					{$comment->poll_comment_text}
				</td>
			</tr>
		</table>
	{/foreach}

	{if $poll->can_comment == 1}
		<br />
		{*<a name="new"></a>*}
		{*<form id="new" method="post" action="index.php?module=poll&action=comment&pid={$poll->id}">*}
		<form id="new" method="post">
			<input name="sub" type="hidden" value="new" />

			<div class="p_input">
				<p>
					<label>Заголовок</label>
					<input type="text" name="comment_title" id="post_title" class="inputfield" size="80" value="{$smarty.post.comment_title|escape|stripslashes}" />
				</p>
			</div>

			<textarea id="post" name="comment_text" cols="80" rows="15">{$smarty.post.comment_text|escape|stripslashes}</textarea>

			<fieldset>
				{if $poll->anti_spam == 1}
					<p>
						<span id="captcha"><img src="{$ABS_PATH}inc/captcha.php" alt="" width="120" height="60" border="0" /></span><br />
						<label>{#POLL_SECURE_CODE#}</label><br />
						<input name="securecode" type="text" id="securecode" maxlength="10" /><br />
					</p>
				{/if}
				<input name="submit" type="submit" class="button" value="{#POLL_BUTTON_ADD_C#}" />
			</fieldset>
		</form>

		<script>
		$(document).ready(function(){ldelim}
			$('#new').submit(function(){ldelim}
				$(this).ajaxSubmit({ldelim}
					url: aveabspath+'index.php?module=poll&action=result&pid={$poll->id}&ajax=1',
					success: function(){ldelim}
						target = $('h6').offset().top;
						$("html").animate({ldelim}scrollTop: target{rdelim}, 1100);
					{rdelim},
					timeout: 3000
				{rdelim});
				return false;
			{rdelim});
		{rdelim});
		</script>
	{/if}
{/if}