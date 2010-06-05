{literal}
<style type="text/css">
.orders_wait {background-color:#cccccc;color:#fff;text-align:right;font-weight:bold}
.orders_progress {background-color:#FFCC00;color:#fff;text-align:right;font-weight:bold}
.orders_ok {background-color:#009900;color:#fff;text-align:right;font-weight:bold}
.orders_ok_send {background-color:#0099FF;color:#fff;text-align:right;font-weight:bold}
.orders_failed {background-color:#FF0000;color:#fff;text-align:right;font-weight:bold}
</style>
{/literal}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/shop_topnav.tpl"}
{*
<script language="javascript" src="../modules/shop/js/admin_funcs.js"></script>
*}
<h4>{#ProductOrdersSShowMoney#}</h4>

<div class="infobox" style="padding:0px">
	<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=showmoney&cp={$sess}&search=1">
		<table width="100%" border="0" cellpadding="4" cellspacing="1">
			<tr>
				<td width="250" class="first">
					<label for="pq">{#ProductOrdersSOrdersFrom#}</label>
				</td>

				<td width="100" class="second">
					{html_select_date time=$ZeitStart prefix="start_" end_year="+0" start_year="-10" display_days=true month_format="%m" reverse_years=false day_size=1 field_order=DMY all_extra=""}
				</td>

				<td rowspan="12" class="first">&nbsp;</td>
			</tr>

			<tr>
				<td width="250" class="first">{#ProductOrdersSOrdersTill#}</td>
				<td width="100" class="second">
					{html_select_date time=$ZeitEnde prefix="end_" end_year="+0" start_year="-10" display_days=true month_format="%m" reverse_years=false day_size=1 field_order=DMY all_extra=""}
				</td>
			</tr>

			<tr>
				<td width="250" class="first">{#ProductOrdersSpayment#}</td>
				<td width="100" class="second">
					<select style="width:160px" name="ZahlungsId">
						<option value="egal">{#ProductDm#}</option>
						{foreach from=$paymentMethods item=pm}
							<option value="{$pm->Id}" {if $smarty.request.ZahlungsId==$pm->Id}selected="selected"{/if}>{$pm->Name}</option>
						{/foreach}
					</select>
				</td>
			</tr>

			<tr>
				<td width="250" class="first">{#ProductOrdersPayShip#}</td>
				<td width="100" class="second">
					<select style="width:160px" name="VersandId">
						<option value="egal">{#ProductDm#}</option>
						{foreach from=$shippingMethods item=zm}
							<option value="{$zm->Id}" {if $smarty.request.VersandId==$zm->Id}selected="selected"{/if}>{$zm->Name}</option>
						{/foreach}
					</select>
				</td>
			</tr>

			<tr>
				<td width="250" class="first">{#ProductOrdersSOrdersCustomerNr#}</td>
				<td width="100" class="second">
					<input style="width:160px" name="Benutzer" type="text" value="{$smarty.request.Benutzer}" />
				</td>
			</tr>

			<tr>
				<td width="250" class="first">&nbsp;</td>
				<td width="100" class="second">
					<input type="submit" class="button" value="{#ButtonSearch#}" />
				</td>
			</tr>

			<tr>
				<td class="first">&nbsp;</td>
				<td width="100" class="second">&nbsp;</td>
			</tr>

			<tr>
				<td class="first">{#ProductOrdersSMoneyAll#}</td>
				<td width="100" class="orders_ok">{$row->GesamtUmsatz} {$currency}</td>
			</tr>

			<tr>
				<td class="first">{#StatusWait#}</td>
				<td width="100" class="orders_wait">{$row->GesamtUmsatzWartend} {$currency}</td>
			</tr>

			<tr>
				<td class="first">{#StatusProgress#}</td>
				<td width="100" class="orders_progress">{$row->GesamtUmsatzBearbeitung} {$currency}</td>
			</tr>

			<tr>
				<td class="first">{#StatusFailed#}</td>
				<td width="100" class="orders_failed">{$row->GesamtFehlgeschlagen} {$currency}</td>
			</tr>

			<tr>
				<td class="first">{#ProductOrdersSPossMoney#}</td>
				<td width="100" align="right" class="second"><strong> {$row->GesamtUmsatzAlle} {$currency}</strong></td>
			</tr>
		</table>
	</form>
</div>