<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#EditPaymentMethod#}</h2></div>
	<div class="HeaderText">{#EditPaymentInfo#}</div>
</div><br />

<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=editpaymentmethod&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=save">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td width="220" class="first">{#SShipperName#}</td>
			<td class="second">
				<input style="width:200px" type="text" name="Name" value="{$ss->Name|stripslashes}">
			</td>
		</tr>

		<tr>
			<td width="220" class="first">{#ShipperDescr#}</td>
			<td class="second">{$Edi}</td>
		</tr>

		<tr>
			<td width="220" class="first">{#SShipperActive#} </td>
			<td class="second">
				<input type="radio" name="Aktiv" value="1" {if $ss->Aktiv=='1'}checked {/if}/>{#Yes#}&nbsp;
				<input type="radio" name="Aktiv" value="0" {if $ss->Aktiv=='0'}checked {/if}/>{#No#}
			</td>
		</tr>

		<tr>
			<td width="220" class="first">{#PaymentCost#}</td>
			<td class="second">
				<input name="Kosten" type="text" id="Kosten" value="{$ss->Kosten}" size="10" />
				<select name="KostenOperant">
					<option value="Wert" {if $ss->KostenOperant=='Wert'}selected="selected"{/if}>{#PaymentCostMoney#}</option>
					<option value="%" {if $ss->KostenOperant=='%'}selected="selected"{/if}>{#PaymentCostPercent#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td width="220" class="first">
				{#AllowedCountries#}<br />
				<small>{#ShippingCTip#}</small>
			</td>
			<td class="second">
				<select name="ErlaubteVersandLaender[]" multiple="multiple" size="8" style="width:200px">
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
			<td width="220" class="first">
				{#AllowedGroups#}<br />
				<small>{#PaymentCTip#}</small>
			</td>
			<td class="second">
				<select name="ErlaubteGruppen[]" multiple="multiple" size="8" style="width:200px">
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

		<tr>
			<td width="220" class="first">
				{#AllowedShippingMethods#}<br />
				<small>{#ShippingMethodInf#}</small>
			</td>
			<td class="second">
				<select name="ErlaubteVersandarten[]" multiple="multiple" size="8" style="width:200px">
					{foreach from=$shipper item=g}
						{assign var='sel' value=''}
						{if $g->Id}
							{if (in_array($g->Id,$ss->Versandarten))}
								{assign var='sel' value='selected'}
							{/if}
						{/if}
						<option value="{$g->Id}" {$sel}>{$g->Name|escape:html}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		{if $ss->Id!=1 && $ss->Id!=2 && $ss->Id!=3}
			<tr>
				<td width="220" class="first">
					{#InstId#}<br />
					<small>{#InstIdInf#}</small>
				</td>
				<td class="second">
					<input name="InstId" type="text" id="InstId" style="width:200px" value="{$ss->InstId}" />
				</td>
			</tr>

			<tr>
				<td width="220" class="first">{#InstTestMode#}</td>
				<td class="second">
					<input name="TestModus" type="text" id="TestModus" style="width:80px" value="{$ss->TestModus}" />
				</td>
			</tr>

			<tr>
				<td class="first">
					{#SubjectPaymentEx#}<br />
					<small>{#SubjectPaymentExInf#}</small>
				</td>
				<td class="second">
					<input name="ZahlungsBetreff" type="text" id="ZahlungsBetreff" style="width:200px" value="{$ss->ZahlungsBetreff}" />
				</td>
			</tr>

			<tr>
				<td width="220" class="first">
					{#ExternScript#}<br />
					<small>{#ExternScriptInf#}</small>
				</td>
				<td class="second">
					<input type="radio" name="Extern" value="1" {if $ss->Extern=='1'}checked {/if}/>{#Yes#}&nbsp;
					<input type="radio" name="Extern" value="0" {if $ss->Extern=='0'}checked {/if}/>{#No#}
				</td>
			</tr>

			<tr>
				<td width="220" class="first">
					{#Gatewayscript#}<br />
					<small>{#GatewayscriptInf#}</small>
				</td>
				<td class="second">
					<input name="Gateway" type="text" id="Gateway" style="width:80px" value="{$ss->Gateway}" />.php
				</td>
			</tr>
		{/if}

		<tr>
			<td width="220" class="first">&nbsp;</td>
			<td class="second">&nbsp;</td>
		</tr>
	</table><br />

	<input class="button" type="submit" value="{#ButtonSave#}" />
</form>