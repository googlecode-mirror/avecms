{strip}

<h4>{#ProductPrice#}</h4>

<form name="form1" method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=staffel_preise&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=save">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td colspan="4" class="tableheader">{#PriceSt#}</td>
		</tr>

		<tr>
			<td width="100" class="second">{#FromSt#}</td>
			<td width="100" class="second">{#ToStk#} </td>
			<td width="100" class="second">{#NewPrice#}</td>
			<td class="second">{#DownDel#}</td>
		</tr>

		{foreach from=$Stf item=item}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="100"><input name="StkVon[{$item->Id}]" type="text" value="{$item->StkVon}" /></td>
				<td width="100"><input name="StkBis[{$item->Id}]" type="text" value="{$item->StkBis}" /></td>
				<td width="100"><input name="Preis[{$item->Id}]" type="text" value="{$item->Preis}" /></td>
				<td><input name="Del[{$item->Id}]" type="checkbox" value="1" /></td>
			</tr>
		{/foreach}
	</table>

	<p><input type="submit" class="button" value="{#ButtonSave#}"></p>
</form><br />
<br />

<form name="form1" method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=staffel_preise&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=new">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td colspan="3" class="tableheader">Neue Staffelung</td>
		</tr>

		<tr>
			<td width="100" class="second">{#FromSt#}</td>
			<td width="100" class="second">{#ToStk#}</td>
			<td class="second">{#NewPrice#}</td>
		</tr>

		<tr>
			<td width="100"><input name="Von" type="text" id="Von" value="5" /></td>
			<td width="100"><input name="Bis" type="text" id="Bis" value="10" /></td>
			<td><input name="Preis" type="text" id="Preis" value="49,90" /></td>
		</tr>
	</table>

	<p><input type="submit" class="button" value="{#ButtonSave#}" /></p>
</form>

<p>&nbsp;</p>

<hr noshade="noshade" size="1">

<p align="center">
	<input type="button" onclick="window.close();" class="button" value="{#WindowClose#}" />
</p>

{/strip}