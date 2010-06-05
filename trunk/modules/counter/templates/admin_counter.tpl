<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('Name').value == '') {ldelim}
		alert("{#COUNTER_ENTER_NAME#}");
		document.getElementById('Name').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#COUNTER_MODULE_NAME#}</h2>
	</div>
	<div class="HeaderText">{#COUNTER_MODULE_INFO#}</div>
</div><br />

<form method="post" action="index.php?do=modules&action=modedit&mod=counter&moduleaction=quicksave&cp={$sess}">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="20">
		<col>
		<col width="110">
		<col width="70">
		<col width="70">
		<col width="70">
		<col width="70">
		<col width="70">
		<col width="70">
		<tr class="tableheader">
			<td align="center"><img src="{$tpl_dir}/images/icon_del.gif" alt="" /></td>
			<td nowrap="nowrap">{#COUNTER_NAME_TABLE#}</td>
			<td nowrap="nowrap">{#COUNTER_SYSTEM_TAG#}</td>
			<td nowrap="nowrap" align="center">{#COUNTER_SHOW_ALL#}</td>
			<td nowrap="nowrap" align="center">{#COUNTER_SHOW_TODAY#}</td>
			<td nowrap="nowrap" align="center">{#COUNTER_SHOW_YESTERDAY#}</td>
			<td nowrap="nowrap" align="center">{#COUNTER_SHOW_MONTH#}</td>
			<td nowrap="nowrap" align="center">{#COUNTER_SHOW_YEAR#}</td>
			<td nowrap="nowrap" align="center">{#COUNTER_ACTION_TABLE#}</td>
		</tr>

		{foreach from=$items item=item}
			<tr style="background-color:#eff3eb" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td><input type="checkbox" name="del[{$item->id}]" id="del[{$item->id}]" value="1" title="{#COUNTER_MARK_DELETE#}" /></td>
				<td><input type="text" name="counter_name[{$item->id}]" id="counter_name[{$item->id}]" value="{$item->counter_name|escape:html|stripslashes}" size="60" maxlength="50" /></td>
				<td><input type="text" name="CpEngineTag{$item->id}" id="CpEngineTag_{$item->id}" value="[mod_counter:{$item->id}]" readonly="" style="width:100%" /></td>
				<td align="center">{$item->all}</td>
				<td align="center">{$item->today}</td>
				<td align="center">{$item->yesterday}</td>
				<td align="center">{$item->prevmonth}</td>
				<td align="center">{$item->prevyear}</td>
				<td align="center">
					<a title="{#COUNTER_SHOW_MORE#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=counter&moduleaction=view_referer&id={$item->id}&cp={$sess}&pop=1','960','700','1','modcontactedit');">
						<img src="{$tpl_dir}/images/icon_look.gif" alt="" border="0" />
					</a>
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#COUNTER_BUTTON_SAVE#}" />
</form>

<h4>{#COUNTER_NEW_COUNTER#}</h4>

<form method="post" action="index.php?do=modules&action=modedit&mod=counter&moduleaction=new_counter&cp={$sess}" onSubmit="return check_name();">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td>{#COUNTER_NAME_COUNTER#}</td>
		</tr>

		<tr>
			<td class="first">
				<input name="counter_name" type="text" id="Name" size="60" maxlength="50" />&nbsp;
				<input type="submit" class="button"  value="{#COUNTER_BUTTON_CREATE#}" />
			</td>
		</tr>
	</table>
</form>