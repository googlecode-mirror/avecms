<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#FAQ_EDIT#}</h2></div>
	<div class="HeaderText">{#FAQ_EDIT_TIP#}</div>
</div><br>

<div class="infobox">
	<a href="index.php?do=modules&action=modedit&mod=faq&moduleaction=questedit&cp={$sess}&faq_id={$faq_id}&id=">{#FAQ_ADD_QUEST#}</a>
	&nbsp;|&nbsp;
	<a href="index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp={$sess}">{#FAQ_BACK#}</a>
</div><br />

{if $faq_arr}
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td width="40%">{#FAQ_QUEST#}</td>
			<td width="50%">{#FAQ_ANSWER#}</td>
			<td width="2%" colspan="2">{#FAQ_ACTIONS#}</td>
		</tr>
		{foreach from=$faq_arr item=item}
			<tr style="background-color:#eff3eb" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td>
					{$item->faq_quest|strip_tags|escape|truncate:40}
				</td>

				<td>
					{$item->faq_answer|strip_tags|escape|truncate:60}
				</td>

				<td align="center">
					<a title="{#FAQ_QEDIT_HINT#}" href="index.php?do=modules&action=modedit&mod=faq&moduleaction=questedit&cp={$sess}&id={$item->id}"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
				</td>

				<td align="center">
					<a title="{#FAQ_QDELETE_HINT#}" href="index.php?do=modules&action=modedit&mod=faq&moduleaction=questdel&cp={$sess}&id={$item->id}"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /></a>
				</td>
			</tr>
		{/foreach}
	</table><br />
{else}
	<h4 class="error" style="color:#800">{#FAQ_NO_ITEMS#}</h4>
{/if}