<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#EditShipperCost#}</h2></div>
	<div class="HeaderText">{#EditShipperCost#}</div>
</div><br />

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=editshipper_cost&cp={$sess}&sub=save&Id={$smarty.request.Id}&pop=1" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		{foreach from=$laender item=sc}
			<tr>
				<td colspan="4" class="tableheader"><strong>{$sc->LandName}</strong></td>
			</tr>

			<tr>
				<td width="1%"><img src="{$tpl_dir}/images/icon_18.gif" alt="" hspace="2" border="0" /></td>
				<td width="100"><strong>{#FromKilo#}</strong></td>
				<td width="100"><strong>{#TillKilo#}</strong></td>
				<td><strong>{#Summ#}</strong></td>
			</tr>

			<tr>
				<td width="1%">&nbsp;</td>
				<td width="100"><input style="width:100px; background:#FFFFCC" type="text" name="NeuVon[{$sc->LandCode}]" /></td>
				<td width="100"><input style="width:100px; background:#FFFFCC" type="text" name="NeuBis[{$sc->LandCode}]" /></td>
				<td><input  style="width:80px; background:#FFFFCC" type="text" name="NeuBetrag[{$sc->LandCode}]" /> {#InsertNewCost#}</td>
			</tr>

			{foreach from=$sc->versandkosten item=w_table}
				<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
					<td width="1%" align="center">
						<input title="{#Delete#}" type="checkbox" name="Del[{$w_table->Id}]" value="{$w_table->KVon}" />
					</td>

					<td width="100">
						<input id="a_{$w_table->Id}" style="width:100px" type="text" name="KVon[{$w_table->Id}]" value="{$w_table->KVon}" />
					</td>

					<td width="100">
						<input id="b_{$w_table->Id}" style="width:100px" type="text" name="KBis[{$w_table->Id}]" value="{$w_table->KBis}" />
					</td>

					<td>
						<input id="c_{$w_table->Id}" style="width:80px" type="text" name="Betrag[{$w_table->Id}]" value="{$w_table->Betrag}" />
					</td>
				</tr>
			{/foreach}
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#ButtonSave#}">
</form>