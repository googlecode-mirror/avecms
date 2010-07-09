<script language="javascript">
function check_nl() {ldelim}
	if (document.getElementById('ugs').value=='') {ldelim}
		alert('{#SNL_SELECT_GROUPS#}');
		document.getElementById('ugs').focus();
		return false;
	{rdelim}

	if (document.getElementById('from').value=='') {ldelim}
		alert('{#SNL_NO_SENDER#}');
		document.getElementById('from').focus();
		return false;
	{rdelim}

	if (document.getElementById('frommail').value=='') {ldelim}
		alert('{#SNL_NO_SENDER_EMAIL#}');
		document.getElementById('frommail').focus();
		return false;
	{rdelim}

	if (document.getElementById('newsletter_title').value=='') {ldelim}
		alert('{#SNL_ENTER_TITLE#}');
		document.getElementById('newsletter_title').focus();
		return false;
	{rdelim}

	if (document.getElementById('radio_text').checked == true && document.getElementById('text_norm').value=='') {ldelim}
		alert('{#SNL_ENTER_TEXT#}');
		document.getElementById('text_norm').focus();
		return false;
	{rdelim}

	if (confirm('{#SNL_CONFIRM_SEND#}')) {ldelim}
		document.getElementById('butt_send').disabled=true;
		return true;
	{rdelim}

	return false;
{rdelim}
</script>

<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#SNL_MODULE_NAME#}</h2></div>
	<div class="HeaderText">{#SNL_NEW_INFO#}</div>
</div><br />

<form onsubmit="return check_nl();" action="index.php?do=modules&action=modedit&mod=newsletter&moduleaction=new&cp={$sess}&sub=send&pop=1" method="post" enctype="multipart/form-data">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="220" />
		<tr class="tableheader">
			<td>{#SNL_NEW_PARAM#}</td>
			<td>{#SNL_NEW_VALUE#}</td>
		</tr>
		<tr>
			<td valign="top" class="first">{#SNL_NEW_GROUPS#}<br /><small>{#SNL_NEW_GROUPS_INFO#}</small></td>
			<td class="second">
				<select id="ugs" name="usergroups[]" size="5" multiple="multiple" style="width:200px">
					{foreach from=$usergroups item=usergroup}
						<option value="{$usergroup->user_group}" selected="selected">{$usergroup->user_group_name|escape}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td class="first">{#SNL_NEW_SENDER#}</td>
			<td class="second"><input name="from" type="text" id="from" value="{$from}" style="width:98%" /></td>
		</tr>

		<tr>
			<td class="first">{#SNL_NEW_EMAIL#}</td>
			<td class="second"><input name="frommail" type="text" id="frommail" value="{$frommail}" style="width:98%" /></td>
		</tr>

		<tr>
			<td class="first">{#SNL_NEW_TITLE#}</td>
			<td class="second"><input name="newsletter_title" type="text" id="newsletter_title" style="width:98%" /></td>
		</tr>

		<tr>
			<td class="first">{#SNL_NEW_FORMAT#}</td>
			<td class="second">
				<label>
					<input id="radio_text" type="radio" name="type" value="text" checked="checked" onclick="document.getElementById('ed2').style.height='0'; document.getElementById('ed1').style.display=''" />{#SNL_NEW_TEXT#}
				</label>
				<label>
					<input type="radio" name="type" value="html" onclick="document.getElementById('ed2').style.height='300px'; document.getElementById('ed1').style.display='none'" />{#SNL_NEW_HTML#}
				</label>
			</td>
		</tr>

		<tr>
			<td colspan="2" class="first">
				<div id="ed1">
					<textarea name="text_norm" cols="50" rows="15" id="text_norm" style="width:98%;height:300px">{#SNL_NEW_TEMPLATE#}</textarea>
				</div>
				<div id="ed2" style="height:0;overflow:hidden">{$Editor}</div>
			</td>
		</tr>

		{section name=attach loop=3}
			<tr>
				<td class="first">{#SNL_NEW_ATTACH#} {$smarty.section.attach.index+1} </td>
				<td class="second"><input name="upfile[]" type="file" id="upfile[]" size="40" /></td>
			</tr>
		{/section}

		<tr>
			<td class="first">{#SNL_DEL_ATTACH#} <small>{#SNL_DEL_ATTACH_INFO#}</small></td>
			<td class="second">
				<input type="radio" name="delattach" value="1" />{#SNL_NEW_YES#}
				<input name="delattach" type="radio" value="2" checked="checked" />{#SNL_NEW_NO#}
			</td>
		</tr>

		<tr>
			<td class="first">{#SNL_NEW_COUNT#}</td>
			<td class="second">
				<select name="steps" id="steps">
					{section name=st loop=101 start=5 step=5}
						<option value="{$smarty.section.st.index}"{if $smarty.section.st.index=='25'} selected="selected"{/if}>{$smarty.section.st.index}{#SNL_NEW_COUNT_M#}</option>
					{/section}
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="third">
				<input id="butt_send" class="button" type="submit" value="{#SNL_BUTTON_SEND#}" />
			</td>
		</tr>
	</table>
</form>