<script language="javascript">
function update_message() {ldelim}
	if(document.getElementById('s_ok').selected == true){ldelim}
		var Inner = '{#ProductOrdersSMessageOk#}';
		var Subject = '{#ProductOrdersSMessageOkSubject#}';
	{rdelim}
	else if(document.getElementById('s_wait').selected == true){ldelim}
		var Inner = '{#ProductOrdersSMessageWait#}';
		var Subject = '{#ProductOrdersSMessageWaitSubject#}';
	{rdelim}
	else if(document.getElementById('s_ok_send').selected == true){ldelim}
		var Inner = '{#ProductOrdersSMessageOkSend#}';
		var Subject = '{#ProductOrdersSMessageOkSendSubject#}';
	{rdelim}
	else if(document.getElementById('s_progress').selected == true){ldelim}
		var Inner = '{#ProductOrdersSMessageProgress#}';
		var Subject = '{#ProductOrdersSMessageProgressSubject#}';
	{rdelim}
	else if(document.getElementById('s_failed').selected == true){ldelim}
		var Inner = '{#ProductOrdersSMessageFailed#}';
		var Subject = '{#ProductOrdersSMessageFailedSubject#}';
	{rdelim}
	else if(document.getElementById('s_n').selected == true){ldelim}
		var Inner = '';
		var Subject = '';
	{rdelim}
	document.getElementById('MSubject').value = Subject;
	document.getElementById('Mwin').innerHTML = Inner;
{rdelim}

function check_form() {ldelim}
	if(document.getElementById('SSelect').value == '' || document.getElementById('SSelect').value == '0'){ldelim}
		alert('{#ProductOrdersSNoStatusSelceted#}');
		// document.getElementById('s_ok').selected = true;
		document.getElementById('SSelect').focus();
		return false;
	{rdelim}
{rdelim}
</script>

{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ProductOrdersSEdit#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

<form onsubmit="return check_form();" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=showorder&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=save" method="post"{* enctype="multipart/form-data"*}>
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="first">{#ProductOrdersSIP#}</td>
			<td class="second"><a href="http://www.ripe.net/perl/whois?query={$row.Ip}&.submit=Submit+Query" target="_blank">{$row.Ip}</a> ({$row.IPC})</td>
		</tr>

		<tr>
			<td width="170" class="first">{#ProductOrdersSStatus#}</td>
			<td class="second">
				<select id="SSelect" name="Status" onchange="update_message();">
					<option id="s_n" value="0"></option>
					<option id="s_wait" value="wait">{#OrdersStatusWait#}</option>
					<option id="s_ok" value="ok">{#OrdersStatusOk#}</option>
					<option id="s_ok_send" value="ok_send">{#OrdersStatusOkSend#}</option>
					<option id="s_progress" value="progress">{#OrdersStatusProgress#}</option>
					<option id="s_failed" value="failed">{#OrdersStatusFailed#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td width="170" class="first">{#ProductOrdersSSubject#}</td>
			<td class="second">
				<input style="width:100%" id="MSubject" type="text" name="Subject" />
			</td>
		</tr>

		<tr>
			<td width="170" valign="top" class="first">
				{#ProductOrdersSMessage#}<br />
				<small>{#ProductOrdersSOrderTextInf#}</small>
			</td>
			<td class="second">
				<textarea name="Message" id="Mwin" style="width:100%;height:140px"></textarea>
			</td>
		</tr>

		<tr>
			<td width="170" valign="top" class="first">
				{#ProductOrdersSOrderText#}<br />
				<small>{#ProductOrdersSOrderInf#}</small></td>
			<td class="second">
				<textarea name="Text" style="width:100%;height:170px">{$text}</textarea>
			</td>
		</tr>

		<tr>
			<td width="170" valign="top" class="first">{#ProductOrdersSOrderHtml#}</td>
			<td class="second"> {$html}</td>
		</tr>

		<tr>
			<td class="first">{#MessageUser#}</td>
			<td class="second">
				<textarea name="NachrichtBenutzer" style="width:100%;height:80px">{$row.NachrichtBenutzer|escape:html|stripslashes}</textarea>
			</td>
		</tr>

		<tr>
			<td class="first">{#MessageAdmin#}</td>
			<td class="second">
				<textarea name="NachrichtAdmin" style="width:100%;height:80px">{$row.NachrichtAdmin|escape:html|stripslashes}</textarea>
			</td>
		</tr>

		<tr>
			<td class="first">{#ProductOrdersSOverAll#}</td>
			<td class="second">
				<input name="Gesamt" type="text" id="Gesamt" value="{$row.Gesamt}" />
			</td>
		</tr>

		<tr>
			<td class="first">{#ProductOrdersSSendMailOk#}</td>
			<td class="second">
				<input name="SendMail" type="checkbox" id="SendMail" value="1" checked="checked" />
			</td>
		</tr>

		<tr>
			<td class="first">{#ProductOrdersSStoreSubt#}</td>
			<td class="second">
				<input name="StoreSubt" type="checkbox" id="StoreSubt" value="1" checked="checked" />
			</td>
		</tr>

		<tr>
			<td width="170" class="first">&nbsp;</td>
			<td class="second">
				<input accesskey="s" class="button" type="submit" value="{#ProductOrdersSSendButton#}" />
			</td>
		</tr>
	</table>
</form>

{/strip}