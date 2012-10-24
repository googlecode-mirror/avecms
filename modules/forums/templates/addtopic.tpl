{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}

<p>
	{$navigation}
</p>

{if count($errors)}
	<div id="error_list">
		<ul>
      {foreach from=$errors item=error}
    <li>{$error}</li>
      {/foreach}
		</ul>
	</div>
{/if}

{if $smarty.request.preview==1}
	<br />
	<table width="100%" border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
		<tr>
			<th colspan="2" class="forum_header_bolder"><strong>{#FORUMS_POSTPREVIEW#}</strong></th>
		</tr>
		<tr>
			<td width="20%" class="forum_post_first">&nbsp;</td>
			<td class="forum_post_first">{$preview_text}</td>
		</tr>
	</table>
	<br />
{/if}

<script language="javascript" type="text/javascript">
<!--
var postmaxchars = '{$max_post_length}';
	function checkf() {ldelim}
	closeall();
	var MessageMax = '{$maxlength_post}';
		MessageLength  = document.f.text.value.length;
		errors = "";
	{if $smarty.request.show=="newtopic" || $smarty.request.show=="addtopic"}
	if (document.f.topic.value.length < 2)
			{ldelim}
				errors = "{#FORUMS_MISSING_TOPIC_M#}";
				document.f.topic.focus();
			{rdelim}
	{/if}

		if (MessageLength < 3) {ldelim}
			 errors = "{#FORUMS_MISSING_THREAD_M#}";
				document.f.text.focus();
		{rdelim}
		if (MessageMax !=0) {ldelim}
			if (MessageLength > MessageMax){ldelim}
				errors = "{#FORUMS_CHARS_MAX_2#} " + MessageLength + ". {#FORUMS_CHARS_MAX#} " + MessageMax + "";
				document.f.text.focus();
			{rdelim}
		{rdelim}

		if (errors != "") {ldelim}
			alert(errors);
			return false;
		{rdelim}
			else {ldelim}
			document.f.submit.disabled = true;

			return true;
		{rdelim}
{rdelim}

function beitrag(theform) {ldelim}
	if (postmaxchars != 0) message = " {#FORUMS_CHARS_MAX#} "+postmaxchars+"";
	else message = "";
	alert("{#FORUMS_CHARS_USED#} "+theform.text.value.length+" "+message);
{rdelim}
//-->
</script>

<form action="{$action}" enctype="multipart/form-data" method="post" name="f" id="f" onsubmit="return checkf();">
	<input type="hidden" name="fid" value="{$forum_id}" />
	<input type="hidden" name="toid" value="{$topic_id}" />
	{$topicform}
	{$threadform}
	<br />
	<table width="100%" border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
  	{if ($permissions.19 == 1) || ($permissions.13 == 1)  || ($permissions.18 == 1)}
  		<tr>
			<td class="forum_post_first">{#FORUMS_ADMIN_OPTIONS#}</td>
			<td class="forum_post_second">
				{if ($permissions.18 != 1) && ($ugroup != 1) }
					{if ($permissions.13==1) && ($aid == $userid) }
						{assign var="close" value="1"}
					{/if}
				{else}
					{assign var="close" value="1"}
				{/if}
				<select id="sa" name="subaction">
					<option value=""></option>
				{if $close == 1}
					<option value="close">{#FORUMS_TOPIC_AFTER_CLOSE#}</option>
				{/if}
          		{if $permissions.19 == 1}
					<option value="announce">{#FORUMS_TOPIC_AFTER_ANNOUNCE#}</option>
					<option value="attention">{#FORUMS_TOPIC_AFTER_ATTENTION#}</option>
          		{/if}
				</select>
			</td>
		</tr>
  	{/if}
    <tr>
		<td class="forum_post_first" style="width: 20%"></td>
		<td class="forum_post_second">
			<input type="hidden" name="preview" id="preview" value="" />
			<input type="hidden" name="pop" id="is_pop" value="" />
			<input type="hidden" name="theme_folder" value="{$theme_folder}" />
			<input type="submit" class="button" value="{#FORUMS_BUTTON_ADD_NEW#}" id="submits" accesskey="s" onclick="closeall();document.getElementById('is_pop').value='1';" />&nbsp;
			<input type="button" class="button" value="{#FORUMS_BUTTON_PREVIEW#}" onclick="closeall();document.getElementById('preview').value=1;document.forms.f.submit();" />&nbsp;
			<input type="button" class="button" value="{#FORUMS_BUTTON_CHECK_LENGTH#}" onclick="beitrag(document.f);closeall()" />
		</td>
    </tr>
  </table>

</form><br />
<br />

{if $smarty.request.show != "newtopic" && $smarty.request.action != "edit"}
	<table width="100%"  border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
		<tr>
			<td colspan="2" class="forum_header_bolder"><strong>{#FORUMS_LAST_POSTS#}</strong></td>
		</tr>
    {foreach from=$items item="lp"}
		<tr class="{cycle name="lastposts" values="forum_post_first,forum_post_second"}">
			<td width="20%" valign="top">
				<strong>{$lp->user}</strong><br />
				{$lp->datum|date_format:"%d.%m.%Y %H:%M"}
			</td>
			<td>
				{if $lp->title}<strong>{$lp->title|escape:"html"|stripslashes}</strong><br /><br />{/if}
				{$lp->message}
			</td>
		</tr>
    {/foreach}
	</table>
{/if}