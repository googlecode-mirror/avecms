<!-- Forum Selektor Template -->

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="right" class="box_innerbody">
			<form action="index.php?module=forums&amp;show=showforum" method="post" name="fp" id="fp">
				<select name="fid" id="fid">
				{foreach from=$categories_dropdown item=category name=cdd}
					<optgroup label="{$category->title}">
					{foreach from=$category->forums item=forum_dropdown name=fdd}
				{if $forum_dropdown->category_id == 0}
					<option style="font-weight: bold; font-style: italic;" value="{$forum_dropdown->id}" {if $smarty.request.fid == $forum_dropdown->id} selected="selected" {/if}>
						{$forum_dropdown->visible_title}
					</option>
				{else}
					<option value="{$forum_dropdown->id}" {if $smarty.request.fid == $forum_dropdown->id} selected="selected" {/if}>
						{$forum_dropdown->visible_title}
					</option>
				{/if}
					{/foreach}
					</optgroup>
				{/foreach}
				</select>
				<select name="pp">
				{section name=pps loop=76 step=5 start=15}
					<option value="{$smarty.section.pps.index}" {if $smarty.request.pp == $smarty.section.pps.index}selected="selected"{/if}>
						{$smarty.section.pps.index}	{#FORUMS_ON_PAGE#}
					</option>
				{/section}
				</select>
				<input type="submit" class="button" value="{#FORUMS_GO_TO#}" />
			</form>
		</td>
	</tr>
</table>
<!-- /Forum Selektor Template -->