<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#FAQ_EDIT#}</h2></div>
	<div class="HeaderText">{#FAQ_EDIT_TIP#}</div>
</div><br />

<div class="infobox">
	<a href="index.php?do=modules&action=modedit&mod=faq&moduleaction=questedit&fid={$smarty.get.fid}&cp={$sess}">{#FAQ_ADD_QUEST#}</a>
	&nbsp;|&nbsp;
	<a href="index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp={$sess}">{#FAQ_BACK#}</a>
</div><br />

{if !$questions}
	<h4 class="error" style="color:#800">{#FAQ_NO_ITEMS#}</h4>
{else}
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="40%" />
		<col width="50%" />
		<col width="1%" />
		<col width="1%" />
		<tr class="tableheader">
			<td>{#FAQ_QUEST#}</td>
			<td>{#FAQ_ANSWER#}</td>
			<td colspan="2">{#FAQ_ACTIONS#}</td>
		</tr>
		{foreach from=$questions item=question}
			<tr style="background-color:#eff3eb" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td>
					{$question->faq_quest|strip_tags|escape|truncate:60}
				</td>

				<td>
					{$question->faq_answer|strip_tags|escape|truncate:80}
				</td>

				<td align="center">
					<a title="{#FAQ_QEDIT_HINT#}" href="index.php?do=modules&action=modedit&mod=faq&moduleaction=questedit&fid={$smarty.get.fid}&id={$question->id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
				</td>

				<td align="center">
					<a title="{#FAQ_QDELETE_HINT#}" href="index.php?do=modules&action=modedit&mod=faq&moduleaction=questdel&fid={$smarty.get.fid}&id={$question->id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /></a>
				</td>
			</tr>
		{/foreach}
	</table><br />
{/if}