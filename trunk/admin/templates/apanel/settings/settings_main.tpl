<script language="javascript">
function presel() {ldelim}
	document.getElementById('mail_port').disabled = false;
	document.getElementById('mail_host').disabled = false;
	document.getElementById('mail_smtp_login').disabled = false;
	document.getElementById('mail_smtp_pass').disabled = false;
	document.getElementById('mail_sendmail_path').disabled = false;

	if(document.getElementById('mail').selected == true) {ldelim}
		document.getElementById('mail_port').disabled = true;
		document.getElementById('mail_host').disabled = true;
		document.getElementById('mail_smtp_login').disabled = true;
		document.getElementById('mail_smtp_pass').disabled = true;
		document.getElementById('mail_sendmail_path').disabled = true;
	{rdelim}

	if(document.getElementById('sendmail').selected == true) {ldelim}
		document.getElementById('mail_port').disabled = true;
		document.getElementById('mail_host').disabled = true;
		document.getElementById('mail_smtp_login').disabled = true;
		document.getElementById('mail_smtp_pass').disabled = true;
	{rdelim}

	if(document.getElementById('smtp').selected == true) {ldelim}
		document.getElementById('mail_sendmail_path').disabled = true;
	{rdelim}
{rdelim}

function openLinkWindow(target,doc) {ldelim}
	if (typeof width=='undefined' || width=='') var width = screen.width * 0.6;
	if (typeof height=='undefined' || height=='') var height = screen.height * 0.6;
	if (typeof doc=='undefined') var doc = 'title';
	if (typeof scrollbar=='undefined') var scrollbar=1;
	window.open('index.php?idonly=1&doc='+doc+'&target='+target+'&do=docs&action=showsimple&cp={$sess}&pop=1','pop','left=0,top=0,width='+width+',height='+height+',scrollbars='+scrollbar+',resizable=1');
{rdelim}
</script>

<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_settings">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#SETTINGS_MAIN_TITLE#}</h2></div>
	<div class="HeaderText">{if $smarty.request.saved==1}{#SETTINGS_SAVED#}{else}{#SETTINGS_SAVE_INFO#}{/if}</div>
</div>
<div class="upPage">&nbsp;</div><br />

<h4>{#SETTINGS_INFO#}</h4>

<table cellspacing="1" cellpadding="8" border="0" width="100%">
	<tr>
		<td class="second">
			<div id="otherLinks">
				<a href="index.php?do=settings&amp;sub=countries&amp;cp={$sess}">
					<div class="taskTitle">{#MAIN_COUNTRY_EDIT#}</div>
				</a>
			</div>
		</td>
	</tr>
</table>

<h4>{#SETTINGS_MAIN_SETTINGS#}</h4>
<body onLoad="presel();">
<form onSubmit="return confirm('{#SETTINGS_SAVE_CONFIRM#}')"  name="settings" method="post" action="index.php?do=settings&cp={$sess}&sub=save">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="300" valign="top" class="first">
		<col class="second">
		<tr>
			<td class="tableheader">{#SETTINGS_NAME#}</td>
			<td class="tableheader">{#SETTINGS_VALUE#}</td>
		</tr>

		<tr>
			<td>{#SETTINGS_SITE_NAME#}</td>
			<td><input name="site_name" type="text" id="site_name" style="width:550px" value="{$row.site_name}" maxlength="200" /></td>
		</tr>

		<tr>
			<td>{#SETTINGS_SITE_COUNTRY#}</td>
			<td>
				<select name="default_country" style="width:250px">
					{foreach from=$available_countries item=land}
						<option value="{$land->country_code}"{if $row.default_country==$land->country_code} selected{/if}>{$land->country_name}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td>{#SETTINGS_DATE_FORMAT#}</td>
			<td>
				<select name="date_format" style="width:250px">
					{foreach from=$date_formats item=date_format}
						<option value="{$date_format}"{if $row.date_format==$date_format} selected{/if}>{$smarty.now|date_format:$date_format|pretty_date}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td>{#SETTINGS_TIME_FORMAT#}</td>
			<td>
				<select name="time_format" style="width:250px">
					{foreach from=$time_formats item=time_format}
						<option value="{$time_format}"{if $row.time_format==$time_format} selected{/if}>{$smarty.now|date_format:$time_format|pretty_date}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td>{#SETTINGS_EMAIL_NAME#}</td>
			<td><input name="mail_from_name" type="text" id="mail_from_name" style="width:250px" value="{$row.mail_from_name}" size="100" /></td>
		</tr>

		<tr>
			<td>{#SETTINGS_EMAIL_SENDER#}</td>
			<td>
				<input name="mail_from" type="text" id="mail_from" style="width:250px" value="{$row.mail_from}" size="100" />
				<input type="hidden" name="mail_content_type" id="mail_content_type" value="text/plain" />
			</td>
		</tr>

		<tr>
			<td>{#SETTINGS_MAIL_TRANSPORT#}</td>
			<td>
				<select style="width:250px" name="mail_type" id="mail_type" onChange="presel();" >
					<option id="mail" value="mail"{if $row.mail_type=='mail'} selected{/if}>{#SETTINGS_MAIL#}</option>
					<option id="smtp" value="smtp"{if $row.mail_type=='smtp'} selected{/if}>{#SETTINGS_SMTP#}</option>
					<option id="sendmail" value="sendmail"{if $row.mail_type=='sendmail'} selected{/if}>{#SETTINGS_SENDMAIL#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td>{#SETTINGS_MAIL_PORT#}</td>
			<td><input name="mail_port" type="text" id="mail_port" value="{$row.mail_port}" size="2" maxlength="5" style="width:50px" /></td>
		</tr>

		<tr>
			<td>{#SETTINGS_SMTP_SERVER#}</td>
			<td><input name="mail_host" type="text" id="mail_host" style="width:250px" value="{$row.mail_host}" size="100" /></td>
		</tr>

		<tr>
			<td>{#SETTINGS_SMTP_NAME#}</td>
			<td><input name="mail_smtp_login" type="text" id="mail_smtp_login" style="width:250px" value="{$row.mail_smtp_login}" size="100" /></td>
		</tr>

		<tr>
			<td>{#SETTINGS_SMTP_PASS#}</td>
			<td><input name="mail_smtp_pass" type="text" id="mail_smtp_pass" style="width:250px" value="{$row.mail_smtp_pass}" size="100" /></td>
		</tr>

		<tr>
			<td>{#SETTINGS_MAIL_PATH#}</td>
			<td><input name="mail_sendmail_path" type="text" id="mail_sendmail_path" style="width:250px" value="{$row.mail_sendmail_path}" size="100"></td>
		</tr>

		<tr>
			<td>{#SETTINGS_USE_DOCTIME#}</td>
			<td>
				<input type="radio" name="use_doctime" value="1"{if $row.use_doctime==1} checked{/if} />{#SETTINGS_YES#}&nbsp;
				<input type="radio" name="use_doctime" value="0"{if $row.use_doctime==0} checked{/if} />{#SETTINGS_NO#}
			</td>
		</tr>
		
		<tr>
			<td>{#SETTINGS_USE_EDITOR#}</td>
			<td>
				<input type="radio" name="use_editor" value="0"{if $row.use_editor==0} checked{/if} />{#SETTINGS_EDITOR_STANDART#} <br>
				<input type="radio" name="use_editor" value="1"{if $row.use_editor==1} checked{/if} />{#SETTINGS_EDITOR_ELFINDER#}<br>
				<input type="radio" name="use_editor" value="2"{if $row.use_editor==2} checked{/if} disabled />{#SETTINGS_EDITOR_INNOVA#}
			</td>
		</tr>

		<tr>
			<td>{#SETTINGS_SYMBOL_BREAK#}</td>
			<td><input name="mail_word_wrap" type="text" id="mail_word_wrap" value="{$row.mail_word_wrap}" size="4" maxlength="3" style="width:50px" /> {#SETTINGS_SYMBOLS#}</td>
		</tr>

		<tr>
			<td>{#SETTINGS_TEXT_EMAIL#}<br /><br /><small>{#SETTINGS_TEXT_INFO#}</small></td>
			<td><textarea name="mail_new_user" id="mail_new_user" style="width:550px; height:200px">{$row.mail_new_user|stripslashes}</textarea></td>
		</tr>

		<tr>
			<td>{#SETTINGS_EMAIL_FOOTER#}</td>
			<td><textarea name="mail_signature" id="mail_signature" style="width:550px; height:100px">{$row.mail_signature|stripslashes}</textarea></td>
		</tr>

		<tr>
			<td>{#SETTINGS_ERROR_PAGE#}</td>
			<td>
				<input name="page_not_found_id" type="text" id="page_not_found_id" value="{$row.page_not_found_id}" size="4" maxlength="10" readonly="readonly" />&nbsp;
				<input onClick="openLinkWindow('page_not_found_id','page_not_found_id');" type="button" class="button" value="... " /> {#SETTINGS_PAGE_DEFAULT#}
			</td>
		</tr>

        <tr>
            <td>{#SETTINGS_TEXT_PERM#}</td>
            <td><textarea name="message_forbidden" id="message_forbidden" style="width:550px; height:100px">{$row.message_forbidden|stripslashes}</textarea></td>
        </tr>

		<tr>
			<td>{#SETTINGS_HIDDEN_TEXT#}</td>
			<td><textarea name="hidden_text" id="hidden_text" style="width:550px; height:100px">{$row.hidden_text|stripslashes}</textarea></td>
		</tr>

		<tr>
			<td>{#SETTINGS_NAVI_BOX#}</td>
			<td><input name="navi_box" type="text" id="navi_box" style="width:550px" value="{$row.navi_box|escape|stripslashes}" /></td>
		</tr>

		<tr>
			<td>{#SETTINGS_PAGE_BEFORE#}</td>
			<td><input name="total_label" type="text" id="total_label" style="width:550px" value="{$row.total_label|stripslashes}" /></td>
		</tr>

		<tr>
			<td>{#SETTINGS_PAGE_START#}</td>
			<td><input name="start_label" type="text" id="start_label" style="width:550px" value="{$row.start_label|stripslashes}" size="100" /></td>
		</tr>

		<tr>
			<td>{#SETTINGS_PAGE_END#}</td>
			<td><input name="end_label" type="text" id="end_label" style="width:550px" value="{$row.end_label|stripslashes}" size="100" /></td>
		</tr>

		<tr>
			<td>{#SETTINGS_PAGE_SEPARATOR#}</td>
			<td><input name="separator_label" type="text" id="separator_label" style="width:550px" value="{$row.separator_label|stripslashes}" size="100" /></td>
		</tr>

		<tr>
			<td>{#SETTINGS_PAGE_NEXT#}</td>
			<td><input name="next_label" type="text" id="next_label" style="width:550px" value="{$row.next_label|stripslashes}" size="100" /></td>
		</tr>

		<tr>
			<td>{#SETTINGS_PAGE_PREV#}</td>
			<td><input name="prev_label" type="text" id="prev_label" style="width:550px" value="{$row.prev_label|stripslashes}" size="100" /></td>
		</tr>

	</table><br />

	<input type="submit" class="button" value="{#SETTINGS_BUTTON_SAVE#}" />

</form>