<p><strong>{$poll->poll_title}</strong></p>
<p>
	{foreach from=$items item=item}
		<div style="padding:2px">{$item->poll_item_title}</div>
		<div style="width:98%;height:5px;padding:0">
			<div style="display:block;background-color:{$item->poll_item_color};height:5px;width:{$item->sum|default:'0'}%"></div>
		</div>
		<small style="color:{$item->poll_item_color}">{#POLL_VOTES#} {$item->poll_item_hits} ({$item->sum|default:'0'}%)</small>
	{/foreach}
</p>
{if $poll->message != ''}<p><small>{$poll->message}</small></p>{/if}
<form method="post">
	<input type="button" class="button" style="width:100px" onclick="location.href='{$formaction_result}';" value="{#POLL_PUB_RESULTS#} ({$poll->sumhits})" />&nbsp;
	<input type="button" class="button" style="width:50px" onclick="location.href='{$formaction_archive}';" value="{#POLL_VIEW_ARCHIVES#}" />
</form>