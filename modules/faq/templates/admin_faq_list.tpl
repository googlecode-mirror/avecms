<script type="text/javascript" language="JavaScript">
function check_title() {ldelim}
	if (document.getElementById('new_faq_title').value == '') {ldelim}
		alert('{#FAQ_ENTER_NAME#}');
		document.getElementById('new_faq_title').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#FAQ_LIST#}</h2></div>
	<div class="HeaderText">{#FAQ_LIST_TIP#}</div>
</div><br />

{if !$faq_arr}
	<h4 style="color:#800">{#FAQ_NO_ITEMS#}</h4>
{else}
	<form method="post" action="index.php?do=modules&action=modedit&mod=faq&moduleaction=save&cp={$sess}">
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			<col />
			<col />
			<col width="100" />
			<col width="10" />
			<col width="10" />
			<tr class="tableheader">
				<td>{#FAQ_NAME#}</td>
				<td>{#FAQ_DESC#}</td>
				<td>{#FAQ_TAG#}</td>
				<td colspan="2">{#FAQ_ACTIONS#}</td>
			</tr>
			{foreach from=$faq_arr item=faq}
				<tr style="background-color:#eff3eb" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
					<td>
						<input style="width:100%" name="faq_title[{$faq->id}]" type="text" id="faq_title[{$faq->id}]" value="{$faq->faq_title|escape}" size="40" />
					</td>

					<td>
						<input style="width:100%" name="faq_description[{$faq->id}]" type="text" id="faq_description[{$faq->id}]" value="{$faq->faq_description|escape}" size="40" />
					</td>

					<td>
						<input style="width:100%" name="textfield" type="text" value="[mod_faq:{$faq->id}]" readonly />
					</td>

					<td align="center">
						<a title="{#FAQ_EDIT_HINT#}" href="index.php?do=modules&action=modedit&mod=faq&moduleaction=questlist&fid={$faq->id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
					</td>

					<td align="center">
						<a title="{#FAQ_DELETE_HINT#}" href="index.php?do=modules&action=modedit&mod=faq&moduleaction=del&fid={$faq->id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /></a>
					</td>
				</tr>
			{/foreach}
			<tr>
				<td colspan="5" class="third"><input type="submit" class="button" value="{#FAQ_BUTTON_SAVE#}" /></td>
			</tr>
		</table><br />
	</form>
{/if}

<h4>{#FAQ_ADD#}</h4>

<form action="index.php?do=modules&action=modedit&mod=faq&moduleaction=new&cp={$sess}" method="post" onSubmit="return check_title();">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td class="tableheader">{#FAQ_NAME#}</td>
			<td class="tableheader">{#FAQ_DESC#}</td>
		</tr>

		<tr>
			<td class="second"><input name="new_faq_title" type="text" id="new_faq_title" size="60" maxlength="100" style="width:100%" /></td>
			<td class="second"><input name="new_faq_desc" type="text" id="new_faq_desc" size="60" maxlength="255" style="width:100%" /></td>
		</tr>

		<tr>
			<td colspan="2" class="third"><input name="submit" type="submit" class="button" value="{#FAQ_BUTTON_ADD#}" /></td>
		</tr>
	</table>
</form>