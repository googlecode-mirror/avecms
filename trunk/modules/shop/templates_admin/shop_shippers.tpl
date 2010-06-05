<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/shop_topnav.tpl"}

<h4>{#SShipper#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=shipping&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td width="1%" class="tableheader" align="center"><img src="{$tpl_dir}/images/icon_18.gif" alt="" hspace="2" border="0" /></td>
			<td width="150" class="tableheader">{#SShipperName#}</td>
			<td width="100" class="tableheader">{#SShipperActive#} </td>
			<td width="150" class="tableheader">{#SShipperDoCost#}</td>
			<td class="tableheader">{#Actions#}</td>
		</tr>

		{foreach from=$shopShipper item=ss}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td>
					<input title="{#Delete#}" name="Del[{$ss->Id}]" type="checkbox" id="Del[{$ss->Id}]" value="1" />
				</td>

				<td>
					<input style="width:160px" type="text" name="Name[{$ss->Id}]" value="{$ss->Name|stripslashes}" />
				</td>

				<td>
					<input type="radio" name="Aktiv[{$ss->Id}]" value="1" {if $ss->Aktiv == '1'}checked="checked" {/if}/>{#Yes#}&nbsp;
					<input type="radio" name="Aktiv[{$ss->Id}]" value="0" {if $ss->Aktiv == '0'}checked="checked" {/if}/>{#No#}
				</td>

				<td>
					<input type="radio" name="KeineKosten[{$ss->Id}]" value="1" {if $ss->KeineKosten == '1'}checked="checked" {/if}/>{#Yes#}&nbsp;
					<input type="radio" name="KeineKosten[{$ss->Id}]" value="0" {if $ss->KeineKosten == '0'}checked="checked" {/if}/>{#No#}
				</td>

				<td>
					{if $ss->Aktiv == '1'}
						<a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=editshipper&cp={$sess}&pop=1&Id={$ss->Id}','750','600','1','shopshipper');">{#DokEdit#}</a>
						{if $ss->KeineKosten == '1' && $ss->LaenderVersand != ''}
							&nbsp;| <a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=editshipper_cost&cp={$sess}&pop=1&Id={$ss->Id}','750','600','1','shopshipper');">{#EditShipperCost#}</a>
						{/if}
					{/if}
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#ButtonSave#}" />
</form>

<h4>{#SShipperNew#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=shipping&cp={$sess}&sub=new" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="first">
				<input name="NewShipper" type="text" style="width:250px" value="{#SShipperName#}" />&nbsp;
				<input type="submit" class="button" value="{#ButtonSave#}" />
			</td>
		</tr>
	</table>
</form>