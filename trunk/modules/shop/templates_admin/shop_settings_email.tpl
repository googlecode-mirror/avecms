<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/shop_topnav.tpl"}

<h4>{#EmailSettings#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=email_settings&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="300" valign="top" class="first">
		<col class="second">
		<tr>
			<td class="tableheader">{#SettingsName#}</td>
			<td class="tableheader">{#SettingsValue#}</td>
		</tr>

		<tr>
			<td>{#SFormatEmail#}</td>
			<td>
				<input type="radio" value="html" name="EmailFormat"{if $row->EmailFormat=='html'} checked{/if} /> {#SFormatHTML#}
				<input type="radio" value="text" name="EmailFormat"{if $row->EmailFormat=='text'} checked{/if} /> {#SFormatText#}
			</td>
		</tr>

		<tr>
			<td>
				{#CompanyLogo#}<br />
				<small>{#CompanyLogoInf#}</small>
			</td>
			<td>
				{if $row->Logo!=''}<img src="{$row->Logo}" /><br />{/if}
				<input name="Logo" type="text" id="Logo" value="{$row->Logo|default:'http://'}" size="50" />
			</td>
		</tr>

		<tr>
			<td>{#SEmailCopy#}</td>
			<td>
				<input name="EmpEmail" type="text" id="EmpEmail" value="{$row->EmpEmail}" size="50" />
			</td>
		</tr>

		<tr>
			<td>{#SEmailSender#}</td>
			<td>
				<input name="AbsEmail" type="text" id="AbsEmail" value="{$row->AbsEmail}" size="50" />
			</td>
		</tr>

		<tr>
			<td>{#SSender#}</td>
			<td>
				<input name="AbsName" type="text" id="AbsName" value="{$row->AbsName}" size="50" />
			</td>
		</tr>

		<tr>
			<td>{#SSubjectOrders#}</td>
			<td>
				<input name="BetreffBest" type="text" id="BetreffBest" value="{$row->BetreffBest|stripslashes}" size="50" />
			</td>
		</tr>

		<tr>
			<td>{#STextfooter#}</td>
			<td>
				<textarea style="width:90%; height:100px" name="AdresseText">{$row->AdresseText|escape:html|stripslashes}</textarea>
			</td>
		</tr>

		<tr>
			<td>{#SHTMLfooter#}</td>
			<td><textarea style="width:90%; height:100px" name="AdresseHTML">{$row->AdresseHTML|stripslashes}</textarea></td>
		</tr>
	</table><br />

	<input accesskey="s" type="submit" value="{#ButtonSave#}" class="button" />
</form>