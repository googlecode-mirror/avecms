{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#EditShipper#}</h2></div>
	<div class="HeaderText">{#EditMethodInfo#}</div>
</div><br />

<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=editshipper&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=save">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td width="200" class="first">{#SShipperName#}</td>
			<td class="second">
				<input style="width:200px" type="text" name="Name" value="{$ss->Name|stripslashes}" />
			</td>
		</tr>

		<tr>
			<td class="first">{#ShipperDescr#}</td>
			<td class="second">
				{$ss->Beschreibung}
			</td>
		</tr>
{*
		<tr>
			<td width="200" class="first">{#SShipperActive#} </td>
			<td class="second">
				<input type="radio" name="Aktiv" value="1" {if $ss->Aktiv=='1'}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" name="Aktiv" value="0" {if $ss->Aktiv=='0'}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td width="200" class="first">{#SShipperDoCost#}</td>
			<td class="second">
				<input type="radio" name="KeineKosten" value="1" {if $ss->KeineKosten=='1'}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" name="KeineKosten" value="0" {if $ss->KeineKosten=='0'}checked="checked" {/if}/>{#No#}
			</td>
		</tr>
*}
		<tr>
			<td class="first">{#DefCost#}</td>
			<td class="second">
				<input name="Pauschalkosten" type="text" id="Pauschalkosten" value="{$ss->Pauschalkosten}" size="10" />
			</td>
		</tr>

		<tr>
			<td class="first">{#JustIfWeightNull#}</td>
			<td class="second">
				<input type="radio" name="NurBeiGewichtNull" value="1" {if $ss->NurBeiGewichtNull=='1'}checked="checked" {/if}/>{#Yes#}&nbsp;
				<input type="radio" name="NurBeiGewichtNull" value="0" {if $ss->NurBeiGewichtNull=='0'}checked="checked" {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td width="200" class="first">
				{#SScountries#}<br />
				<small>{#SSelectCountries#}</small>
			</td>
			<td class="second">
				<select name="LaenderVersand[]" multiple="multiple" size="6" style="width:200px">
					{foreach from=$laender item=g}
						{assign var='sel' value=''}
						{if $g->LandCode}
							{if (in_array($g->LandCode,$ss->VersandLaender))}
									{assign var='sel' value='selected'}
							{/if}
						{/if}
						<option value="{$g->LandCode}" {$sel}>{$g->LandName|escape:html}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td width="200" class="first">
				{#AllowedGroups#}<br />
				<small>{#AllowedGroupsInf#}</small>
			</td>
			<td class="second">
				<select name="ErlaubteGruppen[]" multiple="multiple" size="6" style="width:200px">
					{foreach from=$gruppen item=g}
						{assign var='sel' value=''}
						{if $g->Benutzergruppe}
							{if (in_array($g->Benutzergruppe,$ss->Gruppen))}
								{assign var='sel' value='selected'}
							{/if}
						{/if}
						<option value="{$g->Benutzergruppe}" {$sel}>{$g->Name|escape:html}</option>
					{/foreach}
				</select>
			</td>
		</tr>
	</table><br />

	<input class="button" type="submit" value="{#ButtonSave#}" />
</form>

{/strip}