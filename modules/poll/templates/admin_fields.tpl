<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	{if $smarty.request.moduleaction == 'new'}
		<div class="HeaderTitle"><h2>{#POLL_ADD_POLL#}</h2></div>
		<div class="HeaderText">{#POLL_NEW_INFO#}</div>
	{else}
		<div class="HeaderTitle"><h2>{#POLL_EDIT#}</h2></div>
		<div class="HeaderText">{#POLL_EDIT_INFO#}</div>
	{/if}
</div><br />

<form method="post" action="{$formaction}">
	{include file="$tpl_dir/admin_pollsettings.tpl"}<br />
	{if $smarty.request.id != ''}
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			<tr class="tableheader">
				<td align="center" width="1%"><img src="{$tpl_dir}/images/icon_del.gif" alt="" /></td>
				<td>{#POLL_QUESTION_NAME#}</td>
				<td>{#POLL_QUESTION_COLOR#} </td>
				<td>{#POLL_QUESTION_POSI#}</td>
				<td>{#POLL_QUESTION_HITS#}</td>
			</tr>

			{foreach from=$items item=item}
				<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
					<td width="1%"><input title="{#POLL_MARK_DELETE#}" name="del[{$item->id}]" type="checkbox" id="del[{$item->id}]" value="1" /></td>
					<td width="30%"><input style="width:250px" name="item_title[{$item->id}]" type="text" id="item_title[{$item->id}]" value="{$item->poll_item_title}" /></td>
					<td width="20%">
						<input maxlength="7" onblur="document.getElementById('b[{$item->id}]').style.background = this.value;" style="width:100px" type="text" name="line_color[{$item->id}]" value="{$item->poll_item_color}" />
						<input disabled type="button" id="b[{$item->id}]" style="background:{$item->poll_item_color}" value="&nbsp;&nbsp;">
					</td>
					<td width="12%"><input name="position[{$item->id}]" type="text" id="position[{$item->id}]" size="5" maxlength="3" value="{$item->poll_item_position}" /></td>
					<td width="20%"><input style="width:80px" name="poll_item_hits[{$item->id}]" type="text" id="poll_item_hits[{$item->id}]" value="{$item->poll_item_hits}" /></td>
				</tr>
			{/foreach}

			<tr class="second">
				<td colspan="5"><input type="submit" class="button" value="{#POLL_BUTTON_SAVE#}" /></td>
			</tr>
		</table>
	{/if}
</form>

{if $smarty.request.id != ''}
	<h4>Добавить новый вопрос</h4>
	<form method="post" action="index.php?do=modules&action=modedit&mod=poll&moduleaction=save_new&cp={$sess}&id={$smarty.request.id|escape}&pop=1" name="new">
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			<tr class="tableheader">
				<td>{#POLL_QUESTION_NAME#}</td>
				<td>{#POLL_QUESTION_COLOR#} </td>
				<td>{#POLL_QUESTION_POSI#}</td>
				<td>{#POLL_QUESTION_HITS#}</td>
			</tr>

			<tr class="first">
				<td width="30%"><input style="width:250px" name="item_title" type="text" id="item_title" value="" /></td>
				<td width="20%">
					<input maxlength="7" onblur="document.getElementById('b').style.background = this.value;" style="width:100px" type="text" name="line_color" value="" />
					<input disabled type="button" id="b" style="background:" value="&nbsp;&nbsp;">
				</td>
				<td width="12%"><input name="position" type="text" id="position" size="5" maxlength="3" value="" /></td>
				<td width="20%"><input style="width:80px" name="poll_item_hits" type="text" id="poll_item_hits" value="" /></td>
			</tr>

			<tr class="second">
				<td colspan="4"><input type="submit" class="button" value="{#POLL_BUTTON_ADD#}" /></td>
			</tr>
		</table>
	</form>
{/if}