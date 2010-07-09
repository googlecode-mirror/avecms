<p><strong>{$poll->poll_title}</strong></p>
<form method="post" action="{$formaction}">
	<p>
		{foreach from=$items item=item}
			<input class="absmiddle" type="radio" name="p_item" value="{$item->id}" />&nbsp;{$item->poll_item_title}<br />
		{/foreach}
	</p>
	<input type="submit" style="width:80px" class="button" value="{#POLL_BUTTON_VOTE#}" />&nbsp;
	<input type="button" style="width:80px" class="button" value="{#POLL_PUB_RESULTS#}" onclick="location.href='{$formaction_result}';" />
</form>