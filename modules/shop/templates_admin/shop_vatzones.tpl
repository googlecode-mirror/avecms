{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/shop_topnav.tpl"}

<h4>{#VatZones#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=vatzones&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td width="1%" align="center" class="tableheader"><img src="{$tpl_dir}/images/icon_18.gif" alt="" hspace="2" border="0" /></td>
			<td width="160" class="tableheader">{#VatZonesName#}</td>
			<td class="tableheader">{#VatVal#}</td>
		</tr>

		{foreach from=$vatZones item=ss}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="1%" align="center">
					<input title="{#Delete#}" type="checkbox" name="Del[{$ss->Id}]" value="1">
				</td>

				<td>
					<input style="width:160px" type="text" name="Name[{$ss->Id}]" value="{$ss->Name|stripslashes}" />
				</td>

				<td>
					<input name="Wert[{$ss->Id}]" type="text" value="{$ss->Wert}" size="10" maxlength="6" /> %
				</td>
			</tr>
		{/foreach}
 	</table><br />

 	<input type="submit" class="button" value="{#ButtonSave#}">
</form>

<h4>{#NewVatZone#}</h4>

<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=vatzones&cp={$sess}&sub=new">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="first">
				<input style="width:160px" type="text" name="Name" value="{#NewVatZoneDef#}" />&nbsp;
				<input name="Wert" type="text" id="Wert" value="18.00" size="10" maxlength="6" /> %&nbsp;
				<input type="submit" class="button" value="{#ButtonSave#}" />
			</td>
		</tr>
	</table>
</form>

{/strip}