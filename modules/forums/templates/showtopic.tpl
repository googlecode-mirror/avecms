{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}

{if $smarty.request.print!=1}
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				{include file="$inc_path/tree.tpl"}
			</td>
			<td>
				<div align="right">
					{if $topic->status == 1}
						<img src="{$forum_images}forum/closed.gif" alt="{$lang.f_isclosed}" border="0" class="absmiddle" />
					{else}
						{if ($permissions.6 == 1) || ($permissions.7 == 1) }
							<a class="forum_links" href="index.php?module=forums&amp;show=newpost&amp;toid={$smarty.get.toid}"><img src="{$forum_images}forum/answer.gif" alt="{#FORUMS_REPLY_TO_POST#}" border="0" class="absmiddle" /></a>
						{/if}
					{/if}
				</div>
			</td>
		</tr>
	{if $pages}
		<tr>
			<td>
				<p>{$pages}</p>
			</td>
			<td>&nbsp;</td>
		</tr>
	{/if}
	</table>
{/if}

{if $smarty.request.print==1}
	<h2>{$topic->title|escape:'html'|stripslashes}</h2><br />
{else}
	<table border="0" cellpadding="4" cellspacing="1" class="forum_tableborder" style="width: 100%;">
		<tr>
			<td colspan="2" class="forum_topic_topheader">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<strong>{$topic->title|escape:'html'|stripslashes}</strong>
						</td>
						<td>
							<div align="right">
								{if $ugroup!=2}
									{if $canabo==1}
										<a href="index.php?module=forums&amp;show=addsubscription&amp;t_id={$topic->id}">{#FORUMS_ABO_NOW#}</a>
									{else}
										<a href="index.php?module=forums&amp;show=unsubscription&amp;t_id={$topic->id}">{#FORUMS_ABO_NOW_CANCEL#}</a>
									{/if}
									&nbsp;|&nbsp;
								{/if}
								<a href="{$printlink}&amp;pop=1&amp;theme_folder={$theme_folder}" target="_blank">{#FORUMS_PRINT_TOPIC#}</a>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
{/if}<br />

{foreach from=$postings item=post name=postings}
	<table width="100%" border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
		<tr>
			<td colspan="2" class="forum_header_bolder">
				{if $post->datum|date_format:'%d.%m.%Y' == $smarty.now|date_format:'%d.%m.%Y'}
					<strong>{#FORUMS_TODAY#},&nbsp;{$post->datum|date_format:'%H:%M'}</strong>
				{else}
					<strong>{$post->datum|date_format:$smarty.config.FORUMS_DATE_FORMAT_TIME_THREAD|pretty_date}</strong>
				{/if}
			</td>
		</tr>
		<tr>
			<td valign="top" class="forum_post_first">			
				{if $post->poster->uname != ''}
					{if $post->poster->reg_time > '1' && $post->poster->user_group!=2}
						{if $smarty.request.print!=1}
							{assign var=po value=$post->poster->Ignored}
							<h2><a onclick= "return overlib('{$po}',STICKY,WIDTH,250,TIMEOUT,3000,DELAY,100);" href="javascript:void(0);" rel="nofollow"><strong>{$post->poster->uname}</strong></a></h2><br />
						{else}
							<h2>{$post->poster->uname}</h2>
						{/if}
						<br />
						{$post->poster->user_group_name|escape}
					{else}
						<strong>{$post->poster->groupname_single}</strong>
						<br /><br /><br /><br />
					{/if}

					{if $post->poster->reg_time > 0 && $post->poster->user_group!=2}
						<br />
						{$post->poster->rank|escape|stripslashes}
						{if $post->poster->avatar}
							<br />
							{$post->poster->avatar}<br />
						{/if}
						<p>{if $post->poster->uid == $topic->uid && !$smarty.foreach.postings.first}{#FORUMS_BY_TOPIC#}<br />{/if}</p>
						{#FORUMS_POSTS#} {$post->poster->user_posts}
						<br />
						{#FORUMS_REG_DATE#} {$post->poster->regdate|date_format:$smarty.config.FORUMS_DATE_FORMAT_MEMBER_SINCE}
					{/if}
				{else}
					<h1>{#FORUMS_GUEST#}</h1>
				{/if}
			</td>
			<td width="75%" valign="top" class="forum_post_second">
				{if $post->title != ""}
					<strong>{$post->title}</strong><br />
				{/if}
				{$post->message|stripslashes}
				{if count($post->Attachments) && $smarty.request.print!=1}
					<br />
					<div class="forum_attachment_box">
						{$post->poster->user_name} {#FORUMS_ATTACHMENTS#}
						<table border="0" cellpadding="1" cellspacing="0">
							{foreach from=$post->Attachments item=file name="post"}
								<tr>
									<td>
										<img hspace="2" vspace="4" src="{$forum_images}forum/attach.gif" alt="" class="absmiddle" />
										<a href="index.php?module=forums&amp;show=getfile&amp;file_id={$file->id}&amp;f_id={$topic->forum_id}&amp;t_id={$topic->id}">{$file->orig_name}</a>
									</td>
									<td><small>&nbsp;&nbsp;({$file->hits} {#FORUMS_HITS#}&nbsp;|&nbsp;{$file->FileSize})</small></td>
								</tr>
							{/foreach}
						</table>
					</div>
				{/if}

				{if $post->use_sig==1 && $post->uid!=0 && $post->poster->user_sig!='' && $smarty.request.print!=1}<br />
					<br />
					<br />
					<div class="user_sig_bar">__________________________________________________</div>
					<div class="user_sig">{$post->poster->user_sig|stripslashes}</div>
				{/if}
			</td>
		</tr>
		{if $smarty.request.print!=1}
			<tr>
				<td class="forum_post_first">
					<a name="pid_{$post->id}"></a>
					{if $post->poster->reg_time > 0 && $post->poster->ugroup!=2}
						{$post->poster->OnlineStatus}
					{/if}
				</td>
				<td class="forum_post_second">
					<div align="right">
						&nbsp;
						{if ($post->opened=="2") && ($ismod == 1)}
					        {if !$smarty.foreach.postings.first}{assign var="ispost" value=1}{/if}
							<a href="index.php?module=forums&amp;show=showtopic&amp;toid={$smarty.request.toid}&amp;fid={$smarty.request.fid}&amp;open=1&amp;post_id={$post->id}&amp;ispost={$ispost}"><img src="{$forum_images}forum/moderate_on.gif" border="0" alt="{$lang.f_unlock}" /></a>
						{/if}
						{if ($permissions.15 == 1) || ($permissions.11 == 1) }
						    <a onclick="return confirm('{#FORUMS_DELETE_POST_CONFIRM#}')" href="index.php?module=forums&amp;show=delpost&amp;pid={$post->id}&amp;toid={$smarty.get.toid}&amp;fid={$smarty.request.fid}"><img src="{$forum_images}forum/delete_small.gif" alt="{$lang.forum_deleteb_alt}" border="0" /></a>
						{/if}
						{if $permissions.10 == 1}
						    <a href="index.php?module=forums&amp;show=newpost&amp;action=edit&amp;pid={$post->id}&amp;toid={$smarty.get.toid}"><img src="{$forum_images}forum/edit_small.gif" alt="{$lang.f_edit}" border="0" /></a>
						{/if}
						{if $ugroup!=2  && $topic->status != 1}
							<a href="index.php?module=forums&amp;show=newpost&amp;action=quote&amp;pid={$post->id}&amp;toid={$smarty.get.toid}"><img src="{$forum_images}forum/quote.gif" border="0" alt="{$lang.f_quote}" /></a>
						{/if}
						{if (($permissions.6 == 1) || ($permissions.7 == 1)) && $topic->status != 1}
							<a href="index.php?module=forums&amp;show=newpost&amp;toid={$smarty.get.toid}&amp;pp=15&amp;num_pages={$next_site}"><img src="{$forum_images}forum/reply_small.gif" alt="{$lang.f_reply}" border="0" /></a>
						{/if}
					</div>
				</td>
			</tr>
		{/if}
	</table><br />
{/foreach}

{if $smarty.request.print!=1}
	<table width="100%" border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
		<tr>
			<td colspan="2" class="forum_info_main">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							{if $ugroup!=2}
								{if $canabo==1}
									<a href="index.php?module=forums&amp;show=addsubscription&amp;t_id={$topic->id}">{#FORUMS_ABO_NOW#}</a>
								{else}
									<a href="index.php?module=forums&amp;show=unsubscription&amp;t_id={$topic->id}">{#FORUMS_ABO_NOW_CANCEL#}</a>
								{/if}
								&nbsp;|&nbsp;
							{/if}

							<a href="{$printlink}&amp;pop=1&amp;theme_folder={$theme_folder}" target="_blank">{#FORUMS_PRINT_TOPIC#}</a>

							{if $topic->prev_topic->id != ""}
								&nbsp;|&nbsp;&nbsp;<a class="forumlinks" href="index.php?module=forums&amp;show=showtopic&amp;toid={$topic->prev_topic->id}&amp;fid={$smarty.get.fid}">{#FORUMS_PREV_TOPIC#}</a>
							{/if}

							{if $topic->next_topic->id != ""}
								&nbsp;|&nbsp;&nbsp;<a class="forumlinks" href="index.php?module=forums&amp;show=showtopic&amp;toid={$topic->next_topic->id}&amp;fid={$smarty.get.fid}">{#FORUMS_NEXT_TOPIC#}</a>
							{/if}
						</td>
						<td>
							<div align="right">
								{if $topic->status == 1}
									<img src="{$forum_images}forum/closed.gif" alt="{$lang.f_isclosed}" border="0" class="absmiddle" />
								{else}
									{if ($permissions.6 == 1) || ($permissions.7 == 1) }
										<a class="forum_links" href="index.php?module=forums&amp;show=newpost&amp;toid={$smarty.get.toid}"><img src="{$forum_images}forum/answer.gif" alt="{#FORUMS_REPLY_TO_POST#}" border="0" class="absmiddle" /></a>
									{/if}
								{/if}
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table width="100%"  border="0" cellspacing="0" cellpadding="4">
		<tr>
			<td colspan="2">
				<div align="right">
					<table border="0" cellspacing="0" cellpadding="1">
						<tr>
							<td>{#FORUMS_GO_TO#}</td>
							<td>
								{include file="$inc_path/selector.tpl"}
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td>{$pages}</td>
			<td nowrap="nowrap">
				{if ($permissions.17 == 1) || ($permissions.18 == 1) || ($permissions.14 == 1) || ($permissions.21 == 1) || ($permissions.12 == 1) || ($permissions.20 == 1) || ($permissions.19 == 1) }
					<div align="right">
						{#FORUMS_ADMIN_ACTIONS#}
						<select id="move_sel" name="select" onchange="eval(this.options[this.selectedIndex].value);selectedIndex=0;">
							{if $topic->status eq 1}
								{if ($permissions.13 == 1) || ($permissions.18 == 1)}
									<option value="location.href='index.php?module=forums&amp;show=opentopic&amp;fid={$topic->forum_id}&amp;toid={$smarty.get.toid}';">
										{#FORUMS_OPEN_TOPIC#}
									</option>
								{/if}
							{else}
								{if ($permissions.13 == 1) || ($permissions.18 == 1)}
									<option value="location.href='index.php?module=forums&amp;show=closetopic&amp;fid={$topic->forum_id}&amp;toid={$smarty.get.toid}';">
										{#FORUMS_CLOSE_TOPIC#}
									</option>
								{/if}
							{/if}
							{if ($permissions.14 == 1) || ($permissions.21 == 1)}
								<option value="if(confirm('{#FORUMS_DELETE_TOPIC_CONFIRM#}')) location.href='index.php?module=forums&amp;show=deltopic&amp;fid={$topic->forum_id}&amp;toid={$smarty.get.toid}';">
									{#FORUMS_DELETE_TOPIC#}
								</option>
							{/if}
							{if ($permissions.20 == 1) || ($permissions.12 == 1)}
								<option value="location.href='index.php?module=forums&amp;show=move&amp;item=t&amp;toid={$smarty.get.toid}&amp;fid={$topic->forum_id}';">
									{#FORUMS_MOVE_TOPIC#}
								</option>
							{/if}
							{if $permissions.19 == 1}
								<option value="location.href='index.php?module=forums&amp;show=change_type&amp;toid={$smarty.get.toid}&amp;fid={$topic->forum_id}&amp;t={cpencode val=$topic->title|escape:'html'|stripslashes}';">
									{#FORUMS_CHANGE_TOPIC_TYPE#}
								</option>
							{/if}
						</select>
						<input onclick="eval(document.getElementById('move_sel').value);" type="button" class="button" value="{#FORUMS_BUTTON_GO#}">
					</div>
				{else}
					&nbsp;
				{/if}
			</td>
		</tr>
	</table>
	<table width="100%"  border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td>
				<div align="center">
					{if ($permissions.9 == 1) && ($display_rating == 1) }
						{include file="$inc_path/rating.tpl"}
					{/if}
				</div>
			</td>
		</tr>
	</table>
{/if}