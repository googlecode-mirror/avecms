{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/shop_topnav.tpl"}

<h4>{#ProductManufacturers#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=manufacturer&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td width="1%" class="tableheader" align="center"><img src="{$tpl_dir}/images/icon_del.gif" alt="" /></td>
			<td width="160" class="tableheader">{#ManufacturerName#}</td>
			<td width="160" class="tableheader">{#ManufacturerLink#}</td>
			<td width="160" class="tableheader">{#ManufacturerLogo#}</td>
			<td width="140" class="tableheader">&nbsp;</td>
			<td class="tableheader">&nbsp;</td>
		</tr>

		{foreach from=$Manufacturer item=ss}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="1%" align="center">
					<input title="{#Delete#}" name="Del[{$ss->Id}]" type="checkbox" value="1" />
				</td>
				<td>
					<input style="width:160px" type="text" name="Name[{$ss->Id}]" value="{$ss->Name|stripslashes}" />
				</td>
				<td>
					<input style="width:160px" type="text" name="Link[{$ss->Id}]" value="{$ss->Link|stripslashes}" />
				</td>
				<td>
					<input style="width:160px" type="text" name="Logo[{$ss->Id}]" value="{$ss->Logo|stripslashes}" id="img_feld__{$ss->Id}" />
				</td>
				<td>
					{if $ss->Logo != ''}<img id="_img_feld__{$ss->Id}" src="../index.php?thumb={$ss->Logo}&height=30" />{/if}
					<div id="feld_{$ss->Id}"><img id="_img_feld__{$ss->Id}" src="templates/apanel/images/blanc.gif" alt="" border="0" /></div>
					<div style="display:none" id="span_feld__{$ss->Id}">&nbsp;</div>
				</td>
				<td>
					<input value="{#OpenMediapool#}" class="button" type="button" onclick="cp_imagepop('img_feld__{$ss->Id}','','','0');" />
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#ButtonSave#}">
</form>

<h4>{#ProductManufacturerNew#}</h4>

<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=manufacturer_new&cp={$sess}">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td width="20" class="first">&nbsp;</td>
			<td width="160" class="first">
				<input style="width:160px" type="text" name="Name" value="{#SShipperName#}" />
			</td>
			<td width="160" class="first">
				<input style="width:160px" type="text" name="Link" value="{#SShipperLink#}" />
			</td>
			<td width="160" class="first">
				<input style="width:160px" type="text" name="Logo" value="{#SShipperLogo#}" id="img_feld__0" />
			</td>
			<td width="140" class="first">
				<div id="feld_0"><img id="_img_feld__0" src="templates/apanel/images/blanc.gif" alt="" border="0" /></div>
				<div style="display:none" id="span_feld__0">&nbsp;</div>
			</td>
			<td class="first">
				<input value="{#OpenMediapool#}" class="button" type="button" onclick="cp_imagepop('img_feld__0','','','0');" />&nbsp;
				<input type="submit" class="button" value="{#ButtonSave#}" />
			</td>
		</tr>
	</table>
</form>

{/strip}