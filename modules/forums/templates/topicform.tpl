<table width="100%" cellpadding="4" cellspacing="1" class="forum_tableborder">
	<tr>
		<td class="forum_post_first" style="width: 20%">{#TopicTitle#}</td>
		<td class="forum_post_second">
			<input class="inputfield" type="text" name="topic" value="{$topic|escape:'html'|stripslashes}" maxlength="200" size="50" />
		</td>
	</tr>
	<tr>
		<td class="lastthreads_first" valign="top">{#TopicIcon#}</td>
		<td class="forum_post_second">
			{foreach from=$posticons item=posticon}
				{$posticon}
			{/foreach}
		</td>
	</tr>
</table>
<br />