<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/shop_topnav.tpl"}

<h4>{#EditHelpPages#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=helppages&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="300" valign="top" class="first">
		<col class="second">
		<tr>
			<td class="tableheader">{#SettingsName#}</td>
			<td class="tableheader">{#SettingsValue#}</td>
		</tr>

		<tr>
			<td>{#SShopWelcomeText#}</td>
			<td>{$row->ShopWillkommen}</td>
		</tr>

		<tr>
			<td>{#ShopFooter#}</td>
			<td>{$row->ShopFuss}</td>
		</tr>

		<tr>
			<td>{#DataShippingInf#}</td>
			<td>{$row->VersandInfo}</td>
		</tr>

		<tr>
			<td>{#DataInf#}</td>
			<td>{$row->DatenschutzInf}</td>
		</tr>

		<tr>
			<td>{#Imprint#}</td>
			<td>{$row->Impressum}</td>
		</tr>

		<tr>
			<td>{#SAgb#}</td>
			<td>{$row->Agb}</td>
		</tr>
	</table><br />

	<input type="submit" value="{#ButtonSave#}" class="button" />
</form>