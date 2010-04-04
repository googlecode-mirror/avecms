<!-- poll_nav_result.tpl -->
{strip}
<p><strong>{$poll->title}</strong></p>
<p>
	{foreach from=$items item=item}
		<div style="padding:2px">{$item->title}</div>
		<div style="width:98%;height:5px;padding:0">
			<div style="display:block;background-color:{$item->color};height:5px;width:{$item->sum|default:'0'}%"></div>
		</div>
		<small style="color:{$item->color}">{#POLL_VOTES#} {$item->hits} ({$item->sum|default:'0'}%)</small>
	{/foreach}
</p>
{if $poll->message != ''}<p><small>{$poll->message}</small></p>{/if}
<form method="post">
	<input type="button" class="button" style="width:100px" onclick="location.href='{$formaction_result}';" value="{#POLL_PUB_RESULTS#} ({$poll->sumhits})" />&nbsp;
	<input type="button" class="button" style="width:50px" onclick="location.href='{$formaction_archive}';" value="{#POLL_VIEW_ARCHIVES#}" />
</form>
{/strip}
<!-- /poll_nav_result.tpl -->