<table width="100%"  border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<div class="forum_frame " id="cat_{$categorie.id}">
				<table border="0" cellpadding="0" cellspacing="0" class="forum_tableborder" style="width: 100%">
					<tr>
						<td class="forum_header_bolder">
							<a class="forum_links_cat" href="{$categorie.link}">{$categorie.title}</a> 
							{if $categorie.comment}<br />
								<small>{$categorie.comment}</small>
							{/if}
						</td>
						<td class="forum_header_bolder" style="width:10px">
							<div align="center">
								<img border="0" alt="" id="img_{$categorie.id}" src="{$forum_images}{$categorie.image|default:"minus.gif"}"
					onmouseover="this.style.cursor = 'pointer'"
					onclick="
						MWJ_changeDisplay('id{$categorie.id}', MWJ_getStyle( 'id{$categorie.id}', 'display' ) ? '' : 'none');
						cpengine_toggleImage('img_{$categorie.id}', this.src);
						cpengine_setCookie('categories', 'id{$categorie.id}');" /> 
							</div>
						</td>
					</tr>
				</table>
					<div id="id{$categorie.id}" style="display: {$categorie.display|default:'block'};">
				<table width="100%" border="0" cellpadding="0" cellspacing="1" class="forum_tableborder">
					{* Если форумы доступны в категории *}
					{if count($forums[$categorie.title]) gt 0}
					{/if}
					{* alle foren zur kategorie ausgeben *}
				{foreach from=$forums[$categorie.title] item=forum}
					<tr>
						<td class="forum_info_icon" {if count($forum.subforums)}rowspan="2"{/if}>{$forum.statusicon}</td>
						<td class="forum_info_meta"><a class="forum_links" href="{$forum.link}">{$forum.title}</a>
							<div class="f_info_comment">{$forum.comment|strip_tags}</div>
						</td>
						<td width="120" nowrap="nowrap" class="forum_info_main">
							<div align="center">{#ThreadViewTopics#} {if $forum.tcount == 0}0{else}{$forum.tcount}{/if}</div>
							<div align="center">{#ThreadViewPosts#} {if $forum.pcount == 0}0{else}{$forum.pcount}{/if}</div>			  
						</td>
						<td width="220" align="right" nowrap="nowrap" class="forum_info_meta">
							{if $forum.last_post->topic_id != ""}
								<span class="forum_small">
									<strong>
										<a class="forum_links" href="index.php?module=forums&amp;show=showtopic&amp;toid={$forum.last_post->topic_id}&amp;pp=15&amp;page={$forum.last_post->page}#pid_{$forum.last_post->id}">{#ThreadViewLastPost#}</a>
									</strong>
										&nbsp;{#FromUser#}&nbsp;
								{if $forum.last_post->user_regdate < 2}
									{#Guest#}
								{else}
									<a href="index.php?module=forums&show=userprofile&user_id={$forum.last_post->uid}" class="forum_links_small">{$forum.last_post->LastPoster}</a>
								{/if}
									<br />
									<strong>{#InForum#} </strong>
									&nbsp;
									<a class="forum_links_small" href="index.php?module=forums&amp;show=showtopic&amp;toid={$forum.last_post->topic_id}"{if $forum.last_post->title|count_characters:true > 20} title="{$forum.last_post->title|stripslashes}"{/if}>{$forum.last_post->title|truncate:20:" ...":true|stripslashes}</a>
									<br />
									<strong>{#AtTime#} </strong>
								{if $forum.last_post->datum|date_format:'%d.%m.%Y' == $smarty.now|date_format:'%d.%m.%Y'}
									{#Today#},&nbsp;{$forum.last_post->datum|date_format:'%H:%M'}
								{else}
									{$forum.last_post->datum|date_format:'%d.%m.%Y %H:%M'}
								{/if}
								</span>
							{else}
								&nbsp;
							{/if}
						</td>
					</tr>
						{* См. суб форум *}
				{if count($forum.subforums)}
					<tr>
						<td colspan="4" class="forum_info_main">
							<strong>{#SubBoards#}</strong>&nbsp;
								{foreach from=$forum.subforums item=subforum name="sf"}
									<a class="forum_links_small" href="{$subforum.link}">{$subforum.title|strip_tags}</a>
									{if !$smarty.foreach.sf.last},&nbsp;{/if}
								{/foreach} 
						</td>
					</tr>
				{/if}
				{/foreach}
				</table>
					</div>
			</div>
		</td>
	</tr>
</table>